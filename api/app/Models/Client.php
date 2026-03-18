<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'rfc',
        'address',
        'lat',
        'lng',
        'phone',
        'balance',
        'id_user',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id','id_user');
    }
}
