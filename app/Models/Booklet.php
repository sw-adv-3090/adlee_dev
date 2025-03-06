<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booklet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'sponsor_id', 'template_id', 'title', 'language', 'number', 'payout_deadline', 'amount'];

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
     * Get the template.
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(DesignerTemplate::class);
    }

    /**
     * Get the coupons of booklet.
     */
    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    /**
     * Get the activated coupons of booklet.
     */
    public function activated(): HasMany
    {
        return $this->coupons()->whereNotNull('activated_at');
    }

    /**
     * Get the paid coupons of booklet.
     */
    public function paids(): HasMany
    {
        return $this->coupons()->whereNotNull('payout_at');
    }

    /**
     * Get the redeemed coupons of booklet.
     */
    public function redeemeds(): HasMany
    {
        return $this->coupons()->whereNotNull('redeemed_at');
    }

    /**
     * Get the allocated to BBO coupons of booklet.
     */
    public function allocated(): HasMany
    {
        return $this->coupons()->whereNotNull('redeemed_by');
    }

    /**
     * Get the prints of booklet.
     */
    public function prints(): HasMany
    {
        return $this->hasMany(BookletPrint::class);
    }

    /**
     * Get the print of booklet.
     */
    public function print(): HasOne
    {
        return $this->hasOne(BookletPrint::class);
    }

    /**
     * Get the prints of booklet.
     */
    public function shipments(): HasManyThrough
    {
        return $this->hasManyThrough(Shipment::class, BookletPrint::class);
    }
}
