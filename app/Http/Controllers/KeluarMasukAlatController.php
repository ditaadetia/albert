<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KeluarMasukAlat;
use App\Models\Order;
use App\Models\detailKeluarMasukAlat;
use App\Models\DetailOrder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
setlocale(LC_TIME, 'id_ID');
\Carbon\Carbon::setLocale('id');
\Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");

class KeluarMasukAlatController extends Controller
{
    public function index()
    {
        $keluar_masuk_alats = order::paginate(5);
        $total = DetailOrder::where('status', '=', 'Belum Diambil');
        return view('keluar_masuk_alat', [
            'keluar_masuk_alats' => $keluar_masuk_alats,
            'total' => $total
        ]);
    }

    // public function show($id)
    // {
    //     $keluar_masuk_alat = DB::table('detail_keluar_masuk_alats')
    //     ->join('orders', 'detail_keluar_masuk_alats.order_id', '=', 'orders.id')
    //     ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
    //     ->first();
    //     $equipment = DB::table('detail_keluar_masuk_alats')
    //         ->join('equipments', 'detail_keluar_masuk_alats.equipment_id', '=', 'equipments.id')
    //         ->join('orders', 'detail_keluar_masuk_alats.order_id', '=', 'orders.id')
    //         ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
    //         ->where('detail_keluar_masuk_alats.order_id', '=', $id)
    //         ->where('detail_orders.order_id', '=', $id)
    //         ->select(
    //         'equipments.foto',
    //         'equipments.nama',
    //         'orders.tanggal_mulai',
    //         'orders.tanggal_selesai',
    //         'detail_keluar_masuk_alats.tanggal_ambil',
    //         'detail_keluar_masuk_alats.tanggal_kembali',
    //         'detail_keluar_masuk_alats.status')
    //     ->get();
    //     // $detail_refund = DB::table('refunds')->join('detail_refunds', 'detail_refunds.refund_id', '=', 'refunds.id')->get();
    //     return view('detail_keluar_masuk', [
    //         'keluar_masuk_alat' => $keluar_masuk_alat,
    //         'equipment' => $equipment
    //         // 'detail_refund' => $detail_refund
    //     ]);
    // }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $detail = DB::table('detail_orders')->join('orders', 'detail_orders.order_id', '=', 'orders.id')
        ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        ->select('detail_orders.id','equipments.foto', 'equipments.nama', 'orders.tanggal_mulai', 'orders.tanggal_selesai', 'detail_orders.status', 'detail_orders.tanggal_ambil', 'detail_orders.tanggal_kembali')
        ->where('detail_orders.order_id', '=', $id)
        ->get();
            return view('detail_keluar_masuk', [
            'order' => $order,
            'detail' => $detail,
        ]);
    }

    public function search(Request $request)
    {
        $pagination  = 5;
        $keluar_masuk_alats    = Order::when($request->keyword, function ($query) use ($request) {
                $query
                ->where('nama_kegiatan', 'like', "%{$request->keyword}%")
                ->orWhere('nama_instansi', 'like', "%{$request->keyword}%");

            // $query
            // ->orWhereHas('tenant', function($query) use($request) {
            //     $query
            //     ->where('nama', 'like', "%{$request->keyword}%");
            // });
        })

        ->orderBy('created_at', 'desc')->paginate($pagination);
        $keluar_masuk_alats->appends($request->only('keyword'));
        // dd(DB::getQueryLog());
        return view('keluar_masuk_alat', compact('keluar_masuk_alats'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function alatKeluar(DetailOrder $id){
        $result = DB::transaction(function () use ($id) {
            $id->update([
                'status' => 'Sedang Dipakai',
                'tanggal_ambil' => Carbon::now()
            ]);
            return $id->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            return redirect()->route('keluar-masuk-alat.index')->with('success', 'Berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('keluar-masuk-alat.index')->with('error', 'Gagal!');
        }
    }

    public function alatMasuk(DetailOrder $id){
        $result = DB::transaction(function () use ($id) {
            $id->update([
                'status' => 'Selesai',
                'tanggal_kembali' => Carbon::now()
            ]);
            return $id->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            return redirect()->route('keluar-masuk-alat.index')->with('success', 'Berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('keluar-masuk-alat.index')->with('error', 'Gagal!');
        }
    }

    public function tolakPembayaran(Request $request, KeluarMasukAlat $id){
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
