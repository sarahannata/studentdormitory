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
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'venue' => 'required|string|max:255',
            'kategori' => 'required|in:Tamu Internal,Tamu Eksternal',
            'jumlah_tamu' => 'required|integer|min:1',
            'mulai' => 'required',
            'selesai' => 'required|after_or_equal:mulai',
            'catatan' => 'required|string',
        ]);

        Event::create($validated);
        return redirect()->route('dashboard')->with('success', 'Event berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('event.formevent', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'venue' => 'required|string|max:255',
            'kategori' => 'required|in:Tamu Internal,Tamu Eksternal',
            'jumlah_tamu' => 'required|integer|min:1',
            'mulai' => 'required',
            'selesai' => 'required|after_or_equal:mulai',
            'catatan' => 'required|string',
        ]);

        $event = Event::findOrFail($id);
        $event->update($validated);

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
