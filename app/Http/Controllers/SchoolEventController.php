<?php

namespace App\Http\Controllers;

use\App\Models\SchoolEvent;
use Illuminate\Http\Request;

class SchoolEventController extends Controller
{
    //
    public function store(Request $request)
{
    $validated = $request->validate([
        'school_id' => 'required|exists:schools,id',
        'user_id' => 'required|exists:users,id',
        'event_type' => 'required|string',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'event_date' => 'required|date',
        'school_type' => 'nullable|string',
    ]);

    SchoolEvent::create($validated);

    return redirect()->back()->with('success', 'Tukio limehifadhiwa kwa mafanikio!');
}

public function index()
{
    $user = \App\Helpers\UserHelper::getLoggedInUser();

    $events = SchoolEvent::where('school_id', $user->school_id)
                         ->orderBy('event_date', 'desc')
                         ->get();

    return view('events.index', compact('events'));
}


}
