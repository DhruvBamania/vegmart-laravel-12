<!DOCTYPE html>
<html>
<head>
    <style>
        .status-badge {
            padding: 8px 15px;
            border-radius: 50px;
            color: #ffffff;
            font-weight: bold;
            display: inline-block;
            text-transform: uppercase;
            font-size: 14px;
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    
                    <tr style="background-color: #81c408; text-align: center;">
                        <td style="padding: 30px;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px;">Vegmart - Your One Stop for Groceries</h1>
                            <p style="color: #e0f2f1; margin: 5px 0 0 0;">Fresh & Organic Grocery</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 40px 30px;">
                            <h2 style="color: #333; margin-bottom: 20px;">Order Status Updated</h2>
                            <p style="color: #555; line-height: 1.6;">Hi {{ $order->first_name }},</p>
                            <p style="color: #555; line-height: 1.6;">The status of your order <strong>#{{ $order->order_number }}</strong> has been changed to:</p>

                            <div style="text-align: center; margin: 30px 0;">
                                @php
                                    $color = '#6c757d'; // Default Gray
                                    $icon = '📦';
                                    
                                    if($order->status == 'Confirmed') { $color = '#0dcaf0'; $icon = '✅'; }
                                    elseif($order->status == 'Shipped') { $color = '#0d6efd'; $icon = '🚚'; }
                                    elseif($order->status == 'Delivered') { $color = '#198754'; $icon = '🏁'; }
                                    elseif($order->status == 'Cancelled') { $color = '#dc3545'; $icon = '❌'; }
                                @endphp

                                <span style="background-color: {{ $color }}; padding: 12px 25px; border-radius: 5px; color: white; font-weight: bold; font-size: 20px;">
                                    {{ $icon }} {{ strtoupper($order->status) }}
                                </span>
                            </div>

                            <div style="background-color: #f8f9fa; padding: 20px; border-radius: 5px; color: #444;">
                                @if($order->status == 'Shipped')
                                    <p style="margin: 0;">Great news! Your groceries are on the way. Please keep your phone reachable for the delivery partner.</p>
                                @elseif($order->status == 'Delivered')
                                    <p style="margin: 0;">Your order has been successfully delivered. We hope you enjoy your fresh products!</p>
                                @elseif($order->status == 'Cancelled')
                                    <p style="margin: 0;">Your order has been cancelled. If this was a mistake, please contact our support team immediately.</p>
                                @else
                                    <p style="margin: 0;">We are currently processing your order and will notify you of further updates.</p>
                                @endif
                            </div>

                            <p style="color: #555; line-height: 1.6; margin-top: 30px;">
                                You can view your full order history by logging into your account.
                            </p>
                            
                            <div style="text-align: center; margin-top: 30px;">
                                <a href="{{ url('/profile') }}" style="background-color: #81c408; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">View Order Details</a>
                            </div>
                        </td>
                    </tr>

                    <tr style="background-color: #f1f1f1; text-align: center;">
                        <td style="padding: 20px; font-size: 12px; color: #888;">
                            &copy; {{ date('Y') }} Vegmart Organic Store. Ahmedabad, Gujarat.<br>
                            This is an automated message, please do not reply.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>