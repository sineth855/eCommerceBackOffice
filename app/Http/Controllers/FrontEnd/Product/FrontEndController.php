<?php

namespace App\Http\Controllers\FrontEnd\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\FrontEnd\SessionModel;
class FrontEndController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('frontend.index');
    }

     /**
     * Display proudct Details.
     *
     * @return \Illuminate\Http\Response
     */
    public function product_detail()
    {
        return view('frontend.product_detail');
    }

    /**
     * Pop up Ajax Product.
     *
     * @return \Illuminate\Http\Response
     */

    public function ajax_product(){
        return view('frontend.common.ajax.product');
    }

    /**
     * Display Order Status.
     *
     * @return \Illuminate\Http\Response
     */
    public function order_status(){

        return view('frontend.order_status');
    }
    /**
     * Display Order list.
     *
     * @return \Illuminate\Http\Response
     */
    public function order_lists(){

        return view('frontend.order_lists');
    }
    /**
     * Display Owish_lists.
     *
     * @return \Illuminate\Http\Response
     */
    public function wish_lists(){

        return view('frontend.wish_lists');
    }
      /**
     * Display cart
     *
     * @return \Illuminate\Http\Response
     */
    public function cart_view()
    {
        return view('frontend.common.cart.cart_view');
    }
      /**
     * Display Cusotmer Address
     *
     * @return \Illuminate\Http\Response
     */
    public function customer_address()
    {
        return view('frontend.customer_address');
    }

        /**
     * Display add Address
     *
     * @return \Illuminate\Http\Response
     */
    public function add_address()
    {
        return view('frontend.add_address');
    }

    /**
     * Display add Address
     *
     * @return \Illuminate\Http\Response
     */
    public function account()
    {
        return view('frontend.account_1');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
