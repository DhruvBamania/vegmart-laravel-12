<!DOCTYPE html>
<html>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: sans-serif;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table width="600" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #ddd;">
                    <tr style="background-color: #dc3545; text-align: center;">
                        <td style="padding: 20px;">
                            <h1 style="color: #ffffff; margin: 0;">Order Cancelled</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px;">
                            <p>Hi {{ $order->first_name }},</p>
                            <p>Your order <strong>#{{ $order->order_number }}</strong> has been successfully cancelled as per your request.</p>
                            
                            <div style="background-color: #f8f9fa; padding: 15px; border-left: 4px solid #dc3545; margin: 20px 0;">
                                <strong>Refund Information:</strong><br>
                                @if($order->payment_method == 'Razorpay')
                                    Since you paid online, your refund will be processed back to your original payment method within 5-7 business days.
                                @else
                                    As this was a Cash on Delivery order, no further action is required.
                                @endif
                            </div>

                            <p>If you didn't request this cancellation, please contact our support team immediately.</p>
                            
                            <div style="text-align: center; margin-top: 30px;">
                                <a href="{{ url('/shop') }}" style="background-color: #81c408; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">Order Again</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>