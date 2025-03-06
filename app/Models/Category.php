<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];


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

    /**
     * Get the subcategories of category.
     */
    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }

    /**
     * Get the templates of category.
     */
    public function templates(): HasMany
    {
        return $this->hasMany(Template::class);
    }

    public function designerTemplates()
    {
        return $this->hasMany(DesignerTemplate::class);
    }
}
