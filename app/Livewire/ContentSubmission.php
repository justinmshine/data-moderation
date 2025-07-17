<?php
namespace App\Livewire;

use App\Models\ContentItem;
use App\Services\ModerationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ContentSubmission extends Component
{
    /**
     * The content entered by the user.
     */
    public $content;
    /**
     * The type of content being submitted.
     */
    public $contentType = 'comment';
    /**
     * Message to display after submission.
     */
    public $message = '';
    /**
     * Status of the submitted content.
     */
    public $status = '';
    /**
     * Validation rules for the form.
     */
    protected $rules = [
        'content' => 'required|string|min:5',
        'contentType' => 'required|string',
    ];
    /**
     * Handle form submission.
     */
    public function submitContent()
    {
        // Validate form input
        $this->validate();
        // Create content item in the database
        $contentItem = ContentItem::create([
            'user_id' => Auth::id(), // Current logged-in user
            'content_type' => $this->contentType,
            'content' => $this->content,
            'status' => 'pending', // Initial status is pending
        ]);
        // Moderate the content immediately
        try {
            // Get the moderation service from the container
            $moderationService = app(ModerationService::class);
            // Send the content to OpenAI for moderation
            $moderationService->moderateContent($contentItem);
            // Update the message based on moderation status
            $this->message = 'Content submitted for review';
            $this->status = $contentItem->status;
            if ($contentItem->status === 'approved') {
                $this->message = 'Content approved and published';
            } elseif ($contentItem->status === 'rejected') {
                $this->message = 'Content rejected due to policy violations';
            }
        } catch (\Exception $e) {
            // Handle moderation API errors
            $this->message = 'Content submitted for review, but moderation service is currently unavailable.';
        }
        // Clear form after submission
        $this->reset('content');
    }
    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.content-submission');
    }
}