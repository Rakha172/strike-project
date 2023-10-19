<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_Registration extends Model
{
    use HasFactory;

    protected $table = 'events_registration';
    protected $fillable = [
        'user_id',
        'event_id',
    ];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

}
