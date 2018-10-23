<?php

namespace App\Http\Models\BackEnd\Tax\TaxClass;

use Illuminate\Database\Eloquent\Model;


class TaxClass extends Model
{
    protected $table='tax_class';
    protected $primaryKey='tax_class_id';
    protected $fillable=[
    	'title',
    	'description',
    	'date_added',
    	'date_modified'
    ];
    public $timestamps=false;
}
