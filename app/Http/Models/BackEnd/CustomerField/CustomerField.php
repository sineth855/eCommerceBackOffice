<?php

namespace App\Http\Models\BackEnd\CustomerGroup;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class CustomerGroup extends Model
{
    protected $table='custom_field';
    protected $primaryKey='custom_field_id';
    protected $fillable=[
    	'approval',
    	'sort_order'
    ];
    public $timestamps=false;
}
