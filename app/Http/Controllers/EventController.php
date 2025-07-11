<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('event/detailevent', compact('events'));
    }

    public function create()
    {
        return view('event.formevent');
    }

    public function store(Request $request)
    {
        Event::create($request->all());
        return redirect()->route('dashboard')->with('success', 'Event berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('event.formevent', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return redirect()->route('event.show', $event->id)->with('success', 'Event berhasil diperbarui!');
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('event.detailevent', compact('event'));
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('dashboard')->with('success', 'Event berhasil dihapus.');
    }
}
