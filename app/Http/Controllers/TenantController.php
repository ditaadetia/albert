<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::paginate(5);
        return view('penyewa', ['tenants' => $tenants]);
        // return response()->json([
        //     'message' => 'password slah'
        // ], 401);

        // $token = $tenants->createToken('token-name')->plainTextToken;
        // return response()->json([
        //     'message' => 'sukses',
        //     'tenants' => $tenants,
        //     'token' => $token
        // ], 200);
    }

    public function search(Request $request)
    {
        $pagination  = 5;

        $tenants    = Tenant::when($request->keyword, function ($query) use ($request) {
            $query
        ->where('nama', 'like', "%{$request->keyword}%")
        ->orWhere('username', 'like', "%{$request->keyword}%");
        })->orderBy('created_at', 'desc')->paginate($pagination);
        $tenants->appends($request->only('keyword'));
        return view('penyewa', compact('tenants'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function show($id)
    {
        $tenant = Tenant::findOrFail($id);
        return view('detail_penyewa', compact('tenant'));
    }
}
