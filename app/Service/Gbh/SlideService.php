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
		return Slide::select('slide_name','slide_desc','slide_link','img_url')->get();
	}
}

?>