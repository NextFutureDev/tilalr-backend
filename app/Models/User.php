<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>//
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Relationship: User belongs to many roles
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user')
            ->withTimestamps();
    }

    /**
     * Check if user has role
     */
    public function hasRole($role): bool
    {
        if (is_string($role)) {
            return $this->roles()->where('name', $role)->exists();
        }
        return $this->roles->contains($role);
    }

    /**
     * Check if user has permission
     */
    public function hasPermission($permission): bool
    {
        // Super admin has all permissions
        if ($this->hasRole('super_admin')) {
            return true;
        }

        // Check all roles for the permission
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if user can perform action on resource
     */
    public function canDo(string $action, string $resource): bool
    {
        return $this->hasPermission("{$resource}.{$action}");
    }

    /**
     * Check if user can access a page/resource (view or manage)
     */
    public function hasResourceAccess($resource): bool
    {
        return $this->hasPermission("view_{$resource}") || $this->hasPermission("manage_{$resource}");
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    /**
     * Check if user can access admin panel (legacy helper)
     */
    public function canAccessAdminPanel(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Filament panel access (FilamentUser)
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin
            || $this->hasRole('super_admin')
            || $this->hasRole('executive_manager')
            || $this->hasRole('consultant')
            || $this->hasRole('administration')
            || $this->hasRole('content_manager')
            || $this->hasRole('support_agent')
            || $this->hasRole('data_analyst');
    }
}