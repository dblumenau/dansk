<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noun extends Model
{
    protected $fillable = [
        'danish_word',
        'gender',
        'english_translation',
        'audio_path',
    ];
}
