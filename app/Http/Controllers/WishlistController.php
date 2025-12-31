<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    public function index()
    {
        $sessionId = Session::getId();
        $wishlistItems = Wishlist::where('session_id', $sessionId)
            ->with('product.category')
            ->get();

        $products = $wishlistItems->map(function ($item) {
            return $item->product;
        })->filter();

        return view('wishlist.index', compact('products'));
    }

    public function toggle(Request $request)
    {
        $productId = $request->input('product_id');
        $sessionId = Session::getId();

        $wishlistItem = Wishlist::where('session_id', $sessionId)
            ->where('product_id', $productId)
            ->first();

        if ($wishlistItem) {
            // Remove from wishlist
            $wishlistItem->delete();
            return response()->json([
                'success' => true,
                'in_wishlist' => false,
                'message' => app()->getLocale() === 'ar' ? 'تمت إزالة المنتج من قائمة الأمنيات' : 'Product removed from wishlist'
            ]);
        } else {
            // Add to wishlist
            Wishlist::create([
                'session_id' => $sessionId,
                'product_id' => $productId,
            ]);
            return response()->json([
                'success' => true,
                'in_wishlist' => true,
                'message' => app()->getLocale() === 'ar' ? 'تمت إضافة المنتج إلى قائمة الأمنيات' : 'Product added to wishlist'
            ]);
        }
    }

    public function remove(Request $request)
    {
        $productId = $request->input('product_id');
        $sessionId = Session::getId();

        Wishlist::where('session_id', $sessionId)
            ->where('product_id', $productId)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => app()->getLocale() === 'ar' ? 'تمت إزالة المنتج من قائمة الأمنيات' : 'Product removed from wishlist'
        ]);
    }

    public function check(Request $request)
    {
        $productId = $request->input('product_id');
        $sessionId = Session::getId();

        $inWishlist = Wishlist::where('session_id', $sessionId)
            ->where('product_id', $productId)
            ->exists();

        return response()->json([
            'in_wishlist' => $inWishlist
        ]);
    }

    public function count()
    {
        $sessionId = Session::getId();
        $count = Wishlist::where('session_id', $sessionId)->count();

        return response()->json(['count' => $count]);
    }
}
