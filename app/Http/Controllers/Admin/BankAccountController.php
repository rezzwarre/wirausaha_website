<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index()
    {
        $bankAccounts = BankAccount::latest()->paginate(10);
        return view('admin.bank_accounts.index', compact('bankAccounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_name' => 'required|string|max:150',
            'is_active' => 'nullable|boolean',
        ]);

        BankAccount::create([
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'account_name' => $validated['account_name'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.bank-accounts.index')->with('success', 'Rekening bank berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $bank = BankAccount::findOrFail($id);

        $validated = $request->validate([
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_name' => 'required|string|max:150',
            'is_active' => 'nullable|boolean',
        ]);

        $bank->update([
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'account_name' => $validated['account_name'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.bank-accounts.index')->with('success', 'Rekening bank berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $bank = BankAccount::findOrFail($id);
        if ($bank->payments()->exists()) {
            return back()->with('error', 'Rekening bank tidak dapat dihapus karena sudah memiliki riwayat transaksi pembayaran.');
        }

        $bank->delete();
        return redirect()->route('admin.bank-accounts.index')->with('success', 'Rekening bank berhasil dihapus.');
    }
}
