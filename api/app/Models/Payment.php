<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'file',
        'confirmed',
        'id_client',
        'amount'
    ];
    public function client()
    {
        return $this->hasOne(Client::class, 'id','id_client');
    }
    protected $casts=[
        'confirmed'=>'boolean'
    ];
}
