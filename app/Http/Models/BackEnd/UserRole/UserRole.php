<?php

namespace App\Http\Models\BackEnd\UserRole;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\BackEnd\UserGroup\UserGroup;
use Illuminate\Support\Facades\DB;
class UserRole extends Model
{
    protected $table='group_role';
    public $timestamps=false;
    protected $primaryKey='id';
    protected $fillable=[
    	'name',
    	'group_id',
        'remark',
        'is_active'
    ];

    public function UserGroup(){
		return $this->belongsTo(UserGroup::class,'group_id');
	}

}
