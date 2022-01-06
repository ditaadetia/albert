<?php

namespace App\Http\Controllers;

use App\Models\detailRefund;
use App\Models\Refund;
use Illuminate\Http\Request;

class DetailRefundController extends Controller
{
    public function show($id)
    {
        $tes = detailRefund::findOrFail($id);
        return view('detail_refund', [
            'tes' => $tes
            // 'detail_refund' => $detail_refund
        ]);
    }
}
