<?php

namespace App\Models;

use App\Enums\TemplateLanguage;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Template extends Model
{
    use HasFactory, Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uuid', 'type', 'title', 'styling', 'content', 'active', 'publish_at', 'view', 'preview', 'language', 'category_id', 'sub_category_id'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'publish_at' => 'datetime',
        ];
    }

    /**
     * Get the template's badge.
     */
    protected function badge(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['language'] === TemplateLanguage::ENGLISH->value ? "bg-primary/10 text-primary dark:bg-accent-light/15 dark:text-accent-light" : "bg-secondary/10 text-secondary dark:bg-secondary-light/15 dark:text-secondary-light"
        );
    }

    /**
     * Get the template's user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the template.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the subcategory that owns the template.
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * Get the all booklets template userd for.
     */
    public function booklets(): HasMany
    {
        return $this->hasMany(Booklet::class);
    }
}
