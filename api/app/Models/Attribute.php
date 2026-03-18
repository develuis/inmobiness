<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['description','price','id_attribute'];
    public function attribute()
    {
        return $this->hasOne(AttributeList::class, 'id','id_attribute');
    }
}
