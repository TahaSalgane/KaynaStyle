@extends('admin.layouts.app')

@section('title', 'Categories')
@section('page-title', 'Categories Management')

@section('content')
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 lg:mb-6 gap-4">
    <h2 class="text-lg lg:text-xl font-semibold text-gray-800">{{ __('Manage Categories') }}</h2>
    <a href="{{ route('admin.categories.create') }}"
       class="bg-brown text-white px-4 py-2 rounded-lg hover:bg-brown-darker transition duration-300 text-sm lg:text-base text-center">
        <i class="fas fa-plus {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
        {{ __('Add New Category') }}
    </a>
</div>

@if($categories->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
        @foreach($categories as $category)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="relative">
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}"
                         alt="{{ $category->name }}"
                         class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-th-large text-gray-400 text-4xl"></i>
                    </div>
                @endif

                <div class="absolute top-4 right-4">
                    @if($category->is_active)
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            {{ __('Active') }}
                        </span>
                    @else
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                            {{ __('Inactive') }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $category->name }}</h3>
                @if($category->description)
                    <p class="text-sm text-gray-600 mb-4">{{ Str::limit($category->description, 100) }}</p>
                @endif

                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">
                        {{ __('Order') }}: {{ $category->sort_order }}
                    </span>
                    <div class="flex space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="text-green-600 hover:text-green-800" title="{{ __('Edit') }}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.categories.toggle-active', $category) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-yellow-600 hover:text-yellow-800" title="{{ __('Toggle Active') }}">
                                <i class="fas fa-toggle-{{ $category->is_active ? 'on' : 'off' }}"></i>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                              class="inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" title="{{ __('Delete') }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $categories->links() }}
    </div>
@else
    <div class="text-center py-12">
        <i class="fas fa-th-large text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">{{ __('No Categories') }}</h3>
        <p class="text-gray-500 mb-6">{{ __('Get started by adding your first category.') }}</p>
        <a href="{{ route('admin.categories.create') }}"
           class="bg-brown text-white px-6 py-3 rounded-lg hover:bg-brown-darker transition duration-300">
            <i class="fas fa-plus {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
            {{ __('Add First Category') }}
        </a>
    </div>
@endif
@endsection

