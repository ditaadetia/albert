<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    use HasFactory;

    protected $table = 'detail_orders';
    protected $guarded = ['id'];
    protected $dates = ['created_at'];

    // protected $fillable = [
    //     'user_id',
    //     'equipment_id',
    //     'jumlah_jam_sewa',
    //     'jumlah_hari_sewa',
    //     'harga',
    //     'tanggal_ambil',
    //     'tanggal_kembali',
    //     'status'
    // ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // public function equipment()
    // {
    //     return $this->hasMany(Equipment::class);
    // }

    public function equipment()
    {
        return $this->belongsTo('App\Models\Equipment', 'equipment_id');
    }

    public function belum_diambil()
    {
        return $this->hasMany(detailKeluarMasukAlat::class)->where(['status' => 'Belum Diambil']);
    }

    public function belum_kembali()
    {
        return $this->hasMany(detailKeluarMasukAlat::class)->where(['status' => 'Sedang Dipakai']);
    }
}
