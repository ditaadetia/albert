<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class detailRefund extends Model
{
    use HasFactory;
    protected $table = 'detail_refunds';
    protected $guarded = ['id'];

    public function refund()
    {
        return $this->belongsTo(Refund::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function detail_refund()
    {
        return $this->belongsTo(detailRefund::class);
    }
}
