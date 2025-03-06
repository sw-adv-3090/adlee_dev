<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Subscription;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Laravel\Cashier\Billable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'role_id',
        'google_id',
        'facebook_id',
        'twitter_id',
        'two_factor_code',
        'two_factor_expires_at',
        'profile_photo_url',
        'stripe_account_id',
        'stripe_payment_method_id',
        'completed_onboarding',
        'stripe_id',
        'pm_type',
        'pm_last_four',
        'tapfiliate_id',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'two_factor_code',
        'two_factor_expires_at'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'avatar'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'two_factor_expires_at' => 'datetime',
            'password' => 'hashed',
            'completed_onboarding' => 'boolean',
        ];
    }

    /**
     * Get the user's avatar.
     */
    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['profile_photo_url'] ? asset($attributes['profile_photo_url']) : asset('images/100x100.png'),
        );
    }

    /**
     * Get the user's role is admin or not.
     */
    public function isAdmin(): bool
    {
        return $this->role_id == UserRole::Admin->value;
    }

    /**
     * Get the user's role is sponsor or not.
     */
    public function isSponsor(): bool
    {
        return $this->role_id == UserRole::Sponsor->value;
    }

    /**
     * Get the user's role.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }


    /**
     * Generate and save 2fa code
     */
    public function generateTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(10);
        $this->save();
    }

    /**
     * Reset 2fa code
     */
    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    /**
     * get the sponsor
     */
    public function sponsor(): HasOne
    {
        return $this->hasOne(Sponsor::class);
    }

    /**
     * get the ad space owner
     */
    public function adSpaceOwner(): HasOne
    {
        return $this->hasOne(AdSpaceOwner::class);
    }

    /**
     * get the sponsor's templates
     */
    public function templates(): HasMany
    {
        return $this->hasMany(SponsorTemplate::class);
    }

    /**
     * get the sponsor's designer templates
     */
    public function designerTemplates()
    {
        return $this->hasMany(DesignerTemplate::class,'created_by', 'id');
    }
    /**
     * get the user's coupons
     */
    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    /**
     * get the coupons redeemed by BBO
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Coupon::class, 'redeemed_by', 'email');
    }

    /**
     * get the user's booklets
     */
    public function booklets(): HasMany
    {
        return $this->hasMany(Booklet::class);
    }

    /**
     * get the sponsor's tasks
     */
    public function sponsorTasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
    /**
     * get the bbo's tasks
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assign_to');
    }

    /**
     * Get the prints of booklet.
     */
    public function prints(): HasMany
    {
        return $this->hasMany(BookletPrint::class);
    }

    /**
     * Get the payments of user.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the transactions of sponsor.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'sender_id');
    }

    /**
     * Get the transactions of bbo.
     */
    public function bboTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'receiver_id');
    }

    /**
     * get the user's active subcription plan
     */
    public function plan()
    {
        $stripePriceId = $this->subscription()?->stripe_price;
        if (!$stripePriceId) {
            $stripePriceId = Subscription::where('user_id', $this->id)->latest()->first()?->stripe_price;
        }

        return Plan::where('stripe_price_id', $stripePriceId)->first();
    }

    /**
     * get the user's subcription plan throigh relation
     */
    public function userPlan(): HasOneThrough
    {
        return $this->hasOneThrough(Plan::class, Subscription::class, 'user_id', 'stripe_price_id', 'id', 'stripe_price');
    }
}
