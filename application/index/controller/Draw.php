<?php 

namespace app\index\controller;

use think\Request;

class Draw extends Common
{
    public function index()
    {
    	// dump();
        // return '1';
        return $this->fetch('index',['id'=>1]);
        //加载抽奖页面
    }

    public function is_enjoy(Request $request){

    	dump($request->post());

    	$data = [];
    	return json($data);
    }

    public function enjoy(){

    }
}
