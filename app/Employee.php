<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Http\Request;

class Employee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'salary', 'bonus_rate',
    ];

    // disable timestamps
    public $timestamps = false;
    protected $primaryKey = 'user_id';

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // added some logic to make controller more cleaner 
    // need not repository pattern to not fall in over engineering issues
    public function updateEmployee(Request $request)
    {
        $data_to_update = [];
        if($request->has('name'))
            $data_to_update['name'] = $request->name;
        if($request->has('email'))
            $data_to_update['email'] = $request->email;
        if(count($data_to_update) > 0)
            $this->user()->update($data_to_update);

        $data_to_update = [];
        if($request->has('salary'))
            $data_to_update['salary'] = $request->salary;
        if($request->has('bonus_rate'))
            $data_to_update['bonus_rate'] = $request->bonus_rate;
        if(count($data_to_update) > 0)
            $this->update($data_to_update);
        return true;
    }

    public function destroyEmployee()
    {
        $user = $this->user;
        if($this->delete() && $user->delete())
            return true;
        return false;
    }
}
