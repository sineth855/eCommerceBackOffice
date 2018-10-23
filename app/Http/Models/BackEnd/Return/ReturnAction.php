<?php

namespace App\Http\Models\BackEnd\Return;

use Illuminate\Database\Eloquent\Model;

class ReturnAction extends Model
{
    protected $table = 'return_action';
    protected $primaryKey='return_action_id';
    protected $fillable=[
		'language_id',
		'name',
    ];
    public $timestamps = false;
}
