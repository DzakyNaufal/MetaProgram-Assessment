<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function __construct()
    {
        // Middleware already handled in routes/web.php
    }

    public function index()
    {
        $bankAccounts = BankAccount::orderBy('created_at', 'desc')->get();
        return view('admin.bank-accounts.index', compact('bankAccounts'));
    }

    public function create()
    {
        return view('admin.bank-accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_holder' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        BankAccount::create($request->all());

        return redirect()->route('admin.bank-accounts.index')->with('success', 'Bank account created successfully.');
    }

    public function edit(BankAccount $bankAccount)
    {
        return view('admin.bank-accounts.edit', compact('bankAccount'));
    }

    public function update(Request $request, BankAccount $bankAccount)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_holder' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $bankAccount->update($request->all());

        return redirect()->route('admin.bank-accounts.index')->with('success', 'Bank account updated successfully.');
    }

    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();

        return redirect()->route('admin.bank-accounts.index')->with('success', 'Bank account deleted successfully.');
    }
}
