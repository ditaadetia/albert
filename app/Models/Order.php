<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Laravel\Sanctum\HasApiTokens;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $guarded = ['id'];
    protected $dates = ['created_at'];
    // protected $with = ['id'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('nama_kegiatan', 'like', "%" . $search . "%");
            $query->orWhereHas('tenant', function($query, $search){
                   $query->where('nama', 'like', "%" . $search . "%");
                    });
        });


        // $query->when($filters['category'] ?? false, function($query, $category){
        //     return $query->whereHas('category', function($query) use($category) {;
        //         $query->where('category_order_id', $category);
        //     });
        // });
    }

    // protected $fillable = [
    //     'category_order_id',
    //     'nama_instansi',
    //     'jabatan',
    //     'alamat_instansi',
    //     'nama_kegiatan',
    //     'ktp',
    //     'akta_notaris',
    //     'surat_ket',
    //     'ket_konfirmasi'
    // ];

    public function Category()
    {
        return $this->belongsTo(Order::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function refund()
    {
        return $this->hasMany(Refund::class);
    }

    public function reschedule()
    {
        return $this->hasMany(Reschedule::class);
    }

    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }

    public function detailorder()
    {
        return $this->hasManyThrough(DetailOrder::class,Equipment::class);
    }

    public function belum_diambil()
    {
        return $this->hasMany(DetailOrder::class)->where(['status' => 'Belum Diambil']);
    }

    public function belum_kembali()
    {
        return $this->hasMany(DetailOrder::class)->where(['status' => 'Sedang Dipakai']);
    }

    // public function selesai()
    // {
    //     return $this->hasMany(detailKeluarMasukAlat::class)->where(['status' => 'Selesai']);
    // }
}
