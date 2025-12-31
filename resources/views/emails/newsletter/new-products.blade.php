<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.new_products_available') }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Poppins', Arial, sans-serif; background-color: #f5f5f5;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f5f5f5;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 600px; width: 100%; border-collapse: collapse; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header with Logo -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #80593c, #5d4037); padding: 40px 30px; text-align: center;">
                            <img src="{{ config('app.url') }}/images/logo.png" alt="{{ __('messages.business_name') }}" style="max-height: 60px; width: auto; margin-bottom: 20px;" onerror="this.style.display='none';">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700;">{{ __('messages.business_name') }}</h1>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h2 style="margin: 0 0 20px 0; color: #1f2937; font-size: 24px; font-weight: 700;">{{ __('messages.new_products_available') }}</h2>
                            <p style="margin: 0 0 30px 0; color: #4b5563; font-size: 16px; line-height: 1.6;">{{ __('messages.newsletter_new_products_intro') }}</p>

                            <!-- Products Grid -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                                @foreach($products as $product)
                                <tr>
                                    <td style="padding: 20px; background-color: #f9fafb; border-radius: 8px; margin-bottom: 20px; border: 1px solid #e5e7eb;">
                                        <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="width: 120px; padding-right: 20px; vertical-align: top;">
                                                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" style="width: 100%; max-width: 120px; height: auto; border-radius: 8px; border: 1px solid #e5e7eb; display: block;">
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <h3 style="margin: 0 0 10px 0; color: #1f2937; font-size: 18px; font-weight: 600;">{{ $product['name'] }}</h3>
                                                    <p style="margin: 0 0 15px 0; color: #80593c; font-size: 20px; font-weight: 700;">${{ number_format($product['price'], 2) }}</p>
                                                    <a href="{{ $product['url'] }}" style="display: inline-block; padding: 12px 24px; background: linear-gradient(135deg, #80593c, #5d4037); color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px;">{{ __('messages.view_product') }}</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                @endforeach
                            </table>

                            <!-- CTA Button -->
                            @if(count($products) > 0)
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin-top: 30px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ config('app.url') }}/products" style="display: inline-block; padding: 16px 32px; background: linear-gradient(135deg, #80593c, #5d4037); color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 16px;">{{ __('messages.view_all_products') }}</a>
                                    </td>
                                </tr>
                            </table>
                            @endif
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 10px 0; color: #6b7280; font-size: 14px;">{{ __('messages.business_name_full') }}</p>
                            <p style="margin: 0 0 10px 0; color: #6b7280; font-size: 12px;">{{ __('messages.email') }}: contact@kaynastyle.com</p>
                            <p style="margin: 0; color: #9ca3af; font-size: 12px;">{{ __('messages.newsletter_privacy') }}</p>
                            <p style="margin: 15px 0 0 0;">
                                <a href="{{ config('app.url') }}/newsletter/unsubscribe/{{ urlencode($subscriberEmail ?? '') }}" style="color: #80593c; text-decoration: underline; font-size: 12px;">{{ __('messages.unsubscribe') }}</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
