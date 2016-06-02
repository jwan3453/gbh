<?php

namespace App\Http\Controllers\Admin\MenuSetting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Service\Admin\MenuSettingService;

use App\Tool\MessageResult;

class MenuSettingController extends Controller
{


    private $menuSetting;
    public function __construct(MenuSettingService $menuSetting ){

        $this->menuSetting = $menuSetting ;
    }

    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menuList = $this->menuSetting->getOneMenu();
        // dd($menuList);
        return view('Admin.Menu.menuSetting')->with('menuList',$menuList);
    }

    public function getSecondMenu(Request $request)
    {
        $jsonResult = new MessageResult();

        $jsonResult->getSecondMenu = $this->menuSetting->getSecondMenu($request->input('menuId'));

        return response($jsonResult->toJson());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
