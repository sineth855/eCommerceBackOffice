<?php

namespace App\Http\Models\BackEnd\Download;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Download extends Model
{
    protected $table='download';
    protected $primaryKey='download_id';
    protected $fillable=[
    	'filename',
    	'mask',
    	'date_added'
    ];
    public $timestamps=false;

    static function AllDownloads()
    {
    	$Downloads=DB::table('download')
                  ->leftJoin('download_description','download.download_id','=','download_description.download_id')
                  ->leftJoin('language','download_description.language_id','=','language.language_id')
                  ->select('download.download_id','download.filename','download.mask','download.date_added','language.name as language','download_description.name as description')
                  ->get();
        return $Downloads;
    }
}
