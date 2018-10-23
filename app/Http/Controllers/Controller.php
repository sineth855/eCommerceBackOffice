<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getTypeCategory(){
    	// $query = DB::table('category_type')->get();
    	$query = DB::table('category_type')
				->Join('category_type_description' ,'category_type.category_type_id','=' ,'category_type_description.category_type_id')
				->get();
    	return $query;
    }
    public function ImageMaker($dir,$image)
    {
        if( preg_match('/data:image/', $image) ){                
            preg_match('/data:image\/(?<mime>.*?)\;/', $image , $groups);
            $mimetype = $groups['mime'];
            $file_name = uniqid().'.'.$mimetype;          
            $file_name=preg_replace('/\s/','', $file_name);
            $filepath = "$dir/$file_name";    
            $image = Image::make($image)->resize(400, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
            $image->save(public_path($filepath));     
            return $filepath;
        } 
        return $image;
    }
    /*
	# query get category
    */
	public function getCategories($parent_id = 0,$cat_type = 0) {
		$query = DB::table('category')
				->select('category.*','category_description.name as name')
				->leftJoin('category_description' ,'category.category_id','=' ,'category_description.category_id')
				// ->leftJoin('category_to_store' , 'category.category_id', '=', 'category_to_store.category_id')
				->where('category.category_type_id',$cat_type)
				->where('category.parent_id',$parent_id)
				// ->where('category_to_store.store_id',config_store_id)
				->where('category.status',1)
				->get();
				
		return $query;
	}
	/*
	# query get SlideShow
    */
	public function getBanner() {
		$query = DB::table('banner')
				->leftJoin('banner_image','banner.banner_id','=','banner_image.banner_id')
				// ->where('banner_image.banner_id',7)
				->orderBy('banner_image.sort_order','asc')
				->get();
		return $query;
	}
	/*
	# query get ResizeImage
    */
	public function resize($filename, $width, $height) {
		if (!is_file(DIR_IMAGE . $filename)) {
			return;
		}

		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		$old_image = $filename;
		$new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

		if (!is_file(DIR_IMAGE . $new_image) || (filectime(DIR_IMAGE . $old_image) > filectime(DIR_IMAGE . $new_image))) {
			$path = '';

			$directories = explode('/', dirname(str_replace('../', '', $new_image)));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
			}

			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);

			if ($width_orig != $width || $height_orig != $height) {
				$image = new Image(DIR_IMAGE . $old_image);
				$image->resize($width, $height);
				$image->save(DIR_IMAGE . $new_image);
			} else {
				copy(DIR_IMAGE . $old_image, DIR_IMAGE . $new_image);
			}
		}

		if ($this->request->server['HTTPS']) {
			return $this->config->get('config_ssl') . 'image/' . $new_image;
		} else {
			return $this->config->get('config_url') . 'image/' . $new_image;
		}
	}
	/*
	# query get totalProduct
    */
	public function getTotalProducts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total";
		
		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "product p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$sql .= "pd.tag LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "%'";
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			$sql .= ")";
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	/*
	# query get getLatestProduct
    */
	public function getProducts($data = array()) {
		
		$sql = DB::table('product')
				->select('product.product_id',DB::raw('(SELECT AVG(rating) AS total FROM sg_review r1 
				WHERE r1.product_id = sg_product.product_id AND r1.status = 1 
				GROUP BY r1.product_id) AS rating'),DB::raw('(SELECT price FROM sg_product_discount pd2 WHERE pd2.product_id = sg_product.product_id 
				AND pd2.customer_group_id = 1 AND pd2.quantity = 1  AND ((pd2.date_start = 0000-00-00
				OR pd2.date_start < NOW()) 
				AND (pd2.date_end = 0000-00-00 OR pd2.date_end > NOW())) 
				ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) 
				AS discount'),DB::raw('(SELECT price FROM sg_product_special ps WHERE ps.product_id = sg_product.product_id AND ps.customer_group_id = 1 AND ((ps.date_start = 0000-00-00 OR ps.date_start < NOW()) AND (ps.date_end = 0000-00-00 OR ps.date_end > NOW())) 
				ORDER BY ps.priority ASC
				, ps.price ASC LIMIT 1) AS special'))
				->leftJoin('product_description','product.product_id','=','product_description.product_id')
				->leftJoin('product_to_store','product.product_id','=','product_to_store.product_id')
				->where('product_description.language_id',1)
				->where('product.status',1)
				->where('product.date_available','<=',Carbon::today())
				 ->where('product_to_store.store_id',config_store_id)
				// ->where('product_to_store.store_id',0)
				->groupBy('product_description.name')
				->groupBy('product.product_id');
				// ->limit(4);
				// ->get();

		if (isset($data['limit'])) {
			$sql->Limit($data['limit']);
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql->OrderBy("product_description.name","DESC");
		} else {
			$sql->OrderBy("product_description.name","ASC");
		}

		$query = $sql->get();

		$product_data = array();
		foreach ($query as $result) {
			$product_data[] = $this->getProduct($result->product_id);
		}
		return $product_data;
	}  


	public function getProduct($product_id) {
		
		$query = DB::table('product')
				->select(DB::raw('DISTINCT *'),'product.product_id','product_description.name as name','product.image','manufacturer.name AS manufacturer',DB::raw('(SELECT price FROM sg_product_discount pd2 WHERE pd2.product_id = sg_product.product_id AND pd2.customer_group_id = 1 AND pd2.quantity = 1 AND ((pd2.date_start = 0000-00-00 OR pd2.date_start < NOW()) AND (pd2.date_end = 0000-00-00 OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC
						, pd2.price ASC LIMIT 1) AS discount'),DB::raw('(SELECT price FROM sg_product_special ps WHERE ps.product_id = sg_product.product_id AND ps.customer_group_id = 1 AND ((ps.date_start = 0000-00-00 OR ps.date_start < NOW()) AND (ps.date_end = 0000-00-00 OR ps.date_end > NOW())) ORDER BY ps.priority ASC
						, ps.price ASC LIMIT 1) AS special'),DB::raw('(SELECT points FROM sg_product_reward pr WHERE pr.product_id = sg_product.product_id AND customer_group_id = 1) AS reward'),DB::raw('(SELECT ss.name FROM sg_stock_status ss WHERE ss.stock_status_id = sg_product.stock_status_id AND ss.language_id = 1 ) AS stock_status'),DB::raw('(SELECT wcd.unit FROM sg_weight_class_description wcd WHERE sg_product.weight_class_id = wcd.weight_class_id AND wcd.language_id = 1 ) AS weight_class'),DB::raw('(SELECT lcd.unit FROM sg_length_class_description lcd WHERE sg_product.length_class_id = lcd.length_class_id AND lcd.language_id = 1 ) AS length_class'),DB::raw('(SELECT AVG(rating) AS total FROM sg_review r1 WHERE r1.product_id = sg_product.product_id AND r1.status = 1 GROUP BY r1.product_id) AS rating'),DB::raw('(SELECT COUNT(*) AS total FROM sg_review r2 WHERE r2.product_id = sg_product.product_id AND r2.status = 1 GROUP BY r2.product_id) AS reviews'),'product.sort_order')
				->leftJoin('product_description','product.product_id','=','product_description.product_id')
				->leftJoin('product_to_store','product.product_id','=','product_to_store.product_id')
				->leftJoin('manufacturer','manufacturer.manufacturer_id','=','product.manufacturer_id')
				// ->join('product_to_category','product.product_id','=','product_to_category.product_id')
				->where('product.product_id',$product_id)
				// ->where('product_to_category.category_id',$category_id)
				// ->where('product_description.language_id',config_language_id)
				->where('product_description.language_id',1)
				->where('product.status',1)
				->where('product.date_available','<=',Carbon::today())
				 ->where('product_to_store.store_id',config_store_id)
				// ->where('product_to_store.store_id',0)
				->first();
			return($query);
		
	}

	// public function getProduct($product_id,$category_id) {
		
	// 	$query = DB::table('product')
	// 			->select(DB::raw('DISTINCT *'),'product_to_category.category_id','product.product_id','product_description.name as name','product.image','manufacturer.name AS manufacturer',DB::raw('(SELECT price FROM sg_product_discount pd2 WHERE pd2.product_id = sg_product.product_id AND pd2.customer_group_id = 1 AND pd2.quantity = 1 AND ((pd2.date_start = 0000-00-00 OR pd2.date_start < NOW()) AND (pd2.date_end = 0000-00-00 OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC
	// 					, pd2.price ASC LIMIT 1) AS discount'),DB::raw('(SELECT price FROM sg_product_special ps WHERE ps.product_id = sg_product.product_id AND ps.customer_group_id = 1 AND ((ps.date_start = 0000-00-00 OR ps.date_start < NOW()) AND (ps.date_end = 0000-00-00 OR ps.date_end > NOW())) ORDER BY ps.priority ASC
	// 					, ps.price ASC LIMIT 1) AS special'),DB::raw('(SELECT points FROM sg_product_reward pr WHERE pr.product_id = sg_product.product_id AND customer_group_id = 1) AS reward'),DB::raw('(SELECT ss.name FROM sg_stock_status ss WHERE ss.stock_status_id = sg_product.stock_status_id AND ss.language_id = 1 ) AS stock_status'),DB::raw('(SELECT wcd.unit FROM sg_weight_class_description wcd WHERE sg_product.weight_class_id = wcd.weight_class_id AND wcd.language_id = 1 ) AS weight_class'),DB::raw('(SELECT lcd.unit FROM sg_length_class_description lcd WHERE sg_product.length_class_id = lcd.length_class_id AND lcd.language_id = 1 ) AS length_class'),DB::raw('(SELECT AVG(rating) AS total FROM sg_review r1 WHERE r1.product_id = sg_product.product_id AND r1.status = 1 GROUP BY r1.product_id) AS rating'),DB::raw('(SELECT COUNT(*) AS total FROM sg_review r2 WHERE r2.product_id = sg_product.product_id AND r2.status = 1 GROUP BY r2.product_id) AS reviews'),'product.sort_order')
	// 			->leftJoin('product_description','product.product_id','=','product_description.product_id')
	// 			->leftJoin('product_to_store','product.product_id','=','product_to_store.product_id')
	// 			->leftJoin('manufacturer','product.product_id','=','product_to_store.product_id')
	// 			->join('product_to_category','product.product_id','=','product_to_category.product_id')
	// 			->where('product.product_id',$product_id)
	// 			->where('product_to_category.category_id',$category_id)
	// 			->where('product_description.language_id',1)
	// 			->where('product.status',1)
	// 			->where('product.date_available','<=',Carbon::today())
	// 			->where('product_to_store.store_id',config_store_id)
	// 			->first();
	// 		return($query);
		
	// }
	public function getLanguages()
    {

        $languages=DB::table('language')->select(['language_id as value','name as text'])->get();

        return $languages;

    }
    public function getCreditTypes()
    {

        $creditType=DB::table('credit_type')->select(['credit_type_id as value','name as text'])->get();

        return $creditType;

    }
    public function getGeoZones()
    {

        $GeoZone=DB::table('geo_zone')->select(['geo_zone_id as value','name as text'])->get();

        return $GeoZone;

    }
    public function getTaxRates()
    {

        $TaxRate=DB::table('tax_rate')->select(['tax_rate_id as value','name as text'])->get();

        return $TaxRate;

    }
    public function getTaxClasses()
    {

        $TaxClass=DB::table('tax_class')->select(['tax_class_id as value','title as text'])->get();

        return $TaxClass;

    }
    public function getCustomerGroups()
    {

        $customerGroups=DB::table('customer_group_description')->select(['customer_group_id as value','name as text'])->get();

        return $customerGroups;

    }
    
    public function getStores()
    {

        $stores=DB::table('store')->select(['store_id as value','name as text'])->get();

        return $stores;

    }
    public function getAttributeGroups()
    {

        $atrributeGroup=DB::table('attribute_group_description')->select(['attribute_group_id as value','name as text'])->get();

        return $atrributeGroup;

    }
    public function getAttributes()
    {

        $atrribute=DB::table('attribute_description')->select(['attribute_id as value','name as text'])->get();

        return $atrribute;

    }
    public function getFilterGroups()
    {

        $filterGroup=DB::table('filter_group_description')->select(['filter_group_id as value','name as text'])->get();

        return $filterGroup;

    }
    public function getFilters()
    {

        $filterGroup=DB::table('filter_description')->select(['filter_id as value','name as text'])->get();

        return $filterGroup;

    }
    public function getLayouts()
    {

        $filterGroup=DB::table('layout')->select(['layout_id as value','name as text'])->get();

        return $filterGroup;

    }
    public function getOption()
    {

        $filterGroup=DB::table('option')->select(['option_id as value','type as text'])->get();

        return $filterGroup;

    }
    public function getStockStatu()
    {

        $filterGroup=DB::table('stock_status')->select(['stock_status_id as value','name as text'])->get();

        return $filterGroup;

    }
    public function getProductRelate()
    {

        $filterGroup=DB::table('product_description')->select(['product_id as value','name as text'])->get();

        return $filterGroup;

    }

    public function getCurrencies($value='')
    {
        $filterGroup=DB::table('currency')->select(['currency_id as value','code as text'])->get();

        return $filterGroup;
    }
    public function getLocation($country_id='')
    {
        if ($country_id) {
            $data=Zone::select('country_id','name','zone_id as value')->where('country_id',$country_id)->where('status',1)->get()->toArray();
        }else{
            $data=Country::select('name','country_id as value')->where('status',1)->get()->toArray();
        }
        // dd($data);
        return $data;
    }
    public function getShippingMethod($id='')
    {
        $data=ShippingCourier::select('shipping_courier_name as label','shipping_courier_code','shipping_courier_id as value');
        if (!$id) {
            $data=$data->get()->toArray();
        }else{
            $data=$data->where('shipping_courier_id',$id)->first()->toArray();
        }
        // dd($data);
        return $data;
    }
}
