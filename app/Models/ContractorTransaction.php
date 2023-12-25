<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_worker',
        'total_amount',
        'paid',
        'unpaid',
        'category',
        'paid_date',
        'user_id'
    ];
}
