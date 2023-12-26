<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $table = 'route_list';

    protected $fillable = [
        'driver_name',
        'primary_contact',
        'license_number',
        'license_photo',
        'address',
        'date_of_birth',
        'sex',
        'nid_number',
        'nid_photo',
        'user_id',
        'is_sign_in',
    ];
}
