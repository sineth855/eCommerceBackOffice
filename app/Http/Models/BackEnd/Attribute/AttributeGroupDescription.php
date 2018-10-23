<?php

namespace App\Http\Models\BackEnd\Attribute;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class AttributeGroupDescription extends Model
{
    protected $table='attribute_group_description';
  	protected $primaryKey='attribute_group_id';
	protected $fillable=[
	  	'name',
	  	'attribute_group_id',
	  	'language_id'
	];
	public $timestamps=false;
}
