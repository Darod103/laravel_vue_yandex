<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('place_id')
                ->constrained('places')
                ->onDelete('cascade');
            $table->string('author');
            $table->decimal('rating', 2, 1)->nullable();
            $table->text('text')->nullable();
            $table->string('raw_date')->nullable();
            $table->timestampTz('date_iso')->nullable();
            $table->timestamps();

            // Чтобы один и тот же отзыв не появлялся 10 раз
            $table->unique(['place_id', 'author', 'date_iso']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
