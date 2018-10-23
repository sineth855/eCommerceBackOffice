<?php

namespace App\Http\Models\BackEnd\CategoryType;

use Illuminate\Database\Eloquent\Model;

class CategoryTypeDescription extends Model
{
    protected $table='category_type_description';
	protected $primaryKey='category_type_id';
	protected $fillable=[
		'category_type_id',
		'language_id',
		'name',
		'description'
	];
	public $timestamps=false;
}
