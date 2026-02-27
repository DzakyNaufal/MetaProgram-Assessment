<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{

    // Contact Messages CRUD
    public function contactsIndex()
    {
        $contacts = \App\Models\ContactMessage::all();
        return view('admin.contacts.index', compact('contacts'));
    }

    public function contactsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        try {
            \App\Models\ContactMessage::create($request->all());
            return redirect()->route('admin.contacts.index')->with('success', 'Contact message dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function contactsShow(\App\Models\ContactMessage $contactMessage)
    {
        return view('admin.contacts.show', compact('contactMessage'));
    }

    public function contactsDestroy(\App\Models\ContactMessage $contactMessage)
    {
        try {
            $contactMessage->delete();
            return redirect()->route('admin.contacts.index')->with('success', 'Contact message dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.contacts.index')->with('error', $e->getMessage());
        }
    }


    // Admin Profile
    public function profile()
    {
        $admin = request()->user();
        return view('admin.profile', compact('admin'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
        ]);

        $admin = $request->user();
        $admin->fill($request->validated());

        if ($admin->isDirty('email')) {
            $admin->email_verified_at = null;
        }

        $admin->save();

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }
}
