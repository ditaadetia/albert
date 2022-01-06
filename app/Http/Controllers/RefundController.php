<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use App\Models\detailRefund;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function index()
    {
        $refunds = Refund::paginate(5);
        $tes = DB::table('refunds')
            ->join('detail_refunds', 'detail_refunds.refund_id', '=', 'refunds.id')
            ->where('detail_refunds.ket_verif_admin', '=', 'setuju')->paginate(5);
        return view('refund', [
            'refunds' => $refunds,
            'tes' => $tes
        ]);
    }

    //     $refunds = DB::table('refunds')
    //     ->join('detail_refunds', 'detail_refunds.refund_id', '=', 'refunds.id')
    //     ->join('orders', 'refunds.order_id', '=', 'orders.id')
    //     ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
    //     ->where('detail_refunds.ket_verif_admin', '=', 'verif')
    //     ->select('detail_refunds.id', 'orders.nama_kegiatan', 'tenants.nama', 'orders.category_order_id')->paginate(5);
    // return view('refund', [
    //     'refunds' => $refunds,
    // ]);

    // public function index()
    // {
    //     $refunds = DB::table('refunds')
    //     ->join('detail_refunds', 'detail_refunds.refund_id', '=', 'refunds.id')
    //     ->where('detail_refunds.ket_verif_admin', '=', 1)->paginate(5);
    //     return view('refund', [
    //         'refunds' => $refunds
    //     ]);
    // }

    public function refundsExcel(Request $request)
    {
        $validated = $request->validate([
            'tanggal_awal' => 'date',
            'tanggal_akhir' => 'date',
        ]);
        $tanggal_awal=$validated['tanggal_awal'];
        $tanggal_akhir=$validated['tanggal_akhir'];

        $detail_refunds = DB::table('detail_refunds')
        ->join('refunds', 'refunds.id', '=', 'detail_refunds.refund_id')
        ->where('ket_persetujuan_kepala_dinas', 'setuju')
        ->get();

        $refunds1 = DB::table('refunds')
        ->join('orders', 'orders.id', '=', 'refunds.order_id')
        ->join('tenants', 'tenants.id', '=', 'orders.tenant_id')
        ->join('detail_refunds', 'detail_refunds.refund_id', '=', 'refunds.id')
        ->where('detail_refunds.ket_persetujuan_kepala_dinas', 'setuju')
        ->get();

        $refunds = DB::table('detail_refunds')
        ->join('refunds', 'refunds.id', '=', 'detail_refunds.refund_id')
        ->join('orders', 'orders.id', '=', 'refunds.order_id')
        ->join('tenants', 'tenants.id', '=', 'orders.tenant_id')
        ->where('detail_refunds.ket_persetujuan_kepala_dinas', 'setuju')
        ->whereBetween('refunds.created_at', [$tanggal_awal, $tanggal_akhir])->get();
        return view('refund-excel', [
            'refunds' => $refunds,
            'refunds1' => $refunds1,
        ]);
    }

    public function show($id)
    {
        $refund = Refund::findOrFail($id);
        $detail_refund = DB::table('detail_refunds')->join('refunds', 'detail_refunds.refund_id', '=', 'refunds.id')->where('detail_refunds.refund_id', '=', 'refunds.id')->get();
        if(!auth()->check() || auth()->user()->jabatan === 'admin'){
            $equipment = DB::table('detail_refunds')
            ->join('equipments', 'detail_refunds.equipment_id', '=', 'equipments.id')
            ->join('refunds', 'detail_refunds.refund_id', '=', 'refunds.id')
            ->where('detail_refunds.refund_id', '=', $id)
            ->select('detail_refunds.id',
            'equipments.foto',
            'equipments.nama',
            'detail_refunds.jumlah_hari_refund',
            'detail_refunds.jumlah_jam_refund',
            'equipments.harga_sewa_perhari',
            'equipments.harga_sewa_perjam',
            'detail_refunds.ket_verif_admin',
            'detail_refunds.ket_persetujuan_kepala_uptd',
            'detail_refunds.ket_persetujuan_kepala_dinas',
            'detail_refunds.ket_konfirmasi')
            ->get();
        }elseif(!auth()->check() || auth()->user()->jabatan === 'kepala uptd'){
            $equipment = DB::table('detail_refunds')
            ->join('equipments', 'detail_refunds.equipment_id', '=', 'equipments.id')
            ->join('refunds', 'detail_refunds.refund_id', '=', 'refunds.id')
            ->where('detail_refunds.refund_id', '=', $id)
            ->where('detail_refunds.ket_verif_admin', '=', 'verif')
            ->select('detail_refunds.id',
            'equipments.foto',
            'equipments.nama',
            'detail_refunds.jumlah_hari_refund',
            'detail_refunds.jumlah_jam_refund',
            'equipments.harga_sewa_perhari',
            'equipments.harga_sewa_perjam',
            'detail_refunds.ket_verif_admin',
            'detail_refunds.ket_persetujuan_kepala_uptd',
            'detail_refunds.ket_persetujuan_kepala_dinas',
            'detail_refunds.ket_konfirmasi')
            ->get();
        }elseif(!auth()->check() || auth()->user()->jabatan === 'kepala dinas'){
            $equipment = DB::table('detail_refunds')
            ->join('equipments', 'detail_refunds.equipment_id', '=', 'equipments.id')
            ->join('refunds', 'detail_refunds.refund_id', '=', 'refunds.id')
            ->where('detail_refunds.refund_id', '=', $id)
            ->where('detail_refunds.ket_persetujuan_kepala_uptd', '=', 'setuju')
            ->select('detail_refunds.id',
            'equipments.foto',
            'equipments.nama',
            'detail_refunds.jumlah_hari_refund',
            'detail_refunds.jumlah_jam_refund',
            'equipments.harga_sewa_perhari',
            'equipments.harga_sewa_perjam',
            'detail_refunds.ket_verif_admin',
            'detail_refunds.ket_persetujuan_kepala_uptd',
            'detail_refunds.ket_persetujuan_kepala_dinas',
            'detail_refunds.ket_konfirmasi')
            ->get();
        }
        // $detail_refund = DB::table('refunds')->join('detail_refunds', 'detail_refunds.refund_id', '=', 'refunds.id')->get();
        return view('detail_refund', [
            'refund' => $refund,
            'detail_refund' => $detail_refund,
            'equipment' => $equipment,
            // 'detail_refund' => $detail_refund
        ]);
    }

    public function search(Request $request)
    {
        $pagination  = 5;
        $refunds    = Refund::when($request->keyword, function ($query) use ($request) {
            $query
            ->whereHas('order', function($query) use($request) {
                $query
                ->where('nama_kegiatan', 'like', "%{$request->keyword}%");
            });

            $query
            ->orWhereHas('tenant', function($query) use($request) {
                $query
                ->where('nama', 'like', "%{$request->keyword}%");
            });
        })

        ->orderBy('created_at', 'desc')->paginate($pagination);
        $refunds->appends($request->only('keyword'));
        // dd(DB::getQueryLog());
        return view('refund', compact('refunds'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function downloadPermohonanRefund($id){
        $model_file = Refund::findOrFail($id); //Mencari model atau objek yang dicari
        $file = public_path() . '/storage/permohonan_refund/' . $model_file->surat_permohonan_refund;//Mencari file dari model yang sudah dicari
        return response()->download($file, $model_file->surat_permohonan_refund); //Download file yang dicari berdasarkan nama file
    }

    public function verifRefundAdmin(detailRefund $id){
        $result = DB::transaction(function () use ($id) {
            $id->update([
                'ket_verif_admin' => 'verif'
            ]);
            return $id->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            return redirect()->route('refunds.index')->with('success', 'Verifikasi pengajuan refund berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('refunds.index')->with('error', 'Verifikasi pengajuan refund gagal!');
        }
    }

    public function tolakRefundAdmin(Request $request, detailRefund $id){
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

        if ($result) {
            //redirect dengan pesan sukses
            return redirect()->route('refunds.index')->with('success', 'Penolakan pengajuan refund berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('refunds.index')->with('error', 'Penolakan pengajuan refund gagal!');
        }
    }

    public function setujuRefundKepalaUPTD(detailRefund $id){
        $result = DB::transaction(function () use ($id) {
            $id->update([
                'ket_persetujuan_kepala_uptd' => 'setuju'
            ]);
            return $id->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            return redirect()->route('refunds.index')->with('success', 'Persetujuan pengajuan refund berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('refunds.index')->with('error', 'Persetujuan pengajuan refund gagal!');
        }
    }

    public function tolakRefundKepalaUPTD(Request $request, detailRefund $id){
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
            return redirect()->route('refunds.index')->with('success', 'Penolakan pengajuan refund berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('refunds.index')->with('error', 'Penolakan pengajuan refund gagal!');
        }
    }

    public function setujuRefundKepalaDinas(detailRefund $id){
        $result = DB::transaction(function () use ($id) {
            $id->update([
                'ket_persetujuan_kepala_dinas' => 'setuju'
            ]);
            return $id->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            return redirect()->route('refunds.index')->with('success', 'Persetujuan pengajuan refund berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('refunds.index')->with('error', 'Persetujuan pengajuan refund gagal!');
        }
    }

    public function tolakRefundKepalaDinas(Request $request, detailRefund $id){
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
            return redirect()->route('refunds.index')->with('success', 'Penolakan pengajuan refund berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('refunds.index')->with('error', 'Penolakan pengajuan refund gagal!');
        }
    }
}
