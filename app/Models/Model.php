<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Model extends Eloquent
{
    /** @use HasFactory<\Database\Factories\ModelFactory> */
    use HasFactory;

    protected $guarded =[];
    protected $casts =[
      'attachments'  => 'array',
//        'network_specifications'=> 'array',
//        'body_specifications'=> 'array',
//        'display_specifications'=> 'array',
//        'platform_specifications'=> 'array',
//        'memory_specifications'=> 'array',
//        'main_camera_specifications'=> 'array',
//        'selfie_camera_specifications'=> 'array',
//        'sound_specifications'=> 'array',
//        'communication_specifications'=> 'array',
//        'feature_specifications'=> 'array',
//        'battery_specifications'=> 'array',
//        'test_results_specifications'=> 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Str::slug(strtolower($model->model_no));
        });
    }

    public function published()
    {
        return $this->where('published',true);
    }

    public function brand(): BelongsTo{
        return $this->belongsTo(Brand::class);
    }
    public function skus(){
        return $this->hasMany(Sku::class);
    }

    public function getConfiguration(){
        return $this->skus()
            ->orderBy('price', 'asc')
            ->first();
    }

    public function parts()
    {
        return $this->hasMany(Parts::class);
    }
}
