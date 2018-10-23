<?php
namespace App\Http\Controllers\BackEnd\CategoryType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\CategoryType\CategoryTypeDescription;
use App\Http\Models\BackEnd\CategoryType\CategoryType;
use App\Http\Controllers\BackEnd\commons\DataAction;
use App\Http\Controllers\BackEnd\commons\ImageMaker;
class CategoryTypeController extends Controller
{
     public function index()
    {
        $CategoryType=CategoryType::AllCategoryType();
        return response()->json(['success'=>true,'data'=>$CategoryType,'total'=>count($CategoryType)]);
    }
    public function show($id){
        return response()->json([]);
    }
    public function store(Request $request)
    {
        $data = (new CategoryType)->getFillable();
        $request['date_added']=date('Y-m-d');
        $request['date_modified']=date('Y-m-d');
        $data = $request->only($data);
        if ($request->has('category_type_id')) {
            CategoryType::find($request['category_type_id'])->update($data);
            $data = (new CategoryTypeDescription)->getFillable();
            $data = $request->only($data);
            return (new DataAction)->UpdateData(CategoryTypeDescription::class,$data,'category_type_id',$request['category_type_id']);
        }else{
            $request['category_type_id']=CategoryType::insertGetId($data); 
            $data = (new CategoryTypeDescription)->getFillable();
            $data = $request->only($data);
            return (new DataAction)->StoreData(CategoryTypeDescription::class,[],'',$data);
        }
    }
     public function edit($id)
    {
        // dd("Hello wrold!");
        $CategoryType = CategoryType::CategoryTypeEdit($id);
        foreach($CategoryType as $value){
            $categoryType=$value;
        }
        return response()->json(['success'=>true,'data'=>$CategoryType[0],'total'=>count($CategoryType)]);
    }
    public function update(Request $request,$id)
    {
        // dd($request->all());
         //data for Category value
        $CategoryType=(new CategoryType)->getFillable();
        $CategoryType=$request->only($CategoryType);
        //Data for Category description
        $categoryTypeDesc=(new CategoryTypeDescription)->getFillable();
        $categoryTypeDesc=$request->only($categoryTypeDesc);
        $categoryTypeDesc['language_id'] = config_language_id;

        $saveCategoryType = (new DataAction)->UpdateData(CategoryType::class,$CategoryType,'category_type_id',$id);
        return (new DataAction)->UpdateData(CategoryTypeDescription::class,$categoryTypeDesc,'category_type_id',$id);

    } 
     public function destroy($id)
    {
        CategoryType::where('parent_id',$id)->update(['parent_id'=>0]);
        return (new DataAction)->DeleteData(CategoryType::class,'category_type_id',$id);
        
    }

}