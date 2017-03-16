<?php
/**
 * Created by PhpStorm.
 * Date: 16/12/28
 * Time: 下午4:08
 */
namespace App\Service\Admin;

use App\Models\MarkingSection;
use App\Models\MarkingSystemStandard;

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

}