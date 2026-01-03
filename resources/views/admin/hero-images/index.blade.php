@extends('admin.layouts.app')

@section('title', 'Hero Images')
@section('page-title', 'Hero Images Management')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-800">{{ __('Manage Hero Images') }}</h2>
    <a href="{{ route('admin.hero-images.create') }}"
       class="bg-brown text-white px-4 py-2 rounded-lg hover:bg-brown-darker transition duration-300">
        <i class="fas fa-plus mr-2"></i>
        {{ __('Add New Image') }}
    </a>
</div>

@if($heroImages->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($heroImages as $image)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="relative">
                <img src="{{ asset('storage/' . $image->image_path) }}"
                     alt="Hero Image"
                     class="w-full h-48 object-cover"
                     onerror="console.log('Image failed to load:', this.src); this.src='https://via.placeholder.com/400x300/cccccc/666666?text=Image+Not+Found';">
                <div class="absolute top-4 right-4">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                        {{ $image->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $image->is_active ? __('Active') : __('Inactive') }}
                    </span>
                </div>
            </div>

            <div class="p-6">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">
                        {{ __('Order') }}: {{ $image->order }}
                    </span>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.hero-images.edit', $image) }}"
                           class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.hero-images.toggle', $image) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-yellow-600 hover:text-yellow-800">
                                <i class="fas fa-toggle-{{ $image->is_active ? 'on' : 'off' }}"></i>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.hero-images.destroy', $image) }}"
                              class="inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="text-center py-12">
        <i class="fas fa-images text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">{{ __('No Hero Images') }}</h3>
        <p class="text-gray-500 mb-6">{{ __('Get started by adding your first hero image.') }}</p>
        <a href="{{ route('admin.hero-images.create') }}"
           class="bg-brown text-white px-6 py-3 rounded-lg hover:bg-brown-darker transition duration-300">
            <i class="fas fa-plus mr-2"></i>
            {{ __('Add First Image') }}
        </a>
    </div>
@endif
@endsection
