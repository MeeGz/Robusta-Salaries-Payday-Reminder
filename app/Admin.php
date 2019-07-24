<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'password',
    ];
    public $timestamps = false;
    protected $primaryKey = 'user_id';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // added some logic to make controller more cleaner 
    // need not repository pattern to not fall in over engineering issues
    public function updateAdmin(Request $request)
    {
        $data_to_update = [];
        if($request->has('name'))
            $data_to_update['name'] = $request->name;
        if($request->has('email'))
            $data_to_update['email'] = $request->email;
        if(count($data_to_update) > 0)
            $this->user()->update($data_to_update);

        if($request->has('password'))
            $this->update(['password' => bcrypt($request->password)]);
        return true;
    }

    public function destroyAdmin()
    {
        $user = $this->user;
        DB::table('oauth_access_tokens')->where('user_id','=', $this->user_id)->delete();
        if($this->delete() && $user->delete())
            return true;
        return false;
    }
}
