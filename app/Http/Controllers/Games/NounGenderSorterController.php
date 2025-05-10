<?php
namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Models\Noun;
use Illuminate\Http\Request;

class NounGenderSorterController extends Controller
{
    public function index()
    {
        // For demo, fetch 10 random nouns
        $danishNouns = Noun::inRandomOrder()->limit(10)->get(['id', 'danish_word as danish', 'gender', 'english_translation as english', 'audio_path as audio']);
        return view('games.noun-gender-sorter', compact('danishNouns'));
    }
}
