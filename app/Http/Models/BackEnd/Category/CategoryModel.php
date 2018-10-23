<?php

namespace App\Http\Models\BackEnd\Category;
use App\Http\Models\BackEnd\Category\CategoryFilter;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class CategoryModel extends Model
{
    protected $table = 'category';
	protected $primaryKey='category_id';
	protected $guarded = ['category_id']; 
    protected $fillable=[
    	'category_type_id',
		'image',
		'parent_id',
		'top',
		'column',
		'sort_order',
		'status',
		'date_added',
		'date_modified',
    ];
	public $timestamps = false;

	static function getFilterBaseCategoryId($category_id)
	{
        $result = DB::table('category_filter as cf')
					->Join('filter as f', 'f.filter_id', 'cf.filter_id')
					->Join('filter_description as fd', 'fd.filter_id', 'f.filter_id')
					->Where('cf.category_id', $category_id)
					->Where('fd.language_id', config_language_id)
                    ->OrderBy('fd.name')
                    ->select('fd.filter_id as id', 'fd.name as name')
					->get();
		return $result;
	}

	static function getStoreBaseCategoryId($category_id)
	{
        $result = DB::table('category_to_store as c2s')
                    ->Join('store as s','s.store_id','c2s.store_id')
					->Where('c2s.category_id',$category_id)
					// ->Where('c2s.store_id', config_store_id)
                    ->OrderBy('s.name')
                    ->select('s.store_id as id', 's.name as name')
					->get();
		return $result;
	}

	static function getCategoryBaseProductId($product_id)
	{
        $result = DB::table('product_to_category as p2c')
                    ->Join('category as c','c.category_id','p2c.category_id')
					->Join('category_description as cd','cd.category_id','c.category_id')
					// ->Join('category_to_store as c2s','c2s.category_id','=','c.category_id')
					// ->where('c2s.store_id',config_store_id)
                    ->Where('cd.language_id',config_language_id)
					->Where('p2c.product_id',$product_id)
                    ->OrderBy('cd.name')
                    ->select('cd.*')
					->get();
		return $result;
	}

	static function UpdateOrCreate($data,$category_id='')
	{
		// dd($data);
		if (!$category_id) {
			$data['date_added']=Carbon::now();
			$data['date_modified']=Carbon::now();
			return static::insert($data);
		}else{
			$data['date_modified']=Carbon::now();
			$Category=static::find($category_id);
			if (!$Category) {
				return false;
			}
			return $Category->update($data);
		}
	}
	static function DeleteCategory($category_id)
	{
		// $Category=static::find($category_id);
		// if (!$Category) {
		// 	return false;
		// }
		// return $Category->delete();

		$Category=static::find($category_id);
		$CategoryDescription = CategoryDescription::where('category_id',$category_id)->delete();
		$CategoryFilter = CategoryFilter::where('category_id',$category_id)->delete();
		if (!$Product) {
			return ['success'=>false,
					'message'=>'Data fail to delete.'];
		}
		return ['deleted'=>$Category->delete(),
    			'message'=>'Data successfully deleted.'];

	}
	// static function DeleteProduct($product_id)
	// {
	// 	$Product=static::find($product_id);
	// 	$ProductDescription = ProductDescription::where('product_id',$product_id)->delete();
	// 	if (!$Product) {
	// 		return ['success'=>false,
	// 				'message'=>'Data fail to delete.'];
	// 	}
	// 	return ['deleted'=>$Product->delete(),
 //    			'message'=>'Data successfully deleted.'];
	// }
	public function Description()
	{
		$language_id=1;
		return $this->hasMany(CategoryDescription::class,'category_id')->where('language_id',$language_id);
	}
	public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
	public function scopeParent($query)
	{
		return $query->where('parent_id',0);
	}
	static function ParentCategories($data=array())
	{
		return static::where('parent_id',0)->where('status',1);
	}
	public function ChildCategories($data=array())
	{
		return $this->hasMany(CategoryModel::class,'parent_id');
	}
	public function CategoryType()
	{
		$language_id=1;
		return $this->hasOne(CategoryType::class,'category_type_id','category_type_id')->where('language_id',$language_id);
	}
	static function getAllCategories()
	{
		$Categorys=static::ParentCategories()->get();
		foreach ($Categorys as $Category) {
			$Category->type=$Category->CategoryType()->value('name');
			$Category->name=$Category->Description()->value('name');
			$getChild=$Category->ChildCategories()->get();
			if ($getChild->count()) {
				$Category->child=$getChild;
				foreach ($Category->child as $Child) {
					$Child->name=$Child->Description()->value('name');
				}
				$Category->child=$Category->child->toArray();
			}
		}
		return $Categorys;
	}
	
}
