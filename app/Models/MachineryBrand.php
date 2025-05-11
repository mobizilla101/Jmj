<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MachineryBrand extends Model
{
    /** @use HasFactory<\Database\Factories\MachineryBrandFactory> */
    use HasFactory;

    protected $fillable = ['name','logo'];

    public function machinery()
    {
        return $this->hasMany(Machinery::class, 'machinery_brand_id');
    }

    public function workingNatures(): BelongsToMany
    {
        return $this->belongsToMany(MachineryWorkingNature::class, 'mw_nature_brand', 'mw_brand_id', 'mw_nature_id');
    }

}
