<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class DetailReschedule extends Model
{
    use HasFactory;
    protected $table = 'detail_reschedules';
    protected $guarded = ['id'];
}
