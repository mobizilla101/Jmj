<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enum\UserType;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Laravolt\Avatar\Avatar;

class User extends Authenticatable implements MustVerifyEmail,FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            if(!$user->avatar){
                $user->avatar = $user->generateDefaultProfileImage();
                $user->save();
            }
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'user_type' => UserType::class,
        ];
    }


    public function roles():BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function permissions():BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user_permission');
    }

    public function hasPermission($permission):bool
    {
        // Check if the user is of type 'management', as only management can have permissions
        if ($this->user_type !== UserType::MANAGEMENT && $this->user_type !== UserType::ADMIN) {
            return false; // Regular users have no permissions
        }

        // Check if the user has the permission directly
        if ($this->permissions()->where('name', $permission)->exists()) {
            return true;
        }

        // Check if any of the user's roles has the permission
        return $this->roles()->whereHas('permissions', function ($query) use ($permission) {
            $query->where('name', $permission);
        })->exists();
    }

    public function isAdmin():bool
    {
        return $this->user_type === UserType::ADMIN;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
//        return hasAbility("access_fillament",$this);
    }

    protected function generateDefaultProfileImage()
    {
        // Create the avatar with initials and save it
        $avatar = new Avatar();

        if (!Storage::disk('public')->exists('avatar')) {
            Storage::disk('public')->makeDirectory('avatar');  // Create the directory if it doesn't exist
        }

        $avatar->create($this->name)->setDimension(300,300)->setFontSize(64)->save(storage_path('app/public/avatar/avatar-' . $this->username . '.png'),100);

        // Return the public URL of the generated image
        return Storage::disk('public')->url('avatar/avatar-' . $this->username . '.png');
    }

    public function orders(): HasMany{
        return $this->hasMany(Order::class);
    }

    public function carts():HasMany{
        return $this->hasMany(Cart::class);
    }

    public function activeCarts()
    {
        $this->carts()->where('cart_status',true)->where('cart_delete',false)->get();
    }
}
