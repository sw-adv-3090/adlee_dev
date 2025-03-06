<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'name', 'price', 'ach_transaction_fee', 'credit_card_transaction_fee', 'transaction_service_fee', 'booklet_fee', 'free_booklets', 'booklet_pages', 'stripe_price_id', 'stripe_product_id', 'specifications', 'status', 'template_limit'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'specifications' => 'array',
            'status' => 'boolean',
        ];
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value / 100,
            set: fn($value) => $value * 100,
        );
    }

    protected function achTransactionFee(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value / 100,
            set: fn($value) => $value * 100,
        );
    }

    protected function creditCardTransactionFee(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value / 100,
            set: fn($value) => $value * 100,
        );
    }

    protected function transactionServiceFee(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value / 100,
            set: fn($value) => $value * 100,
        );
    }

    protected function bookletFee(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value / 100,
            set: fn($value) => $value * 100,
        );
    }


    /**
     * Get the plan's badge.
     */
    protected function badge(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['type'] === UserType::SPONSOR->value ? "bg-primary/10 text-primary dark:bg-accent-light/15 dark:text-accent-light" : "bg-secondary/10 text-secondary dark:bg-secondary-light/15 dark:text-secondary-light"
        );
    }

    public function isOnBasicPlan(): bool
    {
        return $this->name === "Sponsor Basic";
    }

}
