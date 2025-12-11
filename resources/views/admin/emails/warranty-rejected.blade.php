<!-- filepath: resources/views/emails/warranty-rejected.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warranty Registration Rejected</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="color: white; margin: 0;">Warranty Registration Status</h1>
    </div>
    
    <div style="background: #ffffff; padding: 30px; border: 1px solid #e0e0e0; border-top: none;">
        <p style="font-size: 16px;">Dear <strong>{{ $registration->customer_name }}</strong>,</p>
        
        <p style="font-size: 16px;">We regret to inform you that your warranty registration has been rejected after review.</p>
        
        <div style="background: #fef2f2; border-left: 4px solid #dc2626; padding: 15px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #991b1b;">Registration Details</h3>
            <table style="width: 100%; font-size: 14px;">
                <tr>
                    <td style="padding: 5px 0;"><strong>Serial Number:</strong></td>
                    <td style="padding: 5px 0;">{{ $registration->serial_number }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;"><strong>Product:</strong></td>
                    <td style="padding: 5px 0;">{{ $registration->product->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;"><strong>Part Number:</strong></td>
                    <td style="padding: 5px 0;">{{ $registration->product->part_number }}</td>
                </tr>
            </table>
        </div>
        
        <div style="background: #fff7ed; border-left: 4px solid #f59e0b; padding: 15px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #92400e;">Reason for Rejection</h3>
            <p style="margin: 0; font-size: 14px;">{{ $registration->rejection_reason }}</p>
        </div>
        
        <h3 style="color: #1f2937;">What can you do next?</h3>
        <ul style="font-size: 14px; line-height: 1.8;">
            <li>Review the rejection reason carefully</li>
            <li>Ensure your serial number matches your product</li>
            <li>Upload a clear and valid invoice</li>
            <li>Submit a new registration with correct information</li>
        </ul>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('warranty.register') }}" style="background: #2563eb; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;">
                Submit New Registration
            </a>
        </div>
        
        <div style="background: #eff6ff; border-left: 4px solid #3b82f6; padding: 15px; margin: 20px 0;">
            <p style="margin: 0; font-size: 14px;"><strong>Need Help?</strong> If you believe this rejection was made in error or need assistance, please contact our support team.</p>
        </div>
        
        <p style="font-size: 14px;">We apologize for any inconvenience and look forward to resolving this matter.</p>
        
        <p style="font-size: 14px;">Best regards,<br><strong>iTech Warranty Team</strong></p>
    </div>
    
    <div style="background: #f3f4f6; padding: 20px; text-align: center; border-radius: 0 0 10px 10px; font-size: 12px; color: #6b7280;">
        <p style="margin: 0;">© {{ date('Y') }} iTech. All rights reserved.</p>
        <p style="margin: 5px 0;">This is an automated email, please do not reply.</p>
    </div>
</body>
</html>