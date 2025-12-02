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
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')
            ->onDelete('cascade')->unique();
            $table->string('name')->nullable();
            $table->text('url');
            $table->decimal('rating', 2, 1)->nullable();
            $table->integer('total_reviews')->nullable();
            $table->enum('status', ['pending','processing', 'done','error'])->default('pending');
            $table->timestampTz('parsed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
