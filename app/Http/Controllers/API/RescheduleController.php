<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailReschedule;
use App\Http\Resources\RefundResource;
use App\Http\Resources\DetailRescheduleResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use App\Mail\Reschedule as Reschedules;
use Illuminate\Support\Facades\Mail;

class RescheduleController extends Controller
{
    public function store(Request $request)
    {
        $validator = $request->validate([
            'detail_order_id' => 'required|integer',
            'order_id' => 'required|integer',
            'waktu_mulai' => 'required|date|max:255',
            'waktu_selesai' => 'required|date|max:255',
            'ket_verif_admin' => 'required|string',
            'ket_persetujuan_kepala_uptd' => 'required|string',
            'keterangan' => '',
            // 'alasan_refund' => 'required|string'
        ]);

        $result = DB::transaction(function () use ($validator, $request) {
            return DetailReschedule::create($validator);
        });
        $staff = DB::table('users')
                ->where('jabatan', '=', 'admin')->first();
        $data = DB::table('detail_reschedules')
                ->join('orders', 'detail_reschedules.order_id', '=', 'orders.id')
                ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
                // ->where('orders.id', '=', $tes)
                ->first();
        Mail::to($staff->email)->send(new Reschedules($data));
        return response()->json(["status" => "success", "success" => true, "message" => "Pengajuan Reschedule Berhasil!", 'data' => new DetailRescheduleResource($result)]);
        // if ($result){
        // }
    }

    public function index(Request $request, $id)
    {
        $reschedules = DB::table('orders')
        ->where('orders.tenant_id', request('id'))
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('detail_reschedules')
                  ->whereColumn('detail_reschedules.order_id', 'orders.id');
                })
        // ->select('orders.id', 'detail_reschedules.created_at', 'detail_reschedules.ket_verif_admin', 'detail_reschedules.ket_persetujuan_kepala_uptd')
        ->orderByDesc('orders.created_at')
        ->get();
        $data=[];
        foreach ($reschedules as $reschedule){
            $data[]= [
                'id' => $reschedule->id,
                'created_at' => $reschedule->created_at,
                'ket_verif_admin' => $reschedule->ket_verif_admin,
                'ket_persetujuan_kepala_uptd' => $reschedule->ket_persetujuan_kepala_uptd,
                'alat' =>
                    DB::table('detail_reschedules')
                    ->join('orders', 'detail_reschedules.order_id', '=', 'orders.id')
                    ->join('detail_orders', 'detail_reschedules.detail_order_id', '=', 'detail_orders.id')
                    ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
                    ->select('detail_reschedules.id', 'detail_reschedules.waktu_mulai', 'detail_reschedules.waktu_selesai', 'equipments.nama', 'equipments.foto')
                    ->where('detail_reschedules.order_id', $reschedule->id)
                    ->orderByDesc('orders.created_at')
                    ->get()
            ];
        }
        return response()->json($data);
        // $tenants = DB::table('equipments')->whereBetween('id', [1, 7])->orWhere('nama', 'Lainnya')->get();
        // return response()->json($tenants);
    }
}
