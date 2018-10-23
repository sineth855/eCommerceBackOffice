<?php

namespace App\Http\Models\BackEnd\Filter;

use Illuminate\Database\Eloquent\Model;

class FilterDescription extends Model
{
    protected $table='filter_description';
	protected $primaryKey='filter_id';
	protected $fillable=[
		'filter_id',
		'filter_group_id',
		'language_id',
		'name'
	];
	public $timestamps=false;
}
