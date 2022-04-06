<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PDF;
use App\Models\Order;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PDFController;

class DokumenSewaController extends Controller
{
    public function dokumenSewa(Request $request)
    {
        $order = Order::where('id', $request->id)->select('nama_kegiatan', 'id', 'created_at', 'nama_instansi','tanggal_mulai', 'tanggal_selesai')->first();
        // $detail = DB::table('orders')
        // ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
        // ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        // ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        // ->where('orders.id', $request->id)
        // ->select('orders.nama_kegiatan', 'orders.id', 'orders.created_at', 'orders.tanggal_mulai', 'orders.tanggal_selesai', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam', 'tenants.nama', 'orders.ttd_kepala_uptd', 'orders.ttd_kepala_dinas', 'orders.ket_persetujuan_kepala_uptd', 'orders.ket_persetujuan_kepala_dinas', 'orders.nama_instansi')->first();

        $detail_orders = DB::table('orders')
        ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        ->where('order_id', $request->id)
        ->select('orders.tanggal_mulai', 'orders.tanggal_selesai', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam', 'equipments.nama', 'equipments.jenis', 'equipments.id')->get();

        $detail_order_id = DB::table('orders')
        ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        ->where('order_id', $request->id)
        ->select('detail_orders.id', 'equipments.nama')->get();

        $kepala_uptd = DB::table('users')->where('jabatan', 'kepala uptd')->select('name', 'pangkat', 'nip')->first();
        $kepala_dinas = DB::table('users')->where('jabatan', 'kepala dinas')->first();

        $order1 = DB::table('orders')
        ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
        ->where('orders.id', $request->id)
        ->select('orders.id', 'orders.nama_instansi', 'tenants.nama', 'orders.nama_kegiatan', 'ket_persetujuan_kepala_dinas', 'ttd_kepala_dinas', 'ket_persetujuan_kepala_uptd', 'orders.ttd_kepala_uptd')
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
        $pdf = PDF::loadView('dokumen_sewa', ['order' => $order, 'order1' => $order1, 'detail1' => $detail1, 'detail_orders' => $detail_orders, 'kepala_uptd' =>$kepala_uptd, 'kepala_dinas' =>$kepala_dinas]);
        $pdf->setPaper('A4', 'potrait');
        $path = public_path('storage/dokumen_sewa');
        $pdf->save($path . '/' . 'dokumen_sewa_' . $request->id . '.pdf');

        // $id_dok=Order::where('id', $id)->select('id');
        Order::where('id', $request->id)
        ->update([
            'dokumen_sewa' => 'dokumen_sewa_' . $request->id . '.pdf'
        ]);

        if(!auth()->check() || auth()->user()->jabatan === 'kepala dinas'){
            foreach($detail_order_id as $detail_order_id){
                DB::table('schedules')->insert([
                    'order_id' => $request->id,
                    'tanggal_mulai' => $order->tanggal_mulai,
                    'tanggal_selesai' => $order->tanggal_selesai,
                    'nama_order' => $detail_order_id->nama,
                    'detail_order_id' => $detail_order_id->id,
                ]);
            }
        }
        return redirect()->route('index', ['category' => '1'])->with('success', 'Verifikasi pengajuan penyewaan berhasil!');
    }

    public function lihatDokumenSewa(Request $request)
    {
        $order = Order::where('id', $request->id)->select('nama_kegiatan', 'id', 'created_at')->first();
        $detail = DB::table('orders')
        ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
        ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        ->where('order_id', $request->id)
        ->select('orders.nama_kegiatan', 'orders.id', 'orders.created_at', 'orders.tanggal_mulai', 'orders.tanggal_selesai', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam', 'tenants.nama', 'orders.ttd_kepala_uptd', 'orders.ttd_kepala_dinas', 'orders.ket_persetujuan_kepala_uptd', 'orders.ket_persetujuan_kepala_dinas', 'orders.nama_instansi')->first();

        $detail_orders = DB::table('orders')
        ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        ->where('order_id', $request->id)
        ->select('orders.tanggal_mulai', 'orders.tanggal_selesai', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam', 'equipments.nama', 'equipments.jenis', 'equipments.id')->get();

        $kepala_uptd = DB::table('users')->where('jabatan', 'kepala uptd')->select('name', 'pangkat', 'nip')->first();
        $kepala_dinas = DB::table('users')->where('jabatan', 'kepala dinas')->first();

        // instantiate and use the dompdf class
        return view('lihat_dokumen_sewa', [
            'order' => $order,
            'detail' => $detail,
            'detail_orders' => $detail_orders,
            'kepala_uptd' => $kepala_uptd,
            'kepala_dinas' => $kepala_dinas,
        ]);
    }
}