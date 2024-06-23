<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, HasApiTokens;
    protected $guard_name = 'api';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function websites()
    {
        return $this->belongsToMany(Website::class, 'votes');
    }

    public function hasVotedFor(Website $website)
    {
        return $this->websites()->where('website_id', $website->id)->exists();
    }

    public function votedWebsites()
    {
        return $this->belongsToMany(Website::class, 'votes')->withTimestamps();
    }

    public function voteFor(Website $website)
    {
        $this->votedWebsites()->attach($website);
    }

    public function unvoteFor(Website $website)
    {
         $this->votedWebsites()->detach($website);
    }

}
