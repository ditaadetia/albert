<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;

class EquipmentController extends Controller
{
    public function index()
    {
        $tenants = DB::table('equipments')->whereBetween('id', [1, 12])->get();
        // $tenants = DB::table('equipments')->whereBetween('id', [1, 7])->orWhere('nama', 'Lainnya')->get();
        return response()->json(EquipmentResource::collection($tenants));
    }

    public function all()
    {
        $tenants = DB::table('equipments')->get();
        // $tenants = DB::table('equipments')->whereBetween('id', [1, 7])->orWhere('nama', 'Lainnya')->get();
        return response()->json(EquipmentResource::collection($tenants));
    }

    public function detail(Request $request)
    {
        $orders = DB::table('equipments')->where('id', request('id'))->get();
        return response()
        ->json(["status" => "success", "success" => true, "message" => "get Equipment!", 'data' => EquipmentResource::collection($orders)]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'foto' => 'required|string',
            'jenis' => 'required|string',
            'kegunaan' => 'required|string',
            'harga_sewa_perjam' => 'required|integer',
            'harga_sewa_perhari' => 'required|integer',
            'keterangan' => 'required|string',
            'kondisi' => 'required|string',
        ]);

        $program = Equipment::create([
            'nama' => $request->nama,
            'foto' => $request->foto,
            'jenis' => $request->jenis,
            'kegunaan' => $request->kegunaan,
            'harga_sewa_perjam' => $request->harga_sewa_perjam,
            'harga_sewa_perhari' => $request->harga_sewa_perhari,
            'keterangan' => $request->keterangan,
            'kondisi' => $request->kondisi
         ]);
         return response(['program' => $program], 200);
    }
}
