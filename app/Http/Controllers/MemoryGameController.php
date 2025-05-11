<?php

namespace App\Http\Controllers;

use App\Models\MemoryTerm;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemoryGameController extends Controller
{
    /**
     * Display the main memory game page where a topic can be selected.
     */
    public function index(): View
    {
        // These topics should ideally come from a config or database
        // For now, they match the existing select options
        $topics = [
            'jobs' => 'Jobs & Arbejde',
            'food' => 'Mad & Drikke',
            'travel' => 'Rejser & Transport',
            'hobbies' => 'Fritid & Hobbies',
        ];
        return view('games.memory-game', ['topics' => $topics]);
    }

    /**
     * Display the memory game for a specific topic.
     */
    public function playTopic(Request $request, string $topicSlug): View
    {
        $terms = MemoryTerm::where('topic', $topicSlug)
                            ->get(['da', 'en'])
                            ->map(fn($term) => ['da' => $term->da, 'en' => $term->en]) // Ensure consistent structure
                            ->all();

        // These topics should ideally come from a config or database
        $availableTopics = [
            'jobs' => 'Jobs & Arbejde',
            'food' => 'Mad & Drikke',
            'travel' => 'Rejser & Transport',
            'hobbies' => 'Fritid & Hobbies',
        ];

        $currentTopicName = $availableTopics[$topicSlug] ?? ucfirst($topicSlug);

        return view('games.memory-game', [
            'terms' => $terms,
            'selectedTopicSlug' => $topicSlug,
            'selectedTopicName' => $currentTopicName,
            'topics' => $availableTopics, // Pass all topics for the dropdown
        ]);
    }
}
