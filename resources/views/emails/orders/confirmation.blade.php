<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.order_confirmation') }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Poppins', Arial, sans-serif; background-color: #f5f5f5;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f5f5f5;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 600px; width: 100%; border-collapse: collapse; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header with Logo -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #80593c, #5d4037); padding: 40px 30px; text-align: center;">
                            <img src="{{ url('images/logo.png') }}" alt="{{ __('messages.business_name') }}" style="max-height: 60px; width: auto; margin-bottom: 20px;" onerror="this.style.display='none';">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700;">{{ __('messages.business_name') }}</h1>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h2 style="margin: 0 0 20px 0; color: #1f2937; font-size: 24px; font-weight: 700;">{{ __('messages.thank_you_for_order') }}</h2>
                            <p style="margin: 0 0 20px 0; color: #4b5563; font-size: 16px; line-height: 1.6;">{{ __('messages.order_confirmation_email_intro') }}</p>

                            <!-- Order Details Box -->
                            <div style="background-color: #f9fafb; border-radius: 8px; padding: 20px; margin: 30px 0; border-left: 4px solid #80593c;">
                                <h3 style="margin: 0 0 15px 0; color: #1f2937; font-size: 18px; font-weight: 600;">{{ __('messages.order_details') }}</h3>
                                <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">{{ __('messages.order_number') }}:</td>
                                        <td style="padding: 8px 0; text-align: right; color: #1f2937; font-size: 14px; font-weight: 600;">{{ $order->order_number }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">{{ __('messages.order_date') }}:</td>
                                        <td style="padding: 8px 0; text-align: right; color: #1f2937; font-size: 14px; font-weight: 600;">{{ $order->created_at->format('F d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">{{ __('messages.total_amount') }}:</td>
                                        <td style="padding: 8px 0; text-align: right; color: #80593c; font-size: 16px; font-weight: 700;">${{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Order Items -->
                            <h3 style="margin: 30px 0 15px 0; color: #1f2937; font-size: 18px; font-weight: 600;">{{ __('messages.order_items') }}</h3>
                            @foreach($order->items as $item)
                            <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 15px; margin-bottom: 15px; background-color: #ffffff;">
                                <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="width: 80px; padding-right: 15px; vertical-align: top;">
                                            <img src="{{ $item->product && $item->product->main_image ? url('storage/' . $item->product->main_image) : url('images/placeholder.png') }}" alt="{{ $item->product_name }}" style="width: 80px; height: 100px; object-fit: cover; border-radius: 6px;">
                                        </td>
                                        <td style="vertical-align: top;">
                                            <h4 style="margin: 0 0 8px 0; color: #1f2937; font-size: 16px; font-weight: 600;">{{ $item->product_name }}</h4>
                                            @if($item->color)
                                            <p style="margin: 4px 0; color: #6b7280; font-size: 14px;">{{ __('messages.color') }}: {{ $item->color }}</p>
                                            @endif
                                            @if($item->size)
                                            <p style="margin: 4px 0; color: #6b7280; font-size: 14px;">{{ __('messages.size') }}: {{ $item->size }}</p>
                                            @endif
                                            <p style="margin: 4px 0; color: #6b7280; font-size: 14px;">{{ __('messages.quantity') }}: {{ $item->quantity }}</p>
                                            <p style="margin: 8px 0 0 0; color: #80593c; font-size: 16px; font-weight: 700;">${{ number_format($item->total_price, 2) }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            @endforeach

                            <!-- Tracking Information -->
                            <div style="background: linear-gradient(135deg, #fef3c7, #fde68a); border-radius: 8px; padding: 20px; margin: 30px 0; border-left: 4px solid #f59e0b;">
                                <h3 style="margin: 0 0 10px 0; color: #92400e; font-size: 18px; font-weight: 600;">
                                    <i class="fas fa-truck" style="margin-right: 8px;"></i>{{ __('messages.tracking_information') }}
                                </h3>
                                <p style="margin: 0; color: #78350f; font-size: 15px; line-height: 1.6;">{{ __('messages.tracking_info_message') }}</p>
                            </div>

                            <!-- Next Steps -->
                            <div style="background-color: #eff6ff; border-radius: 8px; padding: 20px; margin: 30px 0; border-left: 4px solid #3b82f6;">
                                <h3 style="margin: 0 0 15px 0; color: #1e40af; font-size: 18px; font-weight: 600;">{{ __('messages.what_happens_next') }}</h3>
                                <ul style="margin: 0; padding-left: 20px; color: #1e3a8a; font-size: 15px; line-height: 1.8;">
                                    <li>{{ __('messages.order_next_step_1') }}</li>
                                    <li>{{ __('messages.order_next_step_2') }}</li>
                                    <li>{{ __('messages.order_next_step_3') }}</li>
                                </ul>
                            </div>

                            <!-- CTA Button -->
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="{{ route('orders.thank-you', $order->access_token) }}" style="display: inline-block; background: linear-gradient(135deg, #80593c, #5d4037); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: 600; font-size: 16px;">{{ __('messages.view_order_details') }}</a>
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

