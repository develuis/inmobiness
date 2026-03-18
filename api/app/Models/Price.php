<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Zone;
class Price extends Model
{
    protected $fillable = [
        'quantity',
        'price',
        'id_zone'
    ];
    protected $casts=[
        'price'=>'double'
    ];
    public function zone()
    {
        return $this->belongsTo(Zone::class, 'id_zone', 'id');
    }
}
