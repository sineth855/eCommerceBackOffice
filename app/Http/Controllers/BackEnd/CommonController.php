<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Test;
use App\Http\Requests\Admin\PositionRequest;
use Illuminate\Support\Facades\Input;
use App\Models\Admin\Position;
use DB;
use App\user;
use Carbon\Carbon;
use Auth;
use Session;
use Validator;
use rules;
use Redirect;

class CommonController extends Controller
{
	
	public $view_title = "Members <small> >> Position</small>";
	

    public function __construct()
    {   
    }   

    public function index()
    {
        return view('index');
    }

    public function list()
    {
        return view('index');
    }

    public function test()
    {
        $Test = Test::all();
        // return response()->json(['data' => $Test,'success' => false, 'message' => 'Unable to login'], 401);
        return view('frontend.index');
    }

    

    public function getTest()
    {
        // $Test = Test::all();

        // $tests = Test::paginate(5);
        $tests = Test::paginate(5);
        return response()->json($tests);
        // return response()->json(['data' => $items,'success' => false, 'message' => 'Unable to login'], 401);
        // return view('frontend.index');
    }

    public function getShow($id)
    {
        // $Test = Test::all();

        // $tests = Test::paginate(5);
        $tests = Test::Where('id',$id)->get();
        return response()->json($tests);
        // return response()->json(['data' => $items,'success' => false, 'message' => 'Unable to login'], 401);
        // return view('frontend.index');
    }

    public function UpdateApi(Request $request){
        Test::Where('id',$request->get('id'))->update(['name'=>$request->get('name')]);
        return response()->json(['request'=>$request->all(),'success' => true, 'message' => 'Updated successfully'], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.members.position.form')
        								->with('view_title',$this->view_title)
										->with('action',"Create");
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(PositionRequest $request)
    {
        Position::create($request->all());
        // return redirect("admin/members/position")->with('message',"Position => (".$request['name'].") has been created.");
        return redirect()->back()->with('message',"Position => (".$request['name'].") has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tests = Test::paginate(5);
        return response()->json($tests);
   
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Positions = Position::find($id);
        return view('Admin.members.position.form')->with('Positions',$Positions)
                                        ->with('view_title',$this->view_title)
                                        ->with('action',"Edit");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PositionRequest $request, $id)
    {
       $Position = Position::find($id);
       $Position->update($request->all());
       // return redirect("admin/members/position")->with('message',"Position => (".$request['name'].") has been modified.");
       return redirect()->back()->with('message',"Position => (".$request['name'].") has been modified.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Position::find($id)->delete();
        return redirect()->back()->with('message','Deleted Successfully');
    }

}
