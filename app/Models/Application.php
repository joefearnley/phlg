<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Application extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];

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
     * Get the message owned by the application.]
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the time of the last message that was created.
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
     * Get the formatted updated_at time stamp.
     *
     * @return string
     */
    public function formattedUpdateTime()
    {
        return Carbon::parse($this->updated_at)->format('m/d/Y h:i a');
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
}
