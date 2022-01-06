<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        return view('index');
    }

    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            for($bulan=1;$bulan < 13;$bulan++){
                $chartsewa     = collect(DB::SELECT("SELECT count(id) AS jumlah from orders where month(created_at)='$bulan'"))->first();
                $jumlah_sewa[] = $chartsewa->jumlah;
            }
            return redirect()->intended('/dashboard', compact('jumlah_sewa'));
        }
        return redirect()->intended('salah_password');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // public function __construct()
    // {
    //     $this->middleware('guest', ['except' => ['logout', 'getlogout']]);
    // }

    public function updateFoto(Request $request, User $photo)
    {
        $result = DB::transaction(function () use ($request, $photo) {
            if ($request->hasFile('foto')) {

                // delete old image from 'public' disk
                Storage::disk('public')->delete($photo->foto);

                // store the 'foto' into the 'public' disk
                $photo->foto = $request->file('foto')->store('users', 'public');
            }
            return $photo->save();
        });
        if ($result) {
            //redirect dengan pesan sukses
            return redirect()->route('dashboard')->with('success', 'Foto berhasil diubah!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('dashboard')->with('error', 'Foto gagal diubah!');
        }
    }

    public function edit(User $user)
    {
        return view('edit_profil', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'string',
            'foto' => 'file|max:1024|mimes:png,jpg,jpeg',
            'email' => 'string',
            'username' => 'string',
            'kontak' => 'string',
            'pangkat' => 'string',
            'nip' => 'string',
            'alamat' => 'string',
        ]);


        $result = DB::transaction(function () use ($validated, $request, $user) {
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'username' => $validated['username'],
                'kontak' => $validated['kontak'],
                'pangkat' => $validated['pangkat'],
                'nip' => $validated['nip'],
                'alamat' => $validated['alamat'],
            ]);

            if ($request->hasFile('foto')) {

                // delete old image from 'public' disk
                Storage::disk('public')->delete($user->foto);

                // store the 'foto' into the 'public' disk
                $user->foto = $request->file('foto')->store('users', 'public');
            }

            return $user->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            return redirect()->route('users.edit', ['user' => auth()->user()->id])->with('success', 'Profil berhasil diubah!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('users.edit', ['user' => auth()->user()->id])->with('error', 'Profil gagal diubah!');
        }
    }

    public function editPassword(User $password)
    {
        return view('ubah_password', ['password' => $password]);
    }

    public function updatePassword(Request $request, $password)
    {
        $validated = $request->validate([
            'password' => 'string',
        ]);

        $result = DB::transaction(function () use ($validated, $password) {
            $password->update([
                'password' => $validated['password'],
            ]);

            return $password->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            return redirect()->route('/')->with('success', 'Alat berat berhasil diubah!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('/')->with('error', 'Alat berat gagal diubah!');
        }
    }
}
