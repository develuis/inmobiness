<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeList extends Model
{
    protected $table="attributes_list";
    protected $fillable = ['name'];
}
