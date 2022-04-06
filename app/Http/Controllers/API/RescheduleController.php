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
            'keterangan' => ''
        ]);

        $result = DB::transaction(function () use ($validator, $request) {
            return DetailReschedule::create($validator);
        });

        return response()->json(["status" => "success", "success" => true, "message" => "Pengajuan Reschedule Berhasil!", 'data' => new DetailRescheduleResource($result)]);
        // if ($result){
        // }
    }

    public function index(Request $request, $id)
    {
        $reschedules = DB::table('orders')
        ->join('detail_reschedules', 'detail_reschedules.order_id', '=', 'orders.id')
        ->where('tenant_id', request('id'))
        ->get();

        $data=[];
        foreach ($reschedules as $reschedule){
            $data[]= [
                'id' => $reschedule->id,
                'created_at' => $reschedule->created_at,
                'ket_verif_admin' => $reschedule->ket_verif_admin,
                'ket_persetujuan_kepala_uptd' => $reschedule->ket_persetujuan_kepala_uptd,
                'ket_persetujuan_kepala_dinas' => $reschedule->ket_persetujuan_kepala_dinas,
                'alat' =>
                    $equipments = DB::table('detail_reschedules')
                    ->join('orders', 'detail_reschedules.order_id', '=', 'orders.id')
                    ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
                    ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
                    ->select('orders.id', 'detail_reschedules.waktu_mulai', 'detail_reschedules.waktu_selesai', 'equipments.nama', 'equipments.foto')
                    ->where('detail_reschedules.order_id', $reschedule->id)
                    ->get()
            ];
        }
        return response()->json($data);
        // $tenants = DB::table('equipments')->whereBetween('id', [1, 7])->orWhere('nama', 'Lainnya')->get();
        // return response()->json($tenants);
    }
}
