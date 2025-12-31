@extends('admin.layouts.app')

@section('title', 'Contact Messages')
@section('page-title', 'Contact Messages Management')

@section('content')
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 lg:mb-6 gap-4">
    <h2 class="text-lg lg:text-xl font-semibold text-gray-800">{{ __('Manage Contact Messages') }}</h2>
</div>

@if($messages->count() > 0)
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($messages as $message)
                    <tr class="hover:bg-gray-50 message-row {{ !$message->is_read ? 'bg-blue-50' : '' }}" data-message-id="{{ $message->id }}">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $message->name }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $message->email }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $message->subject }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate">{{ Str::limit($message->message, 60) }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap message-status-cell">
                            @if($message->is_read)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 status-badge">Read</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 status-badge">New</span>
                            @endif
                            @if($message->admin_response)
                                <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Responded</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $message->created_at->format('M d, Y') }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.contact.show', $message->id) }}"
                               class="text-brown hover:text-brown-darker mr-3 view-message-btn"
                               data-message-id="{{ $message->id }}"
                               data-is-read="{{ $message->is_read ? '1' : '0' }}">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <form action="{{ route('admin.contact.destroy', $message->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Are you sure you want to delete this message?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
            {{ $messages->links() }}
        </div>
    </div>
@else
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <i class="fas fa-envelope text-4xl text-gray-400 mb-4"></i>
        <p class="text-gray-600">No contact messages found.</p>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-message-btn');

    viewButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const messageId = this.getAttribute('data-message-id');
            const isRead = this.getAttribute('data-is-read') === '1';
            const row = this.closest('.message-row');
            const statusCell = row.querySelector('.message-status-cell');

            // If not already read, mark as read via AJAX
            if (!isRead) {
                e.preventDefault(); // Prevent immediate navigation

                fetch(`/admin/contact/${messageId}/mark-read`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update status badge
                        const badge = statusCell.querySelector('.status-badge');
                        badge.className = 'px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 status-badge';
                        badge.textContent = 'Read';

                        // Remove blue background from row
                        row.classList.remove('bg-blue-50');

                        // Update button data attribute
                        this.setAttribute('data-is-read', '1');

                        // Now navigate to the detail page
                        window.location.href = this.href;
                    } else {
                        // If AJAX fails, just navigate normally
                        window.location.href = this.href;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // If error, just navigate normally
                    window.location.href = this.href;
                });
            }
            // If already read, just navigate normally (no need to prevent default)
        });
    });
});
</script>
@endsection


