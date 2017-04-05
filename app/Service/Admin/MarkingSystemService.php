<?php
/**
 * Created by PhpStorm.
 * Date: 16/12/28
 * Time: 下午4:08
 */
namespace App\Service\Admin;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\MarkingSection;
use App\Models\MarkingSystemStandard;
use App\Models\MarkingRecords;
use App\Models\MarkingPoints;


use Qiniu\Auth as QiniuAuth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

use App\Models\Config;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;

class MarkingSystemService {



    /**
     * 获取所有分区
     */
    public function getAllSection()
    {
            return MarkingSection::all();
    }


    /**
     * 获取所有评分项
     */
    public function getStanderList()
    {
        $sectionList =  MarkingSection::all();
        foreach($sectionList as $section)
        {
            $section->standards = MarkingSystemStandard::where('section_id',$section->id)->get();
        }
        return $sectionList;
    }


    /**
     *ajax创建分区
     */
    public function createNewSectionItem($name )
    {
        $newMarkingSection  = new MarkingSection();
        $newMarkingSection->name  = $name;
        $newMarkingSection->description = '';
        return $newMarkingSection->save();
    }



    /**
     *ajax 删除酒店分区
     */
    public function deleteSectionItem($sectionId )
    {
        $section = MarkingSection::find($sectionId);
        $deleteRows = MarkingSystemStandard::where('section_id',$sectionId)->delete();
        return $section->delete();
    }

    /**
     *ajax创建评分项目
     */
    public function createNewMarkingItems($sectionId, $itemList)
    {
        $success = true;
        foreach($itemList as $item)
        {
            $newStandard  = new MarkingSystemStandard();
            $newStandard->section_id = $sectionId;
            $newStandard->description = $item;

            if(!$newStandard->save())
            {
                $success = false;
            }
        }
        return $success;
    }


    /**
     *ajax 删除评分项目
     */
    public function deleteMarkingStandard($standard )
    {
        $standard = MarkingSystemStandard::find($standard);

        return $standard->delete();
    }

    /*
     * 获取酒店评估列表
     */

    public function getEvaluateRecordList()
    {
        return $recordList = MarkingRecords::latest()->createdAt()->get();
    }

    /*
     * 提交分区评估结果
     */
    public function saveSectionEvaluates(Request $request)
    {


        $section = $request->input('section');
        $status = $request->input('sStatus');
        $hotelName = $request->input('sHotelName');
        $roomName = $request->input('sRoomName');
        $evaluator = $request->input('sEvaluator');
        $recordId = $request->input('recordId');


        //创建一个新的评估记录
        if($status == 'new')
        {
            $newRecord = new MarkingRecords();
            $newRecord->name = $hotelName;
            $newRecord->room_name = $roomName;
            $newRecord->evaluator = $evaluator;
            $newRecord->totalPoints = 0;
            $newRecord->save();

            $recordId = $newRecord->id;

        }
        else{

            //$record = MarkingRecords::where('id',$recordId)->first();

        }

        $formData = $request->all();
        $standardKey = [];
        $inputKeys = array_keys($formData);
        foreach($inputKeys as $key)
        {

            if(strpos($key, 'evlPoints')!==false)
            {

                $standardKey[] = explode('_',$key)[1];
            }
        }

        //获取所有的评估项目id 创建评估项目
        foreach($standardKey as $standerId)
        {
            $points = MarkingPoints::where(['record_id'=>$recordId,'standard_id'=>$standerId])->first();
            if( count($points)>0)
            {
                $points->record_id = $recordId;
                $points->standard_id = $standerId;
                $points->points = $request->input('evlPoints_'.$standerId);
                $points->description = $request->input('evlDesc_'.$standerId);
            }
            else{

                $points = new MarkingPoints();
                $points->record_id  = $recordId;
                $points->standard_id = $standerId;
                $points->points = $request->input('evlPoints_'.$standerId);
                $points->description = $request->input('evlDesc_'.$standerId);
                $points->images = '';
            }

            //上传图片到七牛
            $imageLink = '';




            if($request->file('cameraInput_'.$standerId) != null)
            {
                $imageLink = $this->uploadEvaluateImage($recordId,$standerId,$request->file('cameraInput_'.$standerId) );
                $points->images = $imageLink;
            }



            $points->save();

        }
        //表单提交处理完成 返回下一次需要提交的分区的id
        $nextSection = 0;
        $sectionList = MarkingSection::all();
        for($i=0; $i<count($sectionList); $i++)
        {
            if($sectionList[$i]->id == $section)
            {
                if( $i < count($sectionList)-1 )
                {
                    $nextSection = $sectionList[$i+1]->id;
                }
                else{
                    $nextSection = 0;
                }

            }
        }

        return $nextSection.'_'.$recordId;
    }


