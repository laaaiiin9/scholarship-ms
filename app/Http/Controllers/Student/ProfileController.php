<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\ProfileUpdateRequest;
use App\Services\Student\ProfileUpdateService;
use Illuminate\Http\Request;

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

}
