<?php

namespace App\Http\Controllers;

use App\Models\Reschedule;
use App\Models\DetailReschedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RescheduleController extends Controller
{
    public function index()
    {
        $reschedules = Reschedule::paginate(5);
        $tes = DB::table('reschedules')
            ->join('detail_reschedules', 'detail_reschedules.reschedule_id', '=', 'reschedules.id')
            ->where('detail_reschedules.ket_verif_admin', '=', 'setuju')->paginate(5);
        return view('reschedule', [
            'reschedules' => $reschedules,
            'tes' => $tes
        ]);
    }

    public function show($id)
    {
        $reschedule = Reschedule::findOrFail($id);
        $detail_reschedule = DB::table('detail_reschedules')->join('reschedules', 'detail_reschedules.reschedule_id', '=', 'reschedules.id')->where('detail_reschedules.reschedule_id', '=', 'reschedules.id')->get();
        if(!auth()->check() || auth()->user()->jabatan === 'admin'){
            $equipment = DB::table('detail_reschedules')
            ->join('equipments', 'detail_reschedules.equipment_id', '=', 'equipments.id')
            ->join('reschedules', 'detail_reschedules.reschedule_id', '=', 'reschedules.id')
            ->where('detail_reschedules.reschedule_id', '=', $id)
            ->select('detail_reschedules.id',
            'equipments.foto',
            'equipments.nama',
            'detail_reschedules.waktu_mulai',
            'detail_reschedules.waktu_selesai',
            'equipments.harga_sewa_perhari',
            'equipments.harga_sewa_perjam',
            'detail_reschedules.ket_verif_admin',
            'detail_reschedules.ket_konfirmasi')
            ->get();
        }elseif(!auth()->check() || auth()->user()->jabatan === 'kepala uptd'){
            $equipment = DB::table('detail_reschedules')
            ->join('equipments', 'detail_reschedules.equipment_id', '=', 'equipments.id')
            ->join('reschedules', 'detail_reschedules.reschedule_id', '=', 'reschedules.id')
            ->where('detail_reschedules.reschedule_id', '=', $id)
            ->where('detail_reschedules.ket_verif_admin', '=', 'verif')
            ->select('detail_reschedules.id',
            'equipments.foto',
            'equipments.nama',
            'detail_reschedules.waktu_mulai',
            'detail_reschedules.waktu_selesai',
            'equipments.harga_sewa_perhari',
            'equipments.harga_sewa_perjam',
            'detail_reschedules.ket_verif_admin',
            'detail_reschedules.ket_persetujuan_kepala_uptd',
            'detail_reschedules.ket_konfirmasi')
            ->get();
        }
        // $detail_refund = DB::table('refunds')->join('detail_refunds', 'detail_refunds.refund_id', '=', 'refunds.id')->get();
        return view('detail_reschedule', [
            'reschedule' => $reschedule,
            'detail_reschedule' => $detail_reschedule,
            'equipment' => $equipment,
            // 'detail_refund' => $detail_refund
        ]);
    }

    public function search(Request $request)
    {
        $pagination  = 5;
        $reschedules    = Reschedule::when($request->keyword, function ($query) use ($request) {
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
        $reschedules->appends($request->only('keyword'));
        // dd(DB::getQueryLog());
        return view('reschedule', compact('reschedules'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function verifRescheduleAdmin(DetailReschedule $id){
        $result = DB::transaction(function () use ($id) {
            $id->update([
                'ket_verif_admin' => 'verif'
            ]);
            return $id->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            return redirect()->route('reschedules.index')->with('success', 'Verifikasi pengajuan reschedule berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('reschedules.index')->with('error', 'Verifikasi pengajuan reschedule gagal!');
        }
    }

    public function tolakRescheduleAdmin(Request $request, DetailReschedule $id){
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
            return redirect()->route('reschedules.index')->with('success', 'Penolakan pengajuan reschedule berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('reschedules.index')->with('error', 'Penolakan pengajuan reschedule gagal!');
        }
    }

    public function setujuRescheduleKepalaUPTD(DetailReschedule $id){
        $result = DB::transaction(function () use ($id) {
            $id->update([
                'ket_persetujuan_kepala_uptd' => 'setuju'
            ]);
            return $id->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            return redirect()->route('reschedules.index')->with('success', 'Persetujuan pengajuan reschedule berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('reschedules.index')->with('error', 'Persetujuan pengajuan reschedule gagal!');
        }
    }

    public function tolakRescheduleKepalaUPTD(Request $request, DetailReschedule $id){
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
            return redirect()->route('reschedules.index')->with('success', 'Penolakan pengajuan reschedule berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('reschedules.index')->with('error', 'Penolakan pengajuan reschedule gagal!');
        }
    }
}
