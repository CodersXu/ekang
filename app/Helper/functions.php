<?php
/**
 * Created by PhpStorm.
 * User: moTzxx
 * Date: 2017/12/28
 * Time: 17:47
 */

/**
 * 公用的方法  返回json数据，进行信息的提示
 * @param $status 状态
 * @param string $message 提示信息
 * @param array $data 返回数据
 */
function showMsg($status,$message = '',$data = array()){
    $result = array(
        'status' => $status,
        'message' =>$message,
        'data' =>$data
    );
    exit(json_encode($result));
}
/**
 * 获取当前控制器名
 *
 * @return string
 */
function getCurrentControllerName()
{
    return getCurrentAction()['controller'];
}

/**
 * 获取当前方法名
 *
 * @return string
 */
function getCurrentMethodName()
{
    return getCurrentAction()['method'];
}

/**
 * 获取当前控制器与方法
 *
 * @return array
 */
function getCurrentAction()
{
    $action = \Route::current()->getActionName();
    list($class, $method) = explode('@', $action);

    return ['controller' => $class, 'method' => $method];
}
/**
 * 传输控制器与方法
 *
 * @return array
 */
function get_page_method($module_name,$action_name){
    if($action_name != 'loginout'&&$action_name != 'gxc'&&$action_name != 'validation'&&$action_name != 'uploadPic'){
        islogin();
        if(!session('functions')){
            session()->put('functions',getUserPower());
        }
        if($_SESSION['cad_logo'] && $module_name!='Cadmin' && $action_name!='permissions'){
            unlink('.'.session('cad_logo'));
            session()->forget('cad_logo');
        }
        if(!session('functions')[$module_name."and".$action_name]&&$module_name."and".$action_name!='Indexandindex'){
            return back()->withErrors(['无权限访问此模块!请联系管理员开通!!!']);
        }
        $arr=DB::table("cmanagement")->whereRaw('cma_action= ? and cma_function = ?',[$module_name,$action_name])->orderBy("cma_sord,cma_id","desc")->first();
        //dump($_SESSION['functionslist'][$arr['cma_id']]);exit;
        return ['child_functions' => $_SESSION['functionslist'][$arr['cma_id']], 'functionslist' => $_SESSION['functionslist']];
	}
    
}
/**
 * 返回某个角色对应的权限
 *
 * @return array
 */
function getUserPower(){
    $ba=DB::table("cadmin")->whereRaw('cad_id= ?',[session('ekang_id')])->first();
    if(session('ekang_id')!='1'&& $ba['cad_xiu']=='0'){
           $ca=DB::table("cadmin")->whereRaw('cad_id= ?',[1])->first();
           $poost['jiu_permissions']=$ba['cad_permissions'];
           $poost['cad_permissions']=$ca['jiu_permissions'];
           $poost['cad_xiu']=1;
           $tian=DB::table("cadmin")->where('cad_id','=',session('ekang_id'))->update($poost);

    }
    $xzqx = session('xzqx');
    $arr=DB::select("select * from cmanagement where cma_id in (".$ba->cad_permissions.") and ".$xzqx." order by cma_sord,cma_id desc");
    foreach($arr as $k=>$v){
        dump($v);exit;
             $arrlist[$v['cma_parentid']][]=$v;
            if($v['cma_function']){
            $functions[$v['cma_action']."and".$v['cma_function']]='1';
            }
            if($v['cma_jsfunction']){
            $functions[$v['cma_action']."and".$v['cma_jsfunction']]='1';
            }
    }
    session()->put('functionslist',$arrlist);
    return $functions;
}
/**
 * 检查是否登陆
 *
 * @return array
 */
function islogin(){
    if(session("ekang_id")){
    }else{
        Route::get('login',function(){
            return view('login');
        });
    } 	
} 