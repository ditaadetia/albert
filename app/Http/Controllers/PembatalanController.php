<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Schedule;
use App\Models\Equipment;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;

class PembatalanController extends Controller
{
    public function pembatalan()
    {
        $orders =[];
        // dd($category);
        $orders = Order::whereExists(function ($query) {
            $query->select(DB::raw(1))
                    ->from('detail_orders')
                    ->where('detail_orders.pembatalan', 1)
                    ->whereColumn('detail_orders.order_id', 'orders.id');
                })->paginate(5);
        return view('pembatalan', [
            'orders' => $orders
        ]);
    }

    public function detailPembatalan($id)
    {
        $order = Order::findOrFail($id);
        $detail = DB::table('orders')->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')->where('orders.id', '=', $id)->where('detail_orders.pembatalan', '=', 1)->get();
        $equipment = DB::table('equipments')->join('detail_orders', 'detail_orders.equipment_id', '=', 'equipments.id')->get();
        return view('detail_pembatalan', [
            'order' => $order,
            'detail' => $detail,
            'equipment' => $equipment
        ]);
    }
    public function searchPembatalan(Request $request)
    {
        $pagination  = 5;
        if(!auth()->check() || auth()->user()->jabatan === 'admin'){
            $orders    = Order::when($request->keyword, function ($query) use ($request) {
                $query
                ->whereHas('tenant', function($query) use($request) {
                    $query
                    ->where('nama', 'like', "%{$request->keyword}%")
                    ->orWhere('nama_kegiatan', 'like', "%{$request->keyword}%");
                })
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('detail_orders')
                          ->where('detail_orders.pembatalan', 1)
                          ->whereColumn('detail_orders.order_id', 'orders.id');
                });
            })->orderBy('created_at', 'desc')->paginate($pagination);
        }elseif(!auth()->check() || auth()->user()->jabatan === 'kepala uptd'){
            $orders    = Order::when($request->keyword, function ($query) use ($request) {
                $query
                ->where('ket_verif_admin', '=', 'verif')
                ->whereHas('tenant', function($query) use($request) {
                    $query
                    ->where('nama', 'like', "%{$request->keyword}%")
                    ->orWhere('nama_kegiatan', 'like', "%{$request->keyword}%");
                })
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('detail_orders')
                          ->where('detail_orders.pembatalan', 1)
                          ->whereColumn('detail_orders.order_id', 'orders.id');
                });
            })->orderBy('created_at', 'desc')->paginate($pagination);
        }elseif(!auth()->check() || auth()->user()->jabatan === 'kepala dinas'){
            $orders    = Order::when($request->keyword, function ($query) use ($request) {
                $query
                ->where('ket_persetujuan_kepala_uptd', '=>', 'setuju')
                ->whereHas('tenant', function($query) use($request) {
                    $query
                    ->where('nama', 'like', "%{$request->keyword}%")
                    ->orWhere('nama_kegiatan', 'like', "%{$request->keyword}%");
                })
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('detail_orders')
                          ->where('detail_orders.pembatalan', 1)
                          ->whereColumn('detail_orders.order_id', 'orders.id');
                });
            })->orderBy('created_at', 'desc')->paginate($pagination);
        }
        $orders->appends($request->only('keyword'));

        // $equipments    = Equipment::when($request->keyword, function ($query) use ($request) {
        //         $query
        //         ->where('nama', 'like', "%{$request->keyword}%");
        // })->orderBy('created_at', 'desc')->paginate($pagination);
        // $equipments->appends($request->only('keyword'));

        // dd(DB::getQueryLog());
        return view('pembatalan', compact('orders'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function cancelExcel(Request $request)
    {
        $validated = $request->validate([
            'tanggal_awal' => 'date',
            'tanggal_akhir' => 'date',
        ]);
        $tanggal_awal=$validated['tanggal_awal'];
        $tanggal_akhir=$validated['tanggal_akhir'];

        $orders = DB::table('orders')
        ->join('tenants', 'tenants.id', '=', 'orders.tenant_id')
        // ->where('ket_persetujuan_kepala_dinas', 'setuju')
        ->whereBetween('orders.created_at', [$tanggal_awal, $tanggal_akhir])
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('detail_orders')
                  ->where('detail_orders.pembatalan', 1)
                  ->whereColumn('detail_orders.order_id', 'orders.id');
        })
        ->get();
        // $detail_orders = DB::table('orders')
        // ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        // ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        // // ->where('orders.id', 'detail_orders.order_id')
        // ->select('orders.tanggal_mulai', 'orders.tanggal_selesai', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam', 'equipments.nama', 'equipments.jenis', 'equipments.id')->get();
        return view('pembatalan-excel', [
            'orders' => $orders,
            // 'detail_orders' => $detail_orders
        ]);
    }
}
