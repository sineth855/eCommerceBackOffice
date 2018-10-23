<?php
namespace App\Http\Models\BackEnd\Option;

use Illuminate\Database\Eloquent\Model;

class OptionDescription extends Model
{
	protected $table='option_description';
  	protected $primaryKey='option_id';
	protected $fillable=[
		'option_id',
	  	'name',
	  	'language_id'
	];
	public $timestamps=false;
}
