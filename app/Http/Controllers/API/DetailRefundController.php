<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\detailRefund;
use App\Http\Resources\DetailOrderResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use App\Mail\Refund;
use Illuminate\Support\Facades\Mail;

class DetailRefundController extends Controller
{
    public function store(Request $request)
    {
        $validator = $request->validate([
            'order_id' => 'required|integer',
            'detail_order_id' => 'required|integer',
        ]);
        // $order = Refund::where('order_id', request('id'))->first();

        $data = DB::table('orders')
            ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')->where('orders.id', '=', $validator['order_id'])->first();
        // $data['nama_instansi'] = $tes->nama_instansi;
        $staff = DB::table('users')
            ->where('jabatan', '=', 'admin')->first();
        $alat = DB::table('detail_orders')
            ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
            ->join('orders', 'detail_orders.order_id', '=', 'orders.id')
            ->where('detail_orders.order_id', '=', $validator['order_id'])->get();
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
        $position='penyewa_to_admin';
        $tenants = DB::table('detail_orders')
            ->where('detail_orders.id', request('id'))
            ->where('detail_orders.pembatalan', 1)
            ->first();
            if($tenants->status !== 'Sedang Dipakai'){
                $result = DB::transaction(function () use ($validator, $request) {
                    // if ($request->hasFile('surat_permohonan_refund')) {
                    //     // store the 'foto' into the 'public' disk
                    //     $validator['surat_permohonan_refund'] = $request->file('surat_permohonan_refund')->store('surat_permohonan_refund', 'public');
                    // }
                    detailRefund::create($validator);
                });
                Mail::to($staff->email)->send(new Refund($data, $total_bayar, $position));
                return response()->json(["status" => "success", "success" => true, "message" => "Pengajuan Detail Refund Berhasil!"]);
            }else{
                return response()->json(["status" => "failed", "success" => false, "message" => "Kembalikan alat terlebih dahulu!"]);
            }
        // if ($result){
        // }
    }
}
