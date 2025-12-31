<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderShipped;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'shipping_carrier' => 'required_if:status,shipped|nullable|in:DHL,Express,FedEx,Aramex',
            'tracking_number' => 'required_if:status,shipped|nullable|string|max:100'
        ]);

        $updateData = ['status' => $request->status];

        // If status is shipped, include shipping carrier and tracking number
        if ($request->status === 'shipped') {
            $updateData['shipping_carrier'] = $request->shipping_carrier;
            $updateData['tracking_number'] = $request->tracking_number;
        }

        $order->update($updateData);

        return back()->with('success', 'Order status updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }
}
