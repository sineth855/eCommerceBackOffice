<?php

namespace App\Http\Controllers\BackEnd\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Product\ProductModel;
use App\Http\Models\BackEnd\Product\ProductDescription;
use App\Http\Models\BackEnd\Product\ProductAttribute;
use App\Http\Models\BackEnd\Product\ProductToCategory;
use App\Http\Models\BackEnd\Product\ProductToCarrier;
use App\Http\Models\BackEnd\Product\ProductToStore;
use App\Http\Models\BackEnd\Product\CategoryToStore;
use App\Http\Models\BackEnd\Category\CategoryModel;
use App\Http\Models\BackEnd\Manufacturer\Manufacturer;
use App\Http\Models\BackEnd\Filter\Filter;
use App\Http\Models\BackEnd\Carrier\Carrier;
use App\Http\Models\BackEnd\Product\ProductFilter;
use App\Http\Models\BackEnd\Product\ProductRelated;
use App\Http\Models\BackEnd\Product\ProductOption;
use App\Http\Models\BackEnd\Product\ProductOptionValue;
use App\Http\Models\BackEnd\Product\ProductDiscount;
use App\Http\Models\BackEnd\Product\ProductSpecial;
use App\Http\Models\BackEnd\Product\ProductImage;
use App\Http\Models\BackEnd\Option\OptionDescription;
// use App\Http\Controllers\BackEnd\commons\ImageMaker;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\BackEnd\commons\DataAction;
use DB;
use Auth;
use App\Helpers\common;

class ProductsController extends Controller
{
    public function __construct()
    {
        
    }
    public function index()
    {
        $Products = DB::table('product as p')
                    ->Join('product_description as pd','pd.product_id','p.product_id')
                    ->Join('product_to_store as p2s','p2s.product_id','p.product_id')
                    ->Where('pd.language_id',config_language_id)
                    ->Where('p2s.store_id',config_store_id)
                    ->OrderBy('p.date_modified','desc')
                    ->select('p.product_id','pd.name as product_name','p.model','p.image','p.price','p.quantity','p.sort_order','p.status')
                    ->get();
        return response()->json(['success'=>true, 'data'=>$Products, 'total'=>count($Products)]);
    }
   
