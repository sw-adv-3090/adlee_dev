<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorTemplate extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'sponsor_id', 'template_id', 'category_id', 'sub_category_id'];

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
     * Get the category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the subCategory.
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

}
