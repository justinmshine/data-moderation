<?php
namespace App\Console\Commands;

use App\Models\ContentItem;
use App\Services\ModerationService;
use Illuminate\Console\Command;

class TestModeration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:moderation {content} {--type=comment}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the moderation system with a sample content';
    /**
     * Execute the console command.
     */
    public function handle(ModerationService $moderationService)
    {
        // Get the content and content type from the command arguments
        $content = $this->argument('content');
        $type = $this->option('type');
        $this->info("Testing moderation on content: '$content'");
        // Create a test content item
        $contentItem = ContentItem::create([
            'content_type' => $type,
            'content' => $content,
            'status' => 'pending',
        ]);
        try {
            // Moderate the content using OpenAI
            $result = $moderationService->moderateContent($contentItem);
            // Display the results
            $this->info("Moderation completed for content ID: {$contentItem->id}");
            $this->info("Status: {$contentItem->status}");
            $this->info("Flagged: " . ($result->flagged ? 'Yes' : 'No'));
            if ($result->categories) {
                $this->info("Flagged categories: " . implode(', ', $result->categories));
            }
            if ($result->category_scores) {
                $this->info("Category scores:");
                foreach ($result->category_scores as $category => $score) {
                    $this->info("  - $category: $score");
                }
            }
            $this->info("Confidence: {$result->confidence}");
        } catch (\Exception $e) {
            $this->error("Moderation failed: {$e->getMessage()}");
        }
        return Command::SUCCESS;
    }
}