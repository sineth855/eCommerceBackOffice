<?php

namespace App\Http\Models\BackEnd\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Models\BackEnd\UserGroup\UserGroup;
class User extends Model
{
    protected $table='users';
    public $timestamps=false;
    protected $primaryKey='id';
    protected $fillable=[
    	'user_group_id',
    	'firstname',
    	'lastname',
    	'gender',
    	'dob',
    	'company',
    	'website',
    	'owner',
    	'address_1',
    	'address_2',
        'username',
        'email',
        'email_2',
        'password',
        'telephone_1',
        'telephone_2',
        'country',
        'province',
        'city',
        'code',
        'image',
        'status',
        'remember_token',
        'date_added',
        'updated_at'
    ]; 
    //protected $hidden=['user_group_id','password','salt','ip'];

    public function UserGroup(){
		return $this->belongsTo(UserGroup::class,'user_group_id');
	}
    static function AllUser()
    {
        $users=DB::table('users')
            ->join('user_group', 'users.user_group_id', '=', 'user_group.user_group_id')
            ->select(
                'id as id', 
                'username', 
                'user_group.name as group',
                'firstname',
                'lastname',
                'email', 
                'code',
                'image',
                'status',
                'date_added'
            )
            ->OrderBy('id','desc')
            ->get();
        return $users;
    }

    static function getUserReseller($group_id)
    {
        $users=DB::table('users')
            ->join('user_group', 'users.user_group_id', '=', 'user_group.user_group_id')
            ->select(
                'id as id', 
                'username', 
                'user_group.name as group',
                'firstname',
                'lastname',
                'email', 
                'code',
                'image',
                'status',
                'date_added'
            )
            ->where('users.user_group_id',$group_id)
            ->get();
        return $users;
    }

    static function getUserCarriers($group_id)
    {
        $users=DB::table('users')
            ->join('user_group', 'users.user_group_id', '=', 'user_group.user_group_id')
            ->select(
                'id as id', 
                'username', 
                'user_group.name as group',
                'firstname',
                'lastname',
                'email', 
                'code',
                'image',
                'status',
                'date_added'
            )
            ->where('users.user_group_id',$group_id)
            ->get();
        return $users;
    }

}

