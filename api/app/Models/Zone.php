<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $fillable = [
        'name'
    ];
    public function prices()
    {
        return $this->hasMany(Price::class, 'id_zone', 'id');
    }
}
