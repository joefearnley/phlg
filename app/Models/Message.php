<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Get the level associated with the message.
     */
    public function level()
    {
        return $this->hasOne(MessageLevel::class);
    }
}
