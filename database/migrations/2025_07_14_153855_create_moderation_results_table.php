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
        Schema::create('moderation_results', function (Blueprint $table) {
            // Primary key
            $table->id();
            // Foreign key to the content item being moderated
            $table->foreignId('content_item_id')->constrained()->onDelete('cascade');
            // Whether the content was flagged by the moderation API
            $table->boolean('flagged');
            // Categories that were flagged (stored as JSON)
            $table->json('categories')->nullable();
            // Scores for each category (stored as JSON)
            $table->json('category_scores')->nullable();
            // Highest confidence score among all categories
            $table->decimal('confidence', 8, 6)->nullable();
            // Created/updated timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moderation_results');
    }
};
