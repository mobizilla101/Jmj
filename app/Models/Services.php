<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    /** @use HasFactory<\Database\Factories\ServicesFactory> */
    use HasFactory;
    protected $fillable = [
        'icon',
        'title',
        'description',
        'sort'
    ];


    protected static function boot(){
        parent::boot();

        static::created(function($data){
            $data['sort'] = $data['id'];

            $data->save();
        });

    }


}
