<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Noun;

class NounSeeder extends Seeder
{
    public function run(): void
    {
        Noun::insert([
            [
                'danish_word' => 'bog',
                'gender' => 'en',
                'english_translation' => 'book',
                'audio_path' => null,
            ],
            [
                'danish_word' => 'æble',
                'gender' => 'et',
                'english_translation' => 'apple',
                'audio_path' => null,
            ],
            [
                'danish_word' => 'hus',
                'gender' => 'et',
                'english_translation' => 'house',
                'audio_path' => null,
            ],
            [
                'danish_word' => 'hund',
                'gender' => 'en',
                'english_translation' => 'dog',
                'audio_path' => null,
            ],
            [
                'danish_word' => 'kat',
                'gender' => 'en',
                'english_translation' => 'cat',
                'audio_path' => null,
            ],
        ]);
    }
}
