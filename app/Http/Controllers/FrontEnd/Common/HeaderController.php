<?php

namespace App\Http\Controllers\FrontEnd\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Auth;
use DB;

class HeaderController extends Controller
{
    public function __construct()
    {
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $session_id=$input['session_id'];
        if (Auth::guard('account')->id()) {
            $customer_id=Auth::guard('account')->id();
            DB::table('cart')->where('session_id',$session_id)->update(['customer_id'=>Auth::guard('account')->id()]);
        }
        // dd($this->data['customer_id']);
        //Menu
        // $this->load->model('catalog/category');
        // $this->load->model('catalog/product');
        $cateTypeArr = array();
        $category_type = $this->getTypeCategory();
        foreach ($category_type as $ctype) {
            $cateArr = array();
            $categories = $this->getCategories(0,$ctype->category_type_id);
            foreach ($categories as $category) {
                if ($category->top) {
                    // Level 2
                    $children_data = array();
                    $children = $this->getCategories($category->category_id,$category->category_type_id);
                    foreach ($children as $child) {
                        $filter_data = array(
                            'filter_category_id'  => $child->category_id,
                            'filter_sub_category' => true
                        );

                        $children_data[] = array(
                            'name'  => $child->name,
                            'href'  => '/product/category_product/'.$child->category_id
                            // 'path=' . $category->category_id . '_' . $child->category_id
                        );
                    }

                    // Level 1
                    $cateArr[] = array(
                        'name'     => $category->name,
                        'children' => $children_data,
                        'column'   => $category->column ? $category->column: 1,
                        //'href'     => $this->url->link('product/category', 'path=' . $category->category_id)
                        'href'     => '/product/category_product/' . $category->category_id
                    );
                }
            }

            $cateTypeArr[] = array(
                'name' => $ctype->name,
                'categories' => $cateArr
            );
        }
        
        $data = array('data'=>$cateTypeArr,'success'=>true, 'lang'=>Session::get('applangId'));

        return response()->json($data);
    }

}
