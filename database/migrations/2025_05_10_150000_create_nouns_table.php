<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nouns', function (Blueprint $table) {
            $table->id();
            $table->string('danish_word');
            $table->enum('gender', ['en', 'et']);
            $table->string('english_translation');
            $table->string('audio_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nouns');
    }
};
