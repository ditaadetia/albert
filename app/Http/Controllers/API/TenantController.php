<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        // $tenants = Tenant::paginate(5);
        // return response()->json(TenantResource::collection($tenants));

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $email = $request->input('email');
        $password = $request->input('password');
        $user = Tenant::where('email', $email)->first();
        if (!$user) {
            return response()->json(['message' => 'Login failed'], 401);
        }
        $isValidPassword = Hash::check($password, $user->password);
        if (!$isValidPassword) {
          return response()->json(['message' => 'Login failed'], 401);
        }
        $generateToken = bin2hex(random_bytes(40));
        $user->update([
            'token' => $generateToken
        ]);
        return response()->json($user);
    }

    public function show($id)
    {
        $tenant = Tenant::findOrFail($id);
        return response()->json([new TenantResource($tenant)]);
    }

    public function store(Request $request)
    {
        // $tenant = new Tenant;
        // $tenant->nama=$request->nama;
        // $tenant->foto=$request->foto;
        // $tenant->email=$request->email;
        // $tenant->username=$request->username;
        // $tenant->password=$request->password;
        // $tenant->no_hp=$request->no_hp;
        // $tenant->kontak_darurat=$request->kontak_darurat;
        // $tenant->alamat=$request->alamat;
        // return response(['tenant' => $tenant], 200);
        $validated = $request->validate([

            'nama' => 'required|string',
            'foto' => 'required|string',
            // 'foto' => 'required|file|max:1024|mimes:png,jpg,jpeg',
            'email' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
            'no_hp' => 'required|integer',
            'kontak_darurat' => 'required|integer',
            'alamat' => 'required|string',
        ]);


        $program = Tenant::create([
            'nama' => $request->nama,
            'foto' => $request->foto,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'no_hp' => $request->no_hp,
            'kontak_darurat' => $request->kontak_darurat,
            'alamat' => $request->alamat,
         ]);
        return response(['program' => $program], 200);
    }
}
