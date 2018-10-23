<?php

namespace App\Http\Models\BackEnd\Information;

use Illuminate\Database\Eloquent\Model;

class InformationToLayout extends Model
{
    protected $table='information_to_layout';
	protected $primaryKey='information_id';
	protected $fillable=[
		'information_id',
		'store_id',
		'layout_id'
	];
	public $timestamps=false;
}
