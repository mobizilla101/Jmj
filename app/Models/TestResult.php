<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $fillable = ['model_id', 'name', 'description'];

    public function model()
    {
        return $this->belongsTo(\App\Models\Model::class);
    }
}
