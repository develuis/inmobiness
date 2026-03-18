<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table="addresses";
    protected $fillable = [
        'street',
        'exterior_number',
        'interior_number',
        'city',
        'state',
        'reference',
        'zip',
        'lat',
        'lng',
        'type',
        'id_client',
        'is_default',
        'between_streets',
        'phone'
    ];
    protected $casts=[
        'is_default'=>'boolean'
    ];
    public function client()
    {
        return $this->hasOne(Client::class, 'id','id_client');
    }
}
