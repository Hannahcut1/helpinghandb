<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $product = Product::findOrFail($request->product_id);

        $cartItem = Cart::updateOrCreate(
            ['user_id' => $user->id, 'product_id' => $product->id],
            ['quantity' => \DB::raw("quantity + {$request->quantity}")]
        );

        return response()->json([
            'message' => 'Product added to cart successfully',
            'cart' => $cartItem
        ]);
    }

    public function viewCart()
    {
        $user = Auth::user();
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        return response()->json($cartItems);
    }

    public function removeItem($id)
    {
        $user = Auth::user();
        $cartItem = Cart::where('id', $id)->where('user_id', $user->id)->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        $cartItem->delete();

        return response()->json(['message' => 'Item removed from cart']);
    }
}
