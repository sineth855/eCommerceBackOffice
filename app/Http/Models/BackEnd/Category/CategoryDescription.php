<?php

namespace App\Http\Models\BackEnd\Category;

use Illuminate\Database\Eloquent\Model;

class CategoryDescription extends Model
{
    protected $table = 'category_description';
    // protected $primaryKey='category_id';
    protected $fillable=[
    	'category_id',
		'language_id',
		'name',
		'description',
		'meta_title',
		'meta_description',
		'meta_keyword',
    ];
    public $timestamps = false;
}
