<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\ActiveScope;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

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
        'two_factor_recovery_codes',
        'two_factor_secret',
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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the applications owned by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applications()
    {
        return $this->hasMany(Application::class)
            ->orderByDesc('created_at');
    }

    /**
     * Get all of the applications owned by the user including inactive.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allApplications()
    {
        return $this->hasMany(Application::class)
            ->withoutGlobalScopes()
            ->orderByDesc('created_at');
    }

    /**
     * Get the messages owned by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function messages()
    {
        return $this->hasManyThrough(Message::class, Application::class)
            ->withGlobalScope('active', new ActiveScope())
            ->orderByDesc('created_at', 'desc');
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
            ->withGlobalScope('active', new ActiveScope())
            ->orderBy('created_at', 'desc')
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
            $query->where('body', 'like', "%$searchTerm%");
        }

        return $query;
    }
}
