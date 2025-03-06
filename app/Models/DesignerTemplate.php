<?php
namespace App\Models;

use App\Enums\TemplateLanguage;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class DesignerTemplate extends Model
{
    use HasFactory, Uuid;

    protected $guarded = [];

    protected $casts = [
        // 'language' => TemplateLanguage::class,
    ];

    /**
     * Get the template's badge.
     */
    protected function badge(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['language'] === TemplateLanguage::ENGLISH->value ? "bg-primary/10 text-primary dark:bg-accent-light/15 dark:text-accent-light" : "bg-secondary/10 text-secondary dark:bg-secondary-light/15 dark:text-secondary-light"
        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function booklets(): HasMany
    {
        return $this->hasMany(Booklet::class);
    }
}