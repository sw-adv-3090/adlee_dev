<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'sponsor_id', 'receiver_id', 'payment_intent_id', 'amount', 'description', 'status', 'type', 'ad_space_owner_id', 'stripe_price'];

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

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value / 100,
            set: fn($value) => $value * 100,
        );
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

    /**
     * Get the adSpaceOwner.
     */
    public function adSpaceOwner(): BelongsTo
    {
        return $this->belongsTo(AdSpaceOwner::class);
    }

    /**
     * Get the plan.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'stripe_price', 'stripe_price_id');
    }
}
