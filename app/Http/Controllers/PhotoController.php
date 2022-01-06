<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Photo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function update(Request $request, $photo)
    {
        $request->validate([
            'foto' => 'file|max:1024|mimes:png,jpg,jpeg',
        ]);
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
}
