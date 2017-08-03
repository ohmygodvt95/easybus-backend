<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

use App\Http\Requests;

class ApiEventsController extends Controller
{
    private $perPage = 10;

    public function index(Request $request)
    {
        $type = $request->get('type', 'contributes');
        $events = Event::where('type', $type)->paginate($this->perPage);
        return response()->json($events);
    }
}
