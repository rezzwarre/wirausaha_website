<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    public function edit()
    {
        $setting = CompanySetting::getSettings();
        return view('admin.company_setting.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|max:30',
            'whatsapp_number' => 'required|string|max:30',
            'company_name' => 'required|string|max:150',
            'email' => 'nullable|email|max:150',
            'address' => 'nullable|string|max:500',
        ]);

        $setting = CompanySetting::getSettings();
        $setting->update($validated);

        return back()->with('success', 'Nomor telepon dan informasi perusahaan berhasil diperbarui. Seluruh kontak dan tombol WhatsApp di website otomatis terupdate!');
    }
}
