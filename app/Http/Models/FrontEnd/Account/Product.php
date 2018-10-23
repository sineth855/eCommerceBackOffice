<?php

namespace App\Http\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
	protected $primaryKey='product_id';
	protected $fillable = [
						'product_id',
						'date_added'
					];
	public $timestamps = false;
}