<?php


namespace App\Service\Gbh;


use App\Models\Slide;

/**
* 
*/
class SlideService
{
	
	public function getSlideList()
	{
		return Slide::select('slide_name','slide_desc','img_url')->get();
	}
}

?>