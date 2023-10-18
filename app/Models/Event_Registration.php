<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_Registration extends Model
{
    use HasFactory;

    protected $table = 'events_registration';
    protected $guarded = [];

    public function events_registration()
    {
        return $this->belongsTo(Event_Registration::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}