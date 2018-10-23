<?php

namespace App\Http\Models\BackEnd\Supplier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class SupplierToStore extends Model
{
    protected $table='supplier_to_store';
    public $timestamps=false;
    protected $fillable=[
    	'supplier_id',
        'store_id'
    ];
}
