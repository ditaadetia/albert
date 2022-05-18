<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Skr;
use PDF;
use App\Models\DetailPayment;
use Illuminate\Support\Facades\Mail;
use App\Mail\SKR as suratKetetapanRetribusi;
use Illuminate\Support\Facades\Request as FacadesRequest;

class SkrController extends Controller
{
    public function index()
    {
        $skrs = Order::where(['ket_persetujuan_kepala_dinas' => 'setuju',  'category_order_id' => 1])
        ->orderByDesc('orders.created_at')
        ->paginate(5);

        return view('skr', [
            'skrs' => $skrs
        ]);
    }

    public function show($id)
    {

        $skr = DB::table('orders')
        // ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
        ->where('orders.id', $id)
        ->select('orders.id', 'tenants.nama', 'tenants.foto', 'tenants.no_hp', 'tenants.kontak_darurat', 'tenants.alamat')
        ->first();

        return view('detail_skr', [
            'skr' => $skr
            // 'detail_refund' => $detail_refund
        ]);
    }

    public function search(Request $request)
    {
        $pagination  = 5;
        $skrs    = Order::when($request->keyword, function ($query) use ($request) {
            $query
            ->whereHas('tenant', function($query) use($request) {
                $query
                ->where('nama', 'like', "%{$request->keyword}%")
                ->orWhere('nama_kegiatan', 'like', "%{$request->keyword}%");
            });
        })

        ->orderBy('created_at', 'desc')->paginate($pagination);
        $skrs->appends($request->only('keyword'));
        // dd(DB::getQueryLog());
        return view('Skr', compact('skrs'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function downloadBuktiPembayaran($id){
        $model_file = Skr::findOrFail($id); //Mencari model atau objek yang dicari
        $file = public_path() . '/storage/bukti_pembayaran/' . $model_file->bukti_pembayaran;//Mencari file dari model yang sudah dicari
        return response()->download($file, $model_file->bukti_pembayaran); //Download file yang dicari berdasarkan nama file
    }

    public function setujuBendahara($id){
        $order = Order::findOrFail($id);
        return view('signature_pad', [
            'order' => $order
        ]);
    }

    // public function terbitSkr(Request $request, $id){
    //     $skr = DB::table('skr')
    //     ->join('orders', 'skr.order_id', '=', 'orders.id')
    //     ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
    //     ->select('skr.id', 'tenants.nama', 'tenants.alamat', 'orders.nama_kegiatan', 'orders.ttd_kepala_dinas')
    //     ->first();

    //     $kepala_dinas = DB::table('users')->where('jabatan', 'kepala dinas')->first();

    //     // $pdf = PDF::loadView('skr-pdf', ['skr' => $skr]);
    //     // $pdf->setPaper('A4', 'potrait');
    //     // $path = public_path('storage/skr');
    //     // $pdf->save($path . '/' . 'skr-' . $request->id . '.pdf');

    //     // $result = Skr::create([
    //     //     'order_id' => $id,
    //     //     'skr' => 'skr'
    //     // ]);
    //     return view('signature_pad', [
    //         'skr' => $skr,
    //         'kepala_dinas' => $kepala_dinas
    //     ]);
    //     // return view('skr-pdf', [
    //     //     'skr' => $skr,
    //     //     'kepala_dinas' => $kepala_dinas
    //     // ]);

    //     // if ($result) {
    //     //     //redirect dengan pesan sukses
    //     //     return redirect()->route('skrs.index')->with('success', 'Terbit SKR berhasil!');
    //     // } else {
    //     //     //redirect dengan pesan error
    //     //     return redirect()->route('skrs.index')->with('error', 'Terbit SKR gagal!');
    //     // }
    // }

    public function ttdBendahara(Request $request, $id){
        $folderPath = public_path('storage/ttd-bendahara/');
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = uniqid() . '.'.$image_type;
        file_put_contents($folderPath . $file, $image_base64);
        // echo "<h3><i>Upload Tanda Tangan Berhasil..</i><h3>";


        if($file) {
            $sukses = DB::transaction(function () use ($request, $id, $file) {
                Skr::create([
                    'order_id' => $id,
                    'skr' => 'skr-' . $request->id . '.pdf',
                    'ttd_bendahara' => 'ttd-bendahara/' . $file
                ]);
            });
        }
        $data = DB::table('orders')
            ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')->where('orders.id', '=', $id)->first();
        // $data['nama_instansi'] = $tes->nama_instansi;
        $position='admin_to_kepala_uptd';
        $alat = DB::table('detail_orders')
            ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
            ->join('orders', 'detail_orders.order_id', '=', 'orders.id')
            ->where('detail_orders.order_id', '=', $id)->get();
        $total =0;
        foreach($alat as $alat){
            $awal=date_create($alat->tanggal_mulai);
            $akhir=date_create($alat->tanggal_selesai);
            $diff=date_diff($awal, $akhir);
            if($diff->days >0){
                $harga = $alat->harga_sewa_perhari * $diff->days;
            }
            else{
                $harga = $alat->harga_sewa_perjam * $diff->h;
            }
            $total= $total + $harga;
        }
        Mail::to($data->email)->send(new suratKetetapanRetribusi($data, $total));
        return redirect()->action([generateSkrController::class, 'generateSkr'], ['id' => $id]);
    }
}

