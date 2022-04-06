<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Refund;
use App\Http\Resources\RefundResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class RefundController extends Controller
{
    public function store(Request $request)
    {
        $validator = $request->validate([
            'order_id' => 'required|integer',
            'tenant_id' => 'required|integer',
            'surat_permohonan_refund' => 'file|max:2048|mimes:png,jpg,jpeg',
            'metode_refund' => 'required|string',
        ]);

        $result = DB::transaction(function () use ($validator, $request) {
            if ($request->hasFile('surat_permohonan_refund')) {
                // store the 'foto' into the 'public' disk
                $validator['surat_permohonan_refund'] = $request->file('surat_permohonan_refund')->store('surat_permohonan_refund', 'public');
            }
            return Refund::create($validator);
        });

        return response()->json(['Program created successfully.', new RefundResource($result)]);
        // if ($result){
        // }
    }

    public function index()
    {
        $refunds = DB::table('orders')
        ->join('refunds', 'refunds.order_id', '=', 'orders.id')
        ->get();

        $data=[];
        foreach ($refunds as $refund){
            $data[]= [
                'id' => $refund->id,
                'created_at' => $refund->created_at,
                'metode_refund' => $refund->metode_refund,
                'ket_verif_admin' => $refund->ket_verif_admin,
                'ket_persetujuan_kepala_uptd' => $refund->ket_persetujuan_kepala_uptd,
                'ket_persetujuan_kepala_dinas' => $refund->ket_persetujuan_kepala_dinas,
                'alat' =>
                    $equipments = DB::table('refunds')
                    ->join('detail_refunds', 'detail_refunds.refund_id', '=', 'refunds.id')
                    ->join('orders', 'refunds.order_id', '=', 'orders.id')
                    ->join('equipments', 'detail_refunds.equipment_id', '=', 'equipments.id')
                    ->select('orders.id', 'detail_refunds.jumlah_hari_refund', 'detail_refunds.jumlah_jam_refund', 'equipments.nama', 'equipments.foto', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam')
                    ->where('detail_refunds.refund_id', $refund->id)
                    ->get()
            ];
        }
        return response()->json($data);
        // $tenants = DB::table('equipments')->whereBetween('id', [1, 7])->orWhere('nama', 'Lainnya')->get();
        // return response()->json($tenants);
    }
}
