<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatarialTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'matarial_name',
        'quantity',
        'total_amount',
        'paid',
        'unpaid',
        'category',
        'buying_date',
        'user_id',
        'receipt_photo'
    ];
}
