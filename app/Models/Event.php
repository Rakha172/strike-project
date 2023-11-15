<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $fillable = [
        'name',
        'price',
        'total_booth',
        'event_date',
        'location',
        'description',
        'image',
        'qualification',
        'start',
        'end',


    ];
    public function event_regist()
    {
        return $this->hasMany(Event_Registration::class, 'event_id', 'id');
    }

    public function setBothAttribute($value)
    {
        $this->attributes['both'] = json_encode($value);
    }

    public function getBothAttribute($value)
    {
        return json_decode($value, true);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'event_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'events_registration');
    }

}
