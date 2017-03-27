<?php
namespace App\Http\Controllers\Admin\MarkingSystem;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Admin\MarkingSystemService;
use App\Tool\MessageResult;



class MarkingSystemController extends Controller
{
    //

    private $msService;
    public function __construct(MarkingSystemService $msService ){

        $this->msService =  $msService;

    }

    /**
     * 评分系统
     *
     * @return view
     */
    public function index(){

        $recordList=  $this->msService->getEvaluateRecordList();
        return view('Admin.MarkingSystem.index')->with(['recordList' =>  $recordList]);
    }

    /**
     * 创建评分系统
     *
     * @return view
     */
    public function createMarkingSystem(){

        $sectionList =  $this->msService->getAllSection();
        $standardList=  $this->msService->getStanderList();

        return view('Admin.MarkingSystem.createMarkingSystem')->with(['sectionList' => $sectionList,'standerList' =>  $standardList]);
    }

    /**
     * 创建酒店分区
     *
     * @return Json
     */

    public function createMarkingSection(Request $request){
        $jsonResult = new MessageResult();

        $result = $this->msService->createNewSectionItem($request->input('newSection'));

        if ($result) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "创建成功";
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "创建失败";
        }

        return response($jsonResult->toJson());
    }

    /**
     * 删除酒店分区
     *
     * @return Json
     */
    public function deleteMarkingSection(Request $request){
        $jsonResult = new MessageResult();

        $result = $this->msService->deleteSectionItem($request->input('section'));

        if ($result) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "删除成功";
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "删除失败";
        }

        return response($jsonResult->toJson());
    }


    /**
     * 创建酒店评分项目
     *
     * @return Json
     */
    public function createMarkingItems(Request $request)
    {
        $sectionId  = $request->input('section');
        $items  = $request->input('newMarkingItems');
        $itemList= explode('|',$items);


        $jsonResult = new MessageResult();
        $result = $this->msService->createNewMarkingItems($sectionId,$itemList);
        if ($result) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "创建成功";
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "创建失败";
        }

        return response($jsonResult->toJson());

    }


    /**
     * 删除评分项
     *
     * @return Json
     */
    public function deleteMarkingStandard(Request $request)
    {
        $jsonResult = new MessageResult();

        $result = $this->msService->deleteMarkingStandard($request->input('standard'));

        if ($result) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "删除成功";
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "删除失败";
        }

        return response($jsonResult->toJson());
    }


    /**
     * 评估酒店
     *
     * @return Json
     */

    public function evaluate()
    {
        $standardList=  $this->msService->getStanderList();

        return view('Admin.MarkingSystem.evaluate')->with(['standardList' =>  $standardList]);
    }


    /**
     * 提交分区评估结果
     *
     * @return Json
     */
    public function saveSectionEvaluates(Request $request)
    {
        $jsonResult = new MessageResult();
        $result=  $this->msService->saveSectionEvaluates($request);

        $jsonResult->statusCode = 1;
        $jsonResult->statusMsg = $result;

        return response($jsonResult->toJson());
    }

    /**
     * 查看评估报表
     *
     * @return view
     */
    public function showEvaluateRecord($recordId)
    {
        $recordInfo = $this->msService->getRecordInfo($recordId);
        $evaluatedStandardList=  $this->msService->getEvaluatedStanderList($recordId);



        return view('Admin.MarkingSystem.showEvaluateRecord')->with(['recordInfo'=>$recordInfo,'evaluatedStandardList'=>$evaluatedStandardList]);
    }

    /*
     * 导出Excel
     *
     * return file
     */
    public function exportExcel($recordId)
    {
         $this->msService->exportExcel($recordId);
    }

}

?>