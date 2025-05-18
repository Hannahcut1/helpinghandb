<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\StudentVerification;

class VerificationController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'document_type' => 'required|in:cor,id',
            'document' => 'required|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        $filePath = $request->file('document')->store('verifications', 'public');

        // Help Intelephense recognize the user type
        /** @var \App\Models\User $user */
        $user = auth()->user();

        StudentVerification::create([
            'user_id' => $user->id,
            'document_type' => $request->document_type,
            'file_path' => $filePath,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Document submitted']);
    }
}
