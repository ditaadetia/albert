<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Skr;
use PDF;

use Illuminate\Http\Request;

class generateSkrController extends Controller
{
    public function generateSkr(Request $request) {
        $skr = DB::table('skr')
        ->join('orders', 'skr.order_id', '=', 'orders.id')
        ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
        ->select('skr.id', 'tenants.nama', 'tenants.alamat', 'orders.nama_kegiatan', 'orders.ttd_kepala_dinas', 'skr.ttd_bendahara')
        ->first();

        $kepala_dinas = DB::table('users')->where('jabatan', 'kepala dinas')->first();
        $bendahara = DB::table('users')->where('jabatan', 'bendahara')->first();

        $pdf = PDF::loadView('skr-pdf',[
            'skr' => $skr,
            'kepala_dinas' => $kepala_dinas,
            'bendahara' => $bendahara
        ]);

        $pdf->setPaper('A4', 'potrait');
        $path = public_path('storage/skr');
        $pdf->save($path . '/' . 'skr-' . $request->id . '.pdf');

        if($pdf) {
            return redirect()->route('skrs.index')->with('success', 'Terbit SKR berhasil!');
        }

        // return view('skr-pdf', [
        //     'skr' => $skr,
        //     'kepala_dinas' => $kepala_dinas,
        //     'bendahara' => $bendahara
        // ]);
    }
}
