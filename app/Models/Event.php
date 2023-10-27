<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
