<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailOrder;
use App\Http\Resources\DetailOrderResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class DetailOrderController extends Controller
{
    public function store(Request $request)
    {
        $validator = $request->validate([
            'order_id' => 'required|integer',
            'equipment_id' => 'required|integer',
        ]);

        $result = DB::transaction(function () use ($validator, $request) {
            return DetailOrder::create($validator);
        });

        return response()->json(['Program created successfully.', new DetailOrderResource($result)]);
        // if ($result){
        // }
    }
}
