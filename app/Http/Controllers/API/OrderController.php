<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\OrderController as APIOrderController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\formulirSewaController;
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
use App\Mail\PenyewaanBaru;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         "tenant_id" => ['required'],
    //         "category_order_id" => ['required'],
    //         // "nama_instansi" => ['required'],
    //         // "jabatan" => ['required'],
    //         // "nama_bidang_hukum" => ['required'],
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(
    //             $validator->errors(),
    //             HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY
    //         );
    //     }

    //     try {
    //         $order = Order::create($request->all());

    //         $response = [
    //             'message' => 'Berhasil disimpan',
    //             'data' => $order,
    //         ];

    //         return response()->json($response, HttpFoundationResponse::HTTP_CREATED);
    //     } catch (QueryException $e) {
    //         return response()->json([
    //             'message' => "Gagal " . $e->errorInfo,
    //         ]);
    //     }
    // }

    public function index(Request $request, $id)
    {
        $tenants = DB::table('orders')
        ->where('tenant_id', request('id'))
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('detail_orders')
                  ->where('detail_orders.pembatalan', 0)
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
                'ttd_pemohon' => $tenant->ttd_pemohon,
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
                    ->select('detail_orders.id','equipments.nama', 'equipments.foto', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam')
                    ->where('detail_orders.pembatalan', 0)
                    ->where('detail_orders.order_id', $tenant->id)
                    ->orderByDesc('orders.created_at')
                    ->get()
            ];
        }
        return response()->json($data);
        // $tenants = DB::table('equipments')->whereBetween('id', [1, 7])->orWhere('nama', 'Lainnya')->get();
        // return response()->json($tenants);
    }

    public function cekOrder(Request $request, $id)
    {
        $tenants = DB::table('orders')
        ->where('id', request('id'))
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('detail_orders')
                  ->where('detail_orders.pembatalan', 0)
                  ->whereColumn('detail_orders.order_id', 'orders.id');
                })
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
                    ->select('detail_orders.id','equipments.nama', 'equipments.foto', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam')
                    ->where('detail_orders.pembatalan', 0)
                    ->where('detail_orders.order_id', $tenant->id)
                    ->get()
            ];
        }
        return response()->json($data);
        // $tenants = DB::table('equipments')->whereBetween('id', [1, 7])->orWhere('nama', 'Lainnya')->get();
        // return response()->json($tenants);
    }

    public function schedule(Request $request)
    {
        $tenants = DB::table('schedules')
        ->join('detail_orders', 'schedules.detail_order_id', '=', 'detail_orders.id')
        ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        ->where('equipments.id', request('id'))
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
                // 'color'=> "#ffd700",
                'tanggal_mulai' => date('Y-m-d', strtotime($tenant->tanggal_mulai)),
                'tanggal_selesai' => date('Y-m-d', strtotime($tenant->tanggal_selesai)),
                'month' => $period,
            ];
        }
        return response()->json($data);
        // $tenants = DB::table('equipments')->whereBetween('id', [1, 7])->orWhere('nama', 'Lainnya')->get();
        // return response()->json($tenants);
    }

    public function downloadDokumenSewa($id)
    {
        $model_file =Order::findOrFail($id); //Mencari model atau objek yang dicari
        $dokumen_sewa = trim($model_file->dokumen_sewa, 'dokumen_sewa/');
        $file = public_path() . '/storage/dokumen_sewa/dokumen_sewa_' . $dokumen_sewa;//Mencari file dari model yang sudah dicari
        return response()->download($file, $dokumen_sewa); //Download file yang dicari berdasarkan nama file
    }

    public function store(Request $request, $id)
    {
        $validator = $request->validate([
            'tenant_id' => 'required|integer',
            'category_order_id' => 'required|integer',
            'nama_instansi' => 'string|max:255',
            'jabatan' => 'string|max:255',
            'alamat_instansi' => 'string',
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date|max:255',
            'tanggal_selesai' => 'required|date|max:255',
        ]);

        $order = DB::table('orders')->get();

        $result = DB::transaction(function () use ($validator, $request) {
            return Order::create($validator);
        });

        if($validator) {
            $data = DB::table('orders')
                ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')->latest('orders.created_at')->first();
            $staff = DB::table('users')
            ->where('jabatan', '=', 'admin')->first();
            // $data['nama_instansi'] = $tes->nama_instansi;
            $position='penyewa_to_admin';
            Mail::to($staff->email)->send(new PenyewaanBaru($data, $position));
            return redirect()->action([formulirSewaController::class, 'formulirSewa'], ['id' => request('id')]);
        }

        // return response()->json(['Program created successfully.', new OrderResource($result)]);
        return response()->json(["status" => "success", "success" => true, "message" => "Edit Profil Berhasil!", 'data' => new OrderResource($result)]);
        // if ($result){
        // }
    }

    public function ktp(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'ktp' => 'file|mimes:png,jpg,jpeg,pdf,doc,docx',
        ]);

        $order = Order::latest()->where('tenant_id', request('id'))->first();

        $result = DB::transaction(function () use ($validator, $request, $order) {
            $order->update([
                'ktp' => $request->ktp,

            ]);
            if ($request->hasFile('ktp')) {

                // delete old image from 'public' disk
                Storage::disk('public')->delete($order->ktp);

                // store the 'image' into the 'public' disk
                $order->ktp = $request->file('ktp')->store('ktp', 'public');
            }
            return $order->save();
        });

        // if($validator->fails()){
        //     return response()->json($validator->errors());
        // }

        // if($validator) {
        //     return redirect()->action([formulirSewaController::class, 'formulirSewa'], ['id' => request('id')]);
        // }

        // return response()->json(['Program created successfully.', new OrderResource($result)]);
        return response()->json(["status" => "success", "success" => true, "message" => "Upload KTP Berhasil!", 'hasil' =>$order->id, 'foto' => asset('storage/' . $order->ktp)]);
        // if ($result){
        // }
    }

    public function aktaNotaris(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'akta_notaris' => 'file|mimes:png,jpg,jpeg,pdf,doc,docx',
        ]);

        $order = Order::latest()->where('tenant_id', request('id'))->first();

        $result = DB::transaction(function () use ($validator, $request, $order) {
            $order->update([
                'akta_notaris' => $request->akta_notaris,

            ]);
            if ($request->hasFile('akta_notaris')) {

                // delete old image from 'public' disk
                Storage::disk('public')->delete($order->akta_notaris);

                // store the 'image' into the 'public' disk
                $order->akta_notaris = $request->file('akta_notaris')->store('akta_notaris', 'public');
            }
            return $order->save();
        });

        // if($validator->fails()){
        //     return response()->json($validator->errors());
        // }

        if($validator) {
            return redirect()->action([formulirSewaController::class, 'formulirSewa'], ['id' => request('id')]);
        }

        // return response()->json(['Program created successfully.', new OrderResource($result)]);
        return response()->json(["status" => "success", "success" => true, "message" => "Upload Akta Notaris Berhasil!", 'foto' => asset('storage/' . $order->akta_notaris)]);
        // if ($result){
        // }
    }

    public function suratPengantar(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'surat_ket' => 'file|mimes:png,jpg,jpeg,pdf,doc,docx',
        ]);

        $order = Order::latest()->where('tenant_id', request('id'))->first();

        $result = DB::transaction(function () use ($validator, $request, $order) {
            $order->update([
                'surat_ket' => $request->surat_ket,

            ]);
            if ($request->hasFile('surat_ket')) {

                // delete old image from 'public' disk
                Storage::disk('public')->delete($order->surat_ket);

                // store the 'image' into the 'public' disk
                $order->surat_ket = $request->file('surat_ket')->store('surat_ket', 'public');
            }
            return $order->save();
        });

        // if($validator->fails()){
        //     return response()->json($validator->errors());
        // }

        if($validator) {
            return redirect()->action([formulirSewaController::class, 'formulirSewa'], ['id' => request('id')]);
        }

        // return response()->json(['Program created successfully.', new OrderResource($result)]);
        return response()->json(["status" => "success", "success" => true, "message" => "Upload Surat Pengantar Berhasil!", 'surat_ket' => asset('storage/' . $order->surat_ket)]);
        // if ($result){
        // }
    }

    public function lihatFormulirOrder(Request $request)
    {
        $orders = Order::latest()->where('id', request('id'))->first();
        $pathToFile = public_path() . '/storage/surat_permohonan/' . $orders->surat_permohonan;

        return response()->file($pathToFile);
        // return response()->json(['Program created successfully.', new OrderResource($orders->surat_permohonan)]);
        // return response()->json(["status" => "success", "success" => true, "message" => "Edit Profil Berhasil!", 'data' => new OrderResource($result)]);
        // if ($result){
        // }
    }

    public function ttdPemohon(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'ttd_pemohon' => 'file|mimes:png,jpg,jpeg,pdf,doc,docx',
        ]);

        $order = Order::Where('id', request('id'))->first();

        $result = DB::transaction(function () use ($validator, $request, $order) {
            $order->update([
                'ttd_pemohon' => $request->ttd_pemohon,

            ]);
            if ($request->hasFile('ttd_pemohon')) {

                // delete old image from 'public' disk
                Storage::disk('public')->delete($order->ttd_pemohon);

                // store the 'image' into the 'public' disk
                $order->ttd_pemohon = $request->file('ttd_pemohon')->store('ttd_pemohon', 'public');
            }
            return $order->save();
        });

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        // return response()->json(['Program created successfully.', new OrderResource($result)]);
        return response()->json(["status" => "success", "success" => true, "message" => "Upload TTD Pemohon Berhasil!", 'surat_ket' => asset('storage/' . $order->ttd_pemohon)]);
        // if ($result){
        // }
    }
}
