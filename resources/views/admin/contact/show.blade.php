@extends('admin.layouts.app')

@section('title', 'Contact Message Details')
@section('page-title', 'Contact Message Details')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Contact Message Details</h3>
            <div class="flex items-center gap-3">
                @if(!$message->is_read)
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">New</span>
                @endif
                @if($message->admin_response)
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Responded</span>
                @endif
                <a href="{{ route('admin.contact.index') }}" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-1"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="p-6 space-y-6">
        <!-- Message Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <p class="text-gray-900 font-semibold">{{ $message->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <p class="text-gray-900">
                    <a href="mailto:{{ $message->email }}" class="text-brown hover:underline">{{ $message->email }}</a>
                </p>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                <p class="text-gray-900 font-semibold">{{ $message->subject }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <p class="text-gray-900">{{ $message->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <p>
                    @if($message->is_read)
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
                <p class="text-gray-900 whitespace-pre-wrap">{{ $message->message }}</p>
            </div>
        </div>

        <!-- Admin Response Section -->
        @if($message->admin_response)
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Your Response</label>
            <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                <p class="text-gray-900 whitespace-pre-wrap">{{ $message->admin_response }}</p>
                <p class="text-sm text-gray-500 mt-2">
                    <i class="fas fa-clock mr-1"></i> Responded on {{ $message->responded_at->format('F d, Y \a\t h:i A') }}
                </p>
            </div>
        </div>
        @endif

        <!-- Response Form -->
        <div class="border-t border-gray-200 pt-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">
                @if($message->admin_response)
                    Update Response
                @else
                    Send Response
                @endif
            </h4>
            <form action="{{ route('admin.contact.respond', $message->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="admin_response" class="block text-sm font-medium text-gray-700 mb-2">Response</label>
                    <textarea name="admin_response" id="admin_response" rows="6"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent"
                              placeholder="Enter your response to the customer...">{{ $message->admin_response ?? '' }}</textarea>
                    @error('admin_response')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center gap-3">
                    <button type="submit" class="bg-brown text-white px-6 py-2 rounded-lg hover:bg-brown-darker transition duration-300">
                        <i class="fas fa-paper-plane mr-2"></i>
                        @if($message->admin_response)
                            Update Response
                        @else
                            Send Response
                        @endif
                    </button>
                    <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}"
                       class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition duration-300">
                        <i class="fas fa-envelope mr-2"></i> Reply via Email
                    </a>
                </div>
            </form>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
            <form action="{{ route('admin.contact.destroy', $message->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-300"
                        onclick="return confirm('Are you sure you want to delete this message?')">
                    <i class="fas fa-trash mr-2"></i> Delete Message
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

