<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{
    protected $table = "userreport";

    public $timestamps = false;
    protected $casts = [
        'add_station' => 'array',
        'delete_station' => 'array'
    ];

    public function busline()
	{
	    return $this->belongsTo('App\Busline', 'busline_id', 'code');
	}
}
