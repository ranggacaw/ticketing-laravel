<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SeatController extends Controller
{
    public function index(Venue $venue)
    {
        // Group by section and row for better visualization or just list
        $seats = $venue->seats()
            ->orderBy('section')
            ->orderBy('row')
            ->orderByRaw('CAST(number AS UNSIGNED) ASC')
            ->paginate(50);

        return view('admin.venues.seats.index', compact('venue', 'seats'));
    }

    public function create(Venue $venue)
    {
        return view('admin.venues.seats.create', compact('venue'));
    }

    public function store(Request $request, Venue $venue)
    {
        // Check if bulk or single
        if ($request->has('bulk_mode') && $request->boolean('bulk_mode')) {
            return $this->storeBulk($request, $venue);
        }

        $validated = $request->validate([
            'section' => 'nullable|string|max:50',
            'row' => 'nullable|string|max:50',
            'number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('seats')->where(function ($query) use ($venue, $request) {
                    return $query->where('venue_id', $venue->id)
                        ->where('section', $request->section)
                        ->where('row', $request->row);
                })
            ],
            'type' => 'required|string|in:standard,vip,accessible',
            'status' => 'required|string|in:available,blocked,maintenance',
        ]);

        $venue->seats()->create($validated);

        return redirect()->route('admin.venues.seats.index', $venue)
            ->with('success', 'Seat created successfully.');
    }

    protected function storeBulk(Request $request, Venue $venue)
    {
        $validated = $request->validate([
            'section' => 'nullable|string|max:50',
            'row' => 'nullable|string|max:50',
            'number_start' => 'required|integer|min:1',
            'number_end' => 'required|integer|gte:number_start',
            'type' => 'required|string|in:standard,vip,accessible',
            'status' => 'required|string|in:available,blocked,maintenance',
        ]);

        $count = 0;
        $skipped = 0;

        for ($i = $validated['number_start']; $i <= $validated['number_end']; $i++) {
            $exists = Seat::where('venue_id', $venue->id)
                ->where('section', $validated['section'])
                ->where('row', $validated['row'])
                ->where('number', (string) $i)
                ->exists();

            if (!$exists) {
                Seat::create([
                    'venue_id' => $venue->id,
                    'section' => $validated['section'],
                    'row' => $validated['row'],
                    'number' => (string) $i, // Cast to string as column is string
                    'type' => $validated['type'],
                    'status' => $validated['status'],
                ]);
                $count++;
            } else {
                $skipped++;
            }
        }

        $message = "Created $count seats successfully.";
        if ($skipped > 0) {
            $message .= " Skipped $skipped existing seats.";
        }

        return redirect()->route('admin.venues.seats.index', $venue)
            ->with('success', $message);
    }

    public function edit(Venue $venue, Seat $seat)
    {
        return view('admin.venues.seats.edit', compact('venue', 'seat'));
    }

    public function update(Request $request, Venue $venue, Seat $seat)
    {
        $validated = $request->validate([
            'section' => 'nullable|string|max:50',
            'row' => 'nullable|string|max:50',
            'number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('seats')->where(function ($query) use ($venue, $request) {
                    return $query->where('venue_id', $venue->id)
                        ->where('section', $request->section)
                        ->where('row', $request->row);
                })->ignore($seat->id)
            ],
            'type' => 'required|string|in:standard,vip,accessible',
            'status' => 'required|string|in:available,blocked,maintenance',
        ]);

        $seat->update($validated);

        return redirect()->route('admin.venues.seats.index', $venue)
            ->with('success', 'Seat updated successfully.');
    }

    public function destroy(Venue $venue, Seat $seat)
    {
        $seat->delete();

        return redirect()->route('admin.venues.seats.index', $venue)
            ->with('success', 'Seat deleted successfully.');
    }
}
