<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdSpaceOwner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'company_name', 'company_phone', 'company_logo', 'ein_number', 'ein_number_verified_at', 'ein_number_verify_tries', 'ein_number_verify_last_try', 'country', 'business_type'];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'ein_number_verified_at' => 'datetime',
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
}
