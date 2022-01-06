<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

class Reschedule extends Model
{
    use HasFactory;
    protected $table = 'reschedules';
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function detail_reschedule()
    {
        if(!auth()->check() || auth()->user()->jabatan === 'admin'){
            return $this->hasMany(DetailReschedule::class)->where(['ket_verif_admin' => 'belum']);
        }elseif(!auth()->check() || auth()->user()->jabatan === 'kepala uptd'){
            return $this->hasMany(DetailReschedule::class)->where(['ket_verif_admin' => 'verif', 'ket_persetujuan_kepala_uptd' => 'belum']);
        }elseif(!auth()->check() || auth()->user()->jabatan === 'kepala dinas'){
            return $this->hasMany(DetailReschedule::class)->where(['ket_persetujuan_kepala_uptd' => 'setuju', 'ket_persetujuan_kepala_dinas' => 'belum']);
        }
    }
}