    public function store(Request $request)
    {
        $product = (new ProductModel)->getFillable();
        $product = $request->only($product);
        $product['date_added'] = date('Y-m-d h:i:s');
        $product['date_modified'] = date('Y-m-d h:i:s');
        $product_id = ProductModel::insertGetId($product);

        if (isset($request['carrier']) && $request['carrier']) {
            # code...
            foreach ($request['carrier'] as $item) {
                $p2cr['product_id'] = $product_id;
                $p2cr['carrier_id'] = $item['carrier_id'];
                $p2cr['store_id'] = config_store_id;
                ProductToCarrier::insert($p2cr);
            }
        }

        if (isset($request['category']) && $request['category']) {
            # code...
            foreach ($request['category'] as $item) {
                $p2c['product_id']=$product_id;
                $p2c['category_id']=$item['category_id'];
                ProductToCategory::insert($p2c);
            }
        }

        if (isset($request['store']) && $request['store']) {
            # code...
            foreach ($request['store'] as $item) {
                $p2s['product_id']=$product_id;
                $p2s['store_id']=$item['store_id'];
                ProductToStore::insert($p2s);
            }
        }

        if (isset($request['filter']) && $request['filter']) {
            # code...
            foreach ($request['filter'] as $item) {
                $p2f['product_id']=$product_id;
                $p2f['filter_id']=$item['filter_id'];
                ProductFilter::insert($p2f);
            }
        }
        if (isset($request['related_product']) && $request['related_product']) {
            # code...
            foreach ($request['related_product'] as $item) {
                $p2r['product_id']=$product_id;
                $p2r['related_id']=$item['product_id'];
                ProductRelated::insert($p2r);
            }
        }

        if (isset($request['gallery']) && $request['gallery']) {
            $fill=(new ProductImage)->getFillable();
            foreach ($request['gallery'] as $item) {
                $data=array_only($item,$fill);
                $data['product_id']=$product_id;
                ProductImage::insert($data);
            }
        }

        if (isset($request['attribute']) && $request['attribute']) {
            foreach ($request['attribute'] as $item) {
                $pa['product_id']=$product_id;
                $pa['attribute_id']=$item['attribute_id'];
                $pa['text']=$item['text'];
                $pa['language_id'] = 1;
                ProductAttribute::insert($pa);
            }
        }

        if (isset($request['option']) && $request['option']) {
            $fill=(new ProductOption)->getFillable();
            foreach ($request['option'] as $item) {
                $data=array_only($item,$fill);
                $data['product_id']=$product_id;
                
                $product_option_id=ProductOption::insertGetId($data);
                $fill=(new ProductOptionValue)->getFillable();
                if ($item['checkItem']) {
                    foreach ($item['checkItem'] as $value) {
                        $data=array_only($value,$fill);
                        $data['product_option_id']=$product_option_id;
                        $data['product_id']=$product_id;
                        $data['option_id']=$item['option_id'];
                        ProductOptionValue::insert($data);
                    }
                }
            }
        }
        // dd($request['discount']);
        if (isset($request['discount']) && $request['discount']) {
            $fill=(new ProductDiscount)->getFillable();
            foreach ($request['discount'] as $item) {
                $data=array_only($item,$fill);
                $data['product_id']=$product_id;
                ProductDiscount::insert($data);
            }
        }


        if (isset($request['special']) && $request['special']) {
            $fill=(new ProductSpecial)->getFillable();
            foreach ($request['special'] as $item) {
                $data=array_only($item,$fill);
                $data['product_id']=$product_id;
                ProductSpecial::insert($data);
            }
        }
       
        $productDesc=(new ProductDescription)->getFillable();
        $productDesc = $request->only($productDesc);
        $productDesc['product_id'] = $product_id;
        $productDesc['language_id'] = config_language_id;
        return (new DataAction)->StoreData(ProductDescription::class,[],'',$productDesc);
    }
    public function edit($id)
    {
        $language_id=1;
        $Product['data']=ProductModel::find($id);
        $Product['general']=$Product['data']->Description()->first()->toArray();
        $Product['links']['attributes'] = ProductAttribute::where('product_id',$id)->get();
        $Product['discount']=ProductDiscount::where('product_id',$id)->get()->toArray();
        $Product['special']=ProductSpecial::where('product_id',$id)->get()->toArray();
        $Product['gallery']=ProductImage::where('product_id',$id)->get()->toArray();
        // $Product['links']['category_id']=array_pluck(ProductToCategory::where('product_id',$id)->get(['category_id'])->toArray(),'category_id');
        $Product['links']['category'] = CategoryModel::getCategoryBaseProductId($id);
        // $Product['links']['store_id']=array_pluck(ProductToStore::where('product_id',$id)->get(['store_id'])->toArray(),'store_id');
        $Product['links']['filter']=Filter::getFiltersBaseProductId($id);
        $Product['links']['related_product'] = ProductRelated::getRalatedProductBaseProductId($id);//array_pluck(ProductRelated::where('product_id',$id)->get(['related_id'])->toArray(),'related_id');
        $Product['links']['store'] = ProductModel::getStoreBaseProductId($id);//array_pluck(ProductRelated::where('product_id',$id)->get(['related_id'])->toArray(),'related_id');
        $Product['links']['carrier'] = Carrier::getCarrierBaseProductId($id);//array_pluck(ProductRelated::where('product_id',$id)->get(['related_id'])->toArray(),'related_id');
        // $Product['links']['downloads']=ProductRelated::where('product_id',$id)->get('downloads')->toArray();
        $Product['option']=ProductOption::where('product_id',$id)->get()->toArray();
        foreach ($Product['option'] as $key => $value) {
            $Product['option'][$key]['text']=strtolower(OptionDescription::where('option_id',$value['option_id'])->where('language_id',$language_id)->value('name'));
            if ($value) {
                $checkItem=ProductOptionValue::where('product_id',$id)->where('product_option_id',$value['product_option_id'])->get()->toArray();
                    $Product['option'][$key]['checkItem']=$checkItem;
            }
        }
        // [{"text":"textarea","option_id":6,"required":1,"value":null,"checkItem":[]}]
        // foreach ($request['option'] as $item) {
        //     $data=array_only($item,$fill);
        //     $data['product_id']=$product_id;
        //     if (isset($data['option_id'])) {
        //         $product_option_id=ProductOption::insertGetId($data);
        //         $fill=(new ProductOptionValue)->getFillable();
        //         if (isset($item['checkItem'])) {
        //             foreach ($item['checkItem'] as $value) {
        //                 $data=array_only($value,$fill);
        //                 $data['product_option_id']=$product_option_id;
        //                 $data['product_id']=$product_id;
        //                 $data['option_id']=$item['option_id'];
        //                 ProductOptionValue::insert($data);
        //             }
        //         }
        //     }
        // }
        $Product['special']=ProductSpecial::where('product_id',$id)->get()->toArray();
        // dd($Product);
        return $Product;
    }
    public function update(Request $request, $product_id)
    {
        $product = (new ProductModel)->getFillable();
        $product = $request->only($product);
        $product['date_modified'] = date('Y-m-d h:i:s');

        ProductModel::find($product_id)->update($product);
        // ProductOptionValue::where('product_id',$product_id)->delete();

        if (isset($request['carrier']) && $request['carrier']) {
            ProductToCarrier::where('product_id',$product_id)->delete();
            # code...
            foreach ($request['carrier'] as $item) {
                $p2cr['product_id'] = $product_id;
                $p2cr['carrier_id'] = $item['carrier_id'];
                $p2cr['store_id'] = config_store_id;
                ProductToCarrier::insert($p2cr);
            }
        }

        if (isset($request['category']) && $request['category']) {
            ProductToCategory::where('product_id',$product_id)->delete();
            # code...
            foreach ($request['category'] as $item) {
                $p2c['product_id']=$product_id;
                $p2c['category_id']=$item['category_id'];
                ProductToCategory::insert($p2c);
            }
        }

        if (isset($request['store']) && $request['store'] != '') {
            ProductToStore::where('product_id',$product_id)->delete();
            # code...
            foreach ($request['store'] as $item) {
                $p2s['product_id']=$product_id;
                $p2s['store_id']=$item['store_id'];
                ProductToStore::insert($p2s);
            }
        }

        if (isset($request['filter']) && $request['filter'] != '') {
            ProductFilter::where('product_id',$product_id)->delete();
            # code...
            foreach ($request['filter'] as $item) {
                $p2f['product_id']=$product_id;
                $p2f['filter_id']=$item['filter_id'];
                ProductFilter::insert($p2f);
            }
        }
        if (isset($request['related_product']) && $request['related_product'] != '') {
            ProductRelated::where('product_id',$product_id)->delete();
            # code...
            foreach ($request['related_product'] as $item) {
                $p2r['product_id']=$product_id;
                $p2r['related_id']=$item['product_id'];
                ProductRelated::insert($p2r);
            }
        }
        if (isset($request['gallery']) && $request['gallery'] != '') {
            ProductImage::where('product_id',$product_id)->delete();
            $fillGallary=(new ProductImage)->getFillable();
            foreach ($request['gallery'] as $item) {
                $imageGallary=array_only($item,$fillGallary);
                $imageGallary['product_id']=$product_id;
                ProductImage::insert($imageGallary);
            }
        }

        if (isset($request['attribute']) && $request['attribute'] != '') {
            ProductAttribute::where('product_id',$product_id)->delete();
            foreach ($request['attribute'] as $item) {
                $pa['product_id']=$product_id;
                $pa['attribute_id'] = $item['attribute_id'];
                $pa['text'] = $item['text'];
                $pa['language_id']=config_language_id;
                ProductAttribute::insert($pa);
            }
        }

        if (isset($request['option']) && $request['option'] != '') {
            ProductOption::where('product_id',$product_id)->delete();
            $fillOption=(new ProductOption)->getFillable();
            foreach ($request['option'] as $item) {
                $data=array_only($item,$fillOption);
                $data['product_id']=$product_id;
                
                $product_option_id=ProductOption::insertGetId($data);
                $fillOptionValue=(new ProductOptionValue)->getFillable();
                if ($item['checkItem']) {
                    foreach ($item['checkItem'] as $value) {
                        $data=array_only($value,$fillOptionValue);
                        $data['product_option_id']=$product_option_id;
                        $data['product_id']=$product_id;
                        $data['option_id']=$item['option_id'];
                        ProductOptionValue::insert($data);
                    }
                }
            }
        }

        if (isset($request['discount']) && $request['discount'] != '') {
            ProductDiscount::where('product_id',$product_id)->delete();
            $fillDiscount=(new ProductDiscount)->getFillable();
            foreach ($request['discount'] as $itemDiscount) {
                $dataDiscount=array_only($itemDiscount,$fillDiscount);
                $dataDiscount['product_id']=$product_id;
                ProductDiscount::insert($dataDiscount);
            }
        }


        if (isset($request['special']) && $request['special'] != '') {
            ProductSpecial::where('product_id',$product_id)->delete();
            $fillSpecial=(new ProductSpecial)->getFillable();
            foreach ($request['special'] as $itemSpecial) {
                $dataSpecial=array_only($itemSpecial,$fillSpecial);
                $dataSpecial['product_id']=$product_id;
                ProductSpecial::insert($dataSpecial);
            }
        }
        
        $productDesc=(new ProductDescription)->getFillable();
        $productDesc = $request->only($productDesc);
        $productDesc['product_id'] = $product_id;
        $productDesc['language_id'] = config_language_id;
        ProductDescription::where('product_id', $product_id)->update($productDesc);
        $manufacturer = Manufacturer::find($request['manufacturer_id']);
        $product_link = '/product/'.common::strReplace($request['name']).'-'.$product_id.'-0';
        return response()->json([
            'success'=>true,
            'product_id'=>$product_id,
            'product_link'=>$product_link,
            'manufacturer'=>$manufacturer,
            'data'=>$request->all(),
            'message'=>'Data successfully updated.'
        ]);
        // return (new DataAction)->UpdateData(ProductDescription::class,$productDesc,'product_id',$product_id);
    }
    public function destroy($id)
    {
        return ProductModel::DeleteProduct($id);
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
}
