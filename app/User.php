<?php

namespace App;

class User extends Auth
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
}
