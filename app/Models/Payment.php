<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'bank_account_id',
        'proof_image',
        'status',
        'admin_note',
        'verified_by',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function getProofImageUrlAttribute(): string
    {
        if ($this->proof_image && file_exists(public_path($this->proof_image))) {
            return asset($this->proof_image);
        }
        if ($this->proof_image && file_exists(public_path('uploads/' . $this->proof_image))) {
            return asset('uploads/' . $this->proof_image);
        }
        if ($this->proof_image && file_exists(public_path('storage/' . $this->proof_image))) {
            return asset('storage/' . $this->proof_image);
        }
        return asset('template/images/card-item2.jpg');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Verifikasi',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => ucfirst($this->status),
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'badge-warning',
            'approved' => 'badge-success',
            'rejected' => 'badge-danger',
            default => 'badge-secondary',
        };
    }
}
