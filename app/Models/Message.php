<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'application_id',
        'level_id',
        'body',
    ];

    /**
     * Get the applications that owns the message.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Get the level associated with the message.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level()
    {
        return $this->belongsTo(MessageLevel::class);
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
}
