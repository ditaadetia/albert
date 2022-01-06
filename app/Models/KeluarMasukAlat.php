<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeluarMasukAlat extends Model
{
    use HasFactory;
    protected $table = 'keluar_masuk_alats';
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
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
