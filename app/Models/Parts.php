<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parts extends Model
{
    /** @use HasFactory<\Database\Factories\PartsFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
      'attachments' => 'array',
    ];

    public function partsCategory(){
        return $this->belongsTo(PartsCategory::class);
    }

    public function model(){
        return $this->belongsTo(\App\Models\Model::class);
    }
}
