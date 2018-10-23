<?php

namespace App\Http\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends Model
{
    protected $table = 'order_history';
	protected $primaryKey='order_history_id';
	protected $fillable =[
							'order_id',
							'order_status_id',
							'notify',
							'comment',
							'date_added'
						];
	public $timestamps = false;
	
	static function getCategoryFilters($category_id) {

		$implode = array();

		$query = DB::table('category_filter')
				 	->select('filter_id')
					->where('category_id',"" . (int)$category_id . "")
					->get();
					
		// $query = $this->db->query("SELECT filter_id FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query as $result) {

			$implode[] = (int)$result->filter_id;

		}



		$filter_group_data = array();



		if ($implode) {
			$filter_group_query = DB::table("filter as f")
								  ->distinct()
								  ->select('f.filter_group_id','fgd.name','fg.sort_order')
								  ->leftjoin('filter_group as fg','f.filter_group_id','=','fg.filter_group_id')
								  ->leftjoin('filter_group_description as fgd','fg.filter_group_id','=','fgd.filter_group_id')
								  ->whereIn('f.filter_id', $implode)
								  ->where('fgd.language_id',config_language_id)
								  ->GROUPBY('f.filter_group_id','fgd.name')
								  ->orderby('fg.sort_order',"LCASE(fgd.name)")
								  ->get();
			//$filter_group_query = $this->db->query("SELECT DISTINCT
			//  f.filter_group_id, fgd.name, fg.sort_order FROM " . DB_PREFIX . "filter f 
			//  LEFT JOIN " . DB_PREFIX . "filter_group fg ON (f.filter_group_id = fg.filter_group_id) 
			//  LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON 
			//  (fg.filter_group_id = fgd.filter_group_id) 
			//  WHERE f.filter_id IN (" . implode(',', $implode) . ") 
			//  AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			//  GROUP BY f.filter_group_id ORDER BY fg.sort_order, LCASE(fgd.name)");



			foreach ($filter_group_query as $filter_group) {

				$filter_data = array();


				$filter_query = DB::table('filter as f')
								->leftjoin('filter_description as fd','f.filter_id','=','fd.filter_id')
								->whereIn('f.filter_id',$implode)
								->where('f.filter_group_id',"".(int)$filter_group->filter_group_id."")
								->where('fd.language_id',config_language_id)
								->orderby('f.sort_order','LCASE(fd.name)')
								->get();
				// $filter_query = $this->db->query("SELECT DISTINCT f.filter_id, fd.name 
				// FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON 
				// (f.filter_id = fd.filter_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") 
				// AND f.filter_group_id = '" . (int)$filter_group['filter_group_id'] . "' 
				// AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
				// ORDER BY f.sort_order, LCASE(fd.name)");



				foreach ($filter_query as $filter) {

					$filter_data[] = array(

						'filter_id' => $filter->filter_id,

						'name'      => $filter->name

					);

				}



				if ($filter_data) {

					$filter_group_data[] = array(

						'filter_group_id' => $filter_group->filter_group_id,

						'name'            => $filter_group->name,

						'filter'          => $filter_data

					);

				}

			}

		}



		return $filter_group_data;

	}

	static function getCategory($category_id,$data = array()){
		$query = DB::table('category as c')
				 ->distinct()
				 ->select('*')
				 ->leftjoin('category_description as cd','c.category_id','=','cd.category_id')
				 ->leftjoin('category_to_store as c2s','c.category_id', '=', 'c2s.category_id')
				 ->where('c.category_id',"". (int)$category_id . "")
				 ->where('cd.language_id',"" . (int)config_language_id . "")
				//  ->where('c2s.store_id',(int)$data['store_id'])
				 ->where('c.status',1)
				 ->first();
		
		return $query;
	}

	static function getTotalProducts($data = array()) {
		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql = DB::table('category_path as cp')
					->join('product_to_category as p2c','cp.category_id','=','p2c.category_id');
			} else {
				$sql = DB::table('product_to_category as p2c');
			}

			if (!empty($data['filter_filter'])) {
				$sql->leftjoin('product_filter as pf','p2c.product_id','=','pf.product_id');
				$sql->leftjoin('product as p','pf.product_id','=','p.product_id');
			} else {
				$sql->leftjoin('product as p','p2c.product_id','=','p.product_id');
			}
		} else {
			$sql = DB::table('product as p');
		}

		$sql->select('p.product_id')
			->join('product_description as pd','p.product_id','=','pd.product_id')
			->join('product_to_store as p2s','p.product_id', '=' ,'p2s.product_id')
			->join('product_to_category','p.product_id','=','product_to_category.product_id')
			->where('pd.language_id',config_language_id)
			->where('p.status',1)
			->where('p.date_available','<=',NOW())
			->where('p2s.store_id',(int)$data['store_id']);

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql->where('cp.path_id',(int)$data['filter_category_id']);
			} else {
				$sql->where('p2c.category_id',(int)$data['filter_category_id']);
			}
		}

		// if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
		// 	$sql .= " AND (";

		// 	if (!empty($data['filter_name'])) {
		// 		$implode = array();

		// 		$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

		// 		foreach ($words as $word) {
		// 			$implode[] = "pd.name LIKE '%" . trim($word) . "%'";
		// 		}

		// 		if ($implode) {
		// 			$sql .= " " . implode(" AND ", $implode) . "";
		// 		}

		// 		if (!empty($data['filter_description'])) {
		// 			$sql->orwhere("pd.description","LIKE '%" . $this->db->escape($data['filter_name']) . "%'");
		// 		}
		// 	}

		// 	if (!empty($data['filter_name'])) {
		// 		$sql->orwhere("LCASE(p.model)", "=", "'" .$data['filter_name'] . "'");
		// 		$sql->orwhere("LCASE(p.sku)", "=", "'" .$data['filter_name'] . "'");				
		// 		$sql->orwhere("LCASE(p.upc)", "=", "'" .$data['filter_name'] . "'");
		// 		$sql->orwhere("LCASE(p.ean)", "=", "'" .$data['filter_name'] . "'");
		// 		$sql->orwhere("LCASE(p.jan)", "=", "'" .$data['filter_name'] . "'");
		// 		$sql->orwhere("LCASE(p.isbn)", "=", "'" .$data['filter_name'] . "'");
		// 		$sql->orwhere("LCASE(p.mpn)", "=", "'" .$data['filter_name'] . "'");
		// 	}

		// 	$sql .= ")";
		// }

		// if (!empty($data['filter_manufacturer_id'])) {
		// 	$sql->where('p.manufacturer_id',(int)$data['filter_manufacturer_id']);
		// }

		$query = $sql->count();
		return $query;
	}
	
}
