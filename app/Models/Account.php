<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * Get the user for the account.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the applications for the account.
     */
    public function users()
    {
        return $this->hasMany(Application::class);
    }
}
