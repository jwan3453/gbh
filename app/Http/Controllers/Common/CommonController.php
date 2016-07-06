<?php
namespace App\Http\Controllers\Common;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;




class CommonController extends Controller
{
    //


    public function __construct(){


    }
    public function uploadImage(Request $request)
    {

        $previousImage = $request->input('coverImageFilePath');

        if($previousImage != '')
        {

            if(file_exists($previousImage))
                unlink($previousImage);
        }

        $status = 0;
        $file = $request->file('uploadImage');
        $destinationPath = 'uploads/image/admin/articleCover/';//.Auth::user()->username.'/articleCover/';

        $filename = $file->getClientOriginalName();
        //$filename_utf=iconv("UTF-8","UTF-8", $filename);


        if(!file_exists($destinationPath.$filename))
        {
            $file->move($destinationPath, $filename);
        }


        return response()->json(array(
            'status' => $status,
            'imgFilePath'=> $destinationPath.$filename,
            'img' => '/'.$destinationPath.$filename,
        ));
    }


}

?>