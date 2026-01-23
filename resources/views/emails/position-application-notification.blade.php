<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Job Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #e72177 0%, #862c91 100%);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
        }
        .info-row {
            margin-bottom: 15px;
            padding: 10px;
            background: white;
            border-left: 3px solid #e72177;
        }
        .label {
            font-weight: bold;
            color: #862c91;
            display: block;
            margin-bottom: 5px;
        }
        .value {
            color: #333;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Job Application Received</h1>
    </div>
    
    <div class="content">
        <div class="info-row">
            <span class="label">Position:</span>
            <span class="value">
                {{ $application->position->translate('en')?->name ?? $application->position->translate('ar')?->name ?? 'N/A' }}
            </span>
        </div>
        
        <div class="info-row">
            <span class="label">Applicant Name:</span>
            <span class="value">{{ $application->name }}</span>
        </div>
        
        <div class="info-row">
            <span class="label">Email:</span>
            <span class="value">{{ $application->email }}</span>
        </div>
        
        @if($application->phone)
        <div class="info-row">
            <span class="label">Phone:</span>
            <span class="value">{{ $application->phone }}</span>
        </div>
        @endif
        
        <div class="info-row">
            <span class="label">Experience:</span>
            <div class="value" style="white-space: pre-wrap;">{{ $application->experience }}</div>
        </div>
        
        <div class="info-row">
            <span class="label">Qualifications:</span>
            <div class="value" style="white-space: pre-wrap;">{{ $application->qualifications }}</div>
        </div>
        
        <div class="info-row">
            <span class="label">CV Attachment:</span>
            <span class="value">{{ $application->cv_filename }}</span>
        </div>
        
        <div class="info-row">
            <span class="label">Application Date:</span>
            <span class="value">{{ $application->created_at->format('F j, Y \a\t g:i A') }}</span>
        </div>
    </div>
    
    <div class="footer">
        <p>This is an automated notification from RosaCare website.</p>
        <p>Please review the application and CV attachment.</p>
    </div>
</body>
</html>

