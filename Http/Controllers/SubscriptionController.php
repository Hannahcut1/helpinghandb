<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    // Subscribe to a seller
    public function subscribe($sellerId)
    {
        $user = Auth::user();

        if ($user->id == $sellerId) {
            return response()->json(['message' => 'You cannot subscribe to yourself.'], 400);
        }

        $seller = User::findOrFail($sellerId);

        if (!$seller->hasRole('seller')) {
            return response()->json(['message' => 'Target user is not a seller.'], 400);
        }

        if ($user->subscriptions()->where('seller_id', $sellerId)->exists()) {
            return response()->json(['message' => 'You are already subscribed to this seller.'], 400);
        }

        $user->subscriptions()->attach($sellerId);

        return response()->json(['message' => 'Subscribed successfully.']);
    }

    // Unsubscribe from a seller
    public function unsubscribe($sellerId)
    {
        $user = Auth::user();

        if (!$user->subscriptions()->where('seller_id', $sellerId)->exists()) {
            return response()->json(['message' => 'You are not subscribed to this seller.'], 400);
        }

        $user->subscriptions()->detach($sellerId);

        return response()->json(['message' => 'Unsubscribed successfully.']);
    }

    // View current user's subscriptions
    public function viewSubscriptions()
    {
        $subscriptions = Auth::user()->subscriptions()->with('profile')->get();

        return response()->json($subscriptions);
    }

    // List all subscriptions (admin or management use)
    public function index()
    {
        $subscriptions = Subscription::with(['user', 'seller'])->get();
        return response()->json($subscriptions);
    }

    // Show a specific subscription
    public function show($id)
    {
        $subscription = Subscription::with(['user', 'seller'])->findOrFail($id);
        return response()->json($subscription);
    }

    // Create a subscription manually (optional)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'seller_id' => 'required|exists:users,id',
        ]);

        $subscription = Subscription::create($validated);

        return response()->json($subscription, 201);
    }

    // Update a subscription (optional)
    public function update(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);

        $validated = $request->validate([
            'seller_id' => 'sometimes|exists:users,id',
        ]);

        $subscription->update($validated);

        return response()->json($subscription);
    }

    // Delete a subscription
    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        return response()->json(['message' => 'Subscription deleted.']);
    }
}
