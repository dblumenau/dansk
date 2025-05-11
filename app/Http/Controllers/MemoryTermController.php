<?php

namespace App\Http\Controllers;

use App\Models\MemoryTerm;
use Illuminate\Http\Request;

class MemoryTermController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $memoryTerms = MemoryTerm::all();
        if ($request->wantsJson()) {
            return response()->json($memoryTerms);
        }
        return view('memory-terms.index', compact('memoryTerms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('memory-terms.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'da' => 'required|string|max:255',
            'en' => 'required|string|max:255',
            'topic' => 'nullable|string|max:255',
        ]);

        $memoryTerm = MemoryTerm::create($validatedData);

        if ($request->wantsJson()) {
            return response()->json($memoryTerm, 201);
        }
        return redirect()->route('memory-terms.index')->with('success', 'Memory term created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, MemoryTerm $memoryTerm)
    {
        if ($request->wantsJson()) {
            return response()->json($memoryTerm);
        }
        return view('memory-terms.show', compact('memoryTerm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MemoryTerm $memoryTerm)
    {
        return view('memory-terms.form', ['term' => $memoryTerm]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MemoryTerm $memoryTerm)
    {
        $validatedData = $request->validate([
            'da' => 'sometimes|required|string|max:255',
            'en' => 'sometimes|required|string|max:255',
            'topic' => 'nullable|string|max:255',
        ]);

        $memoryTerm->update($validatedData);

        if ($request->wantsJson()) {
            return response()->json($memoryTerm);
        }
        return redirect()->route('memory-terms.index')->with('success', 'Memory term updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, MemoryTerm $memoryTerm)
    {
        $memoryTerm->delete();

        if ($request->wantsJson()) {
            return response()->json(null, 204);
        }
        return redirect()->route('memory-terms.index')->with('success', 'Memory term deleted successfully.');
    }
}
