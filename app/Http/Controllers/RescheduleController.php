<?php

namespace App\Http\Controllers;

use App\Mail\PemberitahuanRescheduleBerhasil;
use App\Models\Reschedule;
use App\Models\Order;
use App\Models\Schedule;
use App\Models\DetailReschedule;
use App\Models\DetailOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\Reschedule as Reschedules;
use App\Mail\Tolak;
use Illuminate\Support\Facades\Mail;

class RescheduleController extends Controller
{
    public function index()
    {
        if(!auth()->check() || auth()->user()->jabatan === 'admin'){
            $reschedules = DB::table('orders')
            // ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
            // ->join('detail_reschedules', 'detail_reschedules.detail_order_id', '=', 'detail_orders.id')
            ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
            ->orderBy('orders.id', 'asc')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('detail_reschedules')
                    ->whereColumn('detail_reschedules.order_id', 'orders.id');
            })
            ->select('orders.nama_kegiatan', 'orders.category_order_id', 'tenants.nama', 'orders.id')
            // ->groupBy('orders.id')
            ->paginate(5);
        }
        elseif(!auth()->check() || auth()->user()->jabatan === 'kepala uptd'){
            $reschedules = DB::table('orders')
            // ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
            // ->join('detail_reschedules', 'detail_reschedules.detail_order_id', '=', 'detail_orders.id')
            ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
            ->orderBy('orders.id', 'asc')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('detail_reschedules')
                    ->where('detail_reschedules.ket_verif_admin', '=', 'verif')
                    ->whereColumn('detail_reschedules.order_id', 'orders.id');
            })
            ->select('orders.nama_kegiatan', 'orders.category_order_id', 'tenants.nama', 'orders.id')
            // ->groupBy('orders.id')
            ->paginate(5);
        }

        $details = DB::table('orders')
        ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        ->join('detail_reschedules', 'detail_reschedules.detail_order_id', '=', 'detail_orders.id')
        ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
        ->get();

        return view('reschedule', [
            'reschedules' => $reschedules,
            'details' => $details,
        ]);
    }

    public function reschedulesExcel(Request $request)
    {
        $validated = $request->validate([
            'tanggal_awal' => 'date',
            'tanggal_akhir' => 'date',
        ]);
        $tanggal_awal=$validated['tanggal_awal'];
        $tanggal_akhir=$validated['tanggal_akhir'];

        $reschedules = DB::table('reschedules')
        ->join('orders', 'orders.id', '=', 'reschedules.order_id')
        ->join('tenants', 'tenants.id', '=', 'orders.tenant_id')
        ->whereBetween('reschedules.created_at', [$tanggal_awal, $tanggal_akhir])
           ->whereExists(function ($query) {
               $query->select(DB::raw(1))
                     ->from('detail_reschedules')
                     ->where('detail_reschedules.ket_persetujuan_kepala_uptd', 'setuju')
                     ->whereColumn('detail_reschedules.reschedule_id', 'reschedules.id');
           })
        ->get();

        $detail_reschedules = DB::table('detail_reschedules')
        ->join('reschedules', 'reschedules.id', '=', 'detail_reschedules.reschedule_id')
        ->join('orders', 'orders.id', '=', 'reschedules.order_id')
        ->join('equipments', 'equipments.id', '=', 'orders.tenant_id')
        ->get();

        return view('reschedule-excel', [
            'reschedules' => $reschedules,
            'detail_reschedules' => $detail_reschedules
        ]);
    }

    public function rescheduleShow($id)
    {
        $reschedule = Order::findOrFail($id);
        // $detail_reschedule = DB::table('detail_reschedules')->join('reschedules', 'detail_reschedules.reschedule_id', '=', 'reschedules.id')->where('detail_reschedules.reschedule_id', '=', 'reschedules.id')->get();
        if(!auth()->check() || auth()->user()->jabatan === 'admin'){
            $equipment = DB::table('detail_reschedules')
            ->join('detail_orders', 'detail_reschedules.detail_order_id', '=', 'detail_orders.id')
            ->join('orders', 'detail_orders.order_id', '=', 'orders.id')
            ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
            ->where('detail_reschedules.order_id', '=', $id)
            ->select('detail_reschedules.id',
            'equipments.foto',
            'equipments.nama',
            'orders.tanggal_mulai',
            'orders.tanggal_selesai',
            'detail_reschedules.waktu_mulai',
            'detail_reschedules.waktu_selesai',
            'equipments.harga_sewa_perhari',
            'equipments.harga_sewa_perjam',
            'detail_reschedules.ket_verif_admin',
            // 'detail_reschedules.ket_konfirmasi'
            )
            ->get();
        }elseif(!auth()->check() || auth()->user()->jabatan === 'kepala uptd'){
            $equipment = DB::table('detail_reschedules')
            ->join('detail_orders', 'detail_reschedules.detail_order_id', '=', 'detail_orders.id')
            ->join('orders', 'detail_orders.order_id', '=', 'orders.id')
            ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
            ->where('detail_reschedules.order_id', '=', $id)
            ->where('detail_reschedules.ket_verif_admin', '=', 'verif')
            ->select('detail_reschedules.id',
            'equipments.foto',
            'equipments.nama',
            'orders.tanggal_mulai',
            'orders.tanggal_selesai',
            'detail_reschedules.waktu_mulai',
            'detail_reschedules.waktu_selesai',
            'equipments.harga_sewa_perhari',
            'equipments.harga_sewa_perjam',
            'detail_reschedules.ket_verif_admin',
            'detail_reschedules.ket_persetujuan_kepala_uptd',)
            ->get();
        }
        // $detail_refund = DB::table('refunds')->join('detail_refunds', 'detail_refunds.refund_id', '=', 'refunds.id')->get();
        return view('detail_reschedule', [
            'reschedule' => $reschedule,
            // 'detail_reschedule' => $detail_reschedule,
            'equipment' => $equipment,
            // 'detail_refund' => $detail_refund
        ]);
    }

    public function search(Request $request)
    {
        $pagination  = 5;
        if(!auth()->check() || auth()->user()->jabatan === 'admin'){
            $reschedules = DB::table('orders')
            // ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
            // ->join('detail_reschedules', 'detail_reschedules.detail_order_id', '=', 'detail_orders.id')
            ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
            ->orderBy('orders.id', 'asc')
            ->where(function ($query) use($request) {
                $query->where('tenants.nama', 'like', "%{$request->keyword}%")
                    ->orWhere('orders.nama_kegiatan', 'like', "%{$request->keyword}%");
            })
            ->whereExists(function ($query) use($request) {
                $query->select(DB::raw(1))
                ->from('detail_reschedules')
                ->whereColumn('detail_reschedules.order_id', 'orders.id');
            })
            ->select('orders.nama_kegiatan', 'orders.category_order_id', 'tenants.nama', 'orders.id')
            // ->groupBy('orders.id')
            ->paginate(5);
        }
        elseif(!auth()->check() || auth()->user()->jabatan === 'kepala uptd'){
            $reschedules = DB::table('orders')
            // ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
            // ->join('detail_reschedules', 'detail_reschedules.detail_order_id', '=', 'detail_orders.id')
            ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
            ->orderBy('orders.id', 'asc')
            ->where(function ($query) use($request) {
                $query->where('tenants.nama', 'like', "%{$request->keyword}%")
                    ->orWhere('orders.nama_kegiatan', 'like', "%{$request->keyword}%");
            })
            ->whereExists(function ($query) use($request) {
                $query->select(DB::raw(1))
                ->from('detail_reschedules')
                ->where('detail_reschedules.ket_verif_admin', '=', 'verif')
                ->whereColumn('detail_reschedules.order_id', 'orders.id');
            })
            ->where('tenants.nama', 'like', "%{$request->keyword}%")
            ->orWhere('orders.nama_kegiatan', 'like', "%{$request->keyword}%")
            ->select('orders.nama_kegiatan', 'orders.category_order_id', 'tenants.nama', 'orders.id')
            // ->groupBy('orders.id')
            ->paginate(5);
        };
        $reschedules->appends($request->only('keyword'));
        // dd(DB::getQueryLog());
        $details = DB::table('orders')
        ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        ->join('detail_reschedules', 'detail_reschedules.detail_order_id', '=', 'detail_orders.id')
        ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
        ->get();

        return view('reschedule', [
            'reschedules' => $reschedules,
            'details' => $details,
        ]);
    }

    public function verifRescheduleAdmin(DetailReschedule $id){
        $tes=$id->id;
        $result = DB::transaction(function () use ($id) {
            $id->update([
                'ket_verif_admin' => 'verif'
            ]);
            return $id->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            $data = DB::table('detail_reschedules')
                ->join('orders', 'detail_reschedules.order_id', '=', 'orders.id')
                ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
                // ->where('orders.id', '=', $tes)
                ->first();
            $staff = DB::table('users')
                ->where('jabatan', '=', 'kepala uptd')->first();
            Mail::to($staff->email)->send(new Reschedules($data));
            return redirect()->route('reschedules.index')->with('success', 'Verifikasi pengajuan reschedule berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('reschedules.index')->with('error', 'Verifikasi pengajuan reschedule gagal!');
        }
    }

    public function tolakRescheduleAdmin(Request $request, DetailReschedule $id){
        $tes=$id->id;
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
            $data = DB::table('detail_reschedules')
            ->join('orders', 'detail_reschedules.order_id', '=', 'orders.id')
            ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
            ->where('detail_reschedules.id', '=', $tes)->first();
            $status='perubahan jadwal';
            $alasan=$validated['alasan'];
            Mail::to($data->email)->send(new Tolak($data, $status, $alasan));
            return redirect()->route('reschedules.index')->with('success', 'Penolakan pengajuan reschedule berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('reschedules.index')->with('error', 'Penolakan pengajuan reschedule gagal!');
        }
    }

    public function setujuRescheduleKepalaUPTD(DetailReschedule $id){
        $tes=$id->id;
        $result = DB::transaction(function () use ($id) {
            $id->update([
                'ket_persetujuan_kepala_uptd' => 'setuju'
            ]);
            return $id->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            $data = DB::table('detail_reschedules')
                ->join('orders', 'detail_reschedules.order_id', '=', 'orders.id')
                ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
                ->where('detail_reschedules.id', '=', $tes)
                ->first();
            $staff = DB::table('users')
                ->where('jabatan', '=', 'kepala uptd')->first();
            $detail_order =  DB::table('detail_reschedules')
                ->join('detail_orders', 'detail_reschedules.detail_order_id', '=', 'detail_orders.id')
                ->where('detail_reschedules.id', '=', $tes)
                ->select('detail_orders.id as detail_order_id')
                ->first();
            Mail::to($data->email)->send(new PemberitahuanRescheduleBerhasil($data));
            if($data->ket_persetujuan_kepala_uptd == 'setuju'){
                return redirect()->route('editSchedule', ['id' => $id])->with('success', 'Persetujuan pengajuan reschedule berhasil!');
            }else{
                return redirect()->route('reschedules.index')->with('success', 'Persetujuan pengajuan reschedule berhasil!');
            }
        } else {
            //redirect dengan pesan error
            return redirect()->route('reschedules.index')->with('error', 'Persetujuan pengajuan reschedule gagal!');
        }
    }

    public function editSchedule($id){
        $tenant=DB::table('schedules')
            ->join('detail_orders', 'schedules.detail_order_id', '=', 'detail_orders.id')
            ->join('detail_reschedules', 'detail_reschedules.detail_order_id', '=', 'detail_orders.id')
            ->join('orders', 'schedules.order_id', '=', 'orders.id')
            ->where('detail_reschedules.id', $id)
            ->select('schedules.id', 'detail_reschedules.waktu_mulai', 'detail_reschedules.waktu_selesai')
            ->first();
        $orderan=DB::table('orders')->get();
        $order=DB::table('detail_reschedules')
        ->where('detail_reschedules.id', $id)
        ->select('detail_reschedules.waktu_mulai', 'detail_reschedules.waktu_selesai')
        ->first();
        // dd($tenant);
        $result = DB::transaction(function () use ($id, $tenant, $order) {
            DB::table('schedules')->where('id','=', $tenant->id)->update([
                'tanggal_mulai' => $tenant->waktu_mulai,
                'tanggal_selesai' => $tenant->waktu_selesai
            ]);
        });

        if ($result) {
            //redirect dengan pesan sukses
            return redirect()->route('reschedules.index')->with('success', 'Penolakan pengajuan reschedule berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('reschedules.index')->with('error', 'Penolakan pengajuan reschedule gagal!');
        }
    }

    public function tolakRescheduleKepalaUPTD(Request $request, DetailReschedule $id){
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
            $data = DB::table('detail_reschedules')
            ->join('orders', 'detail_reschedules.order_id', '=', 'orders.id')
            ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
            ->where('detail_reschedules.id', '=', $tes)->first();
            $status='perubahan jadwal';
            $alasan=$validated['alasan'];
            Mail::to($data->email)->send(new Tolak($data, $status, $alasan));
            return redirect()->route('reschedules.index')->with('success', 'Penolakan pengajuan reschedule berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('reschedules.index')->with('error', 'Penolakan pengajuan reschedule gagal!');
        }
    }

}
