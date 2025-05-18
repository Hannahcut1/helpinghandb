<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller; // Removed redundant import
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Report;

class AdminController extends Controller
{
    // List all users
    public function listUsers()
    {
        $users = User::all();
        return response()->json(['users' => $users], 200);
    }

    // Delete a specific user by ID
    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully.'], 200);
    }

    // Admin analytics dashboard data
    public function analytics()
    {
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalProducts = Product::count();

        return response()->json([
            'total_users' => $totalUsers,
            'total_orders' => $totalOrders,
            'total_products' => $totalProducts,
        ]);
    }

    // View reports (you may define what reports are)
    public function viewReports()
    {
        $reports = Report::all(); // You need a Report model or adjust accordingly
        return response()->json(['reports' => $reports], 200);
    }
}
