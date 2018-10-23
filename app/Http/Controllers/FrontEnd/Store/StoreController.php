<?php

    namespace App\Http\Controllers\FrontEnd\Store;

    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use App\Http\Models\FrontEnd\Account\Address;
    use App\Http\Models\FrontEnd\Account\Customer;
    use App\Http\Models\FrontEnd\Category;
    use Carbon\Carbon;
    use DB;
    use Auth;
    use Session;

    class StoreController extends Controller
    {
        /**
         * Display a listing of the BestSeller Create On 01-02-2018
         *
         * @return \Illuminate\Http\Response
         */

        public function __construct(){
            // $this->middleware('auth:account');
            // $this->middleware('auth:customer', ['except' => ['logout']]);
        }

        public function index(Request $request){
            $input = $request->all();
            $store_id = $input['store_id'];
            $filter_name = $input['filter_name'];
            $StoreData = DB::table('setting')
                        ->Where('store_id',$store_id)->get();
            $data = [];
            $str = '';
            foreach ($StoreData as $key => $value) {
                define('store_'.$value->key, $value->value);
            }
            $data['store'] = array(
                'config_name'=>store_config_name,
                'config_image'=>store_config_image,
                'config_email'=>store_config_email,
                'config_url'=>store_config_url
            );
            
            $filter_data = array(
                // 'branch' => $branch,
                // 'size' => $size,
                // 'color' => $color,
                'store_id'           => $input['store_id'],
                // 'filter_category_id' => $category_id,
                // 'filter_filter'      => $filter,
                // 'sort'               => $sort,
                // 'order'              => $order,
                'filter_name'         => $filter_name,
                // 'start'              => ($page - 1) * $limit,
                // 'limit'              => $limit

            );
            // get product by store
            $data['getProductByStore'] = $this->getProductByStore($filter_data);
            $data['total_product'] = Category::getTotalProducts($filter_data);
            return response()->json($data);
        }

        public function getProductByStore($data=array()){
            $sql = DB::table('product')
                    ->select(DB::raw('DISTINCT *'),'product.product_id','product_description.name as name','product.image','manufacturer.name AS manufacturer',DB::raw('(SELECT price FROM sg_product_discount pd2 WHERE pd2.product_id = sg_product.product_id AND pd2.customer_group_id = 1 AND pd2.quantity = 1 AND ((pd2.date_start = 0000-00-00 OR pd2.date_start < NOW()) AND (pd2.date_end = 0000-00-00 OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC
                            , pd2.price ASC LIMIT 1) AS discount'),DB::raw('(SELECT price FROM sg_product_special ps WHERE ps.product_id = sg_product.product_id AND ps.customer_group_id = 1 AND ((ps.date_start = 0000-00-00 OR ps.date_start < NOW()) AND (ps.date_end = 0000-00-00 OR ps.date_end > NOW())) ORDER BY ps.priority ASC
                            , ps.price ASC LIMIT 1) AS special'),DB::raw('(SELECT points FROM sg_product_reward pr WHERE pr.product_id = sg_product.product_id AND customer_group_id = 1) AS reward'),DB::raw('(SELECT ss.name FROM sg_stock_status ss WHERE ss.stock_status_id = sg_product.stock_status_id AND ss.language_id = 1 ) AS stock_status'),DB::raw('(SELECT wcd.unit FROM sg_weight_class_description wcd WHERE sg_product.weight_class_id = wcd.weight_class_id AND wcd.language_id = 1 ) AS weight_class'),DB::raw('(SELECT lcd.unit FROM sg_length_class_description lcd WHERE sg_product.length_class_id = lcd.length_class_id AND lcd.language_id = 1 ) AS length_class'),DB::raw('(SELECT AVG(rating) AS total FROM sg_review r1 WHERE r1.product_id = sg_product.product_id AND r1.status = 1 GROUP BY r1.product_id) AS rating'),DB::raw('(SELECT COUNT(*) AS total FROM sg_review r2 WHERE r2.product_id = sg_product.product_id AND r2.status = 1 GROUP BY r2.product_id) AS reviews'),'product.sort_order')
                    ->leftJoin('product_description','product.product_id','=','product_description.product_id')
                    ->leftJoin('product_to_store','product.product_id','=','product_to_store.product_id')
                    ->leftJoin('manufacturer','manufacturer.manufacturer_id','=','product.manufacturer_id')
                    ->join('product_to_category','product.product_id','=','product_to_category.product_id')
                    // ->join('category','category.category_id',$category_id)
                    // ->join('category_description','category_description.category_id',$category_id)
                    // ->where('category_description.language_id',1)
                    // ->where('product.product_id',$product_id)
                    ->where('product_description.language_id',1)
                    ->where('product.status',1)
                    ->where('product.date_available','<=',Carbon::today())
                    ->where('product_to_store.store_id',$data['store_id']);

            if (isset($data['filter_name']) && $data['filter_name']=='price-asc') {
                $sql->OrderBy("product.price","ASC");
            } else if(isset($data['filter_name']) && $data['filter_name']=='price-desc') {
                $sql->OrderBy("product.price","DESC");
            }
    
            if (isset($data['filter_name']) && $data['filter_name']=='name-asc') {
                $sql->OrderBy("product_description.name","ASC");
            } else if(isset($data['filter_name']) && $data['filter_name']=='name-desc') {
                $sql->OrderBy("product_description.name","DESC");
            }

            return($sql->get());
        }

        public function edit($id){

        }

        public function destroy(){

        }

        public function store(){

        }

    }