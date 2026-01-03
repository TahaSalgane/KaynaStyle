<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.order_shipped') }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Poppins', Arial, sans-serif; background-color: #f5f5f5;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f5f5f5;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 600px; width: 100%; border-collapse: collapse; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header with Logo -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #a67c5a, #7a5745); padding: 40px 30px; text-align: center;">
                            <img src="{{ url('images/logo.png') }}" alt="{{ __('messages.business_name') }}" style="max-height: 60px; width: auto; margin-bottom: 20px;" onerror="this.style.display='none';">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700;">{{ __('messages.business_name') }}</h1>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h2 style="margin: 0 0 20px 0; color: #1f2937; font-size: 24px; font-weight: 700;">{{ __('messages.order_shipped_title') }}</h2>
                            <p style="margin: 0 0 20px 0; color: #4b5563; font-size: 16px; line-height: 1.6;">{{ __('messages.order_shipped_intro', ['order_number' => $order->order_number]) }}</p>

                            <!-- Order Details Box -->
                            <div style="background-color: #f9fafb; border-radius: 8px; padding: 20px; margin: 30px 0; border-left: 4px solid #a67c5a;">
                                <h3 style="margin: 0 0 15px 0; color: #1f2937; font-size: 18px; font-weight: 600;">{{ __('messages.order_details') }}</h3>
                                <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">{{ __('messages.order_number') }}:</td>
                                        <td style="padding: 8px 0; text-align: right; color: #1f2937; font-size: 14px; font-weight: 600;">{{ $order->order_number }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Tracking Information -->
                            <div style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); border-radius: 8px; padding: 25px; margin: 30px 0; border-left: 4px solid #3b82f6;">
                                <h3 style="margin: 0 0 15px 0; color: #1e40af; font-size: 20px; font-weight: 600;">
                                    <i class="fas fa-truck" style="margin-right: 8px;"></i>{{ __('messages.tracking_information') }}
                                </h3>

                                <div style="background-color: #ffffff; border-radius: 6px; padding: 15px; margin-bottom: 15px;">
                                    <p style="margin: 0 0 8px 0; color: #6b7280; font-size: 14px; font-weight: 500;">{{ __('messages.shipping_carrier') }}</p>
                                    <p style="margin: 0; color: #1f2937; font-size: 18px; font-weight: 700;">{{ strtoupper($order->shipping_carrier) }}</p>
                                </div>

                                <div style="background-color: #ffffff; border-radius: 6px; padding: 15px; margin-bottom: 20px;">
                                    <p style="margin: 0 0 8px 0; color: #6b7280; font-size: 14px; font-weight: 500;">{{ __('messages.tracking_number') }}</p>
                                    <p style="margin: 0; color: #1f2937; font-size: 20px; font-weight: 700; letter-spacing: 1px;">{{ $order->tracking_number }}</p>
                                </div>

                                @php
                                    $trackingUrls = [
                                        'dhl' => 'https://www.dhl.com/en/express/tracking.html?AWB=' . urlencode($order->tracking_number),
                                        'express' => 'https://www.fedex.com/fedextrack/?trknbr=' . urlencode($order->tracking_number),
                                        'fedex' => 'https://www.fedex.com/fedextrack/?trknbr=' . urlencode($order->tracking_number),
                                        'aramex' => 'https://www.aramex.com/track/' . urlencode($order->tracking_number),
                                    ];
                                    $carrierLower = strtolower($order->shipping_carrier);
                                    $trackingUrl = $trackingUrls[$carrierLower] ?? '#';
                                @endphp

                                <a href="{{ $trackingUrl }}" target="_blank" style="display: inline-block; background: linear-gradient(135deg, #3b82f6, #2563eb); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: 600; font-size: 16px; text-align: center; width: 100%; box-sizing: border-box;">
                                    <i class="fas fa-external-link-alt" style="margin-right: 8px;"></i>{{ __('messages.track_shipment') }}
                                </a>
                            </div>

                            <!-- What to Expect -->
                            <div style="background-color: #fef3c7; border-radius: 8px; padding: 20px; margin: 30px 0; border-left: 4px solid #f59e0b;">
                                <h3 style="margin: 0 0 10px 0; color: #92400e; font-size: 18px; font-weight: 600;">{{ __('messages.what_to_expect') }}</h3>
                                <p style="margin: 0; color: #78350f; font-size: 15px; line-height: 1.6;">{{ __('messages.shipping_expectation_message') }}</p>
                            </div>

                            <!-- CTA Button -->
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="{{ route('orders.thank-you', $order->access_token) }}" style="display: inline-block; background: linear-gradient(135deg, #a67c5a, #7a5745); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: 600; font-size: 16px;">{{ __('messages.view_order_details') }}</a>
                            </div>

                            <!-- Footer -->
                            <div style="border-top: 1px solid #e5e7eb; padding-top: 20px; margin-top: 30px; text-align: center;">
                                <p style="margin: 0 0 10px 0; color: #6b7280; font-size: 14px;">{{ __('messages.questions_contact_us') }}</p>
                                <p style="margin: 0; color: #6b7280; font-size: 14px;">
                                    <strong>{{ __('messages.email') }}:</strong> contact@kaynastyle.com<br>
                                    <strong>{{ __('messages.phone') }}:</strong> +1 917 695 2890
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

