<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'phone',
        'whatsapp_number',
        'email',
        'address',
    ];

    public static function getSettings(): self
    {
        return static::firstOrCreate([], [
            'company_name' => 'Wirausahagoo Official',
            'phone' => '0812-3456-7890',
            'whatsapp_number' => '081234567890',
            'email' => 'admin@wirausahagoo.com',
            'address' => 'Gedung Pusat Kegiatan Mahasiswa (PKM) Lt. 2, Kampus Terpadu',
        ]);
    }

    public function getCleanWhatsappAttribute(): string
    {
        $num = preg_replace('/[^0-9]/', '', $this->whatsapp_number ?: $this->phone);
        if (str_starts_with($num, '0')) {
            $num = '62' . substr($num, 1);
        }
        return $num;
    }
}
