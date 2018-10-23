<?php

namespace App\Http\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
    protected $table = 'product_description';
	protected $primaryKey='product_id';
	 
	public $timestamps = false;
}
