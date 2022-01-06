<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

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

    public function store(Request $request)
    {
        $validator = $request->validate([
            'tenant_id' => 'required|integer',
            'category_order_id' => 'required|integer',
            'nama_instansi' => 'string|max:255',
            'jabatan' => 'string|max:255',
            'alamat_instansi' => 'string',
            'nama_kegiatan' => 'required|string|max:255',
            'ktp' => 'file|max:2048|mimes:png,jpg,jpeg',
            'surat_permohonan' => 'file|max:2048|mimes:png,jpg,jpeg',
            'akta_notaris' => 'file|max:2048|mimes:png,jpg,jpeg',
            'surat_ket' => 'file|max:2048|mimes:png,jpg,jpeg',
            'tanggal_mulai' => 'required|date|max:255',
            'tanggal_selesai' => 'required|date|max:255',
        ]);

        // if($validator->fails()){
        //     return response()->json($validator->errors());
        // }

        // $order = Order::create([
        //     'tenant_id' => $request->tenant_id,
        //     'category_order_id' => $request->category_order_id,
        //     'nama_instansi' => $request->nama_instansi,
        //     'jabatan' => $request->jabatan,
        //     'alamat_instansi' => $request->alamat_instansi,
        //     'nama_kegiatan' => $request->nama_kegiatan,
        //     'ktp' => $request->ktp,
        //     'surat_permohonan' => $request->surat_permohonan,
        //     'akta_notaris' => $request->akta_notaris,
        //     'surat_ket' => $request->surat_ket,
        //     'tanggal_mulai' => $request->tanggal_mulai,
        //     'tanggal_selesai' => $request->tanggal_selesai,
        // ]);

        $result = DB::transaction(function () use ($validator, $request) {
            if ($request->hasFile('ktp')) {
                // store the 'foto' into the 'public' disk
                $validator['ktp'] = $request->file('ktp')->store('ktp', 'public');
            }
            if ($request->hasFile('surat_permohonan')) {
                // store the 'foto' into the 'public' disk
                $validator['surat_permohonan'] = $request->file('surat_permohonan')->store('surat_permohonan', 'public');
            }
            if ($request->hasFile('akta_notaris')) {
                // store the 'foto' into the 'public' disk
                $validator['akta_notaris'] = $request->file('akta_notaris')->store('akta_notaris', 'public');
            }
            if ($request->hasFile('surat_ket')) {
                // store the 'foto' into the 'public' disk
                $validator['surat_ket'] = $request->file('surat_ket')->store('surat_ket', 'public');
        }
            return Order::create($validator);
        });

        return response()->json(['Program created successfully.', new OrderResource($result)]);
        // if ($result){
        // }
    }
}
