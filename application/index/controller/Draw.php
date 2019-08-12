<?php 

namespace app\index\controller;

use think\Request;
use think\Db;

class Draw extends Common
{
    public function index(Request $request)
    {
    	// dump();
        // return '1';
    	$id = $request->get('id');
    	$data = Db::table('draw')->where('id',$id)->find();

        return $this->fetch('index',['data'=>$data]);
        //加载抽奖页面
    }

    public function is_enjoy(Request $request){

    	// dump($request->post());
    	$id = $request->post('id');
    	$res = Db::table('winning')->where(['draw_id'=>$id])->find();
    	// dump($res);
    	if($res){
    		$result = false;
    	}else{
    		$result = true;
    	}

    	// $data = [];
    	return json($result);
    }

    public function enjoy(Request $request){
    	// echo 1;exit();
    	$id = $request->post('id');
    	$data = Db::table('prize')->where('draw_id',$id)->select();

    	// 预留判断是否抽过

    	//没有奖品
    	if(empty($data)){
    		$result = ['res'=>-1];
    	}else{
    		$res = self::get_rand1($data);
    		$result = ['res'=>1,'data'=>$res];
    	}

    	return json($result);

    }


    /*static public function get_rand() {
	    $arr = array(
	        array('id'=>1,'name'=>'t等奖','v'=>1),//特等奖
	        array('id'=>2,'name'=>'1等奖','v'=>5),//1等奖
	        array('id'=>3,'name'=>'2等奖','v'=>10),//2等奖
	        array('id'=>4,'name'=>'3等奖','v'=>12),//3等奖
	        array('id'=>5,'name'=>'4等奖','v'=>23),//4等奖
	        array('id'=>6,'name'=>'5等奖','v'=>59),//5等奖
	        array('id'=>7,'name'=>'6等奖','v'=>80),//6等奖
	        array('id'=>8,'name'=>'7等奖','v'=>100)//7等奖
	    );
	    return self::get_rand1($arr);
    }*/


    static function get_rand1($proArr) {
        $result = array();
        foreach ($proArr as $key => $val) {
            $arr[$key] = $val['prob'];
        }
        // 概率数组的总概率
        $proSum = array_sum($arr);
        asort($arr);
        // 概率数组循环
        foreach ($arr as $k => $v) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $v) {
                $result = $proArr[$k];
                break;
            } else {
                $proSum -= $v;
            }
        }
        return $result;
    }


}
