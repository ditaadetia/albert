<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
// use Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // public function login(Request $request) {
    //     $validate = \Validator::make($request->all(), [
    //         'email' => 'required',
    //         'password' => 'required',
    //     ]);

    //     if ($validate->fails()) {
    //         $respon = [
    //             'status' => 'error',
    //             'msg' => 'Validator error',
    //             'errors' => $validate->errors(),
    //             'content' => null,
    //         ];
    //         return response()->json($respon, 200);
    //     } else {
    //         $credentials = request(['email', 'password']);
    //         $credentials = Arr::add($credentials, 'status', 'aktif');
    //         if (!Auth::attempt($credentials)) {
    //             $respon = [
    //                 'status' => 'error',
    //                 'msg' => 'Unathorized',
    //                 'errors' => null,
    //                 'content' => null,
    //             ];
    //             return response()->json($respon, 401);
    //         }

    //         $user = Tenant::where('email', $request->email)->first();
    //         if (! \Hash::check($request->password, $user->password, [])) {
    //             throw new \Exception('Error in Login');
    //         }

    //         $tokenResult = $user->createToken('token-auth')->plainTextToken;
    //         $respon = [
    //             'status' => 'success',
    //             'msg' => 'Login successfully',
    //             'errors' => null,
    //             'content' => [
    //                 'status_code' => 200,
    //                 'access_token' => $tokenResult,
    //                 'token_type' => 'Bearer',
    //             ]
    //         ];
    //         return response()->json($respon, 200);
    //     }
    // }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = Tenant::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
        $respon = [
            'status' => 'failed',
            'message' => 'unauthorized',
        ];
        return response()
            ->json($respon, 200);
        }
        $user->createToken($request->email)->plainTextToken;
        $respon = [
            'status' => 'success',
            'message' => 'Login Successful',
            'errors' => null,
            'content' => null,
            'access_token' =>$user->createToken($request->email)->plainTextToken,
            'token_type' => 'Bearer',
            'data' => [[
                'id' => $user->id,
                'nama' => $user->nama,
                'email' => $user->email,
                'no_hp' => $user->no_hp,
                'kontak_darurat' => $user->kontak_darurat,
                'alamat' => $user->alamat,
                'foto' => asset('storage/' . $user->foto),
                ]]
        ];
        return response()
            ->json($respon, 200);
    }

    // public function login() {
    //     $this->ensureIsNotRateLimited();

    //     $withEmail = [
    //         'email' => $this->input('email'),
    //         'password' => $this->input('password')
    //     ];

    //     $attempts =
    //         Auth::guard('sanctum')->attempt($withEmail, $this->boolean('remember'));

    //     if (!$attempts) {
    //         RateLimiter::hit($this->throttleKey());

    //         throw ValidationException::withMessages([
    //             'email' => __('auth.failed'),
    //         ]);
    //     }

    //     RateLimiter::clear($this->throttleKey());
    // }

    public function logout(Request $request) {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        $respon = [
            'status' => 'success',
            'msg' => 'Logout successfully',
            'errors' => null,
            'content' => null,
        ];
        return response()->json($respon, 200);
    }

    public function logoutall(Request $request) {
        $user = $request->user();
        $user->tokens()->delete();
        $respon = [
            'status' => 'success',
            'msg' => 'Logout successfully',
            'errors' => null,
            'content' => null,
        ];
        return response()->json($respon, 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'foto' => ''
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $user_status = Tenant::where("email", $request->email)->first();
        if(!is_null($user_status)) {
           return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! email already registered"]);
        } else {
            $user = Tenant::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'foto' => $request->foto,
            ]);
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()
                ->json(["status" => "success", "success" => true, "message" => "Berhasil Registrasi", 'data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
        }
    }

    public function editProfil(Request $request, Tenant $tenant, $id)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required|string',
            'email' => 'required|string',
            // 'username' => 'required|string',
            // 'password' => 'required|string',
            'no_hp' => 'required|string',
            'kontak_darurat' => 'required|string',
            'alamat' => 'required|string',
        ]);
        $tenant=Tenant::find($id);
        DB::transaction(function () use ($validator, $request, $tenant) {
            $tenant->update([
                'nama' => $request->nama,
                // 'foto' => $request->foto,
                'email' => $request->email,
                // 'password' => Hash::make($request->password),
                'no_hp' => $request->no_hp,
                'kontak_darurat' => $request->kontak_darurat,
                'alamat' => $request->alamat,
            ]);
            return $tenant->save();
        });

        if($validator->fails()){
            return response()->json($validator->errors());
        }
        return response()
        ->json(["status" => "success", "success" => true, "message" => "Edit Profil Berhasil!", 'data' => new TenantResource($tenant)]);
        // return response()->json(['Edit Profil Berhasil!', new TenantResource($tenant)]);
    }

    public function updatePicture(Request $request, Tenant $tenant, $id)
    {
        $validator = Validator::make($request->all(),[
            'foto' => 'file|mimes:png,jpg,jpeg',
        ]);
        $tenant=Tenant::find($id);
        DB::transaction(function () use ($validator, $request, $tenant) {
            $tenant->update([
                'foto' => $request->foto,

            ]);
            if ($request->hasFile('foto')) {

                // delete old image from 'public' disk
                Storage::disk('public')->delete($tenant->foto);

                // store the 'image' into the 'public' disk
                $tenant->foto = $request->file('foto')->store('tenants', 'public');
            }
            return $tenant->save();
        });

        if($validator->fails()){
            return response()->json($validator->errors());
        }
        return response()
        ->json(["status" => "success", "success" => true, "message" => "Edit Picture Berhasil!", 'foto' => asset('storage/' . $tenant->foto)]);
        // return response()->json(['Edit Profil Berhasil!', new TenantResource($tenant)]);
    }

    public function cekUser(Request $request)
    {
        $tenant = Tenant::where('id', request('id'))->first();
        return response()->json(["status" => "success", "success" => true, "message" => "Get Tenant!", 'data' => asset('storage/' . $tenant->foto),'no_hp' => $tenant->no_hp, 'kontak_darurat' => $tenant->kontak_darurat, 'alamat' => $tenant->alamat]);
    }

    // public function register(Request $request)
    // {
    //     // $validator = $this->validator($request->all())->validate();
    //     $validator = Validator::make($request->all(),
    //         [
    //             'nama' => ['required', 'string', 'max:255'],
    //             'email' => ['required', 'string', 'email', 'max:255'], // , 'unique:users'
    //             'password' => ['required', 'string', 'min:4'],
    //         ]
    //     );
    //     if($validator->fails()) {
    //         return response()->json(["status" => "failed", "message" => "Please Input Valid Data", "errors" => $validator->errors()]);
    //     }
    //     $user_status = Tenant::where("email", $request->email)->first();
    //     if(!is_null($user_status)) {
    //        return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! email already registered"]);
    //     }

    //     $user = $this->create($request->all());
    //     if(!is_null($user)) {
    //         $this->guard()->login($user);
    //         return response()->json(["status" => $this->status_code, "success" => true, "message" => "Registration completed successfully", "data" => $user]);
    //     }else {
    //         return response()->json(["status" => "failed", "success" => false, "message" => "Failed to register"]);
    //     }
    // }
}
