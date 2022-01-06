<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Categoryorder extends Model
{
    use HasFactory;

    protected $table = 'category_order';

    protected $fillable = [
        'kategori'
    ];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
