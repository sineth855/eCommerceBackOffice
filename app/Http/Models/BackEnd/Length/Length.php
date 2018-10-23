<?php

namespace App\Http\Models\BackEnd\Length;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Length extends Model
{
  protected $table='length_class';
  protected $primaryKey='length_class_id';
  protected $fillable=[
  	'value'
  ];
  public $timestamps=false;

  static function AllLengths()
  {
      $Length=DB::table('length_class')
                ->leftJoin('length_class_description','length_class.length_class_id','=','length_class_description.length_class_id')
                ->leftJoin('language','language.language_id','=','length_class_description.language_id')
                ->select('length_class.length_class_id','length_class_description.title','length_class.value','language.name as language','unit')
                ->get();
      return $Length;
  }

  static function LengthEdit($id)
  {
      $Length=DB::table('length_class')
                ->leftJoin('length_class_description','length_class.length_class_id','=','length_class_description.length_class_id')
                ->select('length_class.length_class_id','length_class_description.title','length_class.value','length_class_description.language_id','unit')
                ->where('length_class.length_class_id',$id)
                ->get();
      return $Length;
  }

}