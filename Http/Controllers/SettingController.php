<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function accountInfo(Request $request)
    {
        return response()->json($request->user());
    }

    public function myPurchases()
    {
        return response()->json(auth()->user()->purchases);
    }

    public function getThemes()
    {
        return response()->json(['themes' => ['light', 'dark', 'retro']]);
    }

    public function updateTheme(Request $request)
    {
        $request->validate(['theme' => 'required|string']);
        $user = $request->user();
        $user->theme = $request->theme;
        $user->save();

        return response()->json(['message' => 'Theme updated']);
    }

    public function getBadges()
    {
        return response()->json(auth()->user()->badges);
    }
}
