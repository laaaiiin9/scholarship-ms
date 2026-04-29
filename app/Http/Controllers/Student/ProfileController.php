<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\ProfileUpdateRequest;
use App\Services\Student\ProfileUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = auth()->user()->profile;

        return view('student.profile', compact('profile'));
    }

    public function update(ProfileUpdateRequest $request, ProfileUpdateService $service)
    {
        $service->update($request->user(), $request->validated());

        return response()->json(
            [
                'success' => true,
                'message' => 'Profile updated successfully'
            ]
        );
    }

    public function updatePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $path = $request->file('profile_picture')->store('profiles', 'public');
        $user->update(['profile_picture' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Profile picture updated successfully',
            'path' => asset('storage/' . $path)
        ]);
    }

}
