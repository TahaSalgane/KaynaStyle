<!-- Filter Sidebar (Off-Canvas) -->
<div id="filter-sidebar-panel" class="filter-sidebar fixed inset-y-0 w-80 right-0 w-full max-w-md bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out z-50 overflow-y-auto">
    <div class="p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">
                {{ __('messages.filters') }}
            </h3>
            <div class="flex items-center gap-4">
                <button onclick="resetFilters()" class="text-brown hover:text-brown-hover text-sm font-medium">
                    {{ __('messages.reset') }}
                </button>
                <button onclick="toggleFilterSidebar()" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Price Range Filter -->
        <div class="mb-8">
            <h4 class="text-md font-semibold text-gray-700 mb-4">
                {{ __('messages.price_range') }}
            </h4>
            <div class="space-y-4">
                <div class="flex items-center space-x-4">
                    <input type="number" id="minPrice" placeholder="0" min="0" max="1000"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent">
                    <span class="text-gray-500">-</span>
                    <input type="number" id="maxPrice" placeholder="1000" min="0" max="1000"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent">
                </div>

                <!-- Dual Range Slider -->
                <div class="relative">
                    <div class="dual-range-container">
                        <input type="range" id="minRange" min="0" max="1000" value="0"
                               class="dual-range-input min-range">
                        <input type="range" id="maxRange" min="0" max="1000" value="1000"
                               class="dual-range-input max-range">
                        <div class="dual-range-track"></div>
                        <div class="dual-range-progress"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-2">
                        <span>$0</span>
                        <span>$1000</span>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($showCategoryFilter) && $showCategoryFilter)
        <!-- Category Filter -->
        <div class="mb-8">
            <h4 class="text-md font-semibold text-gray-700 mb-4">
                {{ __('messages.categories') }}
            </h4>
            <div class="space-y-2">
                @if(isset($categories) && $categories->count() > 0)
                    @foreach($categories as $category)
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="category" value="{{ $category->slug }}" class="hidden category-filter">
                        <div class="w-4 h-4 border-2 border-gray-300 rounded mr-3 flex items-center justify-center category-option">
                            <i class="fas fa-check text-white text-xs opacity-0"></i>
                        </div>
                        <span class="text-sm text-gray-600">{{ $category->name }}</span>
                    </label>
                    @endforeach
                @endif
            </div>
        </div>
        @endif

        <!-- Color Filter -->
        <div class="mb-8">
            <h4 class="text-md font-semibold text-gray-700 mb-4">
                {{ __('messages.colors') }}
            </h4>
            <div class="grid grid-cols-4 gap-3">
                @if(isset($availableColors) && $availableColors->count() > 0)
                    @foreach($availableColors->unique('name_en') as $color)
                    <label class="flex flex-col items-center cursor-pointer group">
                        <input type="checkbox" name="color" value="{{ $color->name_en }}" class="hidden color-filter">
                        <div class="w-8 h-8 rounded-full border-2 border-transparent group-hover:border-gray-300 transition-all" style="background-color: {{ $color->hex_code }}"></div>
                        <span class="text-xs text-gray-600 mt-1">{{ $color->name }}</span>
                    </label>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Size Filter -->
        <div class="mb-8">
            <h4 class="text-md font-semibold text-gray-700 mb-4">
                {{ __('messages.sizes') }}
            </h4>
            <div class="grid grid-cols-4 gap-2">
                @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                <label class="flex items-center justify-center cursor-pointer">
                    <input type="checkbox" name="size" value="{{ $size }}" class="hidden size-filter">
                    <div class="w-10 h-10 border-2 border-gray-300 rounded-lg flex items-center justify-center text-sm font-medium text-gray-600 hover:border-brown hover:text-brown transition-all size-option">
                        {{ $size }}
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Apply Filters Button -->
        <button onclick="applyFilters(); toggleFilterSidebar();" class="w-full btn-brown-gradient py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
            {{ __('messages.apply_filters') }}
        </button>
    </div>
</div>

<!-- Overlay -->
<div id="filter-sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="toggleFilterSidebar()"></div>

