@extends('admin.layouts.app')

@section('title', 'Reviews')
@section('page-title', 'Reviews Management')

@section('content')
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 lg:mb-6 gap-4">
    <h2 class="text-lg lg:text-xl font-semibold text-gray-800">{{ __('Manage Reviews') }}</h2>
    <a href="{{ route('admin.reviews.create') }}"
       class="bg-brown text-white px-4 py-2 rounded-lg hover:bg-brown-darker transition duration-300 text-sm lg:text-base text-center">
        <i class="fas fa-plus mr-2"></i>
        {{ __('Add New Review') }}
    </a>
</div>

@if($reviews->count() > 0)
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Review</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($reviews as $review)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                @if($review->product)
                                    {{ $review->product->name_en }}
                                @else
                                    <span class="text-gray-400 italic">Product Deleted</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $review->customer_name }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-xs"></i>
                                @endfor
                                <span class="ml-2 text-sm text-gray-600">({{ $review->rating }}/5)</span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate">{{ $review->review_text }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            @if($review->is_approved)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ __('Approved') }}
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ __('Pending') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $review->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <form action="{{ route('admin.reviews.toggle-approval', $review) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-blue-600 hover:text-blue-900" title="{{ $review->is_approved ? __('Disapprove') : __('Approve') }}">
                                        <i class="fas fa-{{ $review->is_approved ? 'eye-slash' : 'check' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this review?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="{{ __('Delete') }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
            {{ $reviews->links() }}
        </div>
    </div>
@else
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <i class="fas fa-star text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-600 text-lg">{{ __('No reviews found') }}</p>
    </div>
@endif
@endsection