    public function uploadEvaluateImage($recordId,$standardId,$file)
    {
        $accessKey = 'aavEmxVT7o3vsFMGKUZbJ1udnoAbucqXPmk3tdRX';
        $secretKey ='nDQPr1L7pcurdV8_7iLIICNjSME2EmCiokHXTGTX';
        $auth = new QiniuAuth( $accessKey,  $secretKey);
        $bucket =Config::where('item','bucket')->select('value')->first()->value;

        $token = $auth->uploadToken($bucket);
        $uploadMgr = new UploadManager();

        $filename ='evaluate/'.$recordId.'/'.$standardId.'/'.uniqid().'.'.$file->guessExtension();

        list($result,$error) = $uploadMgr->putFile($token, $filename, $file);

        //如果error 为空则上传成功
        if($error == null) {
            return Config::where('item','bucket_domain')->select('value')->first()->value. $result['key'];
        }
        return '';
    }




    /**
     * 获取所有已评分项明细
     */
    public function getEvaluatedStanderList($recordId)
    {
        $sectionList =  MarkingSection::all();
        foreach($sectionList as $section)
        {
            $section->standards = DB::table('marking_system_standard as mst')->where('mst.section_id',$section->id)

                                    ->LeftJoin('marking_points as mp',function($join) use ($recordId){

                                                $join->on('mst.id','=','mp.standard_id')->where('mp.record_id','=',$recordId);

                                            })



                                    ->select('mst.id','mst.description','mp.points','mp.description as mpdesc','mp.images')->get();// MarkingSystemStandard::where('section_id',$section->id)->get();
        }
        return $sectionList;
    }

    /*
     * 获取评估记录信息
     */
    public function getRecordInfo($recordId)
    {
        return MarkingRecords::find($recordId);
    }

    /*
     * 导出Excel
     */
    public function exportExcel($recordId)
    {

        $esl =  $this->getEvaluatedStanderList($recordId);
        $recordInfo = $this->getRecordInfo($recordId);


        Excel::create($recordInfo->name.'评估表',function($excel) use ($esl,$recordInfo){


            foreach($esl as $section)
            {
                $data= [];
                $totalPoints = 0;
                $totalEvaPoints = 0;
                $data[] = ['','',''];
                $data[] = ['酒店','房型','评估员'];
                $data[] = [$recordInfo->name,$recordInfo->room_name,$recordInfo->evaluator];
                $data[] = ['','',''];
                $data[] = [ '项目','得分','描述'];
                foreach($section->standards as $standard)
                {
                    $data[] = [$standard->description,$standard->points,$standard->mpdesc];
                    $totalPoints += 100;
                    $totalEvaPoints +=  intval($standard->points);
                }

                $data[] = ['','',''];
                $data[] = ['总分',$totalPoints.'/'.$totalEvaPoints,''];


                $excel->sheet(str_replace("/","&",$section->name), function($sheet) use ($data){
                    $sheet->rows($data);
                    $sheet->setFontSize(10);
                    $sheet->setAutoSize(true);
                    $sheet->setOrientation('landscape');
                });
            }



        })->export('xls');

    }


}