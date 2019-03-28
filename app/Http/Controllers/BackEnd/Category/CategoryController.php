<?php
namespace App\Http\Controllers\BackEnd\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Category\CategoryModel;
use App\Http\Models\BackEnd\Category\CategoryDescription;
use App\Http\Models\BackEnd\Category\CategoryType;
use App\Http\Models\BackEnd\Category\CategoryPath;
use App\Http\Controllers\BackEnd\commons\DataAction;
use App\Http\Controllers\BackEnd\commons\ImageMaker;
use App\Http\Models\BackEnd\Category\CategoryFilter;
use App\Http\Models\BackEnd\Category\CategoryToStore;
use Illuminate\Support\Facades\DB;
class CategoryController extends Controller
{
    public function index()
    {
        // $sql = "SELECT cp.category_id AS category_id, 
        // GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, 
        // c1.parent_id, c1.sort_order 
        // FROM " . DB_PREFIX . "category_path cp
        // LEFT JOIN " . DB_PREFIX . "category c1 ON (cp.category_id = c1.category_id) 
        // LEFT JOIN " . DB_PREFIX . "category c2 ON (cp.path_id = c2.category_id) 
        // LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id) 
        // LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) 

        // WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND 
        // cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";
        // $cc = "SELECT GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name";
        // $sql = DB::table('category as c')
        //        ->Join('category as c1','c.category_id','=','c1.category_id')
        //        ->Join('category_description as cd','c1.category_id','=','cd.category_id')
        //        ->WHERE('cd.language_id', config_language_id)
        //     //    ->Select('cp.category_id AS category_id','c.sort_order')
        //        ->Select(DB::raw($cc))
        //        ->get();

        // $sql = "SELECT c.category_id AS category_id, GROUP_CONCAT(cd.name SEPARATOR 'ss&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c.parent_id, c.sort_order FROM sg_category c LEFT JOIN sg_category_description cd ON (c.category_id = cd.category_id) WHERE cd.language_id = '" . config_language_id . "' GROUP BY c.category_id";
        $sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' > ') AS name, c1.status, c1.parent_id, c1.sort_order FROM sg_category_path cp LEFT JOIN sg_category c1 ON (cp.category_id = c1.category_id) LEFT JOIN sg_category c2 ON (cp.path_id = c2.category_id) LEFT JOIN sg_category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN sg_category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . config_language_id . "' AND cd2.language_id = '" . config_language_id . "' GROUP BY cp.category_id ORDER BY c1.category_id DESC";
        $info = DB::select(DB::raw($sql));

        // dd($info);
		// if (!empty($data['filter_name'])) {

		// 	$sql .= " AND cd2.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";

		// }



		// // $sql .= $sql->GROUPBY('cp.category_id');



		// $sort_data = array(

		// 	'name',

		// 	'sort_order'

		// );



		// if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {

		// 	$sql .= " ORDER BY " . $data['sort'];

		// } else {

		// 	$sql .= " ORDER BY sort_order";

		// }


		// if (isset($data['order']) && ($data['order'] == 'DESC')) {

		// 	$sql .= " DESC";

		// } else {

		// 	$sql .= " ASC";

        // }
        
