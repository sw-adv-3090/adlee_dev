<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BankAccount extends Model
{
    use HasFactory, Uuid;

    protected $fillable = ['user_id', 'sponsor_id', 'setup_intent_id', 'last4', 'bank_name', 'verified_at', 'status', 'payment_method_id', 'failure_reason', 'active'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Get the user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the sponsor.
     */
    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }
}
