<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => __('messages.invalid_email'),
            ], 422);
        }

        $email = $request->email;

        // Check if email already exists
        $subscriber = NewsletterSubscriber::where('email', $email)->first();

        if ($subscriber) {
            if ($subscriber->is_active) {
                // Already subscribed - return success anyway (don't reveal email exists)
                return response()->json([
                    'success' => true,
                    'message' => __('messages.newsletter_success'),
                ]);
            } else {
                // Reactivate subscription
                $subscriber->update([
                    'is_active' => true,
                    'subscribed_at' => now(),
                    'unsubscribed_at' => null,
                ]);
            }
        } else {
            // Create new subscription
            NewsletterSubscriber::create([
                'email' => $email,
                'subscribed_at' => now(),
                'is_active' => true,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => __('messages.newsletter_success'),
        ]);
    }

    public function unsubscribe($email)
    {
        $subscriber = NewsletterSubscriber::where('email', $email)->first();

        if ($subscriber) {
            $subscriber->update([
                'is_active' => false,
                'unsubscribed_at' => now(),
            ]);

            return view('newsletter.unsubscribed', compact('email'));
        }

        return view('newsletter.unsubscribed', compact('email'));
    }
}
