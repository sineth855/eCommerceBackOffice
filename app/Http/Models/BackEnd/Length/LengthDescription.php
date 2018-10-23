<?php

namespace App\Http\Models\BackEnd\Length;

use Illuminate\Database\Eloquent\Model;

class LengthDescription extends Model
{
    protected $table='length_class_description';
    protected $primaryKey='length_class_id';
    protected $fillable=[
    	'length_class_id',
    	'title',
    	'unit',
    	'language_id'
    ];
    public $timestamps=false;
}
