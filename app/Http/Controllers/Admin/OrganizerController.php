<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organizer;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    public function index()
    {
        $organizers = Organizer::withCount('events')->latest()->paginate(10);
        return view('admin.organizers.index', compact('organizers'));
    }

    public function create()
    {
        return view('admin.organizers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
        ]);

        Organizer::create($validated);

        return redirect()->route('admin.organizers.index')
            ->with('success', 'Organizer profile created successfully.');
    }

    public function show(Organizer $organizer)
    {
        $organizer->load('events');
        return view('admin.organizers.show', compact('organizer'));
    }

    public function edit(Organizer $organizer)
    {
        return view('admin.organizers.edit', compact('organizer'));
    }

    public function update(Request $request, Organizer $organizer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
        ]);

        $organizer->update($validated);

        return redirect()->route('admin.organizers.index')
            ->with('success', 'Organizer profile updated successfully.');
    }

    public function destroy(Organizer $organizer)
    {
        $organizer->delete();

        return redirect()->route('admin.organizers.index')
            ->with('success', 'Organizer profile deleted successfully.');
    }
}
