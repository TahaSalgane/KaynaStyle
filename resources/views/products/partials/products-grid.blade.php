@foreach($products as $product)
<div class="product-card bg-white rounded-2xl shadow-lg overflow-hidden group hover:shadow-2xl transition-all duration-500 border border-gray-100">
    <a href="{{ route('products.show', $product->slug) }}" class="block">
        <div class="relative overflow-hidden">
            <img src="{{ $product->main_image ? asset('storage/' . $product->main_image) : 'https://via.placeholder.com/300x375/FFC0CB/FFFFFF?text=' . urlencode($product->name) }}"
                 alt="{{ $product->name }}"
                 class="w-full h-64 sm:h-72 lg:h-80 object-cover group-hover:scale-110 transition-transform duration-500 aspect-[2/3]">
            @if($product->sale_price)
            <div class="absolute top-3 left-3 bg-red-500 text-white px-3 py-1.5 rounded-md text-xs font-bold shadow-lg transform -rotate-3 hover:rotate-0 transition-transform duration-300 border-2 border-white">
                <span class="relative z-10">{{ app()->getLocale() === 'ar' ? 'خصم' : 'Sale' }}</span>
            </div>
            @endif
            <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <button class="bg-white text-brown p-2 rounded-full shadow-lg hover:bg-brown-light transition-colors duration-300">
                    <i class="fas fa-heart text-sm"></i>
                </button>
            </div>
        </div>
    </a>
    <div class="p-4">
        <a href="{{ route('products.show', $product->slug) }}">
            <h3 class="text-base font-bold text-gray-800 mb-2 group-hover:text-brown transition-colors duration-300 hover:text-brown cursor-pointer">{{ $product->name }}</h3>
        </a>
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }}">
                @if($product->sale_price)
                <span class="text-lg font-bold text-brown">{{ $product->sale_price }} DH</span>
                <span class="text-sm text-gray-500 line-through">{{ $product->price }} DH</span>
            @else
                <span class="text-lg font-bold text-brown">{{ $product->price }} DH</span>
                @endif
            </div>
            <div class="flex items-center text-yellow-400">
                <i class="fas fa-star text-xs"></i>
                <i class="fas fa-star text-xs"></i>
                <i class="fas fa-star text-xs"></i>
                <i class="fas fa-star text-xs"></i>
                <i class="fas fa-star text-xs"></i>
            </div>
        </div>
        <button onclick="addToCart({{ $product->id }})" class="w-full btn-brown-gradient py-2 rounded-xl text-sm font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg inline-flex items-center justify-center">
            <i class="fas fa-shopping-cart {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
            {{ app()->getLocale() === 'ar' ? 'أضف للسلة' : 'Buy Now' }}
        </button>
    </div>
</div>
@endforeach

