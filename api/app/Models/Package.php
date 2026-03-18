<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table="packages";
    protected $fillable = [
        'product',
        'id_region',
        'id_address_from',
        'id_address_to',
        'id_client',

        'id_type',
        'id_size',
        'id_weight',
        'id_pick',
        'address_type',
        'note',
        'price',
        'status',
        'pick_date',
        'track_number'
       
    ];
    public function region()
    {
        return $this->hasOne(Region::class, 'id','id_region');
    }
    public function address_from()
    {
        return $this->hasOne(Address::class, 'id','id_address_from');
    }
    public function address_to()
    {
        return $this->hasOne(Address::class, 'id','id_address_to');
    }
    public function client()
    {
        return $this->hasOne(Client::class, 'id','id_client');
    }
    public function type()
    {
        return $this->hasOne(Attribute::class, 'id','id_type');
    }
    public function size()
    {
        return $this->hasOne(Attribute::class, 'id','id_size');
    }
    public function weight()
    {
        return $this->hasOne(Attribute::class, 'id','id_weight');
    }
    public function pick()
    {
        return $this->hasOne(Attribute::class, 'id','id_pick');
    }
    public function status()
    {
        return $this->hasOne(Status::class, 'id','status');
    }
   
}
