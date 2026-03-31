<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function notice() {
        return view('email.verification_notice');
    }

    public function verify(EmailVerificationRequest $request) {
        $request->fulfill();

        return view('email.verification_verified');
    }

    public function sendEmail(Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'msg' => 'Verification link sent'
        ]);
    }

}
