<?php

namespace App\Http\Controllers;
use App\Models\DetailOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DetailOrderController extends Controller
{
    // public function index($id)
    // {
    //     $detail = DB::table('detail_orders')->leftjoin('orders', 'detail_orders.order_id', '=', 'orders.id')->leftjoin('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')->get();
    //     return view('detail_order', [
    //         'detail' => $detail
    //     ]);
    // }

    // public function show($id)
    // {
    //     $order = DetailOrder::findOrFail($id);
    //     $detail = DB::table('detail_orders')->leftjoin('orders', 'detail_orders.order_id', '=', 'orders.id')->leftjoin('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')->get();
    //     $equipment = DB::table('orders')->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')->get();
    //     return view('detail_order', [
    //         'order' => $order,
    //         'detail' => $detail,
    //         'equipment' => $equipment
    //     ]);
    // }
}
