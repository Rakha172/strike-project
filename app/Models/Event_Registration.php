<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Event;

class Event_Registration extends Model
{
    use HasFactory;

    protected $table = 'events_registration';
    protected $fillable = [
        'user_id',
        'event_id',
        'payment_status',
        'booth',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
    public function result()
    {
        return $this->hasMany(Result::class, 'event_id', 'event_id');
    }

}
