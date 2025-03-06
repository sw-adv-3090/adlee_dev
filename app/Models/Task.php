<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'sponsor_id', 'coupon_id', 'template_id', 'assign_to', 'is_commemoration', 'language', 'purpose', 'purpose_eng' , 'purpose_heb' ,  'english_name', 'hebrew_name', 'status', 'document_id', 'signed_at', 'printed_at', "english_title", "hebrew_title"];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_commemoration' => 'boolean',
            'signed_at' => 'datetime',
            'created_at' => 'datetime',
            'printed_at' => 'datetime',
        ];
    }

    /**
     * Get the task's user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the task's sponsor.
     */
    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }

    /**
     * Get the task's coupon.
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get the task's template.
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(DesignerTemplate::class);
    }

    /**
     * Get the task's assign.
     */
    public function assign(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assign_to');
    }

    /**
     * Get the task's assign.
     */
    public function company()
    {
        return $this->hasOneThrough(AdSpaceOwner::class, User::class, 'id', 'user_id', 'assign_to', 'id');
    }

    /**
     * Get the task's transactions.
     */
    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, Coupon::class, 'id', 'coupon_id', 'coupon_id', 'id');
    }
}
