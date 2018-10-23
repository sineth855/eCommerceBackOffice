<?php

namespace App\Http\Models\BackEnd\Category;

use Illuminate\Database\Eloquent\Model;

class CategoryPath extends Model
{
    protected $table = 'category_path';
    
    protected $fillable=[
    	'category_id',
        'path_id',
        'level'
		
    ];
    public $timestamps = false;
}
