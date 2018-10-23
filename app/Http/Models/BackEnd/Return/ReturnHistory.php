<?php

namespace App\Http\Models\BackEnd\Return;

use Illuminate\Database\Eloquent\Model;

class ReturnHistory extends Model
{
    protected $table = 'return_history';
    protected $primaryKey='return_history_id';
    protected $fillable=[
		'return_id',
		'return_status_id',
		'notify',
		'comment',
		'date_added',
		
    ];
    public $timestamps = false;
}
