<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller; // Assuming you have a Seller model
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            // Add more validation rules as needed
        ]);

        $user = Auth::user();

        // Optional: check if user already has seller info
        if ($user->seller) {
            return response()->json(['message' => 'Seller info already exists.'], 409);
        }

        // Create seller profile
        $seller = new Seller();
        $seller->user_id = $user->id;
        $seller->business_name = $request->business_name;
        $seller->address = $request->address;
        $seller->phone = $request->phone;
        // Add more fields if necessary
        $seller->save();

        return response()->json(['message' => 'Seller information saved successfully.', 'seller' => $seller], 201);
    }
}
