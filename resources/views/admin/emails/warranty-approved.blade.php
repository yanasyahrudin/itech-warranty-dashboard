<!-- filepath: resources/views/emails/warranty-approved.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warranty Approved</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="color: white; margin: 0;">✓ Warranty Approved</h1>
    </div>
    
    <div style="background: #ffffff; padding: 30px; border: 1px solid #e0e0e0; border-top: none;">
        <p style="font-size: 16px;">Dear <strong>{{ $registration->customer_name }}</strong>,</p>
        
        <p style="font-size: 16px;">Great news! Your warranty registration has been approved.</p>
        
        <div style="background: #f0fdf4; border-left: 4px solid #22c55e; padding: 15px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #15803d;">Warranty Details</h3>
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
                <tr>
                    <td style="padding: 5px 0;"><strong>Warranty Period:</strong></td>
                    <td style="padding: 5px 0;">{{ $registration->product->warranty_period_months }} months</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;"><strong>Start Date:</strong></td>
                    <td style="padding: 5px 0;">{{ $registration->warranty_start_date->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;"><strong>End Date:</strong></td>
                    <td style="padding: 5px 0;">{{ $registration->warranty_end_date->format('d M Y') }}</td>
                </tr>
            </table>
        </div>
        
        <p style="font-size: 14px;">Your warranty is now active and will remain valid until <strong>{{ $registration->warranty_end_date->format('d F Y') }}</strong>.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('warranty.check') }}" style="background: #667eea; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;">
                View Warranty Status
            </a>
        </div>
        
        <div style="background: #eff6ff; border-left: 4px solid #3b82f6; padding: 15px; margin: 20px 0;">
            <p style="margin: 0; font-size: 14px;"><strong>Important:</strong> Please keep your serial number safe. You will need it to check your warranty status or make a claim.</p>
        </div>
        
        <p style="font-size: 14px;">If you have any questions, please don't hesitate to contact our support team.</p>
        
        <p style="font-size: 14px;">Best regards,<br><strong>iTech Warranty Team</strong></p>
    </div>
    
    <div style="background: #f3f4f6; padding: 20px; text-align: center; border-radius: 0 0 10px 10px; font-size: 12px; color: #6b7280;">
        <p style="margin: 0;">© {{ date('Y') }} iTech. All rights reserved.</p>
        <p style="margin: 5px 0;">This is an automated email, please do not reply.</p>
    </div>
</body>
</html>