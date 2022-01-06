<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';
    protected $guarded = [];

    protected $fillable = [
        'id',
        'nama',
        'total',
        'jumlah_tersedia',
        'foto',
        'jenis',
        'kegunaan',
        'harga_sewa_perjam',
        'harga_sewa_perhari',
        'keterangan',
        'kondisi'
    ];

    public function detail()
    {
        return $this->hasMany(Equipment::class);
    }
}
