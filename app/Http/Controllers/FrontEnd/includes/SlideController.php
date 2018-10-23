<?php

namespace App\Http\Controllers\FrontEnd\Includes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        static $module = 0;     
        $banners = array();
        $results = $this->getBanner();
        // dd($results);
        foreach ($results as $result) {

            // if (is_file($result->image)) {
                $banners[] = array(
                    'banner_image_id' => $result->banner_image_id,
                    'title' => $result->title,
                    'link'  => $result->link,
                    //'image' => $this->resize($result->image, $setting->width, $setting->height)
                    'image' => $result->image
                );
            // }
        }

        $module = $module++;
        $data = array('data'=>$banners,'lang'=>Session::get('applangId'));
        return response()->json($data);
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
