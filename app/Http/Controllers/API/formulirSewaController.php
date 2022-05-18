<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use App\Http\Resources\DetailOrderResource;
use Carbon\CarbonPeriod;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Illuminate\Support\Facades\Storage;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;

class formulirSewaController extends Controller
{
    public function formulirSewa(Request $request, $id)
    {
        $orders =Order::latest()->where('tenant_id', request('id'))->first();
        // $detail = DB::table('orders')
        // ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
        // ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        // ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        // ->where('orders.id', $request->id)
        // ->select('orders.nama_kegiatan', 'orders.id', 'orders.created_at', 'orders.tanggal_mulai', 'orders.tanggal_selesai', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam', 'tenants.nama', 'orders.ttd_kepala_uptd', 'orders.ttd_kepala_dinas', 'orders.ket_persetujuan_kepala_uptd', 'orders.ket_persetujuan_kepala_dinas', 'orders.nama_instansi')->first();

        $detail_orders = DB::table('orders')
        ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        ->where('orders.tenant_id', request('id'))
        ->where('orders.id', $orders->id)
        ->select('equipments.nama', 'equipments.id')
        ->latest('orders.created_at')
        ->get();

        $detail_order_id = DB::table('orders')
        ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        ->where('order_id', $request->id)
        ->select('detail_orders.id', 'equipments.nama')->get();

        $kepala_uptd = DB::table('users')->where('jabatan', 'kepala uptd')->select('name', 'pangkat', 'nip')->first();
        $kepala_dinas = DB::table('users')->where('jabatan', 'kepala dinas')->first();

        $order1 = DB::table('orders')
        ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
        ->where('tenants.id', request('id'))
        ->select('orders.nama_instansi', 'orders.ttd_pemohon', 'orders.category_order_id', 'orders.ktp', 'orders.surat_ket', 'orders.akta_notaris', 'orders.alamat_instansi', 'tenants.nama', 'tenants.alamat', 'orders.jabatan', 'tenants.no_hp', 'tenants.kontak_darurat', 'orders.nama_kegiatan', 'ket_persetujuan_kepala_dinas', 'ttd_kepala_dinas', 'ket_persetujuan_kepala_uptd', 'orders.ttd_kepala_uptd', 'orders.id')
        ->latest('orders.created_at')
        ->first();

        $detail1 = DB::table('orders')
        ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        ->where('orders.id', $request->id)
        ->select('orders.id', 'equipments.nama')
        ->get();

        $kepala_dinas1 = DB::table('users')->where('jabatan', 'kepala dinas')->first();

        // $pdf1 = PDF::loadView('download_surat_persetujuan', ['order1' => $order1, 'detail' => $detail1, 'detail_orders' => $detail_orders, 'kepala_dinas' =>$kepala_dinas1]);
        // dd($pdf1->stream());
        // $pdf1->setPaper('A4', 'potrait');
        // $path = public_path('storage/surat_persetujuan');
        // $pdf1->save($path . '/' . 'surat_persetujuan_' . $request->id . '.pdf');

        // instantiate and use the dompdf class
        $pdf = PDF::loadView('surat_permohonan', ['orders' => $orders, 'order1' => $order1, 'detail1' => $detail1, 'detail_orders' => $detail_orders, 'kepala_uptd' =>$kepala_uptd, 'kepala_dinas' =>$kepala_dinas]);
        $pdf->setPaper('A4', 'potrait');
        $path = public_path('storage/surat_permohonan');
        $pdf->save($path . '/' . 'surat_permohonan_' . $orders->nama_kegiatan .'_'. $orders->id . '.pdf');

        // $id_dok=Order::where('id', $id)->select('id');
        Order::latest()->where('tenant_id', request('id'))->first()
        ->update([
            'surat_permohonan' => 'surat_permohonan_' . $orders->nama_kegiatan .'_'. $orders->id . '.pdf'
        ]);
        return response()->json(["status" => "success", "success" => true, "message" => "Berhasil!"]);
        // return redirect()->route('index', ['category' => '1'])->with('success', 'Verifikasi pengajuan penyewaan berhasil!');
    }
}
