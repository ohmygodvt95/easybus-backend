<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{
    protected $table = "userreport";

    protected $casts = [
        'add_station' => 'array',
        'delete_station' => 'array'
    ];

    public function busLine()
	{
	    return $this->belongsTo(BusLine::class, 'busline_id', 'code');
	}

}
