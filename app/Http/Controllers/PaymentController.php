<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\DetailPayment;
use Illuminate\Support\Facades\Mail;
use App\Mail\pemberitahuanPembayaran;
setlocale(LC_TIME, 'id_ID');
\Carbon\Carbon::setLocale('id');
\Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
use Illuminate\Support\Carbon;
use App\Mail\Tolak;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::paginate(5);
        return view('payment', [
            'payments' => $payments
        ]);
    }

    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        $equipment = DB::table('orders')
        ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        ->where('orders.id', $id)
        ->select('orders.id', 'equipments.nama', 'equipments.foto', 'orders.tanggal_mulai', 'orders.tanggal_selesai', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam')
        ->get();
        // $detail_refund = DB::table('refunds')->join('detail_refunds', 'detail_refunds.refund_id', '=', 'refunds.id')->get();
        return view('detail_payment', [
            'payment' => $payment,
            'equipment' => $equipment
            // 'detail_refund' => $detail_refund
        ]);
    }

    public function search(Request $request)
    {
        $pagination  = 5;
        $payments    = Payment::when($request->keyword, function ($query) use ($request) {
            $query
            ->whereHas('order', function($query) use($request) {
                $query
                ->where('nama_kegiatan', 'like', "%{$request->keyword}%");
            });

            $query
            ->orWhereHas('tenant', function($query) use($request) {
                $query
                ->where('nama', 'like', "%{$request->keyword}%");
            });
        })

        ->orderBy('created_at', 'desc')->paginate($pagination);
        $payments->appends($request->only('keyword'));
        // dd(DB::getQueryLog());
        return view('payment', compact('payments'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function downloadBuktiPembayaran($id){
        $model_file = Payment::findOrFail($id); //Mencari model atau objek yang dicari
        $buktiPembayaran = trim($model_file->bukti_pembayaran, 'bukti_pembayaran/');
        $file = public_path() . '/storage/bukti_pembayaran/' . $buktiPembayaran;//Mencari file dari model yang sudah dicari
        return response()->download($file, $buktiPembayaran); //Download file yang dicari berdasarkan nama file
    }

    public function verifPembayaran(Payment $id){
        $tes=$id->id;
        $result = DB::transaction(function () use ($id) {
            $id->update([
                'konfirmasi_pembayaran' => 1
            ]);
            return $id->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            $data = DB::table('orders')
            ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')->where('orders.id', '=', $tes)->first();
            // $data['nama_instansi'] = $tes->nama_instansi;
            $alat = DB::table('detail_orders')
                ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
                ->join('orders', 'detail_orders.order_id', '=', 'orders.id')
                ->where('detail_orders.order_id', '=', $tes)->get();
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
            $payment = DB::table('payments')
                ->join('orders', 'payments.order_id', '=', 'orders.id')->where('payments.id', '=', $tes)->select('payments.created_at')->first();
            $skr = DB::table('skr')
                    ->join('orders', 'skr.order_id', '=', 'orders.id')->join('payments', 'payments.order_id', '=', 'orders.id')->where('payments.id', '=', $tes)->select('skr.created_at')->first();
            $umurSkr = new Carbon($skr->created_at);
            $tanggalPayment = new Carbon($payment->created_at);
            if($tanggalPayment < $umurSkr->addDay(30)){
                $denda=0;
            }
            elseif($tanggalPayment > $umurSkr->addDay(30)){
                $denda=0.02*$total;
            }
            $total_bayar =  $denda + $total;
            $position='bendahara_to_penyewa';
            Mail::to($data->email)->send(new pemberitahuanPembayaran($data, $total_bayar, $position));
            return redirect()->route('payments.index')->with('success', 'Verifikasi pembayaran berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('payments.index')->with('error', 'Verifikasi pembayaran gagal!');
        }
    }

    public function tolakPembayaran(Request $request, Payment $id){
        $tes=$id->id;
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
            $data = DB::table('orders')
            ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
            ->join('payments', 'payments.order_id', '=', 'orders.id')
            ->where('payments.id', '=', $tes)->first();
            $status='pembayaran';
            $alasan=$validated['alasan'];
            Mail::to($data->email)->send(new Tolak($data, $status, $alasan));
            return redirect()->route('payments.index')->with('success', 'Penolakan pembayaran berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('payments.index')->with('error', 'Penolakan pembayaran gagal!');
        }
    }

    public function denda()
    {
        $dendas = Order::whereExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('detail_orders')
                  ->where('orders.tanggal_selesai', '>', 'detail_orders.tanggal_kembali')
                  ->whereColumn('detail_orders.order_id', 'orders.id')
                  ->select('orders.id', 'orders.nama_instansi', 'orders.nama_kegiatan', 'orders.tanggal_selesai', 'detail_orders.equipment_id');
            })
        ->orderBy('orders.created_at', 'desc')->paginate(5);
        $total = DetailOrder::where('status', '=', 'Belum Diambil');
        return view('denda_terlambat_pengembalian', [
            'dendas' => $dendas,
            'total' => $total
        ]);
    }

    public function detailDenda($id)
    {
        $denda = Order::findOrFail($id);
        $equipment = DB::table('orders')
        ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        ->where('orders.id', $id)
        ->select('orders.id as id', 'equipments.nama', 'equipments.foto', 'orders.tanggal_mulai', 'orders.tanggal_selesai', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam', 'detail_orders.id as detail_id', 'detail_orders.konfirmasi_denda', 'detail_orders.tanggal_kembali')
        ->get();
        // $detail_refund = DB::table('refunds')->join('detail_refunds', 'detail_refunds.refund_id', '=', 'refunds.id')->get();
        return view('detail_denda_terlambat_pengembalian', [
            'denda' => $denda,
            'equipment' => $equipment
            // 'detail_refund' => $detail_refund
        ]);
    }

    public function bayarDenda(DetailOrder $id)
    {
        $result = DB::transaction(function () use ($id) {
            $id->update([
                'konfirmasi_denda' => 1
            ]);
            return $id->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            return redirect()->route('denda')->with('success', 'Verifikasi pembayaran berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('denda')->with('error', 'Verifikasi pembayaran gagal!');
        }
    }
    public function searchFine(Request $request)
    {
        $dendas = Order::whereExists(function ($query) use ($request) {
            $query->select(DB::raw(1))
                  ->from('detail_orders')
                  ->where('orders.tanggal_selesai', '>', 'detail_orders.tanggal_kembali')
                  ->whereColumn('detail_orders.order_id', 'orders.id')
                  ->select('orders.id', 'orders.nama_instansi', 'orders.nama_kegiatan', 'orders.tanggal_selesai', 'detail_orders.equipment_id');
            })
            ->whereHas('tenant', function($query) use($request) {
                $query
                ->where('nama', 'like', "%{$request->keyword}%")
                ->orWhere('nama_instansi', 'like', "%{$request->keyword}%")
                ->orWhere('nama_kegiatan', 'like', "%{$request->keyword}%");
            })
        ->orderBy('orders.created_at', 'desc')->paginate(5);
        $total = DetailOrder::where('status', '=', 'Belum Diambil');
        return view('denda_terlambat_pengembalian', [
            'dendas' => $dendas,
            'total' => $total
        ]);
    }

    public function paymentExcel(Request $request)
    {
        $validated = $request->validate([
            'tanggal_awal' => 'date',
            'tanggal_akhir' => 'date',
        ]);
        $tanggal_awal=$validated['tanggal_awal'];
        $tanggal_akhir=$validated['tanggal_akhir'];

        $orders = DB::table('orders')
        ->join('tenants', 'tenants.id', '=', 'orders.tenant_id')
        ->join('payments', 'payments.order_id', '=', 'orders.id')
        // ->where('ket_persetujuan_kepala_dinas', 'setuju')
        ->whereBetween('orders.created_at', [$tanggal_awal, $tanggal_akhir])
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('detail_orders')
                //   ->where('detail_orders.pembatalan', 1)
                  ->whereColumn('detail_orders.order_id', 'orders.id');
        })
        ->get();
        // $detail_orders = DB::table('orders')
        // ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        // ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        // // ->where('orders.id', 'detail_orders.order_id')
        // ->select('orders.tanggal_mulai', 'orders.tanggal_selesai', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam', 'equipments.nama', 'equipments.jenis', 'equipments.id')->get();
        return view('pembayaran_excel', [
            'orders' => $orders,
            // 'detail_orders' => $detail_orders
        ]);
    }
}
