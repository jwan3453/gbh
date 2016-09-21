<?php
namespace App\Service\Admin;
use App\Http\Requests;
use Illuminate\Http\Request;

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


    //上传图片
    public function uploadImage(Request $request)
    {


        $this->auth = new QiniuAuth( $this->accessKey,  $this->secretKey);

        $imageObj=null;
        $token = $this->auth->uploadToken($this->bucket);
        $uploadMgr = new UploadManager();
        $jsonResult = new MessageResult();
        $file = $request->file('file');
//        $type = 0;//1 为产品 2 为article 3为用户头像
//        // 当isAdSlide 为1的时后, 1 为产品首页幻灯片
//        $isAdSlide = 0;
//        $associateId = 0;
//        if($request->input('productId') != '')
//        {
//            $type = 1;
//            $associateId = $request->input('productId');
//        }
//        else if($request->input('articleId') != '')
//        {
//            $type = 2;
//            $associateId = $request->input('articleId');
//        }else if ($request->input('UserId') != '') {
//            $type = 3;
//            $associateId = $request->input('UserId');
//        }
//        else if($request->input('slideType') !='')
//        {
//            $type = $request->input('slideType');
//            $isAdSlide = 1;
//        }

        $hotelId = $request->input('hotelId');
        $sectionId= $request->input('sectionId');
        $type = $request->input('sectionType');

        $filename ='hotelImage/'.$hotelId.'/'.$sectionId.'/'.uniqid().'.'.$file->guessExtension();

        list($result,$error) = $uploadMgr->putFile($token, $filename, $file);

        // if ($request->input('UserId') != '') {
        //     $a = $this->resize_image($file->getClientOriginalName(),$file->getRealPath(),80,80,time());
        //     $jsonResult->pic = $a;
        //     return $jsonResult;
        //     dd($a);
        //     list($result,$error) = $uploadMgr->put($token, $filename, $a);
        // }else{
        //     list($result,$error) = $uploadMgr->putFile($token, $filename, $file);
        // }

        //如果error 为空则上传成功
        if($error == null)
        {

//            if($isAdSlide == 0) {
//
//                $newImage = [
//                    'type' => $type,
//                    'associateId' => $associateId,
//                    'key' => $result['key'],
//                    'link' => 'http://7xq9bj.com1.z0.glb.clouddn.com/' . $result['key'],
//                ];
//                $imageObj = Image::create($newImage);
//
//            }
//            else{
//                $newImage = [
//                    'type' => $type,
//                    'key' => $result['key'],
//                    'link' => 'http://7xq9bj.com1.z0.glb.clouddn.com/' . $result['key'],
//                ];
//                $imageObj = AdSlide::create($newImage);
//
//            }

            $newImage = new HotelImage();
            $newImage->hotel_id = $hotelId;
            $newImage->section_id= $sectionId;
            $newImage->type = $type;
            $newImage->is_cover = 0;
            $newImage->image_key =  $result['key'];
            $newImage->link = 'http://7xw0sv.com1.z0.glb.clouddn.com/' . $result['key'];
            $newImage->save();

            if ($newImage != null || $newImage->id > 0) {
                $jsonResult->statusCode = 1;
                $jsonResult->statusMsg = '上传成功';
                $jsonResult->extra = $newImage;


            } else {
                $jsonResult->statusCode = 2;
                $jsonResult->statusMsg = '插入数据库失败';
                $jsonResult->extra = $newImage;
            }

        }
        else{
            $jsonResult->statusCode  = 3;
            $jsonResult->statusMsg = '上传云端失败';
            $jsonResult->extra = $result;
        }

        return $jsonResult;
    }

    public function deleteImage(Request $request)
    {
        // $imageKey = $request->input('imageKey');
        $jsonResult = new MessageResult();

        $type = $request->input('type'); //0 为删除酒店照片

        $imageKey = $request->input('imageKey');

        if($imageKey != null)
        {
            //初始化BucketManager
            $bucketMgr = new BucketManager($this->auth);

            //删除$bucket 中的文件 $key
            $err = $bucketMgr->delete($this->bucket, $imageKey);


            if($err == null)
            {

                //删除酒店 图片
                if($type == 1) {

                    $deleteImg = HotelImage::where('image_key', $imageKey)->first();
                    $deleteRow = $deleteImg->delete();
                    if ($deleteRow) {

                        $jsonResult->statusCode = 1;
                        $jsonResult->statusMsg = '删除成功';

                    } else {
                        $jsonResult->statusCode = 2;
                        $jsonResult->statusMsg = '删除失败';
                    }


//                    $deleteImg = Image::where('key', $imageKey)->first();
//                    $product = Product::where('thumb', $deleteImg->id)->first();
//                    $deleteRow = $deleteImg->delete();
//
//                    //图片删除后是否影响产品封面
//                    if ($deleteRow) {
//                        $jsonResult->statusCode = 1;
//                        $jsonResult->statusMsg = '删除成功';
//                        if ($product != null) {
//                            //如果删除的图片为产品封面 要重置产品的封面
//                            $product->thumb = '';
//                            $product->save();
//                        }
//
//                    } else {
//                        $jsonResult->statusCode = 2;
//                        $jsonResult->statusMsg = '删除失败';
//                    }
                }

                //删除adslide 表的图像
                else{
//                    $deleteImg = Adslide::where('key', $imageKey)->where('type',$type)->first();
//                    $deleteRow = $deleteImg->delete();
//                    if ($deleteRow) {
//
//                        $jsonResult->statusCode = 1;
//                        $jsonResult->statusMsg = '删除成功';
//
//                    } else {
//                        $jsonResult->statusCode = 2;
//                        $jsonResult->statusMsg = '删除失败';
//                    }
                }

            }
            else{

                $jsonResult->statusCode=3;
                $jsonResult->statusMsg='无法从云端删除';
            }
        }
        else{
            $jsonResult->statusCode=4;
            $jsonResult->statusMsg='图片不存在';
        }
        return $jsonResult;





    }

}


?>