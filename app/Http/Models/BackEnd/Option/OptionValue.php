<?php

namespace App\Http\Models\BackEnd\Option;

use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
	protected $table='option_value';
	protected $primaryKey='option_value_id';
	protected $fillable=[
		'option_id',
		'image',
		'sort_order'
	];
	public $timestamps=false;
}
