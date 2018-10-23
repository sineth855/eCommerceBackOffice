<?php

    namespace App\Http\Controllers\Services;

    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use App\Account;
    use Validator;
    use Carbon\Carbon;
    use DB;
    use Illuminate\Support\Facades\Auth;
    use Session;
    use Illuminate\Support\Facades\Input;

    class FileUploadController extends Controller
    {
        /**
         * Display a listing of the BestSeller Create On 01-02-2018
         *
         * @return \Illuminate\Http\Response
         */
        
        public function fileUploadService(Request $request){
            $input = $request->all();
            $attachments_files = $request->file('image');
            $image = $input['image'];
            $date_create = date('d-M-Y/');
            $destinationPath = 'images/uploads/'.$date_create; // upload path
            $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
            $fileName = $this->generateRandomString(10).'.'.$extension; // renameing image
            // $fileName = rand(11111111,99999999).'.'.$extension; // renameing image
            // $fileName = $image->getClientOriginalName();
            Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
            // $imageUrl = config_url.'/'.$destinationPath.$fileName;
            $imageUrl = '/'.$destinationPath.$fileName;
            return response()->json(['success'=>true,'message'=>'File uploaded successfully.','data'=>['image_url'=>$imageUrl,'extension'=>$extension]], 200);
        }

        public function generateRandomString($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
    }