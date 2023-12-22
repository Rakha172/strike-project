<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTypes extends Model
{
    use HasFactory;
    protected $table = 'payment_types';

    protected $fillable = [
        'name',
        'owner',
        'account_number',
        'username',
        'status',
    ];
    public function eventRegist()
    {
        return $this->hasMany(Event_Registration::class, 'payment_types_id', 'id');
    }
}

