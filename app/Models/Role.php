<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function permissions():belongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
