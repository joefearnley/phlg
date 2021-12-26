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
     * formattedCreationDate
     *
     * @return \Carbon\Carbon
     */
    public function formattedCreationDate()
    {
        return Carbon::parse($this->created_at)->format('d/m/Y h:i a');
    }
}
