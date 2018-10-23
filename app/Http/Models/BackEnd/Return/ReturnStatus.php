<?php

namespace App\Http\Models\BackEnd\Return;

use Illuminate\Database\Eloquent\Model;

class ReturnStatus extends Model
{
    protected $table = 'return_status';
    protected $primaryKey='return_status_id';
    protected $fillable=[
		'language_id',
		'name',
    ];
    public $timestamps = false;
}
