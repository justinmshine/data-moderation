<?php
namespace App\Livewire;
use App\Models\ContentItem;
use Livewire\Component;
class DashboardStats extends Component
{
    /**
     * Number of pending content items.
     */
    public $pendingCount;
    /**
     * Number of approved content items.
     */
    public $approvedCount;
    /**
     * Number of rejected content items.
     */
    public $rejectedCount;
    /**
     * Number of flagged content items.
     */
    public $flaggedCount;
    /**
     * Initialize the component.
     */
    public function mount()
    {
        // Check if user has permissions to view this page
        $this->authorize('viewModeration');
        // Load initial statistics
        $this->loadStats();
    }
    /**
     * Load moderation statistics from the database.
     */
    public function loadStats()
    {
        // Count items by status
        $this->pendingCount = ContentItem::where('status', 'pending')->count();
        $this->approvedCount = ContentItem::where('status', 'approved')->count();
        $this->rejectedCount = ContentItem::where('status', 'rejected')->count();
        // Count items that were flagged by the moderation API
        $this->flaggedCount = ContentItem::whereHas('moderationResult', function($query) {
            $query->where('flagged', true);
        })->count();
    }
    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.dashboard-stats');
    }
}