@extends('admin.layouts.app')

@section('title', 'Sizes')
@section('page-title', 'Sizes Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Sizes') }}</h1>
            <p class="mt-1 text-sm text-gray-600">{{ __('Manage product sizes with multilingual support') }}</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.sizes.create') }}"
               class="inline-flex items-center px-4 py-2 bg-brown text-white text-sm font-medium rounded-lg hover:bg-brown-hover transition duration-300">
                <i class="fas fa-plus mr-2"></i>
                {{ __('Add Size') }}
            </a>
        </div>
    </div>

    <!-- Sizes Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($sizes->count() > 0)
            <!-- Desktop Table -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Size') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Name') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Sort Order') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Status') }}
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($sizes as $size)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-brown-light rounded-full flex items-center justify-center">
                                        <span class="text-sm font-semibold text-brown">{{ $size->name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $size->name_en }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $size->sort_order }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $size->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $size->is_active ? __('Active') : __('Inactive') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.sizes.edit', $size) }}"
                                       class="text-brown hover:text-brown-hover transition-colors duration-300"
                                       title="{{ __('Edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.sizes.toggle-active', $size) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="text-gray-400 hover:text-brown transition-colors duration-300"
                                                title="{{ $size->is_active ? __('Deactivate') : __('Activate') }}">
                                            <i class="fas fa-{{ $size->is_active ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.sizes.destroy', $size) }}" method="POST" class="inline"
                                          onsubmit="return confirm('{{ __('Are you sure you want to delete this size?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-gray-400 hover:text-red-600 transition-colors duration-300"
                                                title="{{ __('Delete') }}">
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

            <!-- Mobile Cards -->
            <div class="lg:hidden">
                @foreach($sizes as $size)
                <div class="border-b border-gray-200 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $size->name_en }}</h3>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            {{ $size->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $size->is_active ? __('Active') : __('Inactive') }}
                        </span>
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">{{ __('Sort Order') }}:</span>
                            <span class="text-sm text-gray-900">{{ $size->sort_order }}</span>
                        </div>
                    </div>

                    <div class="flex space-x-3"></div>
                        <a href="{{ route('admin.sizes.edit', $size) }}"
                           class="flex-1 bg-brown text-white text-center py-2 px-4 rounded-lg hover:bg-brown-hover transition-colors text-sm">
                            <i class="fas fa-edit mr-2"></i>
                            {{ __('Edit') }}
                        </a>
                        <form action="{{ route('admin.sizes.toggle-active', $size) }}" method="POST" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors text-sm">
                                <i class="fas fa-{{ $size->is_active ? 'eye-slash' : 'eye' }} mr-2"></i>
                                {{ $size->is_active ? __('Deactivate') : __('Activate') }}
                            </button>
                        </form>
                        <form action="{{ route('admin.sizes.destroy', $size) }}" method="POST" class="flex-1"
                              onsubmit="return confirm('{{ __('Are you sure you want to delete this size?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors text-sm">
                                <i class="fas fa-trash mr-2"></i>
                                {{ __('Delete') }}
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 lg:py-12">
                <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-ruler text-xl lg:text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No sizes found') }}</h3>
                <p class="text-sm lg:text-base text-gray-600 mb-4 lg:mb-6">{{ __('Get started by creating your first size.') }}</p>
                <a href="{{ route('admin.sizes.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-brown text-white text-sm font-medium rounded-lg hover:bg-brown-hover transition duration-300">
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('Add Size') }}
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
