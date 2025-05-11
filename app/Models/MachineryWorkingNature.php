<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MachineryWorkingNature extends Model
{
    /** @use HasFactory<\Database\Factories\MachineryWorkingNatureFactory> */
    use HasFactory;
    protected $guarded = [];

    public function machinery()
    {
        return $this->hasMany(Machinery::class, 'machinery_working_nature_id');
    }

    public function machineryBrands(): BelongsToMany
    {
        return $this->belongsToMany(MachineryBrand::class, 'mw_nature_brand', 'mw_nature_id', 'mw_brand_id');
    }

    public function machineryCategories(): BelongsToMany
    {
        return $this->belongsToMany(MachineryCategories::class, 'mc_machinery_category', 'mc_working_natures_id', 'mc_category_id');
    }

    public function machinery_category(){
        return $this->hasMany(MachineryCategories::class, 'machinery_category_id');
    }
}
