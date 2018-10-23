<?php

namespace App\Http\Models\FrontEnd\Product;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'review';
    protected $primarykey='review_id';
	protected $fillable = [
						'review_id',
						'product_id',
						'customer_id',
						'author',
						'text',
						'rating',
						'status',
						'date_added',
						'date_modified'
					];
	public $timestamps = false;	
}
