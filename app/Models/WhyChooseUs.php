<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyChooseUs extends Model
{
    protected $table = "why_choose_us";

    protected $fillable = [
        'title',
        'description',
        'sort',
        'image'
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function($models){
            if(static::count() >= 4){
                return false;
            }
        });

        static::created(function($model){
            $model->sort = $model->id;
            $model->save();
        });
    }
}
