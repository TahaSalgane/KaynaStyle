@extends('admin.layouts.app')

@section('title', 'Colors')
@section('page-title', 'Colors Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Colors') }}</h1>
            <p class="mt-1 text-sm text-gray-600">{{ __('Manage product colors with multilingual support') }}</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.colors.create') }}"
               class="inline-flex items-center px-4 py-2 bg-brown text-white text-sm font-medium rounded-lg hover:bg-brown-hover transition duration-300">
                <i class="fas fa-plus {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                {{ __('Add Color') }}
            </a>
        </div>
    </div>

    <!-- Colors Grid -->
    <div class="bg-white rounded-lg shadow">
        @if($colors->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 p-6">
                @foreach($colors as $color)
                <div class="group relative bg-white border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-all duration-300">
                    <!-- Color Preview -->
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-16 h-16 rounded-full border-4 border-gray-200 shadow-lg"
                             style="background-color: {{ $color->hex_code }}"></div>
                    </div>

                    <!-- Color Info -->
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $color->name }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $color->hex_code }}</p>

                        <!-- Status Badge -->
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            {{ $color->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $color->is_active ? __('Active') : __('Inactive') }}
                        </span>
                    </div>

                    <!-- Actions -->
                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="flex space-x-1">
                            <a href="{{ route('admin.colors.edit', $color) }}"
                               class="p-2 text-gray-400 hover:text-brown transition-colors duration-300"
                               title="{{ __('Edit') }}">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <form action="{{ route('admin.colors.destroy', $color) }}" method="POST" class="inline"
                                  onsubmit="return confirm('{{ __('Are you sure you want to delete this color?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-2 text-gray-400 hover:text-red-600 transition-colors duration-300"
                                        title="{{ __('Delete') }}">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Toggle Active -->
                    <div class="mt-4 text-center">
                        <form action="{{ route('admin.colors.toggle-active', $color) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="text-xs px-3 py-1 rounded-full transition-colors duration-300
                                    {{ $color->is_active
                                        ? 'bg-red-100 text-red-700 hover:bg-red-200'
                                        : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                {{ $color->is_active ? __('Deactivate') : __('Activate') }}
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-palette text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No colors found') }}</h3>
                <p class="text-gray-600 mb-6">{{ __('Get started by creating your first color.') }}</p>
                <a href="{{ route('admin.colors.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-brown text-white text-sm font-medium rounded-lg hover:bg-brown-hover transition duration-300">
                    <i class="fas fa-plus {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                    {{ __('Add Color') }}
                </a>
            </div>
        @endif
    </div>
</div>
@endsection








