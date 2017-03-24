<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

use App\Http\Requests;

class EventsController extends Controller
{
    private $perPage = 10;

    public function index()
    {
        $events = Event::whereIn('type', ['notification', 'news'])->paginate($this->perPage);

        return view('events.index', [
            'pageTitle' => 'Events Management',
            'events' => $events
        ]);
    }

    public function create()
    {
        return view('events.create', [
            'pageTitle' => "Create event"
        ]);
    }

    public function store(Request $request)
    {
        $event = new Event();
        $event->title = $request->input('title');
        $event->type = $request->input('type');
        $event->content = $request->input('content');
        $event->save();
        return redirect('events')
            ->with([
                'type' => 'success',
                'message' => "Event has been created"
            ]);
    }

    public function edit($id)
    {
        $event = Event::find($id);
        return view('events.edit', [
            'pageTitle' => "Edit event: $event->title",
            'event' => $event
        ]);
    }

    public function update($id, Request $request)
    {
        $event = Event::find($id);
        $event->title = $request->input('title');
        $event->type = $request->input('type');
        $event->content = $request->input('content');
        $event->save();
        return redirect('events')
            ->with([
                'type' => 'success',
                'message' => "Event has been updated"
            ]);
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();
        return redirect('events')
            ->with([
                'type' => 'danger',
                'message' => "Event has been deleted"
            ]);
    }
}
