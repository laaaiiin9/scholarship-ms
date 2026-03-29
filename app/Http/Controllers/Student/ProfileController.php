<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\ProfileRequest;
use App\Services\Student\ProfileService;
use Auth;

class ProfileController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasRole('student')) {
            return redirect()->route('home');
        }

        $profile = Auth::user()->profile;

        return view('student.profile', compact('profile'));
    }

    public function createOrSave(ProfileRequest $request, ProfileService $service)
    {
        $result = $service->createOrSave($request->validated());

        return response()->json([
            'msg' => $result['type'] === 'create'
                ? 'Profile created successfully.'
                : 'Profile updated successfully.'
        ]);

        // return redirect()
        //     ->route('student.profile')
        //     ->with('status', $result['type'] === 'create'
        //         ? 'Profile created successfully.'
        //         : 'Profile updated successfully.');
    }
}
