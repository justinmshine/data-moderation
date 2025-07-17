<?php

namespace App\Services;

use App\Models\ContentItem;
use App\Models\ModerationResult;
use App\Models\ModerationSetting;
use OpenAI;
use Exception;
use Illuminate\Support\Facades\Log;

class ModerationService
{
    /**
     * The OpenAI client instance.
     */
    private $client;

    /**
     * Create a new ModerationService instance.
     */
    public function __construct()
    {
        // Initialize the OpenAI client with the API key from .env
        $this->client = OpenAI::client(env('OPENAI_API_KEY'));
    }

    /**
     * Moderate a content item using OpenAI's moderation API.
     *
     * @param ContentItem $contentItem The content item to moderate
     * @return ModerationResult The result of the moderation
     * @throws Exception If the moderation API request fails
     */
    public function moderateContent(ContentItem $contentItem)
    {
        try {
            // Get the content and settings
            $content = $contentItem->content;

            // Find or create settings for this content type
            $settings = ModerationSetting::where('content_type', $contentItem->content_type)->first();

            if (!$settings) {
                // Create default settings if none exist
                $settings = ModerationSetting::create([
                    'content_type' => $contentItem->content_type,
                    'flagged_categories' => null, // Consider all categories
                    'confidence_threshold' => 0.5, // Medium threshold
                    'auto_approve' => false, // Don't auto-approve
                ]);
            }

            // Call OpenAI moderation API
            $response = $this->client->moderations()->create([
                'input' => $content,
            ]);

            // Process response
            $result = $response->results[0];
            $flagged = $result->flagged;

            // Extract categories and scores
            $categories = [];
            $categoryScores = [];

            // Loop through each category in the response
            foreach ($result->categories as $key => $category) {
                $categoryScores[$key] = $category->score;

                if ($category->violated) {
                    $categories[] = $key;
                }
            }

            // Determine highest score as overall confidence
            $confidence = !empty($categoryScores) ? max($categoryScores) : 0;

            // Save moderation result to database
            $moderationResult = ModerationResult::create([
                'content_item_id' => $contentItem->id,
                'flagged' => $flagged,
                'categories' => $categories,
                'category_scores' => $categoryScores,
                'confidence' => $confidence,
            ]);

            // Auto-approve or auto-reject based on settings
            if (!$flagged && $settings->auto_approve) {
                // Content is clean and auto-approve is enabled
                $contentItem->update(['status' => 'approved']);
            } elseif ($flagged && $confidence >= $settings->confidence_threshold) {
                // Content is flagged with confidence above threshold
                $contentItem->update(['status' => 'rejected']);
            }

            return $moderationResult;
        } catch (Exception $e) {
            // Log the error and rethrow
            Log::error('Moderation API error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Approve a content item.
     *
     * @param ContentItem $contentItem The content item to approve
     * @return bool Whether the update was successful
     */
    public function approveContent(ContentItem $contentItem)
    {
        return $contentItem->update(['status' => 'approved']);
    }

    /**
     * Reject a content item.
     *
     * @param ContentItem $contentItem The content item to reject
     * @return bool Whether the update was successful
     */
    public function rejectContent(ContentItem $contentItem)
    {
        return $contentItem->update(['status' => 'rejected']);
    }
}