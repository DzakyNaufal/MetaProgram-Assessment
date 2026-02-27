<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        try {
            // Create the contact message
            $contactMessage = \App\Models\ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
            ]);

            // Send notification email to admin
            Log::info('Attempting to send email to wilberttgr@gmail.com', [
                'to' => 'wilberttgr@gmail.com',
                'from_config' => config('mail.from.address'),
                'mailer' => config('mail.default')
            ]);
            Mail::to('wilberttgr@gmail.com')->send(new \App\Mail\ContactNotification($contactMessage));
            Log::info('Email sent successfully to wilberttgr@gmail.com');

            return redirect()->back()->with('success', 'Pesan terkirim!');
        } catch (\Exception $e) {
            Log::error('Failed to send email: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengirim pesan: ' . $e->getMessage());
        }
    }
}
