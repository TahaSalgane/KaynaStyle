@extends('admin.layouts.app')

@section('title', 'Question Details')
@section('page-title', 'Question Details')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Question Details</h3>
            <div class="flex items-center gap-3">
                @if(!$question->is_read)
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">New</span>
                @endif
                <a href="{{ route('admin.questions.index') }}" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-1"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="p-6 space-y-6">
        <!-- Question Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <p class="text-gray-900 font-semibold">{{ $question->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <p class="text-gray-900">
                    <a href="mailto:{{ $question->email }}" class="text-brown hover:underline">{{ $question->email }}</a>
                </p>
            </div>
            @if($question->phone)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <p class="text-gray-900">
                    <a href="tel:{{ $question->phone }}" class="text-brown hover:underline">{{ $question->phone }}</a>
                </p>
            </div>
            @endif
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product</label>
                <p class="text-gray-900">
                    @if($question->product)
                        <a href="{{ route('admin.products.show', $question->product->id) }}" class="text-brown hover:underline">{{ $question->product->name_en }}</a>
                    @else
                        <span class="text-gray-400">General Question</span>
                    @endif
                </p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <p class="text-gray-900">{{ $question->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <p>
                    @if($question->is_read)
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Read</span>
                    @else
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">New</span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Message -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <p class="text-gray-900 whitespace-pre-wrap">{{ $question->message }}</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
            <a href="mailto:{{ $question->email }}?subject=Re: Your Question"
               class="bg-brown text-white px-4 py-2 rounded-lg hover:bg-brown-darker transition duration-300">
                <i class="fas fa-reply mr-2"></i> Reply via Email
            </a>
            <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-300"
                        onclick="return confirm('Are you sure you want to delete this question?')">
                    <i class="fas fa-trash mr-2"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

