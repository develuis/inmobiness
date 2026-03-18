<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'start_date',
        'end_date',
        'file',
        'status',
        'id_user',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id','id_user');
    }
}
