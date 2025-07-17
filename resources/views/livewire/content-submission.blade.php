<div>
    <div class="p-6 bg-white rounded-lg shadow-md card">
        <h2 class="mb-4 text-xl font-semibold">Submit Content</h2>
        <form wire:submit="submitContent">
            <!-- Content Type Dropdown -->
            <div class="mb-4">
                <label for="contentType" class="block text-sm font-medium text-gray-700">Content Type</label>
                <select wire:model="contentType" id="contentType" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="comment">Comment</option>
                    <option value="forum_post">Forum Post</option>
                    <option value="review">Product Review</option>
                    <option value="code_snippet">Code Snippet</option>
                </select>
                @error('contentType') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>
            <!-- Content Textarea -->
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                <textarea wire:model="content" id="content" rows="4" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                @error('content') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>
            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25">
                    Submit
                </button>
            </div>
        </form>
        <!-- Status Message -->
        @if ($message)
            <div class="mt-4 {{ $status === 'rejected' ? 'bg-red-100 text-red-700' : ($status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700') }} p-3 rounded">
                {{ $message }}
            </div>
        @endif
    </div>
</div>