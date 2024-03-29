<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Scopes\ActiveScope;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;
use Hashids\Hashids;

class Application extends Authenticatable
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'app_id',
        'active',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($application) {
            $hashids = new Hashids('', 12);
            $application->app_id = $hashids->encode($application->id);
            $application->save();
        });

        static::addGlobalScope(new ActiveScope());
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    /**
     * Get the user that owns the application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the message owned by the application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the time of the last message that was created or the last time the
     * application model was updated.
     *
     * @return string
     */
    public function lastUpdated()
    {
        if ($this->messages->isNotEmpty()) {
            return $this->messages->last()->formattedCreationTime();
        }

        return $this->formattedUpdateTime();
    }

    /**
     * Get the formatted created_at time stamp.
     *
     * @return string
     */
    public function formattedCreationTime()
    {
        return Carbon::parse($this->created_at)->format('m/d/Y h:i a');
    }

    /**
     * Get the formatted updated_at time stamp.
     *
     * @return string
     */
    public function formattedUpdateTime()
    {
        return Carbon::parse($this->updated_at)->format('m/d/Y h:i a');
    }

    /**
     * Get the formatted status.
     *
     * @return string
     */
    public function status()
    {
        return $this->active ? 'Active' : 'Not Active';
    }
}
