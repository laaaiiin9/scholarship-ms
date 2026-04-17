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
            <h1 style="margin:0;">Application Received!</h1>
        </div>
        <div class="content">
            <p>Dear {{ $application->user->name }},</p>
            <p>We are excited to inform you that your application for the <strong>{{ $application->scholarship->name }}</strong> has been successfully submitted and is now being processed.</p>
            
            <div class="info-card">
                <p style="margin:0;"><strong>Application ID:</strong> #{{ $application->id }}</p>
                <p style="margin:0;"><strong>Submitted On:</strong> {{ $application->created_at->format('M d, Y') }}</p>
            </div>

            <p>Our team will now review your documents. You can track the real-time progress of your application through your student dashboard.</p>
            
            <a href="{{ route('student.applications.show', $application->id) }}" class="button">Track Application</a>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Eskoylar Scholarship Management System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
