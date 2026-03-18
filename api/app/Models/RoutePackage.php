<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoutePackage extends Model
{
    protected $table='routes_packages';
    protected $fillable = [
        'hour',
        'address',
        'box_image',
        'notes',
        'progress',
        'delivery_note',
        'delivery_evidence',
        'note1',
        'note2',
        'note3',
        'note4',
        'note5',
        'id_route',
        'id_package',
    ];
    public function route()
    {
        return $this->hasOne(Route::class, 'id','id_route');
    }
    public function package()
    {
        return $this->hasOne(Package::class, 'id','id_package');
    }
}
