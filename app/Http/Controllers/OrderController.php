<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Schedule;
use App\Models\Equipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\PenyewaanBaru;
use App\Mail\Tolak;
use App\Mail\PemberitahuanPenyewaanBerhasil;
class OrderController extends Controller
{
    public function index($category)
    {
        $orders =[];
        // dd($category);
        if(!auth()->check() || auth()->user()->jabatan === 'admin'){
            $orders = Order::where(['category_order_id' => $category])
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('detail_orders')
                      ->where('detail_orders.pembatalan', 0)
                      ->where('orders.ttd_pemohon', '!=', '')
                      ->whereColumn('detail_orders.order_id', 'orders.id');
                    })
                    ->orderByDesc('orders.created_at')
                    ->paginate(5);
        }
        elseif(!auth()->check() || auth()->user()->jabatan === 'kepala uptd'){
            $orders =  Order::where(['category_order_id' => $category, 'ket_verif_admin' => 'verif'])
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('detail_orders')
                      ->where('detail_orders.pembatalan', 0)
                      ->where('orders.ttd_pemohon', '!=', '')
                      ->whereColumn('detail_orders.order_id', 'orders.id');
                    })
                    ->orderByDesc('orders.created_at')
                    ->paginate(5);
        }
        if(!auth()->check() || auth()->user()->jabatan === 'kepala dinas'){
            $orders =  Order::where(['category_order_id' => $category, 'ket_persetujuan_kepala_uptd' => 'setuju', 'ket_persetujuan_kepala_uptd' => 'setuju'])
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('detail_orders')
                      ->where('detail_orders.pembatalan', 0)
                      ->where('orders.ttd_pemohon', '!=', '')
                      ->whereColumn('detail_orders.order_id', 'orders.id');
                    })
                    ->orderByDesc('orders.created_at')
                    ->paginate(5);
        }
        return view('order', [
            'orders' => $orders,
            'category' =>$category
        ]);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $detail = DB::table('orders')->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')->where('orders.id', '=', $id)->where('detail_orders.pembatalan', '=', 0)->get();
        $equipment = DB::table('equipments')->join('detail_orders', 'detail_orders.equipment_id', '=', 'equipments.id')->get();
        return view('detail_order', [
            'order' => $order,
            'detail' => $detail,
            'equipment' => $equipment
        ]);
    }

    public function ordersExcel(Request $request)
    {
        $validated = $request->validate([
            'tanggal_awal' => 'date',
            'tanggal_akhir' => 'date',
        ]);
        $tanggal_awal=$validated['tanggal_awal'];
        $tanggal_akhir=$validated['tanggal_akhir'];

        $orders = DB::table('orders')
        ->join('tenants', 'tenants.id', '=', 'orders.tenant_id')
        ->where('ket_persetujuan_kepala_dinas', 'setuju')
        ->whereBetween('orders.created_at', [$tanggal_awal, $tanggal_akhir])
        ->where('category_order_id', request('category'))
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('detail_orders')
                  ->where('detail_orders.pembatalan', 0)
                  ->whereColumn('detail_orders.order_id', 'orders.id');
        })
        ->get();
        // $detail_orders = DB::table('orders')
        // ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        // ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        // // ->where('orders.id', 'detail_orders.order_id')
        // ->select('orders.tanggal_mulai', 'orders.tanggal_selesai', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam', 'equipments.nama', 'equipments.jenis', 'equipments.id')->get();
        return view('order-excel', [
            'orders' => $orders,
            // 'detail_orders' => $detail_orders
        ]);
    }

    public function search(Request $request)
    {
        $pagination  = 5;
        if(!auth()->check() || auth()->user()->jabatan === 'admin'){
            $orders    = Order::when($request->keyword, function ($query) use ($request) {
                $query
                ->where('category_order_id', request('category'))
                ->whereHas('tenant', function($query) use($request) {
                    $query
                    ->where('nama', 'like', "%{$request->keyword}%")
                    ->orWhere('nama_kegiatan', 'like', "%{$request->keyword}%");
                })
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('detail_orders')
                          ->where('detail_orders.pembatalan', 0)
                          ->whereColumn('detail_orders.order_id', 'orders.id');
                });
            })->orderBy('created_at', 'desc')->paginate($pagination);
        }elseif(!auth()->check() || auth()->user()->jabatan === 'kepala uptd'){
            $orders    = Order::when($request->keyword, function ($query) use ($request) {
                $query
                ->where('category_order_id', request('category'))
                ->where('ket_verif_admin', '=', 'verif')
                ->whereHas('tenant', function($query) use($request) {
                    $query
                    ->where('nama', 'like', "%{$request->keyword}%")
                    ->orWhere('nama_kegiatan', 'like', "%{$request->keyword}%");
                })
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('detail_orders')
                          ->where('detail_orders.pembatalan', 0)
                          ->whereColumn('detail_orders.order_id', 'orders.id');
                });
            })->orderBy('created_at', 'desc')->paginate($pagination);
        }elseif(!auth()->check() || auth()->user()->jabatan === 'kepala dinas'){
            $orders    = Order::when($request->keyword, function ($query) use ($request) {
                $query
                ->where('category_order_id', request('category'))
                ->where('ket_persetujuan_kepala_uptd', '=>', 'setuju')
                ->whereHas('tenant', function($query) use($request) {
                    $query
                    ->where('nama', 'like', "%{$request->keyword}%")
                    ->orWhere('nama_kegiatan', 'like', "%{$request->keyword}%");
                })
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('detail_orders')
                          ->where('detail_orders.pembatalan', 0)
                          ->whereColumn('detail_orders.order_id', 'orders.id');
                });
            })->orderBy('created_at', 'desc')->paginate($pagination);
        }
        $orders->appends($request->only('keyword'));

        // $equipments    = Equipment::when($request->keyword, function ($query) use ($request) {
        //         $query
        //         ->where('nama', 'like', "%{$request->keyword}%");
        // })->orderBy('created_at', 'desc')->paginate($pagination);
        // $equipments->appends($request->only('keyword'));

        // dd(DB::getQueryLog());
        return view('order', compact('orders'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function downloadPermohonan($id){
        $model_file = Order::findOrFail($id); //Mencari model atau objek yang dicari
        // $surat_permohonan = trim($model_file->surat_permohonan, 'surat_permohonan/');
        $file = public_path() . '/storage/surat_permohonan/' . $model_file->surat_permohonan;//Mencari file dari model yang sudah dicari
        return response()->download($file, $model_file->surat_permohonan); //Download file yang dicari berdasarkan nama file
    }

    public function downloadAkta($id){
        $model_file = Order::findOrFail($id); //Mencari model atau objek yang dicari
        $akta_notaris = trim($model_file->akta_notaris, 'akta_notaris/');
        $file = public_path() . '/storage/akta_notaris/' . $akta_notaris;//Mencari file dari model yang sudah dicari
        return response()->download($file, $akta_notaris); //Download file yang dicari berdasarkan nama file
    }

    public function downloadKtp($id){
        $model_file = Order::findOrFail($id); //Mencari model atau objek yang dicari
        $ktp = trim($model_file->ktp, 'ktp/');
        $file = public_path() . '/storage/ktp/' . $ktp;//Mencari file dari model yang sudah dicari
        return response()->download($file, $ktp); //Download file yang dicari berdasarkan nama file
    }

    public function downloadSuratPengantar($id){
        $model_file = Order::findOrFail($id); //Mencari model atau objek yang dicari
        $surat_ket = trim($model_file->surat_ket, 'surat_ket/');
        $file = public_path() . '/storage/surat_ket/' . $surat_ket;//Mencari file dari model yang sudah dicari
        return response()->download($file, $surat_ket); //Download file yang dicari berdasarkan nama file
    }


    public function verifAdmin(Order $id){
        $tes=$id->id;
        $result = DB::transaction(function () use ($id) {
            $id->update([
                'ket_verif_admin' => 'verif'
            ]);
            return $id->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            // Mail::to($result->email)->send(new MailNotify($result->username));
            // return $result;
            $data = DB::table('orders')
            ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')->where('orders.id', '=', $tes)->first();
            $staff = DB::table('users')
            ->where('jabatan', '=', 'kepala uptd')->first();
            // $data['nama_instansi'] = $tes->nama_instansi;
            $position='admin_to_kepala_uptd';
            Mail::to($staff->email)->send(new PenyewaanBaru($data, $position));
            return redirect()->action([DokumenSewaController::class, 'dokumenSewa'], ['id' => $tes]);
        } else {
            //redirect dengan pesan error
            return redirect()->route('index', ['category' => '1'])->with('error', 'Verifikasi pengajuan penyewaan gagal!');
        }
    }

    public function tolakAdmin(Request $request, Order $id){
        $tes=$id->id;
        $validated = $request->validate([
            'alasan' => 'string',
        ]);

        $result = DB::transaction(function () use ($validated, $request, $id) {
            $id->update([
                'ket_verif_admin' => 'tolak',
                'ket_konfirmasi' => $validated['alasan'],
            ]);
            return $id->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            $data = DB::table('orders')
            ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')->where('orders.id', '=', $tes)->first();
            $status='penyewaan';
            $alasan=$validated['alasan'];
            Mail::to($data->email)->send(new Tolak($data, $status, $alasan));
            return redirect()->route('index', ['category' => '1'])->with('success', 'Penolakan pengajuan penyewaan berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('index', ['category' => '1'])->with('error', 'Penolakan pengajuan penyewaan gagal!');
        }
    }

    public function setujuKepalaUPTD($id){
        $order = Order::findOrFail($id);
        return view('signature_pad', [
            'order' => $order
        ]);
    }

    public function ttdKepalaUPTD(Request $request, Order $id){
        $folderPath = public_path('storage/ttd-kepala-uptd/');
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = uniqid() . '.'.$image_type;
        file_put_contents($folderPath . $file, $image_base64);
        // echo "<h3><i>Upload Tanda Tangan Berhasil..</i><h3>";

        if($file) {
            $tes=$id->id;
            $sukses = DB::transaction(function () use ($id, $file) {
            $id->update([
                'ket_persetujuan_kepala_uptd' => 'setuju',
                'ttd_kepala_uptd' => 'ttd-kepala-uptd/' . $file
            ]);
            return $id->save();
            });

            if ($sukses) {
                //redirect dengan pesan sukses
                $data = DB::table('orders')
                ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')->where('orders.id', '=', $tes)->first();
                $staff = DB::table('users')
                ->where('jabatan', '=', 'kepala dinas')->first();
                // $data['nama_instansi'] = $tes->nama_instansi;
                $position='kepala_uptd_to_kepala_dinas';
                Mail::to($staff->email)->send(new PenyewaanBaru($data, $position));
                return redirect()->action([DokumenSewaController::class, 'dokumenSewa'], ['id' => $id]);
            } else {
                //redirect dengan pesan error
                return redirect()->route('index', ['category' => '1'])->with('error', 'Persetujuan pengajuan penyewaan gagal!');
            }
        }
    }

    public function tolakKepalaUPTD(Request $request, Order $id){
        $tes=$id->id;
        $validated = $request->validate([
            'alasan' => 'string',
        ]);

        $result = DB::transaction(function () use ($validated, $request, $id) {
            $id->update([
                'ket_persetujuan_kepala_uptd' => 'tolak',
                'ket_konfirmasi' => $validated['alasan'],
            ]);
            return $id->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            $data = DB::table('orders')
            ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')->where('orders.id', '=', $tes)->first();
            $status='penyewaan';
            $alasan=$validated['alasan'];
            Mail::to($data->email)->send(new Tolak($data, $status, $alasan));
            return redirect()->route('index', ['category' => '1'])->with('success', 'Penolakan pengajuan penyewaan berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('index', ['category' => '1'])->with('error', 'Penolakan pengajuan penyewaan gagal!');
        }
    }

    public function setujuKepalaDinas($id){
        $order = DB::table('orders')
        ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
        ->where('orders.id', $id)
        ->select('orders.id', 'orders.dokumen_sewa', 'orders.nama_instansi', 'tenants.nama', 'orders.nama_kegiatan', 'ket_persetujuan_kepala_dinas', 'ttd_kepala_dinas')
        ->first();

        $detail = DB::table('orders')
        ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
        ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
        ->where('orders.id', $id)
        ->select('orders.id', 'equipments.nama')
        ->get();

        $kepala_dinas = DB::table('users')->where('jabatan', 'kepala dinas')->first();

        return view('surat_persetujuan_kepala_dinas', [
            'order' => $order,
            'detail' => $detail,
            'kepala_dinas' => $kepala_dinas,
        ]);
    }

    public function ttdKepalaDinas(Request $request, Order $id){
        $folderPath = public_path('storage/ttd-kepala-dinas/');
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = uniqid() . '.'.$image_type;
        file_put_contents($folderPath . $file, $image_base64);
        // echo "<h3><i>Upload Tanda Tangan Berhasil..</i><h3>";

        if($file) {
            $tes=$id->id;
            $sukses = DB::transaction(function () use ($id, $file) {
            $id->update([
                'ket_persetujuan_kepala_dinas' => 'setuju',
                'ttd_kepala_dinas' => 'ttd-kepala-dinas/' . $file
            ]);
            return $id->save();
            });

            // // instantiate and use the dompdf class
            // $pdf = PDF::loadView('dokumen_sewa', $data);
            // return $pdf->download('tutsmake.pdf');

            // if ($sukses) {
            //     //redirect dengan pesan sukses
            //     return redirect()->action([DokumenSewaController::class, 'dokumenSewa'], ['id' => $tes]);
            // } else {
            //     //redirect dengan pesan error
            //     return redirect()->route('index', ['category' => '1'])->with('error', 'Persetujuan pengajuan penyewaan gagal!');
            // }
            if ($sukses) {
                //redirect dengan pesan sukses
                $data = DB::table('orders')
                ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')->where('orders.id', '=', $tes)->first();
                $staff = DB::table('users')
                ->where('jabatan', '=', 'bendahara')->first();
                // $data['nama_instansi'] = $tes->nama_instansi;
                $position='kepala_dinas_to_bendahara';
                Mail::to($staff->email)->send(new PenyewaanBaru($data, $position));
                Mail::to($data->email)->send(new PemberitahuanPenyewaanBerhasil($data));
                return redirect()->action([DokumenSewaController::class, 'dokumenSewa'], ['id' => $id]);
            } else {
                //redirect dengan pesan error
                return redirect()->route('index', ['category' => '1'])->with('error', 'Penolakan pengajuan penyewaan gagal!');
            }
        }
    }
    public function generateSuratPersetujuan($id){
        $order = Order::findOrFail($id);
        return view('signature_pad', [
            'order' => $order
        ]);
    }

    public function tolakKepalaDinas(Request $request, Order $id){
        $tes=$id->id;
        $validated = $request->validate([
            'alasan' => 'string',
        ]);

        $result = DB::transaction(function () use ($validated, $request, $id) {
            $id->update([
                'ket_persetujuan_kepala_dinas' => 'tolak',
                'ket_konfirmasi' => $validated['alasan'],
            ]);
            return $id->save();
        });

        if ($result) {
            //redirect dengan pesan sukses
            $data = DB::table('orders')
            ->join('tenants', 'orders.tenant_id', '=', 'tenants.id')->where('orders.id', '=', $tes)->first();
            $status='penyewaan';
            $alasan=$validated['alasan'];
            Mail::to($data->email)->send(new Tolak($data, $status, $alasan));
            return redirect()->route('index', ['category' => '1'])->with('success', 'Penolakan pengajuan penyewaan berhasil!');
        } else {
            //redirect dengan pesan error
            return redirect()->route('index', ['category' => '1'])->with('error', 'Penolakan pengajuan penyewaan gagal!');
        }
    }
}
