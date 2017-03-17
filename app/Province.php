<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = "province";

    public function busLine()
    {
        return $this->hasMany(BusLine::class, 'provinceID', 'id');
    }

    public function busStop()
    {
        return $this->hasMany(BusStop::class, 'provinceID', 'id');
    }

    public $timestamps = false;
}
