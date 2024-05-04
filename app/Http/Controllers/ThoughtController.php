<?php

namespace App\Http\Controllers;

use App\Models\Thought;
use App\Events\ThoughtCreated;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class ThoughtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('thoughts.index', [
            'thoughts' => Thought::with('user')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]); 
        // validate the new thought

        $request->user()->thoughts()->create($validated); 
        // add the new thought

        return redirect(route('thoughts.index'));
        // redirect the user
    }

    /**
     * Display the specified resource.
     */
    public function show(Thought $thought)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Thought $thought): View
    {
        Gate::authorize('update', $thought);
 
        return view('thoughts.edit', [
            'thought' => $thought,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Thought $thought): RedirectResponse
    {
        Gate::authorize('update', $thought);
 
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        $thought->update($validated);
 
        return redirect(route('thoughts.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Thought $thought)
    {
        Gate::authorize('delete', $thought);

        $thought->delete();

        return redirect(route('thoughts.index'));
    }
}