        // // $data = collect($sql)->get();
        // // $data=CategoryModel::OrderBy('category_id','desc')->get();
        // // foreach ($data as $value) {
        // //     $value->type=$value->CategoryType()->value('name');
        // //     $value->name=$value->Description()->value('name');
        // //     if ($value->parent_id) {
        // //         $value->parent_name=CategoryModel::find($value->parent_id)->Description()->value('name');
        // //     }
        // // }
        return response()->json(['success'=>true,'data'=>$info,'total'=>count($info)]);
    }
    public function show($id){
        return response()->json([]);
    }
    public function store(Request $request)
    {
        // $data = (new CategoryModel)->getFillable();
        // $request['image']=(new ImageMaker)->base64ToImage('images\\icon',$request['image']);
        // $request['date_added']=date('Y-m-d');
        // $request['date_modified']=date('Y-m-d');
        // // Insert Category Filter
        // $data = $request->only($data);
        // CategoryModel::find($request['category_id'])->update($data);
        // $data = (new CategoryDescription)->getFillable();
        // $data = $request->only($data);
        // return (new DataAction)->UpdateData(CategoryDescription::class,$data,'category_id',$request['category_id']);

        $fill=(new CategoryModel)->getFillable();
        $data=$request->only($fill);
        $category = CategoryModel::insertGetId($data);

        if (isset($request['filter']) && $request['filter']) {
            # code...
            foreach ($request['filter'] as $item) {
                $c2f['category_id'] = $category;
                $c2f['filter_id'] = $item['id'];
                CategoryFilter::insert($c2f);
            }
        }

        if (isset($request['store']) && $request['store']) {
            # code...
            foreach ($request['store'] as $item) {
                $c2s['category_id'] = $category;
                $c2s['store_id'] = $item['id'];
                CategoryToStore::insert($c2s);
            }
        }

        $level = 0;
        $query = CategoryPath::where('category_id',$request['parent_id'])->OrderBy('level','ASC')->get();
        foreach ($query as $result) {
            CategoryPath::create([
                'category_id' => $category,
                'path_id' => $result->path_id,
                'level' => $level
            ]);
            $level++;
        }
        CategoryPath::create([
            'category_id' => $category,
            'path_id' => $category,
            'level' => $level
        ]);

        //Data for Category description
        $categoryDesc = (new CategoryDescription)->getFillable();
        $categoryDesc = $request->only($categoryDesc);
        $categoryDesc['category_id'] = $category;
        $categoryDesc['language_id'] = config_language_id;
        // return (new DataAction)->UpdateData(CategoryDescription::class,$categoryTypeDesc,'category_id',$id);
        return (new DataAction)->StoreData(CategoryDescription::class,[],'',$categoryDesc);

        // if ($request->has('category_id')) {
        //     CategoryModel::find($request['category_id'])->update($data);
        //     $data = (new CategoryDescription)->getFillable();
        //     $data = $request->only($data);
        //     return (new DataAction)->UpdateData(CategoryDescription::class,$data,'category_id',$request['category_id']);
        // }else{
        //     $request['category_id']=CategoryModel::insertGetId($data); 
        //     $data = (new CategoryDescription)->getFillable();
        //     $data = $request->only($data);

            
        //     if (isset($request['category_id'])) {
        //         # code...
        //         foreach ($request['filter'] as $item) {
        //             $p2f['category_id']=$request['category_id'];
        //             $p2f['filter_id']=$item['id'];
        //             CategoryFilter::insert($p2f);
        //         }
        //     }

        //     if (isset($request['category_id'])) {
        //         # code...
        //         foreach ($request['filter'] as $item) {
        //             $p2f['category_id']=$request['category_id'];
        //             $p2f['filter_id']=$item['id'];
        //             CategoryFilter::insert($p2f);
        //         }
        //     }

        //     return (new DataAction)->StoreData(CategoryDescription::class,[],'',$data);
        // }
    }
    public function edit($id)
    {
        // $data=CategoryModel::find($id)->toArray();
        // $description=CategoryModel::find($id)->Description()->first()->toArray();
        // foreach ($description as $key=>$value) {
        //     $data[$key]=$value;
        // }
        // // return $data;
        $query = "SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') 
        FROM sg_category_path cp LEFT JOIN sg_category_description cd1 
        ON (cp.path_id = cd1.category_id AND cp.category_id != cp.path_id) 
        WHERE cp.category_id = c.category_id AND cd1.language_id = '" . (int)config_language_id . "' 
        GROUP BY cp.category_id) AS path, (SELECT DISTINCT keyword FROM sg_url_alias 
        WHERE query = 'category_id=" . (int)$id . "') AS keyword FROM sg_category c 
        LEFT JOIN sg_category_description cd2 ON (c.category_id = cd2.category_id) 
        WHERE c.category_id = '" . (int)$id . "' AND cd2.language_id = '" . (int)config_language_id . "'";
        // dd($query);
        $data['general'] = DB::select(DB::raw($query))[0];
        $data['filter'] = CategoryModel::getFilterBaseCategoryId($id);
        $data['store'] = CategoryModel::getStoreBaseCategoryId($id);
        return response()->json(['success'=>true,'data'=>$data]);
        
    }
    public function update(Request $request,$id)
    {
         //data for Category value
        $fill=(new CategoryModel)->getFillable();
        $data=$request->only($fill);
        CategoryModel::find($id)->update($data);

        CategoryFilter::where('category_id',$id)->delete();
        if (isset($request['filter']) && $request['filter']) {
            # code...
            foreach ($request['filter'] as $item) {
                $c2f['category_id'] = $id;
                $c2f['filter_id'] = $item['id'];
                CategoryFilter::insert($c2f);
            }
        }

        CategoryToStore::where('category_id',$id)->delete();
        if (isset($request['store']) && $request['store']) {
            # code...
            foreach ($request['store'] as $item) {
                $c2s['category_id']=$id;
                $c2s['store_id'] = $item['id'];
                CategoryToStore::insert($c2s);
            }
        }

        $CategoryPath = CategoryPath::where('path_id',$id)->get();
        if($CategoryPath){
            foreach ($CategoryPath as $category_path) {
                CategoryPath::where('category_id', $category_path->category_id)
                              ->where('level','<', $category_path->level)
                              ->delete();
                $path = array();
                $query = CategoryPath::where('category_id',$request['parent_id'])
                                        ->OrderBy('level', 'ASC')
                                        ->get();
                
                foreach ($query as $result) {
                    $path[] = $result->path_id;
                }

                $query = CategoryPath::where('category_id',$category_path->category_id)
                                        ->OrderBy('level', 'ASC')
                                        ->get();
            
                foreach ($query as $result) {
                    $path[] = $result->path_id;
                }

                $level = 0;

                foreach ($path as $path_id) {
					DB::select(DB::raw("REPLACE INTO `" . env("DB_PREFIX") . "category_path` SET category_id = '" . (int)$category_path->category_id . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'"));
					$level++;
				}

            }
        }else{
            CategoryPath::where('category_id', $id)->delete();
            $level = 0;
            $query = CategoryPath::where('category_id', $request['parent_id'])
                                    ->OrderBy('level','ASC')
                                    ->get();
            
            foreach ($query as $result) {
                CategoryPath::create([
                    'category_id' => $id,
                    'path_id' => $result->path_id,
                    'level' => $level
                ]);
                $level++;
            }
            DB::select(DB::raw("REPLACE INTO `" . env("DB_PREFIX") . "category_path` SET category_id = '" . (int)$id . "', `path_id` = '" . (int)$id . "', level = '" . (int)$level . "'"));
        }

        //Data for Category description
        $fillCategoryDes=(new CategoryDescription)->getFillable();
        $categoryTypeDesc=$request->only($fillCategoryDes);

        return (new DataAction)->UpdateData(CategoryDescription::class,$categoryTypeDesc,'category_id',$id);
    }
    public function destroy($id)
    {
        //CategoryModel::where('parent_id',$id)->update(['parent_id'=>0]);
        CategoryDescription::where('category_id',$id)->delete();
        CategoryFilter::where('category_id',$id)->delete();
        CategoryPath::where('category_id',$id)->delete();
        CategoryToStore::where('category_id',$id)->delete();
        return (new DataAction)->DeleteData(CategoryModel::class,'category_id',$id);
        
    }
    public function getCategoriesList()
    {
        $language_id=config_language_id;
        return CategoryDescription::select('category_id as value','name as text')->where('language_id',$language_id)->get();
    }
    public function getCategoriesType()
    {
        return CategoryType::select('category_type_id as value','name as text')->get();
    }
    public function getCategoriesParent()
    {
        // $data=CategoryModel::select('category_id')->Parent()->Active()->get();
        // foreach ($data as $value) {
        //     $value->text=$value->Description()->value('name');
        //     $value->value=$value->category_id;
        // }
        // return $data;
        $data = DB::table('category')
                ->Join('category_description','category.category_id','=','category_description.category_id')
                ->select('category.category_id as value','category_description.name as text','category.category_type_id')
                // ->where('category.category_type_id',intval($id))
                ->get();
        return $data;
    }
    public function menu()
    {
        return CategoryModel::getAllCategories()->groupBy('type')->toArray();
    }
}