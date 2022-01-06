<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('ubah_password');
    }

    public function update(UpdatePasswordRequest $request)
    {
        $request->user()->update([
            'password' => Hash::make($request->get('password')),
            Auth::logout(),
            $request->session()->invalidate(),
            $request->session()->regenerateToken()
        ]);
        // return redirect('/');
        if ($request) {
            //redirect dengan pesan sukses
            return redirect('/')->with('success', 'Password berhasil diubah, mohon login kembali!');
        } else {
            //redirect dengan pesan error
            return redirect('password.edit', ['password' => auth()->user()->id])->with('error', 'Password gagal diubah!');
        }
    }
}
