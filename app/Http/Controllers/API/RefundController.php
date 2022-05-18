<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Refund;
use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\Schedule;
use App\Http\Resources\RefundResource;
use App\Http\Resources\DetailOrderResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use DateTime;
use Carbon\CarbonPeriod;
// use Carbon;
use App\Mail\pemberitahuanPembatalan;
use Illuminate\Support\Facades\Mail;
use App\Mail\pemberitahuanPembayaran;
use Illuminate\Support\Facades\Storage;
setlocale(LC_TIME, 'id_ID');
\Carbon\Carbon::setLocale('id');
\Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class RefundController extends Controller
{
    public function store(Request $request)
    {
        $validator = $request->validate([
            'order_id' => 'required|integer',
            'tenant_id' => 'required|integer',
            // 'surat_permohonan_refund' => 'file|max:2048|mimes:png,jpg,jpeg',
            'metode_refund' => 'required|string',
            'no_rekening' => 'required',
            'nama_penerima' => 'required|string',
            'ket_verif_admin' => 'required',
            'ket_persetujuan_kepala_uptd' => 'required',
            'ket_persetujuan_kepala_dinas' => 'required',
        ]);

        $batal = DB::table('refunds')->where('order_id', request('id'))->count();
        if($batal <= 0){
            $result = DB::transaction(function () use ($validator, $request) {
                // if ($request->hasFile('surat_permohonan_refund')) {
                //     // store the 'foto' into the 'public' disk
                //     $validator['surat_permohonan_refund'] = $request->file('surat_permohonan_refund')->store('surat_permohonan_refund', 'public');
                // }
                Refund::create($validator);
            });
            $data = DB::table('orders')
            ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')->where('orders.id', '=', $validator['order_id'])->first();
            // $data['nama_instansi'] = $tes->nama_instansi;
            $staff = DB::table('users')
                ->where('jabatan', '=', 'bendahara')->first();
            $alat = DB::table('detail_orders')
                ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
                ->join('orders', 'detail_orders.order_id', '=', 'orders.id')
                ->where('detail_orders.order_id', '=', $validator['order_id'])->get();
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
                    ->join('orders', 'payments.order_id', '=', 'orders.id')->where('orders.id', '=', $validator['order_id'])->first();
            $skr = DB::table('skr')
                    ->join('orders', 'skr.order_id', '=', 'orders.id')->where('orders.id', '=', $validator['order_id'])->first();
            $umurSkr = new Carbon($skr->created_at);
            $tanggalPayment = new Carbon($payment->created_at);
            if($tanggalPayment > $umurSkr->addDay(30)){
                $denda=0;
            }
            elseif($tanggalPayment < $umurSkr->addDay(30)){
                $denda=0.02*$total;
            }
            $total_bayar =  $denda + $total;
            $position='penyewa_to_bendahara';
            Mail::to($staff->email)->send(new pemberitahuanPembayaran($data, $total_bayar, $position));
            return response()->json(["status" => "success", "success" => true, "pesan" => "Pengajuan Refund Berhasil!"]);
        } else if($batal >0){
            return response()->json(["status" => "failed", "success" => false, "pesan" => "Anda telah mengajukan pengembalian Dana!"]);
        }
    }

    public function riwayatPembatalan(Request $request, $id)
    {
        $tenants = DB::table('orders')
        ->where('tenant_id', request('id'))
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('detail_orders')
                  ->where('detail_orders.pembatalan', 1)
                  ->whereColumn('detail_orders.order_id', 'orders.id');
                })
        ->orderByDesc('orders.created_at')
        ->get();

        $data=[];
        foreach ($tenants as $tenant){
            $awal=date_create($tenant->tanggal_mulai);
            $akhir=date_create($tenant->tanggal_selesai);
            $t_awal = new DateTime($tenant->tanggal_mulai);
            $t_awal = $t_awal->modify('+1 day');
            $t_akhir = new DateTime($tenant->tanggal_selesai);
            $t_akhir = $t_akhir->modify('+1 day');
            $period = CarbonPeriod::create($t_awal, $t_akhir);
            $tes = date('Y-m-d', strtotime($period));
            $diff=date_diff($awal, $akhir);
            foreach($period as $date){
                $month = $date->format('Y-m-d');
            }
            $data[]= [
                'id' => $tenant->id,
                'nama_instansi' => $tenant->nama_instansi,
                'nama_kegiatan' => $tenant->nama_kegiatan,
                'created_at' => $tenant->created_at,
                'month' => $period,
                'color'=> "#ffd700",
                'tanggal_mulai' => $tenant->tanggal_mulai,
                'tanggal_selesai' => $tenant->tanggal_selesai,
                // 'tanggal_mulai' => date('Y-m-d', strtotime($tenant->tanggal_mulai)),
                // 'tanggal_selesai' => date('Y-m-d', strtotime($tenant->tanggal_selesai)),
                'total_hari'=>$diff->days,
                'total_jam'=>$diff->h,
                'ket_verif_admin' => $tenant->ket_verif_admin,
                'ket_persetujuan_kepala_uptd' => $tenant->ket_persetujuan_kepala_uptd,
                'ket_persetujuan_kepala_dinas' => $tenant->ket_persetujuan_kepala_dinas,
                'alat' =>
                    $equipments = DB::table('orders')
                    ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
                    ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
                    ->select('orders.id as order_id','detail_orders.id','equipments.nama', 'equipments.foto', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam')
                    ->where('detail_orders.pembatalan', 1)
                    ->where('detail_orders.order_id', $tenant->id)
                    ->orderByDesc('orders.created_at')
                    ->get()
            ];
        }
        return response()->json($data);
        // $tenants = DB::table('equipments')->whereBetween('id', [1, 7])->orWhere('nama', 'Lainnya')->get();
        // return response()->json($tenants);
    }

    public function index()
    {
        $refunds = DB::table('orders')
        ->join('refunds', 'refunds.order_id', '=', 'orders.id')
        ->get();

        $data=[];
        foreach ($refunds as $refund){
            $data[]= [
                'id' => $refund->id,
                'created_at' => $refund->created_at,
                'metode_refund' => $refund->metode_refund,
                'ket_verif_admin' => $refund->ket_verif_admin,
                'ket_persetujuan_kepala_uptd' => $refund->ket_persetujuan_kepala_uptd,
                'ket_persetujuan_kepala_dinas' => $refund->ket_persetujuan_kepala_dinas,
                'alat' =>
                    $equipments = DB::table('refunds')
                    ->join('detail_refunds', 'detail_refunds.refund_id', '=', 'refunds.id')
                    ->join('orders', 'refunds.order_id', '=', 'orders.id')
                    ->join('equipments', 'detail_refunds.equipment_id', '=', 'equipments.id')
                    ->select('orders.id', 'detail_refunds.jumlah_hari_refund', 'detail_refunds.jumlah_jam_refund', 'equipments.nama', 'equipments.foto', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam')
                    ->where('detail_refunds.refund_id', $refund->id)
                    ->get()
            ];
        }
        return response()->json($data);
        // $tenants = DB::table('equipments')->whereBetween('id', [1, 7])->orWhere('nama', 'Lainnya')->get();
        // return response()->json($tenants);
    }

    public function pembatalan(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'alasan' => 'string',
        ]);

        $batal = DetailOrder::where('id', request('id'))->first();
        $order = DB::table('orders')
        ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        ->where('detail_orders.id', request('id'))
        ->select('orders.ket_persetujuan_kepala_dinas', 'detail_orders.status', 'orders.tanggal_selesai')
        ->first();
        $data = DB::table('orders')
        ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
        ->where('detail_orders.id', request('id'))
        ->select('orders.nama_kegiatan', 'orders.nama_instansi', 'tenants.nama', 'equipments.nama as nama_alat', 'orders.id')
        ->first();
        $staff = DB::table('users')
            ->where('jabatan', '=', 'admin')->first();
        $staff1 = DB::table('users')
            ->where('jabatan', '=', 'kepala uptd')->first();
            // $data['nama_instansi'] = $tes->nama_instansi;
        $schedule = Schedule::where('detail_order_id', request('id'))->first();
        // $data = DB::table('orders')
        //         ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')->latest('orders.created_at')->first();
        if($order->tanggal_selesai > Carbon::now()){
            if($order->status != 'Sedang Dipakai'){
                $result = DB::transaction(function () use ($validator, $request, $batal) {
                    $batal->update([
                        'pembatalan' => 1,
                        'alasan' => $request->alasan
                    ]);
                    return $batal->save();
                });
                if($order->ket_persetujuan_kepala_dinas === 'setuju'){
                    $result1 = $schedule->delete();
                }
                Mail::to($staff->email)->send(new pemberitahuanPembatalan($data));
                Mail::to($staff1->email)->send(new pemberitahuanPembatalan($data));
                return response()->json(["status" => "success", "success" => true, "message" => "Pengajuan Pembatalan Berhasil!"]);
            }
            else if($order->status == 'Sedang Dipakai'){
                return response()->json(["status" => "failed", "success" => false, "message" => "Kembalikan alat terlebih dahulu!"]);
            }
        } elseif($order->tanggal_selesai <= Carbon::now()){
            return response()->json(["status" => "failed", "success" => false, "message" => "Masa penyewaan telah berakhir"]);
        }

        // if ($result) {
        //     //redirect dengan pesan sukses
        //     if($order->ket_persetujuan_kepala_dinas === 'setuju'){
        //         $result1 = $schedule->delete();
        //     }
        //     return response()->json(["status" => "success", "success" => true, "message" => "Pengajuan Pembatalan Berhasil!"]);
        // }
    }
}
