<?php
namespace App\Service\Admin;

use App\Models\HotelImage;

use App\Tool\MessageResult;

use Qiniu\Auth as QiniuAuth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

/**
* 
*/
class ImageService
{
	private $accessKey = 'aavEmxVT7o3vsFMGKUZbJ1udnoAbucqXPmk3tdRX';
    private $secretKey ='nDQPr1L7pcurdV8_7iLIICNjSME2EmCiokHXTGTX';
    private $bucket = 'gbhchina';
    private $auth;


	function __construct()
	{
		$this->auth = new QiniuAuth( $this->accessKey,  $this->secretKey);
	}

	public function uploadImage($request)
	{
		// dd($request->input());

		$imageObj=null;
        $token = $this->auth->uploadToken($this->bucket);
        $uploadMgr = new UploadManager();
        $jsonResult = new MessageResult();
        $file = $request->file('file');

        $sectionId = $request->input('sectionId');
        $hotelId = $request->input('hotelId');

        $filename =time().uniqid().'.'.$file->guessExtension();

        list($result,$error) = $uploadMgr->putFile($token, $filename, $file);

        if($error == null)
        {

        	$HotelImage = new HotelImage();
        	$HotelImage->hotel_id = $hotelId;
        	$HotelImage->section_id = $sectionId;
        	$HotelImage->key = $result['key'];
        	$HotelImage->link = 'http://7xw0sv.com1.z0.glb.clouddn.com/' . $result['key'];
            $imageObj = $HotelImage->save();
            // $imageObj = HotelImage::create($newImage);


            if ($imageObj != null || $imageObj->id > 0) {
                $jsonResult->statusCode = 1;
                $jsonResult->statusMsg = '上传成功';
                $jsonResult->extra = $imageObj;


            } else {
                $jsonResult->statusCode = 2;
                $jsonResult->statusMsg = '插入数据库失败';
                $jsonResult->extra = $imageObj;
            }

        }
        else{
            $jsonResult->statusCode  = 3;
            $jsonResult->statusMsg = '上传云端失败';
            $jsonResult->extra = $result;
        }

        return response($jsonResult->toJson());
	}



    public function deleteHotelImage($request)
    {
        $imageKey = $request['key'];
        $jsonResult = new MessageResult();

        if($imageKey != null){

            //初始化BucketManager
            $bucketMgr = new BucketManager($this->auth);

            //删除$bucket 中的文件 $key
            $err = $bucketMgr->delete($this->bucket, $imageKey);

            if($err == null){
                $id = $request['iamgeId'];
                $deleteImg = HotelImage::where('id', $id)->delete();

                if ($deleteImg) {
                    $jsonResult->statusCode = 1;
                    $jsonResult->statusMsg = '删除成功';
                }else{
                    $jsonResult->statusCode = 2;
                    $jsonResult->statusMsg = '删除失败';
                }
            }else{
                $jsonResult->statusCode=3;
                $jsonResult->statusMsg='无法从云端删除';
            }

        }else{
            $jsonResult->statusCode=4;
            $jsonResult->statusMsg='图片不存在';
        }

        return response($jsonResult->toJson());
    }


}


?>