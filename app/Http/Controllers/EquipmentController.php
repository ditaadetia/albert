<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = DB::table('equipments')->where('nama', '!=', 'Lainnya')->paginate(5);
        return view('alat_berat', ['equipments' => $equipments]);
    }

    public function create()
    {
        return view('tambah_alat');
    }

    public function store(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            // 'total' => 'required|integer',
            'foto' => 'image|file|max:1024',
            'jenis' => 'required|string',
            'kegunaan' => 'required|string',
            'harga_sewa_perjam' => 'required|integer',
            'harga_sewa_perhari' => 'required|integer',
            'keterangan' => 'required|string',
            'kondisi' => 'required|string',
        ]);
        if ($request->file('foto')) {
            // store the 'foto' into the 'public' disk
            $validated['foto'] = $request->file('foto')->store('equipments', 'public');
        }

        Equipment::create($validated);

        // $result= DB::table('equipments')->insert([
        //     'nama' => $validated['nama'],
        //     'total' => $validated['total'],
        //     'jumlah_tersedia' => $validated['total'],
        //     'foto' => $validated['foto'],
        //     'jenis' => $validated['jenis'],
        //     'kegunaan' => $validated['kegunaan'],
        //     'harga_sewa_perjam' => $validated['harga_sewa_perjam'],
        //     'harga_sewa_perhari' => $validated['harga_sewa_perhari'],
        //     'keterangan' => $validated['keterangan'],
        //     'kondisi' => $validated['kondisi'],
        // ]);

        // $result = DB::transaction(function () use ($validated, $request, $equipment) {
        //     // $equipment->create([
        //     //     'nama' => $validated['nama'],
        //     //     'total' => $validated['total'],
        //     //     'jumlah_tersedia' => $validated['total'],
        //     //     'foto' => $validated['foto'],
        //     //     'jenis' => $validated['jenis'],
        //     //     'kegunaan' => $validated['kegunaan'],
        //     //     'harga_sewa_perjam' => $validated['harga_sewa_perjam'],
        //     //     'harga_sewa_perhari' => $validated['harga_sewa_perhari'],
        //     //     'keterangan' => $validated['keterangan'],
        //     //     'kondisi' => $validated['kondisi'],
        //     // ]);
        //     if ($request->hasFile('foto')) {
        //         // store the 'foto' into the 'public' disk
        //         $validated['foto'] = $request->file('foto')->store('equipments', 'public');
        //     }

        //     // return $equipment->save();
        //     return Equipment::create($validated);
        // });

        if ($validated) {
            return redirect()->route('equipments.index')->with('success', 'Alat berat berhasil ditambahkan!');
        } else {
            return redirect()->route('equipments.index')->with('error', 'Alat berat gagal ditambahkan!');
        }
    }

    public function show($id)
    {
        $equipment = Equipment::findOrFail($id);
        return view('detail_alat', compact('equipment'));
    }

    public function edit(Equipment $equipment)
    {
        return view('edit_alat', ['equipment' => $equipment]);
    }

    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            // 'total' => 'required|integer',
            'foto' => 'file|max:1024|mimes:png,jpg,jpeg',
            'jenis' => 'required|string',
            'kegunaan' => 'required|string',
            'harga_sewa_perjam' => 'required|integer',
            'harga_sewa_perhari' => 'required|integer',
            'keterangan' => 'required|string',
            'kondisi' => 'required|string',
        ]);

        $result = DB::transaction(function () use ($validated, $request, $equipment) {
            $equipment->update([
                'nama' => $validated['nama'],
                // 'total' => $validated['total'],
                // 'jumlah_tersedia' => $validated['total'],
                'jenis' => $validated['jenis'],
                'kegunaan' => $validated['kegunaan'],
                'harga_sewa_perjam' => $validated['harga_sewa_perjam'],
                'harga_sewa_perhari' => $validated['harga_sewa_perhari'],
                'keterangan' => $validated['keterangan'],
                'kondisi' => $validated['kondisi'],
            ]);

            if ($request->hasFile('foto')) {

                // delete old image from 'public' disk
                Storage::disk('public')->delete($equipment->foto);

                // store the 'foto' into the 'public' disk
                $equipment->foto = $request->file('foto')->store('equipments', 'public');
            }

            return $equipment->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            // dd($equipment->jumlah_tersedia);
            return redirect()->route('equipments.index')->with('success', 'Alat berat berhasil diubah!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('equipments.index')->with('error', 'Alat berat gagal diubah!');
        }
    }

    public function destroy($id)
    {
        $albert = Equipment::findOrfail($id)->delete();
        if($albert){
            return redirect()->route('equipments.index')->with('success', 'Alat berat berhasil dihapus!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('equipments.index')->with('error', 'Alat berat gagal dihapus!');
        }
    }

    public function search(Request $request)
    {
        $pagination  = 5;

        $equipments    = Equipment::when($request->keyword, function ($query) use ($request) {
            $query
        ->where('nama', 'like', "%{$request->keyword}%");
        })->orderBy('created_at', 'desc')->paginate($pagination);
        $equipments->appends($request->only('keyword'));
        return view('alat_berat', compact('equipments'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
