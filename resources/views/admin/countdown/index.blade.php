@extends('admin.layouts.app')

@section('title', 'Countdown Timer')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Countdown Timer</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        @if($timer && $timer->id)
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Current Active Timer</h3>
            <div class="space-y-2 text-sm">
                <p><strong>Title:</strong> {{ $timer->title ?? 'N/A' }}</p>
                <p><strong>Message:</strong> {{ $timer->message ?? 'N/A' }}</p>
                <p><strong>End Date:</strong> {{ $timer->end_date ? $timer->end_date->format('Y-m-d H:i:s') : 'N/A' }}</p>
                <p><strong>Status:</strong>
                    <span class="px-2 py-1 rounded {{ $timer->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $timer->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </p>
                <p><strong>Background Color:</strong>
                    <span class="inline-block w-6 h-6 rounded border border-gray-300" style="background-color: {{ $timer->background_color }};"></span>
                    {{ $timer->background_color }}
                </p>
                <p><strong>Text Color:</strong>
                    <span class="inline-block w-6 h-6 rounded border border-gray-300" style="background-color: {{ $timer->text_color }};"></span>
                    {{ $timer->text_color }}
                </p>
            </div>
        </div>
        @endif

        <form action="{{ $timer && $timer->id ? route('admin.countdown.update', $timer->id) : route('admin.countdown.store') }}" method="POST">
            @csrf
            @if($timer && $timer->id)
                @method('PUT')
            @endif

            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Title (Optional)
                    </label>
                    <input type="text"
                           name="title"
                           id="title"
                           value="{{ old('title', $timer->title ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent"
                           placeholder="e.g., Flash Sale! Limited Time Offer">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                        Message (Optional)
                    </label>
                    <textarea name="message"
                              id="message"
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent"
                              placeholder="e.g., Don't miss out on our biggest sale of the year!">{{ old('message', $timer->message ?? '') }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                        End Date & Time <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local"
                           name="end_date"
                           id="end_date"
                           value="{{ old('end_date', ($timer && $timer->end_date) ? $timer->end_date->format('Y-m-d\TH:i') : '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent"
                           required>
                    @error('end_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="background_color" class="block text-sm font-medium text-gray-700 mb-2">
                            Background Color
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="color"
                                   name="background_color"
                                   id="background_color"
                                   value="{{ old('background_color', $timer->background_color ?? '#DC2626') }}"
                                   class="w-16 h-10 border border-gray-300 rounded cursor-pointer">
                            <input type="text"
                                   value="{{ old('background_color', $timer->background_color ?? '#DC2626') }}"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent"
                                   oninput="document.getElementById('background_color').value = this.value"
                                   placeholder="#DC2626">
                        </div>
                    </div>

                    <div>
                        <label for="text_color" class="block text-sm font-medium text-gray-700 mb-2">
                            Text Color
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="color"
                                   name="text_color"
                                   id="text_color"
                                   value="{{ old('text_color', $timer->text_color ?? '#FFFFFF') }}"
                                   class="w-16 h-10 border border-gray-300 rounded cursor-pointer">
                            <input type="text"
                                   value="{{ old('text_color', $timer->text_color ?? '#FFFFFF') }}"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent"
                                   oninput="document.getElementById('text_color').value = this.value"
                                   placeholder="#FFFFFF">
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="bg-brown text-white px-6 py-2 rounded-lg hover:bg-brown-darker transition duration-300">
                        <i class="fas fa-save mr-2"></i>{{ $timer && $timer->id ? 'Update Timer' : 'Create Timer' }}
                    </button>
                </div>
            </div>
        </form>

        @if($timer && $timer->id)
        <div class="mt-4 pt-4 border-t border-gray-200">
            <form action="{{ route('admin.countdown.destroy', $timer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to deactivate this countdown timer?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition duration-300">
                    <i class="fas fa-times mr-2"></i>Deactivate Timer
                </button>
            </form>
        </div>
        @endif
    </div>

    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <h4 class="font-semibold text-yellow-800 mb-2">
            <i class="fas fa-info-circle mr-2"></i>Tips:
        </h4>
        <ul class="text-sm text-yellow-700 space-y-1 list-disc list-inside">
            <li>Only one countdown timer can be active at a time.</li>
            <li>The timer will automatically hide when the end date passes.</li>
            <li>Use eye-catching colors like red (#DC2626) or orange (#F97316) for urgency.</li>
            <li>The timer appears at the top of every page and on product pages.</li>
        </ul>
    </div>
</div>

<script>
    // Sync color inputs
    document.getElementById('background_color')?.addEventListener('input', function(e) {
        const textInput = e.target.nextElementSibling;
        if (textInput) textInput.value = e.target.value;
    });

    document.getElementById('text_color')?.addEventListener('input', function(e) {
        const textInput = e.target.nextElementSibling;
        if (textInput) textInput.value = e.target.value;
    });
</script>
@endsection

