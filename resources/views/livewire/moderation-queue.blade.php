<div>
    <!-- Status Filter Buttons -->
    <div class="flex mb-4 space-x-2">
        <button wire:click="filterByStatus('pending')" class="px-4 py-2 rounded-md {{ $statusFilter === 'pending' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
            Pending
        </button>
        <button wire:click="filterByStatus('approved')" class="px-4 py-2 rounded-md {{ $statusFilter === 'approved' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
            Approved
        </button>
        <button wire:click="filterByStatus('rejected')" class="px-4 py-2 rounded-md {{ $statusFilter === 'rejected' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
            Rejected
        </button>
        <button wire:click="filterByStatus('all')" class="px-4 py-2 rounded-md {{ $statusFilter === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
            All
        </button>
    </div>
    <!-- Content Items Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">ID</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Type</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Content</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Flags</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($contentItems as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">{{ $item->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $item->content_type }}</td>
                        <td class="max-w-md px-6 py-4 text-sm text-gray-500">
                            <div class="overflow-y-auto max-h-20">
                                {{ $item->content }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            @if ($item->status === 'pending')
                                <span class="inline-flex px-2 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full">
                                    Pending
                                </span>
                            @elseif ($item->status === 'approved')
                                <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                    Approved
                                </span>
                            @elseif ($item->status === 'rejected')
                                <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                    Rejected
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            @if ($item->moderationResult)
                                @if ($item->moderationResult->flagged)
                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                        Flagged
                                    </span>
                                    <div class="mt-1 text-xs">
                                        @foreach ($item->moderationResult->categories as $category)
                                            <span class="px-1 mr-1 text-red-700 rounded bg-red-50">{{ $category }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                        Clean
                                    </span>
                                @endif
                            @else
                                <span class="inline-flex px-2 text-xs font-semibold leading-5 text-gray-800 bg-gray-100 rounded-full">
                                    Not Checked
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                            <div class="flex space-x-2">
                                @if ($item->status !== 'approved')
                                    <button wire:click="approve({{ $item->id }})" class="text-green-600 hover:text-green-900">Approve</button>
                                @endif
                                @if ($item->status !== 'rejected')
                                    <button wire:click="reject({{ $item->id }})" class="text-red-600 hover:text-red-900">Reject</button>
                                @endif
                                @if (!$item->moderationResult)
                                    <button wire:click="moderate({{ $item->id }})" class="text-blue-600 hover:text-blue-900">Check</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-sm text-center text-gray-500">No content items found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $contentItems->links() }}
    </div>
</div>