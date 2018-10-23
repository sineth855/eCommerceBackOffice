<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Session;
use App;
use Auth;

class SettingConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    


    public function __construct()
    {
      
    }


    public function handle($request, Closure $next)
    {  
        // Auth::user()->id
        $store_id=isset($store_id) ? $store_id : 1 ;
        $SettingConfig = DB::table('setting')->where('store_id',$store_id)->get(); 
        foreach ($SettingConfig as $key => $value) {
            define($value->key, $value->value);
        }
        
        if(!Session::get('applangId')){
            session(['applangId' => config_language]);
        }
       return $next($request);
       
    }
}
