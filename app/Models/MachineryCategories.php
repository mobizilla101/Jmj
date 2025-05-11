<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MachineryCategories extends Model
{
    /** @use HasFactory<\Database\Factories\MachineryCategoriesFactory> */
    use HasFactory;
    protected $guarded = [];

    public function machinery()
    {
        return $this->hasMany(Machinery::class, 'machinery_category_id');
    }

    public function machineryWorkingNature(): BelongsToMany
    {
        return $this->belongsToMany(MachineryWorkingNature::class, 'mc_machinery_category', 'mc_category_id', 'mc_working_natures_id');
    }

    public function subCategories()
    {
        return $this->hasMany(MachinerySubCategory::class, 'machinery_category_id');
    }
}
