<?php
namespace App\Service\Admin;
use App\Http\Requests;
use Illuminate\Http\Request;

use App\Models\HotelImage;

use App\Tool\MessageResult;

use Qiniu\Auth as QiniuAuth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

use App\Models\Config;
/**
 *
 */
class ImageService
{
    private $accessKey = 'aavEmxVT7o3vsFMGKUZbJ1udnoAbucqXPmk3tdRX';
    private $secretKey ='nDQPr1L7pcurdV8_7iLIICNjSME2EmCiokHXTGTX';
    private $bucket = '';
    private $auth;


    function __construct()
    {
        $this->auth = new QiniuAuth( $this->accessKey,  $this->secretKey);
        $this->bucket =Config::where('item','bucket')->select('item')->first()->item;
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
        $imageType = $request->input('imageType');
        // $type = 0;//1 为酒店图片 2为目的地图片 3为酒店分类图标
        if($imageType ==1)
        {
            $hotelId = $request->input('hotelId');
            $sectionId= $request->input('sectionId');
            $type = $request->input('sectionType');//1 为酒店区域照片 2为房间照片

            $filename ='hotelImage/'.$hotelId.'/'.$sectionId.'/'.uniqid().'.'.$file->guessExtension();

            list($result,$error) = $uploadMgr->putFile($token, $filename, $file);

            //如果error 为空则上传成功
            if($error == null)
            {
                $newImage = new HotelImage();
                $newImage->hotel_id = $hotelId;
                $newImage->section_id= $sectionId;
                $newImage->type = $type;
                $newImage->is_cover = 0;
                $newImage->image_key =  $result['key'];
                $newImage->link = Config::where('item','bucket-domain')->select('item')->first()->item. $result['key'];
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

        }
        else if($imageType == 2 || $imageType == 3)
        {
            $prefix = '';
            if($imageType == 2)
                $prefix = 'destination/'.$request->input('code');
            else
                $prefix = 'category';

            $filename =$prefix.'/'.uniqid().'.'.$file->guessExtension();

            list($result,$error) = $uploadMgr->putFile($token, $filename, $file);

            //如果error 为空则上传成功
            if($error == null)
            {
                    $link = 'http://7xw0sv.com1.z0.glb.clouddn.com/' . $result['key'];
                    $jsonResult->statusCode = 1;
                    $jsonResult->statusMsg = '上传成功';
                    $jsonResult->extra = $link;
            }
            else{
                $jsonResult->statusCode  = 3;
                $jsonResult->statusMsg = '上传云端失败';
            }
        }
        return $jsonResult;
//
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




    }

    public function deleteHotelImage(Request $request)
    {
        // $imageKey = $request->input('imageKey');
        $jsonResult = new MessageResult();

        $type = $request->input('type'); //1 为删除酒店照片

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


    public function deleteImage($link)
    {

        $jsonResult = new MessageResult();
        $imageKey = explode('.com/',$link);
        if($imageKey != null)
        {
            //初始化BucketManager
            $bucketMgr = new BucketManager($this->auth);

            //删除$bucket 中的文件 $key
            $err = $bucketMgr->delete($this->bucket, $imageKey[1]);
            if($err == null)
            {
                $jsonResult->statusCode = 1;
                $jsonResult->statusMsg = '删除成功';
            }
            else{
                $jsonResult->statusCode = 2;
                $jsonResult->statusMsg = '删除失败';
            }
        }
        else{
            $jsonResult->statusCode = 3;
            $jsonResult->statusMsg = '删除失败,image key 错误';
        }
        return $jsonResult;
    }

}


?>