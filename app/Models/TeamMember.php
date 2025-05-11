<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TeamMember extends Model
{
    /** @use HasFactory<\Database\Factories\TeamMemberFactory> */
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('team_members');  // Clear cache on save/update
        });

        static::deleted(function () {
            Cache::forget('team_members');  // Clear cache on delete
        });
    }
}
