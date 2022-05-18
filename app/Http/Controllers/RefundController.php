<?php

namespace App\Http\Controllers;

use App\Mail\NotifRefund;
use App\Models\Refund;
use App\Models\Order;
use App\Models\Reschedule;
use App\Models\Schedule;
use App\Models\detailRefund;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Mail\Refund as Refunds;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Mail\pemberitahuanPembayaran;
use App\Mail\PemberitahuanRefund;
use App\Mail\Tolak;

class RefundController extends Controller
{
    public function index()
    {
        if(!auth()->check() || auth()->user()->jabatan === 'admin'){
            // ->join('detail_refunds', 'orders.id', '=', 'detail_refunds.order_id')
            $tenant=DB::table('refunds')
            ->join('orders', 'orders.id', '=', 'refunds.order_id')
            ->join('tenants', 'tenants.id', '=', 'orders.tenant_id')
            ->select('orders.category_order_id', 'refunds.id', 'orders.nama_kegiatan', 'tenants.nama', 'refunds.metode_refund', 'refunds.no_rekening', 'refunds.nama_penerima')
            ->paginate(5);
        }
        elseif(!auth()->check() || auth()->user()->jabatan === 'kepala uptd'){
            $tenant=DB::table('refunds')
            ->join('orders', 'orders.id', '=', 'refunds.order_id')
            ->join('tenants', 'tenants.id', '=', 'orders.tenant_id')
            ->where('refunds.ket_verif_admin', '=', 'verif')
            ->select('orders.category_order_id', 'refunds.id', 'orders.nama_kegiatan', 'tenants.nama', 'refunds.metode_refund', 'refunds.no_rekening', 'refunds.nama_penerima')
            ->paginate(5);
        }
        elseif(!auth()->check() || auth()->user()->jabatan === 'kepala dinas'){
            $tenant=DB::table('refunds')
            ->join('orders', 'orders.id', '=', 'refunds.order_id')
            ->join('tenants', 'tenants.id', '=', 'orders.tenant_id')
            ->where('refunds.ket_persetujuan_kepala_uptd','=', 'setuju')
            ->select('orders.category_order_id', 'refunds.id', 'orders.nama_kegiatan', 'tenants.nama', 'refunds.metode_refund', 'refunds.no_rekening', 'refunds.nama_penerima')
            ->paginate(5);
        }

        elseif(!auth()->check() || auth()->user()->jabatan === 'bendahara'){
            $tenant=DB::table('refunds')
            ->join('orders', 'orders.id', '=', 'refunds.order_id')
            ->join('tenants', 'tenants.id', '=', 'orders.tenant_id')
            ->where('refunds.ket_persetujuan_kepala_dinas','=', 'setuju')
            ->select('orders.category_order_id', 'refunds.id', 'orders.nama_kegiatan', 'tenants.nama', 'refunds.metode_refund', 'refunds.no_rekening', 'refunds.nama_penerima')
            ->paginate(5);
        }

        return view('refund', [
            'tenant' => $tenant,
        ]);
    }

