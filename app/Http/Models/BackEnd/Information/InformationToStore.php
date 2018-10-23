<?php

namespace App\Http\Models\BackEnd\Information;

use Illuminate\Database\Eloquent\Model;

class InformationToStore extends Model
{
    protected $table='information_to_store';
	protected $primaryKey='information_id';
	protected $fillable=[
		'information_id',
		'store_id'
	];
	public $timestamps=false;
}
