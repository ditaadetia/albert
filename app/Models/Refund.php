<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Refund extends Model
{
    use HasFactory;

    protected $table = 'refunds';
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function detail_refund()
    {
        if(!auth()->check() || auth()->user()->jabatan === 'admin'){
            return $this->hasMany(detailRefund::class)->where(['ket_verif_admin' => 'belum']);
        }elseif(!auth()->check() || auth()->user()->jabatan === 'kepala uptd'){
            return $this->hasMany(detailRefund::class)->where(['ket_verif_admin' => 'verif', 'ket_persetujuan_kepala_uptd' => 'belum']);
        }elseif(!auth()->check() || auth()->user()->jabatan === 'kepala dinas'){
            return $this->hasMany(detailRefund::class)->where(['ket_persetujuan_kepala_uptd' => 'setuju', 'ket_persetujuan_kepala_dinas' => 'belum']);
        }
    }

    // public function tenant()
    // {
    //     return $this->hasOneThrough(Refund::class, Order::class, 'tenant_id', 'order_id', 'id', 'id');
    // }
}
