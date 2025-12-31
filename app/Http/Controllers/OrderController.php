<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        // Get cart items
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', app()->getLocale() === 'ar' ? 'سلة التسوق فارغة' : 'Your cart is empty');
        }

        $cartItems = [];
        $total = 0;

        foreach ($cart as $cartKey => $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $colorId = $item['color_id'] ?? null;
                $sizeId = $item['size_id'] ?? null;

                $color = $colorId ? \App\Models\Color::find($colorId) : null;
                $size = $sizeId ? \App\Models\Size::find($sizeId) : null;

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

        // Moroccan cities data
        $moroccanCities = [
            ['en' => 'Casablanca', 'ar' => 'الدار البيضاء'],
            ['en' => 'Rabat', 'ar' => 'الرباط'],
            ['en' => 'Fes', 'ar' => 'فاس'],
            ['en' => 'Marrakech', 'ar' => 'مراكش'],
            ['en' => 'Agadir', 'ar' => 'أكادير'],
            ['en' => 'Tangier', 'ar' => 'طنجة'],
            ['en' => 'Meknes', 'ar' => 'مكناس'],
            ['en' => 'Oujda', 'ar' => 'وجدة'],
            ['en' => 'Kenitra', 'ar' => 'القنيطرة'],
            ['en' => 'Tetouan', 'ar' => 'تطوان'],
            ['en' => 'Safi', 'ar' => 'آسفي'],
            ['en' => 'Mohammedia', 'ar' => 'المحمدية'],
            ['en' => 'Khouribga', 'ar' => 'خريبكة'],
            ['en' => 'Beni Mellal', 'ar' => 'بني ملال'],
            ['en' => 'El Jadida', 'ar' => 'الجديدة'],
            ['en' => 'Taza', 'ar' => 'تازة'],
            ['en' => 'Nador', 'ar' => 'الناظور'],
            ['en' => 'Settat', 'ar' => 'سطات'],
            ['en' => 'Larache', 'ar' => 'العرائش'],
            ['en' => 'Ksar El Kebir', 'ar' => 'القصر الكبير'],
            ['en' => 'Khemisset', 'ar' => 'الخميسات'],
            ['en' => 'Guelmim', 'ar' => 'كلميم'],
            ['en' => 'Berrechid', 'ar' => 'برشيد'],
            ['en' => 'Ouarzazate', 'ar' => 'ورزازات'],
            ['en' => 'Errachidia', 'ar' => 'الرشيدية'],
            ['en' => 'Beni Mellal', 'ar' => 'بني ملال'],
            ['en' => 'Tiznit', 'ar' => 'تيزنيت'],
            ['en' => 'Chefchaouen', 'ar' => 'شفشاون'],
            ['en' => 'Dakhla', 'ar' => 'الداخلة'],
            ['en' => 'Laayoune', 'ar' => 'العيون'],
            ['en' => 'Essaouira', 'ar' => 'الصويرة'],
            ['en' => 'Ifrane', 'ar' => 'إفران'],
            ['en' => 'Azrou', 'ar' => 'أزرو'],
            ['en' => 'Midelt', 'ar' => 'ميدلت'],
            ['en' => 'Zagora', 'ar' => 'زاكورة'],
            ['en' => 'Tinghir', 'ar' => 'تنغير'],
            ['en' => 'Taroudant', 'ar' => 'تارودانت'],
            ['en' => 'Sidi Ifni', 'ar' => 'سيدي إفني'],
            ['en' => 'Guelmim', 'ar' => 'كلميم'],
            ['en' => 'Tan-Tan', 'ar' => 'طانطان'],
            ['en' => 'Smara', 'ar' => 'السمارة']
        ];

        // Countries list (ISO 3166-1 alpha-2 codes)
        $countries = $this->getCountries();

        // US States
        $usStates = $this->getUSStates();

        return view('orders.checkout', compact('cartItems', 'total', 'countries', 'usStates'));
    }

    private function getCountries()
    {
        return [
            'US' => 'United States (US)',
            'GB' => 'United Kingdom (UK)',
            'CA' => 'Canada',
            'AU' => 'Australia',
            'DE' => 'Germany',
            'FR' => 'France',
            'ES' => 'Spain',
            'IT' => 'Italy',
            'NL' => 'Netherlands',
            'BE' => 'Belgium',
            'CH' => 'Switzerland',
            'AT' => 'Austria',
            'SE' => 'Sweden',
            'NO' => 'Norway',
            'DK' => 'Denmark',
            'FI' => 'Finland',
            'PL' => 'Poland',
            'IE' => 'Ireland',
            'PT' => 'Portugal',
            'GR' => 'Greece',
            'CZ' => 'Czech Republic',
            'HU' => 'Hungary',
            'RO' => 'Romania',
            'BG' => 'Bulgaria',
            'HR' => 'Croatia',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'LT' => 'Lithuania',
            'LV' => 'Latvia',
            'EE' => 'Estonia',
            'LU' => 'Luxembourg',
            'MT' => 'Malta',
            'CY' => 'Cyprus',
            'IS' => 'Iceland',
            'LI' => 'Liechtenstein',
            'MC' => 'Monaco',
            'SM' => 'San Marino',
            'VA' => 'Vatican',
            'AD' => 'Andorra',
            'MA' => 'Morocco',
            'DZ' => 'Algeria',
            'TN' => 'Tunisia',
            'EG' => 'Egypt',
            'SA' => 'Saudi Arabia',
            'AE' => 'United Arab Emirates',
            'KW' => 'Kuwait',
            'QA' => 'Qatar',
            'BH' => 'Bahrain',
            'OM' => 'Oman',
            'JO' => 'Jordan',
            'LB' => 'Lebanon',
            'IL' => 'Israel',
            'TR' => 'Türkiye',
            'JP' => 'Japan',
            'CN' => 'China',
            'KR' => 'South Korea',
            'IN' => 'India',
            'SG' => 'Singapore',
            'MY' => 'Malaysia',
            'TH' => 'Thailand',
            'ID' => 'Indonesia',
            'PH' => 'Philippines',
            'VN' => 'Vietnam',
            'NZ' => 'New Zealand',
            'MX' => 'Mexico',
            'BR' => 'Brazil',
            'AR' => 'Argentina',
            'CL' => 'Chile',
            'CO' => 'Colombia',
            'PE' => 'Peru',
            'ZA' => 'South Africa',
            'NG' => 'Nigeria',
            'KE' => 'Kenya',
            'GH' => 'Ghana',
        ];
    }

    private function getUSStates()
    {
        return [
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'DC' => 'District of Columbia',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
            'MD' => 'Maryland',
            'MA' => 'Massachusetts',
            'MI' => 'Michigan',
            'MN' => 'Minnesota',
            'MS' => 'Mississippi',
            'MO' => 'Missouri',
            'MT' => 'Montana',
            'NE' => 'Nebraska',
            'NV' => 'Nevada',
            'NH' => 'New Hampshire',
            'NJ' => 'New Jersey',
            'NM' => 'New Mexico',
            'NY' => 'New York',
            'NC' => 'North Carolina',
            'ND' => 'North Dakota',
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'OR' => 'Oregon',
            'PA' => 'Pennsylvania',
            'RI' => 'Rhode Island',
            'SC' => 'South Carolina',
            'SD' => 'South Dakota',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VA' => 'Virginia',
            'WA' => 'Washington',
            'WV' => 'West Virginia',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming',
            'AA' => 'Armed Forces (AA)',
            'AE' => 'Armed Forces (AE)',
            'AP' => 'Armed Forces (AP)',
        ];
    }

    public function store(Request $request)
    {
        try {
            // Check if this is a direct product order (Buy it Now) or cart-based order
            if ($request->has('product_id')) {
                // Direct product order from product page
                return $this->handleDirectOrder($request);
            } else {
                // Cart-based order
                return $this->handleCartOrder($request);
            }
        } catch (\Exception $e) {
            Log::error('Order creation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() === 'ar' ? 'حدث خطأ في معالجة الطلب' : 'Error processing order: ' . $e->getMessage()
            ], 500);
        }
    }

    private function handleDirectOrder(Request $request)
    {
        // Validate direct order request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'color' => 'nullable|exists:colors,id',
            'size' => 'nullable|exists:sizes,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // Get product
        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() === 'ar' ? 'المنتج غير موجود' : 'Product not found'
            ], 404);
        }

        // Check stock
        if ($product->stock_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() === 'ar' ? 'الكمية المطلوبة غير متوفرة' : 'Insufficient stock'
            ], 400);
        }

        // Get color and size names
        $colorName = null;
        $sizeName = null;

        if ($request->color) {
            $color = \App\Models\Color::find($request->color);
            $colorName = $color ? $color->name : null;
        }

        if ($request->size) {
            $size = \App\Models\Size::find($request->size);
            $sizeName = $size ? $size->name : null;
        }

        // Calculate total
        $unitPrice = $product->current_price;
        $quantity = $request->quantity;
        $total = $unitPrice * $quantity;

        // Split full name into first and last name
        $nameParts = explode(' ', $request->full_name, 2);
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

        // Create order
        $order = Order::create([
            'order_number' => 'ORD-' . time() . '-' . rand(1000, 9999),
            'access_token' => bin2hex(random_bytes(32)),
            // Billing fields (using defaults for Morocco)
            'billing_email' => $request->phone . '@temp.com', // Temporary email since not provided
            'billing_first_name' => $firstName,
            'billing_last_name' => $lastName,
            'billing_company' => null,
            'billing_country' => 'MA', // Morocco
            'billing_address_1' => $request->address,
            'billing_address_2' => null,
            'billing_city' => $request->city,
            'billing_state' => $request->city,
            'billing_postcode' => '00000',
            'billing_phone' => $request->phone,
            // Legacy fields
            'customer_name' => $request->full_name,
            'customer_phone' => $request->phone,
            'customer_city' => $request->city,
            'customer_address' => $request->address,
            'customer_notes' => $request->notes ?? null,
            'status' => 'pending',
            'total_amount' => $total,
            'payment_status' => 'pending',
            'delivery_status' => 'pending'
        ]);

        // Create order item
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_sku' => $product->sku,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $total,
            'color' => $colorName,
            'size' => $sizeName
        ]);

        // Update product stock
        $product->decrement('stock_quantity', $quantity);

        // Send order confirmation email (if email was provided)
        try {
            // Since we don't have email, we'll skip email for now
            // You can add email field to the form later if needed
        } catch (\Exception $e) {
            Log::error('Order confirmation email error: ' . $e->getMessage());
        }

        // Return success response
        return response()->json([
            'success' => true,
            'message' => app()->getLocale() === 'ar' ? 'تم إنشاء الطلب بنجاح' : 'Order created successfully',
            'redirect_url' => route('orders.thank-you', $order->access_token),
            'order' => $order
        ]);
    }

    private function handleCartOrder(Request $request)
    {
        // Validate the request
        $request->validate([
            'billing_email' => 'required|email|max:255',
            'billing_first_name' => 'required|string|max:255',
            'billing_last_name' => 'required|string|max:255',
            'billing_company' => 'nullable|string|max:255',
            'billing_country' => 'required|string|size:2',
            'billing_address_1' => 'required|string|max:500',
            'billing_address_2' => 'nullable|string|max:500',
            'billing_city' => 'required|string|max:100',
            'billing_state' => 'required|string|max:100',
            'billing_postcode' => 'required|string|max:20',
            'billing_phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Get cart
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() === 'ar' ? 'سلة التسوق فارغة' : 'Your cart is empty'
            ], 400);
        }

        // Calculate total and prepare order items
        $total = 0;
        $orderItems = [];

        foreach ($cart as $cartKey => $item) {
            $product = Product::find($item['product_id']);
            if (!$product) continue;

            $unitPrice = $product->current_price;
            $quantity = $item['quantity'];
            $subtotal = $unitPrice * $quantity;
            $total += $subtotal;

            $colorId = $item['color_id'] ?? null;
            $sizeId = $item['size_id'] ?? null;

            $color = $colorId ? \App\Models\Color::find($colorId) : null;
            $size = $sizeId ? \App\Models\Size::find($sizeId) : null;

            $orderItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
                'color' => $color ? $color->name : null,
                'size' => $size ? $size->name : null,
                'color_id' => $colorId,
                'size_id' => $sizeId
            ];
        }

        if (empty($orderItems)) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() === 'ar' ? 'لا توجد منتجات صالحة في السلة' : 'No valid products in cart'
            ], 400);
        }

        // Create order
        $order = Order::create([
            'order_number' => 'ORD-' . time() . '-' . rand(1000, 9999),
            'access_token' => bin2hex(random_bytes(32)), // Generate secure random token
            // New billing fields
            'billing_email' => $request->billing_email,
            'billing_first_name' => $request->billing_first_name,
            'billing_last_name' => $request->billing_last_name,
            'billing_company' => $request->billing_company,
            'billing_country' => $request->billing_country,
            'billing_address_1' => $request->billing_address_1,
            'billing_address_2' => $request->billing_address_2,
            'billing_city' => $request->billing_city,
            'billing_state' => $request->billing_state,
            'billing_postcode' => $request->billing_postcode,
            'billing_phone' => $request->billing_phone,
            // Legacy fields (for backward compatibility)
            'customer_name' => $request->billing_first_name . ' ' . $request->billing_last_name,
            'customer_phone' => $request->billing_phone,
            'customer_city' => $request->billing_city,
            'customer_address' => $request->billing_address_1 . ($request->billing_address_2 ? ', ' . $request->billing_address_2 : ''),
            'customer_notes' => $request->notes,
            'status' => 'pending',
            'total_amount' => $total,
            'payment_status' => 'pending',
            'delivery_status' => 'pending'
        ]);

        // Create order items and update stock
        foreach ($orderItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'product_name' => $item['product']->name,
                'product_sku' => $item['product']->sku,
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['subtotal'],
                'color' => $item['color'],
                'size' => $item['size']
            ]);

            // Update product stock
            $item['product']->decrement('stock_quantity', $item['quantity']);
        }

        // Clear cart
        session()->forget('cart');

        // // Send order confirmation email
        // try {
        //     if ($order->billing_email) {
        //         Mail::to($order->billing_email)->send(new OrderConfirmation($order));
        //     }
        // } catch (\Exception $e) {
        //     // Log email error but don't fail the order
        //     Log::error('Order confirmation email error: ' . $e->getMessage());
        // }

        // Handle AJAX requests
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => app()->getLocale() === 'ar' ? 'تم إنشاء الطلب بنجاح' : 'Order created successfully',
                'redirect_url' => route('orders.thank-you', $order->access_token)
            ]);
        }

        // Regular form submission - redirect
        return redirect()->route('orders.thank-you', $order->access_token)
            ->with('success', app()->getLocale() === 'ar' ? 'تم إنشاء الطلب بنجاح' : 'Order created successfully');
    }

    public function thankYou($token)
    {
        $order = Order::with('items.product')->where('access_token', $token)->firstOrFail();

        return view('orders.thank-you', compact('order'));
    }
}
