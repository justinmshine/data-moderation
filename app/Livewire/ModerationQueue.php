<?php
namespace App\Livewire;

use App\Models\ContentItem;
use App\Services\ModerationService;
use Livewire\Component;
use Livewire\WithPagination;

class ModerationQueue extends Component
{
    // Use Laravel's pagination with Livewire
    use WithPagination;
    // Use Tailwind CSS for pagination styling
    protected $paginationTheme = 'tailwind';
    /**
     * Current filter for content status.
     */
    public $statusFilter = 'pending';
    /**
     * Initialize the component.
     */
    public function mount()
    {
        // Check if user has permissions to view this page
        $this->authorize('viewModeration');
    }
    /**
     * Approve a content item.
     *
     * @param int $id The ID of the content item
     */
    public function approve($id)
    {
        $contentItem = ContentItem::findOrFail($id);
        app(ModerationService::class)->approveContent($contentItem);
        // Notify other components that content was moderated
        $this->dispatch('content-moderated');
    }
    /**
     * Reject a content item.
     *
     * @param int $id The ID of the content item
     */
    public function reject($id)
    {
        $contentItem = ContentItem::findOrFail($id);
        app(ModerationService::class)->rejectContent($contentItem);
        // Notify other components that content was moderated
        $this->dispatch('content-moderated');
    }
    /**
     * Moderate a content item using OpenAI.
     *
     * @param int $id The ID of the content item
     */
    public function moderate($id)
    {
        $contentItem = ContentItem::findOrFail($id);
        app(ModerationService::class)->moderateContent($contentItem);
        // Notify other components that content was moderated
        $this->dispatch('content-moderated');
    }
    /**
     * Filter content items by status.
     *
     * @param string $status The status to filter by
     */
    public function filterByStatus($status)
    {
        $this->statusFilter = $status;
        // Reset pagination when filter changes
        $this->resetPage();
    }
    /**
     * Render the component.
     */
    public function render()
    {
        // Build the query for content items
        $query = ContentItem::query()->with(['moderationResult', 'user']);
        // Apply status filter if not 'all'
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }
        // Get paginated results
        $contentItems = $query->latest()->paginate(10);
        return view('livewire.moderation-queue', [
            'contentItems' => $contentItems
        ]);
    }