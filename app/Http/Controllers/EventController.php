<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index() {
        return view('dashboard'); // your Blade view
    }

    public function getEvents() {
        return Event::all(); // Return all events as JSON
    }

    public function store(Request $request) {
        $event = Event::create([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end ?? $request->start,
        ]);
        return response()->json($event);
    }

    public function update(Request $request, Event $event) {
        $event->update([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end ?? $request->start,
        ]);
        return response()->json($event);
    }

    public function destroy(Event $event) {
        $event->delete();
        return response()->json(['success' => true]);
    }
}
