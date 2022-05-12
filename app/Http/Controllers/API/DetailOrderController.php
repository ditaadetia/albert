<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailOrder;
use App\Models\Order;
use App\Http\Resources\DetailOrderResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\formulirSewaController;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class DetailOrderController extends Controller
{
    public function index()
    {
        $tenants = DB::table('detail_orders')
        ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        ->select('detail_orders.id', 'detail_orders.order_id', 'detail_orders.equipment_id', 'equipments.nama')
        // ->where('orders.id', 'detail_orders.order_id')
        ->get();
        return response()->json($tenants);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'order_id' => 'required|integer',
            'equipment_id' => 'required|integer',
        ]);
        $order = Order::latest()->where('tenant_id', request('id'))->first();

        $result = DB::transaction(function () use ($validator, $request) {
            return DetailOrder::create($validator);
        });

        if($result){
            $detail = DetailOrder::latest()->first();
            $order_id = DB::transaction(function () use ($validator, $request, $order, $detail) {
                $detail->update([
                    'order_id' => $order->id,

                ]);
                return $detail->save();
            });
        }

        if($validator) {
            return redirect()->action([formulirSewaController::class, 'formulirSewa'], ['id' => request('id')]);
        }

        return response()->json(['Program created successfully.', new DetailOrderResource($result)]);
        // if ($result){
        // }
    }
}
