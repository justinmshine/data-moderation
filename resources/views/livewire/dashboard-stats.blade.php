<div>
    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4">
        <!-- Pending Items -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Pending Review</p>
                    <p class="text-xl font-semibold text-gray-700">{{ $pendingCount }}</p>
                </div>
            </div>
        </div>
        <!-- Approved Items -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Approved</p>
                    <p class="text-xl font-semibold text-gray-700">{{ $approvedCount }}</p>
                </div>
            </div>
        </div>
        <!-- Rejected Items -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Rejected</p>
                    <p class="text-xl font-semibold text-gray-700">{{ $rejectedCount }}</p>
                </div>
            </div>
        </div>
        <!-- Flagged Items -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Flagged</p>
                    <p class="text-xl font-semibold text-gray-700">{{ $flaggedCount }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Link to Moderation Queue -->
    <div class="flex justify-center">
        <a href="{{ route('admin.moderation-queue') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700">
            View Moderation Queue
        </a>
    </div>
</div>