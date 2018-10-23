<?php

namespace App\Http\Models\BackEnd\Review;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table='review';
    public $timestamps = false;
    protected $primaryKey='review_id';
    protected $fillable=[
    	'product_id',
    	'customer_id',
    	'author',
    	'text',
        'rating',
        'status',
        'date_added',
        'date_modified'
    ];

    public function ProductDescription()
	{
		return $this->belongsTo('App\Http\Models\BackEnd\Product\ProductDescription','product_id');
	}

    public function Customer()
    {
    	return $this->belongsTo('App\Http\Models\BackEnd\Customer\Customer','customer_id');
    }
}
