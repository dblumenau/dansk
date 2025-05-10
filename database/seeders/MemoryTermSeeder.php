<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MemoryTerm;

class MemoryTermSeeder extends Seeder
{
    public function run(): void
    {
        $terms = [
            ['da' => 'Pædagog', 'en' => 'Preschool Teacher'],
            ['da' => 'En børnehave', 'en' => 'A kindergarten'],
            ['da' => 'Journalist', 'en' => 'Journalist'],
            ['da' => 'En avis', 'en' => 'A newspaper'],
            ['da' => 'Tømrer', 'en' => 'Carpenter'],
            ['da' => 'Et byggefirma', 'en' => 'Construction company'],
            ['da' => 'Rengøringsassistent', 'en' => 'Cleaning Assistant'],
            ['da' => 'Et hospital', 'en' => 'A hospital'],
            ['da' => 'Lav løn', 'en' => 'Low salary'],
            ['da' => 'God løn', 'en' => 'Good salary'],
            ['da' => 'Stressende', 'en' => 'Stressful'],
            ['da' => 'Fysisk hårdt', 'en' => 'Physically hard'],
            ['da' => 'Fordele', 'en' => 'Advantages'],
            ['da' => 'Ulemper', 'en' => 'Disadvantages'],
            ['da' => 'Fuldtidsjob', 'en' => 'Full-time job'],
            ['da' => 'Deltidsjob', 'en' => 'Part-time job'],
            ['da' => 'Kollegaer', 'en' => 'Colleagues'],
            ['da' => 'Chef', 'en' => 'Boss'],
            ['da' => 'Ansøgning', 'en' => 'Application'],
            ['da' => 'Jobannonce', 'en' => 'Job advertisement'],
        ];
        foreach ($terms as $term) {
            MemoryTerm::create([
                'da' => $term['da'],
                'en' => $term['en'],
                'topic' => 'jobs',
            ]);
        }
    }
}
