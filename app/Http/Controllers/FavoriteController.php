<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $events = Auth::user()->favorites()->latest('favorites.created_at')->paginate(12);
        return view('favorites.index', compact('events'));
    }

    public function toggle(Event $event)
    {
        Auth::user()->favorites()->toggle($event->id);

        return back();
    }
}
