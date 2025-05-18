<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    // Get all services (could be all or user-specific depending on your use case)
    public function index()
    {
        // Example: only fetch services of the logged-in user
        $services = Service::where('user_id', Auth::id())->get();

        return response()->json($services);
    }

    // Store a new service
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        $service = Service::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
        ]);

        return response()->json(['message' => 'Service created', 'service' => $service], 201);
    }

    // Update an existing service
    public function update(Request $request, $id)
    {
        $service = Service::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
        ]);

        $service->update($validated);

        return response()->json(['message' => 'Service updated', 'service' => $service]);
    }

    // Delete a service
    public function destroy($id)
    {
        $service = Service::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $service->delete();

        return response()->json(['message' => 'Service deleted']);
    }
}
