<?php

namespace App\Http\Models\BackEnd\Option;

use Illuminate\Database\Eloquent\Model;

class OptionValueDescription extends Model
{
    protected $table='option_value_description';
	protected $primaryKey='option_value_id';
	protected $fillable=[
		'option_value_id',
		'option_id',
		'name',
		'language_id'
	];
	public $timestamps=false;
}
