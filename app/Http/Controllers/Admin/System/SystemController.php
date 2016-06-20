<?php

namespace App\Http\Controllers\Admin\System;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Service\Admin\SystemService;

use App\Tool\MessageResult;

/**
* 
*/
class SystemController extends Controller
{
	private $system;
	function __construct(SystemService $system)
	{
		$this->system = $system;
	}


	public function slideConfigure()
	{
		$slideList = $this->system->getSlideList();
		return view('Admin.System.slideConfigurePage')->with('slideList',$slideList);
	}

	public function uploadImg(Request $request)
	{
		$file = $_FILES[$request->input('filename')];

        return $this->system->uploadImg($file);
	}

	public function createSlide(Request $request)
	{
		$jsonResult = new MessageResult();

		$createSlide = $this->system->createOrUpdateSlide($request->input());

		if ($createSlide) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
	}

	public function delSlide(Request $request)
	{
		$jsonResult = new MessageResult();

        $delSlide = $this->system->delSlide($request->input('slideId'));

        if ($delSlide) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
	}





}




?>