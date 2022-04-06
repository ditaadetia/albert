<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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

    public function editProfil(Request $request, Tenant $tenant)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required|string',
            // 'foto' => 'required|string',
            // 'foto' => 'required|file|max:1024|mimes:png,jpg,jpeg',
            'email' => 'required|string',
            // 'username' => 'required|string',
            'password' => 'required|string',
            'no_hp' => 'required|string',
            'kontak_darurat' => 'required|string',
            'alamat' => 'required|string',
        ]);

        DB::transaction(function () use ($validator, $request, $tenant) {
            $tenant->update([
                'nama' => $validator['nama'],
                // 'foto' => $validator['foto'],
                'email' => $validator['email'],
                'password' => $validator['password'],
                'no_hp' => $validator['no_hp'],
                'kontak_darurat' => $validator['kontak_darurat'],
                'alamat' => $validator['alamat'],
            ]);
            return $tenant->save();
        });

        if($validator->fails()){
            return response()->json($validator->errors());
        }
        return response()->json(['Edit Profil Berhasil!', new TenantResource($tenant)]);
    }

    // public function update(Request $request, Tenant $tenant)
    // {
    //     $validated = $request->validate([
    //         'nama' => 'required|string',
    //         'foto' => 'required|string',
    //         // 'foto' => 'required|file|max:1024|mimes:png,jpg,jpeg',
    //         'email' => 'required|string',
    //         // 'username' => 'required|string',
    //         'password' => 'required|string',
    //         'no_hp' => 'required|integer',
    //         'kontak_darurat' => 'required|integer',
    //         'alamat' => 'required|string',
    //     ]);

    //     $result = DB::transaction(function () use ($validated, $request, $tenant) {
    //         $tenant->update([
    //             'nama' => $validated['nama'],
    //             'foto' => $validated['foto'],
    //             'email' => $validated['email'],
    //             'password' => $validated['password'],
    //             'no_hp' => $validated['no_hp'],
    //             'kontak_darurat' => $validated['kontak_darurat'],
    //             'alamat' => $validated['alamat'],
    //         ]);

    //         if ($request->hasFile('foto')) {

    //             // delete old image from 'public' disk
    //             Storage::disk('public')->delete($tenant->foto);

    //             // store the 'foto' into the 'public' disk
    //             $tenant->foto = $request->file('foto')->store('tenants', 'public');
    //         }

    //         return $tenant->save();
    //     });

    //     if ($result) {
    //         return response()->json($tenant);
    //     }
    // }
}
