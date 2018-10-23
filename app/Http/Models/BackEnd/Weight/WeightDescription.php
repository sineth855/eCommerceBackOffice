<?php

namespace App\Http\Models\BackEnd\Weight;

use Illuminate\Database\Eloquent\Model;

class WeightDescription extends Model
{
    protected $table='weight_class_description';
    protected $primaryKey='weight_class_id';
    protected $fillable=[
    	'weight_class_id',
    	'title',
    	'unit',
    	'language_id'
    ];
    public $timestamps=false;
}
