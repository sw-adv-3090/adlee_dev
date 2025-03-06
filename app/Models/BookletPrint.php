<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BookletPrint extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'booklet_id', 'amount_paid', 'status', 'type'];

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

    protected function amountPaid(): Attribute
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
     * Get the booklet.
     */
    public function booklet(): BelongsTo
    {
        return $this->belongsTo(Booklet::class);
    }


    /**
     * Get the shipment.
     */
    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }
}
