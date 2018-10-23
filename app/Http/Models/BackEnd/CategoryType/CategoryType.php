<?php

namespace App\Http\Models\BackEnd\CategoryType;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class CategoryType extends Model
{
    protected $table='category_type';
	protected $primaryKey='category_type_id';
	protected $fillable=[
		'order_level',
		'date_added',
		'date_modified'
	];
	public $timestamps=false;
	static function AllCategoryType()
	{
		$CategoryTypes=DB::table('category_type as categoryType')
                ->Join('category_type_description as desc','desc.category_type_id','=','categoryType.category_type_id')
                ->Join('language','language.language_id','=','desc.language_id')
                ->select('categoryType.category_type_id','categoryType.order_level as sort_order','desc.name','language.name as language','desc.description')
                ->get();
      	return $CategoryTypes;
	}
	static function CategoryTypeEdit($id)
	{
		$CategoryTypes=DB::table('category_type as categoryType')
                ->Join('category_type_description as desc','desc.category_type_id','=','categoryType.category_type_id')
                ->Join('language','language.language_id','=','desc.language_id')
                ->select('categoryType.category_type_id','desc.name as name','language.language_id','desc.name','language.name as language','desc.description')
                ->where('categoryType.category_type_id',$id)
                ->get();
      	return $CategoryTypes;
	}
	
	static function UpdateOrCreate($data,$category_type_id='')
	{
		// dd($data);
		if (!$category_type_id) {
			$data['date_added']=Carbon::now();
			$data['date_modified']=Carbon::now();
			return static::insert($data);
		}else{
			$data['date_modified']=Carbon::now();
			$CategoryType=static::find($category_type_id);
			if (!$CategoryType) {
				return false;
			}
			return $CategoryType->update($data);
		}
	}
}
