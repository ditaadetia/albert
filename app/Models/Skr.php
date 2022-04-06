<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Skr extends Model
{
    use HasFactory;
    protected $table = 'skr';
    protected $guarded = ['id'];

    protected $fillable = [
        'order_id',
        'skr',
        'ttd_bendahara'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
