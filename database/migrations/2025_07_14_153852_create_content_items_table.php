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
        Schema::create('content_items', function (Blueprint $table) {
            // Primary key
            $table->id();
            // Foreign key to the user who created the content (optional)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            // Type of content (e.g., 'comment', 'post', 'review')
            $table->string('content_type');
            // The actual content text
            $table->text('content');
            // Current moderation status ('pending', 'approved', 'rejected')
            $table->string('status')->default('pending');
            // Created/updated timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_items');
    }
};
