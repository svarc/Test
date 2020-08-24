<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name'];

    public function calls()
    {
        return $this->hasMany(Call::class)->orderBy('date', 'desc');
    }
}
