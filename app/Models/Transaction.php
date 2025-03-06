<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Transaction extends Model
{
    use HasFactory, Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uuid', 'sender_id', 'receiver_id', 'sponsor_id', 'coupon_id', 'amount', 'paid_amount', 'receiver_amount', 'transaction_fee', 'service_fee', 'payment_intent_id', 'transfer_id', 'description', 'status', 'number', 'transaction_fee_percentage', 'service_fee_percentage', 'commission_paid', 'type'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    /**
     * Get the sender.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    /**
     * Get the receiver.
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }

    /**
     * Get the sponsor.
     */
    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }

    /**
     * Get the receiver company.
     */
    public function company(): HasOneThrough
    {
        return $this->hasOneThrough(AdSpaceOwner::class, User::class, 'id', 'user_id', 'receiver_id', 'id');
    }

    /**
     * Get the coupon.
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }
}
