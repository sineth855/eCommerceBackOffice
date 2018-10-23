<?php

namespace App\Http\Models\BackEnd\Currency;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table='currency';
    protected $primaryKey='currency_id';
    protected $fillable=[
    	'title',
    	'code',
    	'symbol_left',
    	'symbol_right',
    	'decimal_place',
    	'value',
    	'status',
    	'date_modified'
    ];
    public $timestamps=false;
}
