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
        'events_registration_id',
        'weight',
        'status',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function eventRegistration()
    {
        return $this->belongsTo(Event_Registration::class, 'event_id');
    }
    // public function eventRegistration()
    // {
    //     return $this->belongsTo(Event_Registration::class, 'events_registration_id');
    // }
}
