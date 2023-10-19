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
        'event_date',
        'location',
        'description',
        'category',
    ];
    public function event_regist()
    {
        return $this->hasMany(Event_Registration::class, 'event_id','id');
    }

}
