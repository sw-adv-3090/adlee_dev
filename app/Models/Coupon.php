<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Coupon extends Model
{
    use HasFactory, Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uuid', 'user_id', 'sponsor_id', 'template_id', 'title', 'language', 'number', 'payout_deadline', 'shorten_url_activate', 'shorten_url_redeem', 'payout_on', 'activated_at', 'redeemed_at', 'payout_at', 'amount', 'redeemed_by', 'booklet_id', 'failed_tries'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'payout_on' => 'date',
            'activated_at' => 'datetime',
            'redeemed_at' => 'datetime',
            'payout_at' => 'datetime',
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
     * Get the template.
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(DesignerTemplate::class);
    }

    /**
     * Get the bookelt.
     */
    public function booklet(): BelongsTo
    {
        return $this->belongsTo(Booklet::class);
    }

    /**
     * Get the redeem bbo of coupon.
     */
    public function redeem(): HasOne
    {
        return $this->hasOne(User::class, 'email', 'redeemed_by');
    }

    /**
     * Get the transactions of coupon.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the redeem ad space owner of coupon.
     */
    public function adSpaceOwner(): HasOneThrough
    {
        return $this->hasOneThrough(AdSpaceOwner::class, User::class, 'email', 'user_id', 'redeemed_by');
    }

    /**
     * Get the task of coupon.
     */
    public function task(): HasOne
    {
        return $this->hasOne(Task::class);
    }
}
