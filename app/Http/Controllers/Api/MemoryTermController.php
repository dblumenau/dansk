<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemoryTerm;

class MemoryTermController extends Controller
{
    public function index(Request $request)
    {
        $topic = $request->query('topic', 'jobs');
        $terms = MemoryTerm::where('topic', $topic)->inRandomOrder()->limit(10)->get(['da', 'en']);
        return response()->json($terms);
    }
}
