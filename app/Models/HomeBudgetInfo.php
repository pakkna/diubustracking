<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeBudgetInfo extends Model
{
    use HasFactory;

    protected $table = 'home_budget_info';
    protected $fillable = [
        'estimate',
        'total_square_feet',
        'contract_rate',
        'contractor_name',
        'user_id',
    ];
}
