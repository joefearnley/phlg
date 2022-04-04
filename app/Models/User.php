<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Application;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the applications owned by the user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get the messages owned by the user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function messages()
    {
        return $this->hasManyThrough(Message::class, Application::class)
            ->orderBy('created_at');
    }

    /**
     * Get the latest messages for the user.
     *
     * @param  mixed $amount
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function latestMessages($limit = 10)
    {
        return $this->hasManyThrough(Message::class, Application::class)
            ->orderBy('created_at')
            ->take($limit);
    }

    /**
     * Create an application related to the user.
     *
     * @param \App\Models\Application
     * @return \App\Models\Application
     */
    public function createApplication(Application $application)
    {
        return $this->applications()->save($application);
    }

    /**
     * Search user's messages for a given search term.
     * 
     * @param int $appID
     * @param string $term
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function searchMessages($appId = null, $searchTerm = null)
    {
        $query = $this->messages();

        if (!empty($appId)) {
            $query->where('application_id', $appId);
        }

        if (!empty($searchTerm)) {
            $query->where('body', 'like', "%$term%");
        }

        return $query;
    }
}
