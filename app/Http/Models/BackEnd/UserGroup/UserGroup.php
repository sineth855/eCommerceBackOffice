<?php

namespace App\Http\Models\BackEnd\UserGroup;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class UserGroup extends Model
{
    protected $table='user_group';
    public $timestamps=false;
    protected $primaryKey='user_group_id';
    protected $fillable=[
    	'name',
    	'group_type',
    	'permission'
    ];
    protected $hidden = array('permission');
    static function AllUserGroup()
    {
        $UserGroup=DB::select('select user_group_id as id,name,group_type,
            case 
                when length(permission)>0 then concat(substr(permission,1,50),\'...\')
            end as permission 
            from sg_user_group')->get();
        return $UserGroup;
    }
    static function Groups()
    {
        $groups=UserGroup::get(['name as text','user_group_id as value']);
        return $groups;
    }
}
