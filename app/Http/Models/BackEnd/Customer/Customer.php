<?php

namespace App\Http\Models\BackEnd\Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Customer extends Model
{
    protected $table='customer';
    protected $primaryKey='customer_id';
    protected $fillable=[
        'firstname',
        'lastname',
        'email',
        'telephone',
        'password',
    	'sec_user_id',
    	'customer_group_id',
    	'store_id',
    	'language_id',
    	'cart',
    	'wishlist',
    	'newsletter',
    	'address_id',
        'custom_field',
        'ip',
        'status',
        'safe',
        'token',
        'code',
        'date_added'
    ];
    public $timestamps=false;
    static function CustomerList()
    {
        $Customers=DB::table('customer as cm')
            ->Join('customer_group as cmg','cm.customer_group_id','=','cmg.customer_group_id')
            ->Join('customer_group_description as cmgdesc','cmg.customer_group_id','=','cmgdesc.customer_group_id')
            // ->leftJoin('customer_ip as cmip','cm.customer_id','=','cmip.customer_id')
            ->select('cm.*',
                DB::RAW(
                    "concat(lastname,' ',firstname) as customer_name"
                ),
                'email',
                'cmgdesc.name as customer_group'
            )
            ->get();
            // 'cmip.ip',
        return $Customers;
    }
    static function customerByFilter($filter=array())
    {
        foreach($filter as $key=>$val){
            if($val==='' or $val===null){
                unset($filter[$key]);
            }
        }
        $Customers=DB::table('v_customers')
            ->select('*'            )
            ->where($filter)
            ->get();
        return $Customers;
    }
    static function Customer($id)
    {
        return DB::table('customer')->where('customer_id',$id);
    }
    static function CustomerAddress($cid){
        return DB::table('address')->where('customer_id',$cid);
    }
    static function CustomerEdit($id){
        $Customer=static::Customer($id)->get();
        foreach($Customer as $k=>$v){
            $address=static::CustomerAddress($v->customer_id)->get();
            $v->addressItem=$address->toArray();
        }
        return $Customer;
    }
    static function DeleteAddress($id)
    {
        $sql="DELETE addr
        FROM sg_customer cus JOIN sg_address addr
        ON cus.customer_id=addr.customer_id
        WHERE cus.customer_id='".$id."'";
        return DB::delete($sql);
    }
}
