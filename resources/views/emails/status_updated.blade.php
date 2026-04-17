<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Poppins', sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f7f9; }
        .container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { background: #3b82f6; color: #ffffff; padding: 40px 20px; text-align: center; }
        .content { padding: 30px; }
        .footer { background: #f8f9fa; color: #6c757d; padding: 20px; text-align: center; font-size: 12px; }
        .button { display: inline-block; padding: 12px 25px; background: #3b82f6; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: bold; margin-top: 20px; }
        .status-badge { display: inline-block; padding: 5px 15px; border-radius: 20px; font-weight: bold; font-size: 14px; text-transform: uppercase; margin-bottom: 20px; }
        .status-DECIDED { background: #d1fae5; color: #059669; }
        .status-UNDER_REVIEW { background: #fef3c7; color: #d97706; }
        .status-REVISION_REQUIRED { background: #fee2e2; color: #dc2626; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0;">Status Update</h1>
        </div>
        <div class="content">
            <p>Dear {{ $application->user->name }},</p>
            <p>There has been a status update regarding your application for the <strong>{{ $application->scholarship->name }}</strong>.</p>
            
            <div class="status-badge status-{{ $application->status }}">
                {{ str_replace('_', ' ', $application->status) }}
            </div>

            @if($application->status === 'DECIDED')
                <p>A final decision has been made on your application. Please check the dashboard to view the result and any next steps.</p>
            @elseif($application->status === 'REVISION_REQUIRED')
                <p>Our team requires more information or corrected documents. Please log in to view the specific requirements and resubmit.</p>
            @else
                <p>Your application has moved into a new phase of review. Thank you for your patience.</p>
            @endif
            
            <a href="{{ route('student.applications.show', $application->id) }}" class="button">View Application Details</a>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Eskoylar Scholarship Management System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
