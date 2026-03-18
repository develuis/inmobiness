<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = [
        'name',
        'id_zone',
    ];
    public function zone()
    {
        return $this->hasOne(Zone::class, 'id','id_zone');
    }
}
