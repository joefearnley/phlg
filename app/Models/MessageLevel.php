<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageLevel extends Model
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
     * Get the color related to the message level
     *
     * @return string
     */
    public function color()
    {
        if ($this->name === 'INFO') {
            return 'emerald';
        }

        if ($this->name === 'ERROR') {
            return 'red';
        }

        if ($this->name === 'DEBUG') {
            return 'amber';
        }
    }
}
