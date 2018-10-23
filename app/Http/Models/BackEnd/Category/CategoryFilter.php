<?php

namespace App\Http\Models\BackEnd\Category;

use Illuminate\Database\Eloquent\Model;

class CategoryFilter extends Model
{
    protected $table = 'category_filter';
    
    protected $fillable=[
    	'category_id',
		'filter_id',
		
    ];
    public $timestamps = false;
}
