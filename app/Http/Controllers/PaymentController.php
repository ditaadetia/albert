<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\DetailPayment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::paginate(5);
        return view('payment', [
            'payments' => $payments
        ]);
    }

    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        $equipment = DB::table('orders')
        ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        ->where('orders.id', $id)
        ->select('orders.id', 'equipments.nama', 'equipments.foto', 'orders.tanggal_mulai', 'orders.tanggal_selesai', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam')
        ->get();
        // $detail_refund = DB::table('refunds')->join('detail_refunds', 'detail_refunds.refund_id', '=', 'refunds.id')->get();
        return view('detail_payment', [
            'payment' => $payment,
            'equipment' => $equipment
            // 'detail_refund' => $detail_refund
        ]);
    }

    public function search(Request $request)
    {
        $pagination  = 5;
        $payments    = Payment::when($request->keyword, function ($query) use ($request) {
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
        $payments->appends($request->only('keyword'));
        // dd(DB::getQueryLog());
        return view('payment', compact('payments'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function downloadBuktiPembayaran($id){
        $model_file = Payment::findOrFail($id); //Mencari model atau objek yang dicari
        $file = public_path() . '/storage/bukti_pembayaran/' . $model_file->bukti_pembayaran;//Mencari file dari model yang sudah dicari
        return response()->download($file, $model_file->bukti_pembayaran); //Download file yang dicari berdasarkan nama file
    }

    public function verifPembayaran(Payment $id){
        $result = DB::transaction(function () use ($id) {
            $id->update([
                'konfirmasi_pembayaran' => 1
            ]);
            return $id->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            return redirect()->route('payments.index')->with('success', 'Verifikasi pembayaran berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('payments.index')->with('error', 'Verifikasi pembayaran gagal!');
        }
    }

    public function tolakPembayaran(Request $request, Payment $id){
        $validated = $request->validate([
            'alasan' => 'string',
        ]);

        $result = DB::transaction(function () use ($validated, $request, $id) {
            $id->update([
                'ket_konfirmasi' => $validated['alasan'],
            ]);
            return $id->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            return redirect()->route('payments.index')->with('success', 'Penolakan pembayaran berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('payments.index')->with('error', 'Penolakan pembayaran gagal!');
        }
    }
}