    public function refundsExcel(Request $request)
    {
        $validated = $request->validate([
            'tanggal_awal' => 'date',
            'tanggal_akhir' => 'date',
        ]);
        $tanggal_awal=$validated['tanggal_awal'];
        $tanggal_akhir=$validated['tanggal_akhir'];

        $refund = DB::table('refunds')
        ->join('orders', 'orders.id', '=', 'refunds.order_id')
        ->join('tenants', 'tenants.id', '=', 'orders.tenant_id')
        ->where('refunds.ket_persetujuan_kepala_dinas', 'setuju')
        ->whereBetween('orders.created_at', [$tanggal_awal, $tanggal_akhir])
        // ->where('category_order_id', request('category'))
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('detail_refunds')
                  ->whereColumn('detail_refunds.order_id', 'orders.id');
        })
        ->get();
        // $detail_orders = DB::table('orders')
        // ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        // ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        // // ->where('orders.id', 'detail_orders.order_id')
        // ->select('orders.tanggal_mulai', 'orders.tanggal_selesai', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam', 'equipments.nama', 'equipments.jenis', 'equipments.id')->get();
        return view('refund-excel', [
            'refund' => $refund,
            // 'detail_orders' => $detail_orders
        ]);
    }

    public function show($id)
    {
        $refund = DB::table('refunds')
        ->join('tenants', 'tenants.id', '=', 'refunds.tenant_id')
        // ->join('detail_refunds', 'detail_refunds.id', '=', 'refunds.tenant_id')
        ->where('refunds.id', '=', $id)->first();
        $order = DB::table('orders')->where('orders.id', '=', $id)->first();
        // $tanggal_refund=$refund->created_at;
        // $tanggal_harus_kembali=$order->tanggal_selesai;
        $detail_refund = DB::table('detail_refunds')->join('orders', 'detail_refunds.order_id', '=', 'orders.id')->where('detail_refunds.order_id', '=', 'orders.id')->get();
        if(!auth()->check() || auth()->user()->jabatan === 'admin'){
            $equipment = DB::table('detail_refunds')
            ->join('orders', 'detail_refunds.order_id', '=', 'orders.id')
            ->join('refunds', 'refunds.order_id', '=', 'orders.id')
            ->join('detail_orders', 'detail_refunds.detail_order_id', '=', 'detail_orders.id')
            ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
            ->where('refunds.id', '=', $id)
            ->select(
            'refunds.id',
            'equipments.foto',
            'equipments.nama',
            'equipments.harga_sewa_perhari',
            'equipments.harga_sewa_perjam',
            'refunds.ket_verif_admin',
            'refunds.ket_persetujuan_kepala_uptd',
            'refunds.ket_persetujuan_kepala_dinas')
            ->get();
        }elseif(!auth()->check() || auth()->user()->jabatan === 'kepala uptd'){
            $equipment = DB::table('detail_refunds')
            ->join('orders', 'detail_refunds.order_id', '=', 'orders.id')
            ->join('refunds', 'refunds.order_id', '=', 'orders.id')
            ->join('detail_orders', 'detail_refunds.detail_order_id', '=', 'detail_orders.id')
            ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
            ->where('refunds.id', '=', $id)
            ->where('refunds.ket_verif_admin', '=', 'verif')
            ->select(
            'refunds.id',
            'equipments.foto',
            'equipments.nama',
            'equipments.harga_sewa_perhari',
            'equipments.harga_sewa_perjam',
            'refunds.ket_verif_admin',
            'refunds.ket_persetujuan_kepala_uptd',
            'refunds.ket_persetujuan_kepala_dinas')
            ->get();
        }elseif(!auth()->check() || auth()->user()->jabatan === 'kepala dinas'){
            $equipment = DB::table('detail_refunds')
            ->join('orders', 'detail_refunds.order_id', '=', 'orders.id')
            ->join('refunds', 'refunds.order_id', '=', 'orders.id')
            ->join('detail_orders', 'detail_refunds.detail_order_id', '=', 'detail_orders.id')
            ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
            ->where('refunds.id', '=', $id)
            ->where('refunds.ket_persetujuan_kepala_uptd', '=', 'setuju')
            ->select(
            'refunds.id',
            'equipments.foto',
            'equipments.nama',
            'equipments.harga_sewa_perhari',
            'equipments.harga_sewa_perjam',
            'refunds.ket_verif_admin',
            'refunds.ket_persetujuan_kepala_uptd',
            'refunds.ket_persetujuan_kepala_dinas',
            )
            ->get();
        }elseif(!auth()->check() || auth()->user()->jabatan === 'bendahara'){
            $equipment = DB::table('detail_refunds')
            ->join('orders', 'detail_refunds.order_id', '=', 'orders.id')
            ->join('refunds', 'refunds.order_id', '=', 'orders.id')
            ->join('detail_orders', 'detail_refunds.detail_order_id', '=', 'detail_orders.id')
            ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
            ->where('refunds.order_id', '=', $id)
            ->where('refunds.ket_persetujuan_kepala_dinas', '=', 'setuju')
            ->select(
            'refunds.id',
            'equipments.foto',
            'equipments.nama',
            'equipments.harga_sewa_perhari',
            'equipments.harga_sewa_perjam',
            'refunds.ket_verif_admin',
            'refunds.ket_persetujuan_kepala_uptd',
            'refunds.ket_persetujuan_kepala_dinas',
            'refunds.refund_bendahara',
            'refunds.bukti_refund')
            ->get();
        }
        // $detail_refund = DB::table('refunds')->join('detail_refunds', 'detail_refunds.refund_id', '=', 'refunds.id')->get();
        return view('detail_refund', [
            'refund' => $refund,
            'detail_refund' => $detail_refund,
            'equipment' => $equipment,
            'order' => $order,
            // 'detail_refund' => $detail_refund
        ]);
    }

    public function search(Request $request)
    {
        $pagination  = 5;
        if(!auth()->check() || auth()->user()->jabatan === 'admin'){
            $tenant = DB::table('refunds')
                ->join('orders', 'refunds.order_id', '=', 'orders.id')
                ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
                ->orderBy('refunds.id', 'asc')
                ->where(function ($query) use($request) {
                    $query->where('tenants.nama', 'like', "%{$request->keyword}%")
                        ->orWhere('orders.nama_kegiatan', 'like', "%{$request->keyword}%");
                })
                ->paginate(5);
        }
        else if(!auth()->check() || auth()->user()->jabatan === 'kepala uptd'){
            $tenant = DB::table('refunds')
                ->join('orders', 'refunds.order_id', '=', 'orders.id')
                ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
                ->orderBy('refunds.id', 'asc')
                ->where('ket_setuju_kepala_uptd','=', 'setuju')
                ->where(function ($query) use($request) {
                    $query->where('tenants.nama', 'like', "%{$request->keyword}%")
                        ->orWhere('orders.nama_kegiatan', 'like', "%{$request->keyword}%");
                })
                ->paginate(5);
        }
        else if(!auth()->check() || auth()->user()->jabatan === 'kepala dinas'){
            $tenant = DB::table('refunds')
                ->join('orders', 'refunds.order_id', '=', 'orders.id')
                ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
                ->orderBy('refunds.id', 'asc')
                ->where('ket_setuju_kepala_uptd','=', 'setuju')
                ->where(function ($query) use($request) {
                    $query->where('tenants.nama', 'like', "%{$request->keyword}%")
                        ->orWhere('orders.nama_kegiatan', 'like', "%{$request->keyword}%");
                })
                ->paginate(5);
        }
        return view('refund', compact('tenant'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function downloadPermohonanRefund($id){
        $model_file = Refund::findOrFail($id); //Mencari model atau objek yang dicari
        $file = public_path() . '/storage/permohonan_refund/' . $model_file->surat_permohonan_refund;//Mencari file dari model yang sudah dicari
        return response()->download($file, $model_file->surat_permohonan_refund); //Download file yang dicari berdasarkan nama file
    }

    public function verifRefundAdmin(Refund $id){
        $result = DB::transaction(function () use ($id) {
            $id->update([
                'ket_verif_admin' => 'verif'
            ]);
            return $id->save();
        });

        $data = DB::table('orders')
        ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
        ->join('refunds', 'refunds.order_id', '=', 'orders.id')
        ->where('refunds.id', '=', $id->id)->first();
        // $data['nama_instansi'] = $tes->nama_instansi;
        $staff = DB::table('users')
            ->where('jabatan', '=', 'kepala uptd')->first();
        $alat = DB::table('detail_orders')
            ->join('detail_refunds', 'detail_refunds.detail_order_id', '=', 'detail_orders.id')
            ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
            ->join('orders', 'detail_orders.order_id', '=', 'orders.id')
            ->join('refunds', 'detail_refunds.order_id', '=', 'orders.id')
            ->where('refunds.id', '=', $id->id)->get();
        $tes = DB::table('refunds')
            ->join('orders', 'refunds.order_id', '=', 'orders.id')
            ->where('refunds.id', '=', $id->id)->first();
        $total =0;
        foreach($alat as $alat){
            $awal=date_create($tes->tanggal_mulai);
            $akhir=date_create($tes->tanggal_selesai);
            $diff=date_diff($awal, $akhir);
            if($diff->days >0){
                $harga = $alat->harga_sewa_perhari * $diff->days;
            }
            else{
                $harga = $alat->harga_sewa_perjam * $diff->h;
            }
            $total= $total + $harga;
        }
        $total_bayar =  $total;
        $position= 'admin_to_kepala_uptd';

        if ($result) {
            //redirect dengan pesan sukses
            Mail::to($staff->email)->send(new Refunds($data, $total_bayar, $position));
            return redirect()->route('refunds.index')->with('success', 'Verifikasi pengajuan refund berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('refunds.index')->with('error', 'Verifikasi pengajuan refund gagal!');
        }
    }

    public function tolakRefundAdmin(Request $request, Refund $id){
        $validated = $request->validate([
            'alasan' => 'string',
        ]);

        $result = DB::transaction(function () use ($validated, $request, $id) {
            $id->update([
                'ket_verif_admin' => 'tolak',
                'ket_konfirmasi' => $validated['alasan'],
            ]);
            return $id->save();
        });

        $data = DB::table('orders')
        ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
        ->join('refunds', 'refunds.order_id', '=', 'orders.id')
        ->where('refunds.id', '=', $id->id)->first();
        // $data['nama_instansi'] = $tes->nama_instansi;
        $alat = DB::table('detail_orders')
            ->join('detail_refunds', 'detail_refunds.detail_order_id', '=', 'detail_orders.id')
            ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
            ->join('orders', 'detail_orders.order_id', '=', 'orders.id')
            ->join('refunds', 'detail_refunds.order_id', '=', 'orders.id')
            ->where('refunds.id', '=', $id->id)->get();
        $tes = DB::table('refunds')
            ->join('orders', 'refunds.order_id', '=', 'orders.id')
            ->where('refunds.id', '=', $id->id)->first();
        $total =0;
        foreach($alat as $alat){
            $awal=date_create($tes->tanggal_mulai);
            $akhir=date_create($tes->tanggal_selesai);
            $diff=date_diff($awal, $akhir);
            if($diff->days >0){
                $harga = $alat->harga_sewa_perhari * $diff->days;
            }
            else{
                $harga = $alat->harga_sewa_perjam * $diff->h;
            }
            $total= $total + $harga;
        }
        $total_bayar =  $total;
        $status='pengembalian dana';
        $alasan=$validated['alasan'];

        if ($result) {
            //redirect dengan pesan sukses
            Mail::to($data->email)->send(new Tolak($data, $status, $alasan));
            return redirect()->route('refunds.index')->with('success', 'Penolakan pengajuan refund berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('refunds.index')->with('error', 'Penolakan pengajuan refund gagal!');
        }
    }

    public function setujuRefundKepalaUPTD(Refund $id, Request $request){
        $result = DB::transaction(function () use ($id) {
            $id->update([
                'ket_persetujuan_kepala_uptd' => 'setuju'
            ]);
            return $id->save();
        });

        $data = DB::table('orders')
        ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
        ->join('refunds', 'refunds.order_id', '=', 'orders.id')
        ->where('refunds.id', '=', $id->id)->first();
        // $data['nama_instansi'] = $tes->nama_instansi;
        $staff = DB::table('users')
            ->where('jabatan', '=', 'kepala uptd')->first();
        $alat = DB::table('detail_orders')
            ->join('detail_refunds', 'detail_refunds.detail_order_id', '=', 'detail_orders.id')
            ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
            ->join('orders', 'detail_orders.order_id', '=', 'orders.id')
            ->join('refunds', 'detail_refunds.order_id', '=', 'orders.id')
            ->where('refunds.id', '=', $id->id)->get();
        $tes = DB::table('refunds')
            ->join('orders', 'refunds.order_id', '=', 'orders.id')
            ->where('refunds.id', '=', $id->id)->first();
        $total =0;
        foreach($alat as $alat){
            $awal=date_create($tes->tanggal_mulai);
            $akhir=date_create($tes->tanggal_selesai);
            $diff=date_diff($awal, $akhir);
            if($diff->days >0){
                $harga = $alat->harga_sewa_perhari * $diff->days;
            }
            else{
                $harga = $alat->harga_sewa_perjam * $diff->h;
            }
            $total= $total + $harga;
        }
        $total_bayar =  $total;
        $position= 'kepala_uptd_to_kepala_dinas';

        if ($result) {
            //redirect dengan pesan sukses
            Mail::to($staff->email)->send(new Refunds($data, $total_bayar, $position));
            return redirect()->route('refunds.index')->with('success', 'Persetujuan pengajuan refund berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('refunds.index')->with('error', 'Persetujuan pengajuan refund gagal!');
        }
    }

    public function tolakRefundKepalaUPTD(Request $request, Refund $id){
        $tes=$id->id;
        $validated = $request->validate([
            'alasan' => 'string',
        ]);

        $result = DB::transaction(function () use ($validated, $request, $id) {
            $id->update([
                'ket_persetujuan_kepala_uptd' => 'tolak',
                'ket_konfirmasi' => $validated['alasan'],
            ]);
            return $id->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            $data = DB::table('orders')
            ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
            ->join('payments', 'payments.order_id', '=', 'orders.id')
            ->where('payments.id', '=', $tes)->first();
            $status='pengembalian dana';
            $alasan=$validated['alasan'];
            Mail::to($data->email)->send(new Tolak($data, $status, $alasan));
            return redirect()->route('refunds.index')->with('success', 'Penolakan pengajuan refund berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('refunds.index')->with('error', 'Penolakan pengajuan refund gagal!');
        }
    }

    public function setujuRefundKepalaDinas(Refund $id){
        $tes =DB::table('schedules')->where('detail_order_id', $id)->delete();

        $result = DB::transaction(function () use ($id) {
            $id->update([
                'ket_persetujuan_kepala_dinas' => 'setuju'
            ]);
            return $id->save();
        });
        $data = DB::table('orders')
        ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
        ->join('refunds', 'refunds.order_id', '=', 'orders.id')
        ->where('refunds.id', '=', $id->id)->first();
        // $data['nama_instansi'] = $tes->nama_instansi;
        $staff = DB::table('users')
            ->where('jabatan', '=', 'bendahara')->first();
        $alat = DB::table('detail_orders')
            ->join('detail_refunds', 'detail_refunds.detail_order_id', '=', 'detail_orders.id')
            ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
            ->join('orders', 'detail_orders.order_id', '=', 'orders.id')
            ->join('refunds', 'detail_refunds.order_id', '=', 'orders.id')
            ->where('refunds.id', '=', $id->id)->get();
        $tes = DB::table('refunds')
            ->join('orders', 'refunds.order_id', '=', 'orders.id')
            ->where('refunds.id', '=', $id->id)->first();
        $total =0;
        foreach($alat as $alat){
            $awal=date_create($tes->tanggal_mulai);
            $akhir=date_create($tes->tanggal_selesai);
            $diff=date_diff($awal, $akhir);
            if($diff->days >0){
                $harga = $alat->harga_sewa_perhari * $diff->days;
            }
            else{
                $harga = $alat->harga_sewa_perjam * $diff->h;
            }
            $total= $total + $harga;
        }
        $total_bayar =  $total;
        $position= 'kepala_dinas';

        if ($result) {
            //redirect dengan pesan sukses
            Mail::to($staff->email)->send(new Refunds($data, $total_bayar, $position));
            Mail::to($data->email)->send(new PemberitahuanRefund($data, $total_bayar, $position));
            return redirect()->route('hapusSchedule', ['id' => $id])->with('success', 'Persetujuan pengajuan refund berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('refunds.index')->with('error', 'Persetujuan pengajuan refund gagal!');
        }
    }

    public function hapusSchedule($id){
        $tes =DB::table('schedules')->where('detail_order_id', $id)->delete();

        if ($tes) {
            //redirect dengan pesan sukses
            return redirect()->route('refunds.index')->with('success', 'Persetujuan pengajuan refund berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('refunds.index')->with('error', 'Persetujuan pengajuan refund gagal!');
        }
    }

    public function tolakRefundKepalaDinas(Request $request, Refund $id){
        $tes=$id->id;
        $validated = $request->validate([
            'alasan' => 'string',
        ]);

        $result = DB::transaction(function () use ($validated, $request, $id) {
            $id->update([
                'ket_persetujuan_kepala_dinas' => 'tolak',
                'ket_konfirmasi' => $validated['alasan'],
            ]);
            return $id->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            $data = DB::table('orders')
            ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
            ->join('payments', 'payments.order_id', '=', 'orders.id')
            ->where('payments.id', '=', $tes)->first();
            $status='pembayaran';
            $alasan=$validated['alasan'];
            Mail::to($data->email)->send(new Tolak($data, $status, $alasan));
            return redirect()->route('refunds.index')->with('success', 'Penolakan pengajuan refund berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('refunds.index')->with('error', 'Penolakan pengajuan refund gagal!');
        }
    }

    public function refundBendahara(Request $request)
    {
        $validated = $request->validate([
            'bukti_refund' => 'required|file|max:1024|mimes:png,jpg,jpeg',
        ]);

        $refund = Refund::where('order_id', request('id'))->first();
        $result = DB::transaction(function () use ($validated, $request, $refund) {
            $refund->update([
                'refund_bendahara' => 1,
                'bukti_refund' =>  $validated['bukti_refund'],
            ]);
            if ($validated) {

                // delete old image from 'public' disk
                Storage::disk('public')->delete($refund->bukti_refund);

                // store the 'foto' into the 'public' disk
                $refund->bukti_refund = $request->file('bukti_refund')->store('bukti_refund', 'public');
            }
            return $refund->save();
        });
        $data = DB::table('orders')
            ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
            ->join('refunds', 'refunds.order_id', '=', 'refunds.id')
            ->where('orders.id', '=', request('id'))->first();
        // $data['nama_instansi'] = $tes->nama_instansi;
        $staff = DB::table('users')
            ->where('jabatan', '=', 'bendahara')->first();
        $alat = DB::table('detail_orders')
            ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
            ->join('orders', 'detail_orders.order_id', '=', 'orders.id')
            ->where('detail_orders.order_id', '=', request('id'))->get();
        $total =0;
        foreach($alat as $alat){
            $awal=date_create($alat->tanggal_mulai);
            $akhir=date_create($alat->tanggal_selesai);
            $diff=date_diff($awal, $akhir);
            if($diff->days >0){
                $harga = $alat->harga_sewa_perhari * $diff->days;
            }
            else{
                $harga = $alat->harga_sewa_perjam * $diff->h;
            }
            $total= $total + $harga;
        }
        $total_bayar =  $total;
        $position= 'bendahara_to_penyewa';
        if ($result) {
            //redirect dengan pesan sukses
            if($validated){
                Mail::to($data->email)->send(new NotifRefund($data, $total_bayar, $position));
                return redirect()->route('refunds.index')->with('success', 'Bukti Refund berhasil diunggah!');
            }else{
                return redirect()->route('refunds.index')->with('error', 'Bukti Refund gagal diunggah!, format harus dalam bentuk pdf/jpg/jpeg/png');
            }
        } else {
            //redirect dengan pesan error
            return redirect()->route('refunds.index')->with('error', 'Bukti Refund gagal diunggah!');
        }
    }
}
