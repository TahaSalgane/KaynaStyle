<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.contact_response') }}</title>
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
                            <h2 style="margin: 0 0 20px 0; color: #1f2937; font-size: 24px; font-weight: 700;">{{ __('messages.contact_response_title') }}</h2>
                            <p style="margin: 0 0 20px 0; color: #4b5563; font-size: 16px; line-height: 1.6;">{{ __('messages.contact_response_intro', ['name' => $contactMessage->name]) }}</p>

                            <!-- Original Message Reference -->
                            <div style="background-color: #f9fafb; border-radius: 8px; padding: 20px; margin: 30px 0; border-left: 4px solid #80593c;">
                                <h3 style="margin: 0 0 15px 0; color: #1f2937; font-size: 18px; font-weight: 600;">{{ __('messages.your_original_message') }}</h3>
                                <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">{{ __('messages.subject') }}:</td>
                                        <td style="padding: 8px 0; text-align: right; color: #1f2937; font-size: 14px; font-weight: 600;">{{ $contactMessage->subject }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="padding: 12px 0 0 0; color: #4b5563; font-size: 14px; line-height: 1.6; border-top: 1px solid #e5e7eb; margin-top: 12px;">
                                            {{ $contactMessage->message }}
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Admin Response -->
                            <div style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); border-radius: 8px; padding: 25px; margin: 30px 0; border-left: 4px solid #3b82f6;">
                                <h3 style="margin: 0 0 15px 0; color: #1e40af; font-size: 20px; font-weight: 600;">
                                    <i class="fas fa-reply" style="margin-right: 8px;"></i>{{ __('messages.our_response') }}
                                </h3>
                                <div style="background-color: #ffffff; border-radius: 6px; padding: 20px; margin-bottom: 15px;">
                                    <p style="margin: 0; color: #1f2937; font-size: 15px; line-height: 1.8; white-space: pre-wrap;">{{ $contactMessage->admin_response }}</p>
                                </div>
                            </div>

                            <!-- Additional Help -->
                            <div style="background-color: #fef3c7; border-radius: 8px; padding: 20px; margin: 30px 0; border-left: 4px solid #f59e0b;">
                                <h3 style="margin: 0 0 10px 0; color: #92400e; font-size: 18px; font-weight: 600;">{{ __('messages.need_more_help') }}</h3>
                                <p style="margin: 0; color: #78350f; font-size: 15px; line-height: 1.6;">{{ __('messages.contact_us_again_message') }}</p>
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

