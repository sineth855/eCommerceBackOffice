<?php

namespace App\Http\Models\BackEnd\Category;

use Illuminate\Database\Eloquent\Model;

class CategoryToStore extends Model
{
    protected $primaryKey='category_id';
    protected $table = 'category_to_store';
    protected $fillable=[
		'store_id'
    ];
    public $timestamps = false;
}
