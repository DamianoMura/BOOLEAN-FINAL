<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
        ];
    }

    //adding relationships

    public function role()
    {
        return $this->belongsToMany(Role::class);
    }

    //verify if the user have been assigned a Role
    public function hasRole(): bool
    {
        return $this->role()->exists() ? true : false;
    }

    //checks if user is a dev, admin or user
    public function isDev(): bool
    {
        return $this->role()->where('name', 'dev')->exists() ? true : false;
    }


    public function isAdmin(): bool
    {
        return $this->role()->where('name', 'admin')->exists();
    }



    //used only in user maintenance (changing role)
    public function isUser(): bool
    {
        return $this->role()->where('name', 'user')->exists();
    }

    // assign Role to users
    public function assignRole(string $roleName): void
    {
        $role = Role::where('name', $roleName)->firstOrFail();
        $this->role()->attach($role);
        $this->save();
    }


    // Accessor for role label to be shown in page 
    public function getRoleName(): ?string
    {
        $role = $this->role()->first();
        return $role ? $role->name : null;
    }
    public function getRoleLabel(): ?string
    {
        $role = $this->role()->first();
        return $role ? $role->label : null;
    }
    public function getRole(): Role
    {
        $role = $this->role()->first();
        return $role ? $role : null;
    }

    //to establish a relation with Project into project_user pivot

    public function canEdit()
    {

        return $this->belongsToMany(Project::class, 'project_user');
    }
}
