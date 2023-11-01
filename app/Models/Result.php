<?php

namespace App\Models;

use App\Models\Event_Registration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Result extends Model
{
    use HasFactory;
    protected $table = 'results';

    protected $fillable = [
        'user_id',
        'weight',
        'status',
        // 'fish_total',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function event_registration()
    {
        return $this->belongsTo(Event_Registration::class, 'event_registration_id');
    }
}
