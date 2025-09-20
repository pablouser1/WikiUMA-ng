<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
    ];

    protected $hidden = [
        'password',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function checkPassword(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->password);
    }
}
