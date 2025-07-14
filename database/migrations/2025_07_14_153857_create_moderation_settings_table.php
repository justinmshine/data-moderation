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
        Schema::create('moderation_settings', function (Blueprint $table) {
            // Primary key
            $table->id();
            // Type of content these settings apply to
            $table->string('content_type');
            // Categories to flag (stored as JSON)
            $table->json('flagged_categories')->nullable();
            // Threshold for auto-rejection (0-1)
            $table->decimal('confidence_threshold', 8, 6)->default(0.5);
            // Whether to auto-approve content that passes moderation
            $table->boolean('auto_approve')->default(false);
            // Created/updated timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moderation_settings');
    }
};
