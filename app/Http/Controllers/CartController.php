<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $cartKey => $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $colorId = $item['color_id'] ?? null;
                $sizeId = $item['size_id'] ?? null;

                $color = $colorId ? Color::find($colorId) : null;
                $size = $sizeId ? Size::find($sizeId) : null;

                $cartItems[] = [
                    'cart_key' => $cartKey,
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'color' => $color,
                    'size' => $size,
                    'subtotal' => $product->current_price * $item['quantity']
                ];
                $total += $product->current_price * $item['quantity'];
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'color' => 'nullable|integer',
            'size' => 'nullable|integer',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        // Create unique cart key based on product, color, and size
        $colorId = $request->color ? (int)$request->color : null;
        $sizeId = $request->size ? (int)$request->size : null;
        $cartKey = $request->product_id . '_' . ($colorId ?? 'default') . '_' . ($sizeId ?? 'default');

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $request->quantity;
        } else {
            $cart[$cartKey] = [
                'product_id' => (int)$request->product_id,
                'quantity' => (int)$request->quantity,
                'color_id' => $colorId,
                'size_id' => $sizeId,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => __('messages.add_to_cart') . ' ' . __('messages.success'),
            'cart_count' => count($cart)
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        // Support both index-based and direct cart_key
        if (is_numeric($request->cart_key)) {
            // Legacy: index-based lookup
            $cartKeys = array_keys($cart);
            if (isset($cartKeys[$request->cart_key])) {
                $actualKey = $cartKeys[$request->cart_key];
                $cart[$actualKey]['quantity'] = $request->quantity;
                session()->put('cart', $cart);
            }
        } else {
            // Direct cart_key lookup
            if (isset($cart[$request->cart_key])) {
                $cart[$request->cart_key]['quantity'] = $request->quantity;
                session()->put('cart', $cart);
            }
        }

        return response()->json(['success' => true]);
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        // Support both index-based and direct cart_key
        if (is_numeric($request->cart_key)) {
            // Legacy: index-based lookup
            $cartKeys = array_keys($cart);
            if (isset($cartKeys[$request->cart_key])) {
                $actualKey = $cartKeys[$request->cart_key];
                unset($cart[$actualKey]);
                session()->put('cart', $cart);
            }
        } else {
            // Direct cart_key lookup
            if (isset($cart[$request->cart_key])) {
                unset($cart[$request->cart_key]);
                session()->put('cart', $cart);
            }
        }

        return response()->json(['success' => true]);
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully');
    }

    public function count()
    {
        $cart = session()->get('cart', []);
        $count = count($cart);

        return response()->json(['count' => $count]);
    }

    public function sidebar()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $cartKey => $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $colorId = $item['color_id'] ?? null;
                $sizeId = $item['size_id'] ?? null;

                $color = $colorId ? Color::find($colorId) : null;
                $size = $sizeId ? Size::find($sizeId) : null;

                // Get product image
                $mainImage = null;
                if ($color) {
                    $mainImage = $product->getMainImageForColor($color->id);
                }
                $imagePath = $mainImage ? $mainImage->image_path : ($product->main_image ?? null);

                $cartItems[] = [
                    'cart_key' => $cartKey,
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'price' => $product->current_price,
                        'image' => $imagePath ? asset('storage/' . $imagePath) : 'https://via.placeholder.com/150x150/FFC0CB/FFFFFF?text=' . urlencode($product->name),
                    ],
                    'quantity' => $item['quantity'],
                    'color' => $color ? ['id' => $color->id, 'name' => $color->name] : null,
                    'size' => $size ? ['id' => $size->id, 'name' => $size->name] : null,
                    'subtotal' => $product->current_price * $item['quantity']
                ];
                $total += $product->current_price * $item['quantity'];
            }
        }

        return response()->json([
            'success' => true,
            'items' => $cartItems,
            'total' => $total,
            'count' => count($cart)
        ]);
    }
}
