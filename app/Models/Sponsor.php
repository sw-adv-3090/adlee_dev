<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sponsor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'company_name', 'company_phone', 'company_logo', 'ein_number', 'ein_number_verified', 'ein_number_verify_tries', 'ein_number_verify_last_try', 'paying_commission', 'default_coupon_payout', 'address', 'postal_code', 'city', 'state', 'country', 'shipping_address', 'shipping_postal_code', 'shipping_city', 'shipping_state', 'shipping_country', 'code', 'last_coupon', 'is_commemoration', 'name_code', 'last_booklet', 'ach_support'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_commemoration' => 'boolean',
            'ach_support' => 'boolean',
            'ein_number_verify_last_try' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Get the sponsor's user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * get the sponsor's templates
     */
    public function templates(): HasMany
    {
        return $this->hasMany(SponsorTemplate::class);
    }
}
