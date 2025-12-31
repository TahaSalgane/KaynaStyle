@extends('admin.layouts.app')

@section('title', 'Questions')
@section('page-title', 'Questions Management')

@section('content')
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 lg:mb-6 gap-4">
    <h2 class="text-lg lg:text-xl font-semibold text-gray-800">{{ __('Manage Questions') }}</h2>
</div>

@if($questions->count() > 0)
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($questions as $question)
                    <tr class="hover:bg-gray-50 question-row {{ !$question->is_read ? 'bg-blue-50' : '' }}" data-question-id="{{ $question->id }}">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $question->name }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $question->email }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @if($question->product)
                                    {{ $question->product->name_en }}
                                @else
                                    <span class="text-gray-400">General Question</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate">{{ Str::limit($question->message, 60) }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap question-status-cell">
                            @if($question->is_read)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 status-badge">Read</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 status-badge">New</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $question->created_at->format('M d, Y') }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.questions.show', $question->id) }}"
                               class="text-brown hover:text-brown-darker mr-3 view-question-btn"
                               data-question-id="{{ $question->id }}"
                               data-is-read="{{ $question->is_read ? '1' : '0' }}">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Are you sure you want to delete this question?')">
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
            {{ $questions->links() }}
        </div>
    </div>
@else
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <i class="fas fa-question-circle text-4xl text-gray-400 mb-4"></i>
        <p class="text-gray-600">No questions found.</p>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-question-btn');

    viewButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const questionId = this.getAttribute('data-question-id');
            const isRead = this.getAttribute('data-is-read') === '1';
            const row = this.closest('.question-row');
            const statusCell = row.querySelector('.question-status-cell');

            // If not already read, mark as read via AJAX
            if (!isRead) {
                e.preventDefault(); // Prevent immediate navigation

                fetch(`/admin/questions/${questionId}/mark-read`, {
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

