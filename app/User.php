<?php

namespace App;

use Illuminate\Http\Request;

class User extends Auth
{
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];
    public $timestamps = false;

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    static public function addAdmin(Request $request)
    {
        $user = User::create($request->only('name', 'email'));
        $user->admin()->create(['password' => bcrypt($request->password)]);
        return true;
    }

    static public function addEmployee(Request $request)
    {
        $user = User::create($request->only('name', 'email'));
        $user->employee()->create($request->only('salary', 'bonus_rate'));
        return true;
    }
    
}
