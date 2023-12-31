<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class VerificationCode extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'code']; // Define fillable attributes

    // Define the relationship with the User model if needed
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
