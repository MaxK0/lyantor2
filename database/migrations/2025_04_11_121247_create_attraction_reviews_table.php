<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attraction_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attraction_id')->constrained('attractions')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('name');
            $table->tinyInteger('rating');
            $table->text('comment')->nullable();
            $table->string('ip');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attraction_reviews');
    }
};
