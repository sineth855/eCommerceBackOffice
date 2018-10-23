<?php

namespace App\Http\Models\BackEnd\Filter;

use Illuminate\Database\Eloquent\Model;

class FilterGroupDescription extends Model
{
    protected $table='filter_group_description';
	protected $primaryKey='filter_group_id';
	protected $fillable=[
		'filter_group_id',
		'language_id',
		'name'
	];
	public $timestamps=false;
}
