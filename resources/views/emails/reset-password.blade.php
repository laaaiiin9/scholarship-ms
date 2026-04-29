<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Poppins', sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f7f9; }
        .container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { background: #0d6efd; color: #ffffff; padding: 40px 20px; text-align: center; }
        .content { padding: 30px; }
        .footer { background: #f8f9fa; color: #6c757d; padding: 20px; text-align: center; font-size: 12px; }
        .button { display: inline-block; padding: 12px 25px; background: #0d6efd; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: bold; margin-top: 20px; }
        .info-card { background: #f8f9fa; border-radius: 8px; padding: 15px; margin-top: 20px; border-left: 4px solid #0d6efd; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0;">Reset Password</h1>
        </div>
        <div class="content">
            <p>Hello {{ $user->username }},</p>
            <p>You are receiving this email because we received a password reset request for your account.</p>
            
            <p style="text-align: center;">
                <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}" class="button">Reset Password</a>
            </p>

            <div class="info-card" style="margin-top: 30px;">
                <p style="margin:0; font-size: 13px;">This password reset link will expire in {{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} minutes.</p>
                <p style="margin-top: 10px; margin-bottom: 0; font-size: 13px;">If you did not request a password reset, no further action is required.</p>
            </div>
            
            <p style="margin-top: 30px; font-size: 12px; color: #6c757d; word-break: break-all;">
                If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:
                <br>
                <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}">{{ route('password.reset', ['token' => $token, 'email' => $email]) }}</a>
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Eskoylar Scholarship Management System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
