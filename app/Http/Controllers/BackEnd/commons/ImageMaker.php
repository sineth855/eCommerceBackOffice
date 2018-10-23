<?php
	namespace App\Http\Controllers\BackEnd\commons;

	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	class ImageMaker extends Controller
	{
		public function base64ToImage($pathToStore,$imageName)
		{
		   	$imageData='';
			$file_data = $imageName; 
			
		    if(strlen($imageName)>300){
		    	$file_name = uniqid().'.png'; //generating unique file name; 
				@list($type, $file_data) = explode(';', $file_data);
				@list(, $file_data) = explode(',', $file_data); 
				if($file_data!=""){ 
			   		$image = public_path() . "\\".$pathToStore."\\" . $file_name;
			   		$imageData="\\".$pathToStore."\\" . $file_name;
			        file_put_contents($image,base64_decode($file_data)); 
			    } 
		    }else{
		    	$imageData=$imageName;
		    }
		    return $imageData;
		}
		public function deleteFile($filename)
		{
	        $filepath = public_path().$filename;
	        $fileDelete=\File::delete($filepath);
	        return $fileDelete;
		}
		public function check_base64_image($base64) {
		    $img = imagecreatefromstring(base64_decode($base64));
		    if (!$img) {
		        return false;
		    }

		    imagepng($img, 'tmp.png');
		    $info = getimagesize('tmp.png');

		    unlink('tmp.png');

		    if ($info[0] > 0 && $info[1] > 0 && $info['mime']) {
		        return true;
		    }

		    return false;
		}

	}
?>