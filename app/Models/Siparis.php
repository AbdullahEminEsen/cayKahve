<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siparis extends Model
{
    use HasFactory;

    protected $fillable = [
        'office_id',
        'product_id',
        'status',
        'description',
        'card_id'
    ];
}
