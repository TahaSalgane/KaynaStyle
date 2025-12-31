<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactResponse;

class AdminContactController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.contact.index', compact('messages'));
    }

    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);

        // Mark as read if not already read
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.contact.show', compact('message'));
    }

    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.contact.index')
            ->with('success', 'Contact message deleted successfully.');
    }

    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function markAsUnread($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->update(['is_read' => false]);

        return response()->json(['success' => true]);
    }

    public function respond(Request $request, $id)
    {
        $request->validate([
            'admin_response' => 'required|string|max:5000'
        ]);

        $message = ContactMessage::findOrFail($id);
        $message->update([
            'admin_response' => $request->admin_response,
            'responded_at' => now()
        ]);

        // Refresh the message to get updated data
        $message->refresh();

        // Send email notification to customer
        $emailSent = false;
        $emailError = null;

        try {
            // Log attempt
            Log::info('Attempting to send contact response email', [
                'to' => $message->email,
                'subject' => $message->subject,
                'mail_driver' => config('mail.default')
            ]);

            Mail::to($message->email)->send(new ContactResponse($message));
            $emailSent = true;

            Log::info('Contact response email sent successfully', [
                'to' => $message->email
            ]);
        } catch (\Exception $e) {
            // Log email error
            $emailError = $e->getMessage();
            Log::error('Contact response email error: ' . $emailError);
            Log::error('Email details: ' . json_encode([
                'to' => $message->email,
                'subject' => $message->subject,
                'error' => $emailError,
                'trace' => $e->getTraceAsString()
            ]));
        }

        if ($emailSent) {
            return redirect()->route('admin.contact.show', $id)
                ->with('success', 'Response saved and email sent successfully.');
        } else {
            return redirect()->route('admin.contact.show', $id)
                ->with('warning', 'Response saved successfully, but email could not be sent. Please check your mail configuration. Error: ' . ($emailError ?? 'Unknown error'));
        }
    }
}
