<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('memory_terms', function (Blueprint $table) {
            $table->id();
            $table->string('da');
            $table->string('en');
            $table->string('topic')->default('jobs');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memory_terms');
    }
};
