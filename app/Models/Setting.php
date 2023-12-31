<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'setting';

    protected $fillabel = [
        'name',
        'history',
        'location',
        'logo',
        'slogan',
        'desc',
        'phone',
        'email',
        'sender',
        'endpoint',
        'media_endpoint',
        'api_key',
    ];
}
