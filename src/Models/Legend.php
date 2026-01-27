<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Legend extends Model
{
    protected $table = 'legends';

    protected $fillable = [
        'first_name',
        'last_name',
        'idnc',
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
