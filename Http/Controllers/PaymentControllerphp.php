<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;  // Make sure to import your Order model

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'payment_method' => 'required|in:cod,gcash',
            'gcash_reference' => 'nullable|string',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'payment_method' => $validated['payment_method'],
            'gcash_reference' => $validated['gcash_reference'] ?? null,
            'status' => $validated['payment_method'] === 'cod' ? 'pending' : 'paid',
        ]);

        // Optionally handle items in another table here

        return response()->json(['order' => $order]);
    }
}
