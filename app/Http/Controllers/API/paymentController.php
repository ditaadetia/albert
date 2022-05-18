<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\OrderController as APIOrderController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skr;
use App\Models\Payment;
use App\Http\Resources\OrderResource;
use App\Http\Resources\DetailOrderResource;
use Carbon\CarbonPeriod;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\pemberitahuanPembayaran;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Illuminate\Support\Facades\Storage;
setlocale(LC_TIME, 'id_ID');
\Carbon\Carbon::setLocale('id');
\Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
use Illuminate\Support\Carbon;

class paymentController extends Controller
{
    public function skrPdf(Request $request)
    {
        $orders = Skr::where('order_id', request('id'))->first();
        $pathToFile = public_path() . '/storage/skr/' . $orders->skr;
        return response()->file($pathToFile);
        // return response()->json(['Program created successfully.', new OrderResource($orders->surat_permohonan)]);
        // return response()->json(["status" => "success", "success" => true, "message" => "Edit Profil Berhasil!", 'data' => new OrderResource($result)]);
        // if ($result){
        // }
    }

    public function cekSkr(Request $request)
    {
        $orders = Skr::where('order_id', request('id'))->first();
        if($orders != null){
            return response()->json(["status" => "success", "success" => true, "message" => "SKR telah terbit!", 'data' => $orders]);
        }else {
            return response()->json(["status" => "failed", "success" => false, "message" => "SKR belum terbit!"]);
        }
        // return response()->json(['Program created successfully.', new OrderResource($orders->surat_permohonan)]);
        // return response()->json(["status" => "success", "success" => true, "message" => "Edit Profil Berhasil!", 'data' => new OrderResource($result)]);
        // if ($result){
        // }
    }
    public function skr(Request $request)
    {
        $orders = Skr::where('order_id', request('id'))->first();
         return response()->json(["status" => "success", "success" => true, "message" => "Get SKR!", 'data' => $orders]);
    }


    public function cekPayments(Request $request)
    {
        $orders = Payment::where('order_id', request('id'))->first();
        $skrs = Skr::where('order_id', request('id'))->first();
        if($orders != null){
            if($orders->konfirmasi_pembayaran==0){
                return response()->json(["status" => "1", "success" => true, "message" => "Telah Dibayar. Harap Menunggu verifikasi pembayaran!", 'konfirmasi_pembayaran' => $orders->konfirmasi_pembayaran]);
            }
            elseif($orders->konfirmasi_pembayaran==1){
                return response()->json(["status" => "2", "success" => true, "message" => "Telah Dibayar. Pembayaran berhasil diproses!", 'konfirmasi_pembayaran' => $orders->konfirmasi_pembayaran]);
            }
        }elseif ($orders == null) {
            if($skrs !=null){
                return response()->json(["status" => "3", "success" => false, "message" => "Belum Dibayar. Harap segera lakukan pembayaran!"]);
            }
            elseif($skrs ==null){
                return response()->json(["status" => "4", "success" => false, "message" => "SKR belum terbit. Belum dapat melakukan pembayaran!"]);
            }
        }
        // return response()->json(['Program created successfully.', new OrderResource($orders->surat_permohonan)]);
        // return response()->json(["status" => "success", "success" => true, "message" => "Edit Profil Berhasil!", 'data' => new OrderResource($result)]);
        // if ($result){
        // }
    }

    public function payments(Request $request)
    {
        $validator = $request->validate([
            'tenant_id' => 'required|integer',
            'order_id' => 'required|integer',
            'total' => 'required|integer',
        ]);

        $order = DB::table('payments')->get();

        $result = DB::transaction(function () use ($validator, $request) {
            return Payment::create($validator);
        });

        // return response()->json(['Program created successfully.', new OrderResource($result)]);
        $data = DB::table('orders')
            ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')->where('orders.id', '=', $validator['order_id'])->first();
        // $data['nama_instansi'] = $tes->nama_instansi;
        $staff = DB::table('users')
            ->where('jabatan', '=', 'bendahara')->first();
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
        $payment = DB::table('payments')
                ->join('orders', 'payments.order_id', '=', 'orders.id')->where('orders.id', '=', $validator['order_id'])->first();
        $skr = DB::table('skr')
                ->join('orders', 'skr.order_id', '=', 'orders.id')->where('orders.id', '=', $validator['order_id'])->first();
        $umurSkr = new Carbon($skr->created_at);
        $tanggalPayment = new Carbon($payment->created_at);
        $total_bayar =  $total;
        $position='penyewa_to_bendahara';
        Mail::to($staff->email)->send(new pemberitahuanPembayaran($data, $total_bayar, $position));
        return response()->json(["status" => "success", "success" => true, "message" => "Pembayaran Berhasil!", 'data' => $order]);
        // if ($result){
        // }
    }

    public function buktiPembayaran(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'bukti_pembayaran' => 'file|mimes:png,jpg,jpeg,pdf',
        ]);

        $order = Payment::latest()->where('order_id', request('id'))->first();

        $result = DB::transaction(function () use ($validator, $request, $order) {
            $order->update([
                'bukti_pembayaran' => $request->bukti_pembayaran,

            ]);
            if ($request->hasFile('bukti_pembayaran')) {

                // delete old image from 'public' disk


                // store the 'image' into the 'public' disk
                $order->bukti_pembayaran = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            }
            return $order->save();
        });

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        // return response()->json(['Program created successfully.', new OrderResource($result)]);
        return response()->json(["status" => "success", "success" => true, "message" => "Upload Bukti Pembayaran Berhasil!", 'foto' => asset('storage/' . $order->ktp)]);
        // if ($result){
        // }
    }
}
