<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $table = 'schedules';
    protected $guarded = ['id'];

    protected $fillable = [
        'order_id',
        'detail_order_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'nama_order'
    ];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function detail_order()
    {
        return $this->belongsTo(DetailOrder::class);
    }
}
