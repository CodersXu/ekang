<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class IndexController extends Controller
{
     /**
     * 机构显示
     *
     * @var array
     */
    public function index()
    {
        # code...
        $some = getCurrentAction();
        $debugbase = explode("\\",$some['controller']);
        $result = get_page_method($debugbase[3],$some['method']);
        if(session("jg_id")){
            if(session("con_work")!=1){
                return view('index');
            }else{
                $tim=date("Y-m-d H:i:s");
                $mintervention_info=DB::table("mintervention_info")->whereRaw('inf_cadid> ? and stase = ? and int_visits >0 ? and execution_time < ',[$_SESSION['jg_id'],3,0,$tim])->count();
                dump($mintervention_info);
                $this->assign("dainum",$mintervention_info);
                $mintervention_info=M("mintervention_info");
                $dainum=$mintervention_info->where("inf_cadid=".$_SESSION['jg_id']." and stase=3 and int_visits>0 and  execution_time<'".$tim."'")->count();
                //echo $mintervention_info->getlastsql();exit;
                $this->assign("dainum",$dainum);

                /*201703.28  开始*/

                $member = M("member");
                //库存
                $sql = "SELECT count(mem_id) FROM `member` where mem_states=1 and mem_cid=".$_SESSION['jg_id'];
                $resultku = $member->query($sql);
                $this->assign("resultku",$resultku[0]['count(mem_id)']);

                //未激活的     
                $sql = "SELECT count(mem_id) FROM `member` where mem_states=2 and mem_state=1 and mem_cid=".$_SESSION['jg_id'];
                $resultwei = $member->query($sql);
                $this->assign("resultwei",$resultwei[0]['count(mem_id)']);
                //已激活的  
                $sql = "SELECT count(mem_id) FROM `member` where mem_states=2 and mem_state=2 and mem_cid=".$_SESSION['jg_id'];
                $resultyi = $member->query($sql);
                $this->assign("resultyi",$resultyi[0]['co   unt(mem_id)']);
                //服务中用户
                $erqi_review = M("erqi_review");
                $fuwuzhong=$erqi_review->where("review_jgid=".$_SESSION['jg_id']."")->select();

                $erqi_gyjl_fs = M("erqi_gyjl_fs");
                $fuwuzhong1=$erqi_gyjl_fs->where("gyjh_cin_id=".$_SESSION['jg_id']."")->select();

                foreach ($fuwuzhong as $key => $value) {
                $resquan[]=$value['review_userid'];
                }
                foreach ($fuwuzhong1 as $key => $value) {
                $resquan[].=$value['gyjh_userid'];
                }
                foreach (array_unique($resquan) as $key => $value) {
                $bao=$member->where("mem_id=".$value."")->find();
                if($bao['mem_cid']==$_SESSION['jg_id']){
                $some[]=$value;
                }
                }
                //var_dump($karry);exit;
                $rest=count($some);
                $this->assign("fuwuzhong",$rest);
                //新增体检报告view_record
                $view_record = M("view_record");
                $kstime1 = date('Y-m-d 00:00:00',time());
                $jstime1 = date('Y-m-d 23:59:59',time());
                $xinz=$view_record->where("res_cid=".$_SESSION['jg_id']." and up_time >='".$kstime1."' and up_time <='".$jstime1."'")->count();
                $this->assign("xinz",$xinz);
                //用户卡到期提醒
                $member = M("member");
                $erqi_worklog = M("erqi_worklog");
                $yonghuTZ=$member->where("mem_cid=".$_SESSION['jg_id']."")->select();
                foreach ($yonghuTZ as $key => $value){
                //mem_cardnum  卡号
                $time=date('Y-m-d',time());
                $second2 = strtotime($time);
                $second1 = strtotime($value['expiration']);
                $atime=($second1 - $second2)/86400;
                if($second1>=$second2){
                if($atime==30){
                    $xftime='30天';
                }else if($atime==10){
                    $xftime='10天';
                }else if($atime==7){
                    $xftime='7天';
                }else if($atime==0){
                    $xftime='今天';
                }
                if($atime==30||$atime==10||$atime==7||$atime==0){
                    $caa['userid']=$value['mem_cardnum'];
                $caa['name']=$value['mem_name'];
                $caa['type']="4";
                $caa['jg_id']=$_SESSION['jg_id'];
                $caa['typecontent']="【到期提醒】：".$value['mem_name']."用户的健管服务还有【".$xftime."】到期，为了不影响正常使用，请尽快敦促用户进行续费。";
                $caa['time']=date('Y-m-d H:i:s',time());
                $pandu=$erqi_worklog->where("userid=".$value['mem_cardnum']." and time >='".$kstime1."' and time <='".$jstime1."' and type=4")->find();
                if($pandu){

                }else{
                    $erqi_worklog->add($caa);
                }

                }
                    
                }
                }
                //干预计划到期提醒
                $erqi_gyjl_fs = M("erqi_gyjl_fs");  
                $ganyuTZ=$erqi_gyjl_fs->where("gyjh_cin_id=".$_SESSION['jg_id']."")->select();
                foreach ($ganyuTZ as $key => $value) {
                $time=date('Y-m-d H:i:s',time());
                $second2 = strtotime($time);
                $second1 = strtotime($value['gyjh_jstime']);
                $atime=($second1 - $second2)/86400;
                if($second1>$second2){
                if($atime==3){
                    $sj=$member->where("mem_id=".$value['gyjh_userid']."")->find();
                    $caa['userid']=$sj['mem_cardnum'];
                $caa['name']=$sj['mem_name'];
                $caa['type']="5";
                $caa['jg_id']=$_SESSION['jg_id'];
                $caa['typecontent']="【干预计划结束提醒】：".$sj['mem_name']."用户干预计划将于【3天后】结束，请及时制定新的干预计划。";
                $caa['time']=date('Y-m-d H:i:s',time());
                $pandu=$erqi_worklog->where("userid=".$sj['mem_cardnum']." and time >='".$kstime1."' and time <='".$jstime1."'and type=5")->find();
                //echo $erqi_worklog->getlastsql();exit;
                if($pandu){

                }else{
                    $erqi_worklog->add($caa); 
                }

                }
                    
                }
                }
                $yujing = M("yujing");//三级预警
                $t=time();
                $jtime=date('Y-m-d H:i:s',$t);
                $t-=7*24*3600;
                $qtime=date('Y-m-d',$t)." 23:59:59";
                $yujt = $yujing->where("time<='".$jtime."' and time>='".$qtime."' and cad_id='".$_SESSION['ekang_id']."' and yuedu=1")->count();
                //echo $yujing->getlastsql();exit;
                $this->assign("yujt",$yujt);
                //工作量统计
                $jstime1=date('Y-m-d 00:00:00',time());
                $kstime1=date('Y-m-d 23:59:59',time());
                $erqi_recording = M("erqi_recording");
                $erqi_worklog = M("erqi_worklog");
                $member = M("member");
                $erqi_plan = M("erqi_plan");
                $erqi_gyjl_fs = M("erqi_gyjl_fs");
                $erqi_hdsf_fs_subsidiary= M("erqi_hdsf_fs_subsidiary");
                $erqi_review = M("erqi_review");
                //问卷审核
                $count['sh']=$erqi_review->where("review_jgid=".$_SESSION['jg_id']." and review_extime<='".$kstime1."' and review_extime>='".$jstime1."' and review_type!=0")->count();
                if($count['sh']==""){
                    $count['sh']=0;
                }
                //服务记录  
                $wufu=$erqi_recording->where("creat_time<='".$kstime1."' and creat_time>='".$jstime1."'")->select();

                foreach ($wufu as $key => $value) {
                    $some=$member->where("mem_id='".$value['userid']."'")->find();
                    if($some['mem_cid']==$_SESSION['jg_id']){
                        $ppo[]=$value;
                    }	 
                }
                $count['fw']=count($ppo);
                //计划提醒
                $count['jh']=$erqi_plan->where("jg_id=".$_SESSION['jg_id']." and time<='".$kstime1."' and time>='".$jstime1."'")->count();
                //干预计划
                $count['gy']=$erqi_gyjl_fs->where("gyjh_cin_id=".$_SESSION['jg_id']." and creat_time<='".$kstime1."' and creat_time>='".$jstime1."' and gyjh_type='1'")->count();
                //互动随访
                $hd=$erqi_hdsf_fs_subsidiary->where("creat_time<='".$kstime1."' and creat_time>='".$jstime1."'")->select();
                $res1 = array();
                $st1 = array();
                    foreach($hd as $v) {
                        if(in_array($v['fsub_userid'],$st1)){

                        }else{
                        $st1[]=$v['fsub_userid'];
                        $res1[]=$v;
                        }
                        
                    }

                foreach ($res1 as $key => $value) {
                    $some=$member->where("mem_id='".$value['fsub_userid']."'")->find();
                    if($some['mem_cid']==$_SESSION['jg_id']){
                        $ppsf[]=$value;
                    }	
                }
                $count['hd']=count($ppsf);

                if($count['sh']>=70||$count['fw']>=70||$count['jh']>=70||$count['gy']>=70||$count['hd']>=70){
                    $adsf['0']=$count['sh'];
                    $adsf['1']=$count['fw'];
                    $adsf['2']=$count['jh'];
                    $adsf['3']=$count['gy'];
                    $adsf['4']=$count['hd'];
                    $bian=max($adsf);
                    $this->assign("bian",$bian);
                }
                if($count['sh']==0 && $count['fw']==0&&$count['jh']==0&&$count['gy']==0&&$count['hd']==0){
                    $biandf=1;
                    
                }else{
                    $biandf=2;
                }
                $jg_id=$_SESSION["jg_id"];	
                $this->assign("jg_id",$jg_id);
                $this->assign("biandf",$biandf);
                $this->assign("count",$count);
                $this->display("index"); 
            }
     }else{
          return view('login');
     }
    }
    /**
     * ajax验证登陆
     *
     * @var array
     */
	public function validation(Request $request){
        $request = request()->all();
        if(isset($request['tyys'])){
            if($request['tyys']=='1'){
                $res=$member->where("mem_cardnum='".$request['mem_cardnum']."'")->find();
                if($res['mem_cid']=='390'){
                      echo 2;
                }else{
                      echo 1;
                }
             }
        }else if(isset($request['types'])){
            if($request['types']=='1'){
                //ajax验证卡号是否正确
                $res=$member->where("mem_cardnum='".$request['mem_cardnum']."'")->find();

                if($res){
                    if($res['mem_state']=='2'){
                        echo 3;
                    }else{
                        if($res['mem_states']=='2'){
                            echo 1;
                        }else{
                            echo 4;
                        }
                    }
                    
                }else{
                    echo 2;
                }
            }else if($request['types']=='2'){
                //ajax验证卡号密码是否正确
                $res=$member->where("mem_cardnum='".$request['mem_cardnum']."' and mem_password='".$request['password']."'")->find();
                if($res){
                    echo 1;
                }else{
                    echo 2;
                }
            }else if($request['types']=='3'){
                //ajax判断是否已存在手机号
                $res=$member->where("mem_mobile='".$request['mem_mobile']."' and mem_type!=3")->find();
                if($res){
                    echo 2;
                }else{
                    echo 1;
                }
            }else if($request['types']=='4'){
                $member=M('member');
                //ajax激活操作
                $erqi_gnwz_list= M('erqi_gnwz_list');
                $member_info=M("member_info");
                $erqi_servicemessage = M("erqi_servicemessage");
                $resbug=$member->where("mem_cardnum='".$request['mem_cardnum']."'")->find();
                // 激活发送互动随访 程2017.06.15
                $erqi_hdsf_fs = M("erqi_hdsf_fs");
                $erqi_hdsf_list = M("erqi_hdsf_list");
                $erqi_gnwz_intervention = M("erqi_gnwz_intervention");
                $erqi_hdsf_fs_subsidiary = M("erqi_hdsf_fs_subsidiary");
                $arrs['fs_cin_id'] = $resbug['mem_cid'];
                $arrs['send_times'] = 1;
                $arrs['fs_admin_id'] = $resbug['mem_cadid'];
                $arrs['fs_kstime'] = date('Y-m-d',time());
                $arrs['fs_jstime'] = date('Y-m-d',time());
                $arrs['fs_thefirst']=1;
                $arrs['fs_userid']=$resbug['mem_id'];
                $arrs['fs_parent_id']=21;
                $resdebug= $erqi_hdsf_fs->add($arrs);
                $hdsf_some = $erqi_hdsf_list->where("gnwz_int_id='21'")->find();
                    # code...
                    $cadmin=M('cadmin');
                                    
                    $timeres=$member->where("mem_id=".$resbug['mem_id'])->find();
                    $tires=$cadmin->where("cad_id=".$timeres['mem_cadid'])->find();
                    $this->creat_modify($resbug['mem_id'],$tires['cad_name'],"互动随访");
                    //PC端服务消息
                    $okk['textcont']=strip_tags($hdsf_some['txtz_id']);
                    $okk['userid']=$resbug['mem_id'];
                    $okk['name']="互动随访";
                    $okk['state']=1;
                    $okk['Connect']="/index.php/Interactive/service_follow";
                    $okk['type']=1;
                    $bbo=$erqi_servicemessage->add($okk);

                                    
                    $someher = explode(',',$hdsf_some['gnwz_id']);
                    $hdsome = date("Y-m-d",time());
                    foreach( $someher as $k => $v )
                    {
                        # code...
                        $codefa = $erqi_gnwz_intervention->where("gnwz_id = '".$v."'")->find();
                        
                        if($codefa['data_type'] == "1"){//问诊问卷
                        $tim[$k]['count'] =	$erqi_gnwz_list->where("gnwz_int_id='".$v."'")->count();
                        $arrsbug['fsub_hdsf_type'] = 1;
                        }else{
                        $tim[$k]['count'] = 0;
                        $arrsbug['fsub_hdsf_type'] = 2;	
                        }
                        $arrsbug['fsub_hdsf_mobanidsed'] = $hdsf_some['id'];
                        $arrsbug['fsub_userid'] = $resbug['mem_id'];
                        $arrsbug['fsub_parent_id'] = $resdebug;
                        $arrsbug['fsub_projects'] = $tim[$k]['count'];
                        $arrsbug['fsub_kstime'] = $hdsome;
                        $arrsbug['fsub_hdsf_mobanid'] = $codefa['gnwz_id'];
                        $arrsbug['type_stast'] = 1;
                        $erqi_hdsf_fs_subsidiary->add($arrsbug);
                    } 
                
                //结束

                //echo $erqi_hdsf_fs_subsidiary->getlastsql();exit;
                $idcard = $request['mem_idcard'];
                $birth = strlen($idcard)==15 ? ('19' . substr($idcard, 6, 6)) : substr($idcard, 6, 8);
                $request['info_year'] = substr($birth,0,4);
                $request['info_mouth'] = substr($birth,4,2);
                $request['info_day'] = substr($birth,6,8);	
                $request['info_sex']=$this->get_sex($idcard);	
                $request['mem_password']=md5(md5($request['mem_password']));
                $request['mem_state']='2';
                $request['mem_createtime']=date("Y-m-d H:i:s");
                $request['expiration']=date("Y-m-d",strtotime("+1years",strtotime($request['mem_createtime'])));
                $res=$member->where("mem_cardnum='".$request['mem_cardnum']."'")->save($request);
                $res=$member_info->where("info_memid='".$request['mem_cardnum']."'")->save($request);
                unset($request['types']);
                if($res){
                    echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
                    echo '<script>alert("激活成功!");window.location.href="/index.php/Member/index";</script>';
                    exit;
                }else{
                    echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
                    echo '<script>alert("激活失败!");window.location.href="/index.php/Member/index";</script>';
                    exit;
                }
            
            }else if($request['types']=='5'){
                //ajax获取用户信息
                
            }else if($request['types']=='6'){
                $member=M("member");
                $result=$member->where("mem_idcard='".$request['mem_idcard']."'")->find();
                //echo $member->getlastsql();
                if($result){
                    echo '2';
                }else{
                    echo '1';
                }
            }else if($request['types']=='7'){
                
            }else if($request['types']=='8'){
                //发送邮箱验证码
                
            }else if($request['types']=='9'){
                //手机验证码验证
                $phone_validation=$request['phone_validation'].'-'.$request['mem_mobile'];
                if($_SESSION['phone_validation']==$phone_validation){
                    echo 1;
                }else{
                    echo 2;
                }
            }else if($request['types']=='10'){
                //邮箱验证码验证
                
            }else if($request['types']=='11'){
                //验证激活邮箱唯一性
                $member_info=M('member_info');
                $res=$member_info->where("info_mail='".$request['info_mail']."'")->find();
                if($res){
                    echo 2;
                }else{
                    echo 1;
                }
            }else if($request['types']=='12'){
                //验证修改邮箱唯一性
                
            }else if($request['types']=='13'){
                //验证原始密码正确性
                $member=M('member');
                $mem_password=md5(md5($request['mem_password']));
                $res=$member->where("mem_password='".$mem_password."' and mem_id='".$_SESSION['member_id']."'")->find();
                if($res){
                    echo 1;
                }else{
                    echo 2;
                }
            }
        }else{
            //获取链接地址
            $url3=$_SERVER['HTTP_REFERER'];
            if(isset($request['debug'])){
                if($request['debug'] == "1"){
                    $request['cin_name'] = "一洹健康管理云平台"; 
                }
            }
			if(strpos($url3,"?str=")>'0'){
				$url3=substr($url3,0,strpos($url3,"?str="));
			}
			if(strpos($url3,"&str=")>'0'){
				$url3=substr($url3,0,strpos($url3,"&str="));
			}
			if(strpos($url3,"?")>'0'){
				$url3=$url3."&";
			}else{
				$url3=$url3."?";
            }
            session()->put('url3',$url3);
            
            //判断有没有机构id
            if(isset($request['cin_id'])){
                if($request['cin_id']){
                    $yyres=DB::table("cinstitutions")->whereRaw('cin_id= ? and cin_state = ?',[$request['cin_id'],1])->first();
                }
            }else{
                $yyres=DB::table("cinstitutions")->whereRaw('cin_name= ? and cin_state = ?',[$request['cin_name'],1])->first();
            }
            $configres=DB::table("config")->where('con_cid','=',$yyres->cin_id)->first(); 
            $res=DB::table("cadmin")->whereRaw('cad_login= ? and cad_password = ? and cad_cid = ?',[$request['cad_login'],md5(md5($request['cad_password']."admin")),$yyres->cin_id])->first();
			if($res){
                session()->put('ekang_id',$res->cad_id);            //管理师id
                session()->put('cad_level',$res->cad_level);        //管理级别
                session()->put('con_logo',$configres->con_logo);    //机构logo
                session()->put('con_work',$configres->con_work);    //机构是否显示工作台 1 是 2否
                session()->put('jg_id',$res->cad_cid);              //机构id
                session()->put('ekang_name',$res->cad_name);        //管理师名字
                session()->put('cin_name',$yyres->cin_name);        //机构名称
                session()->put('cin_parentid',$yyres->cin_parentid);//机构的上级id
                session()->put('cin_parentall',$yyres->cin_parentall);//可查看机构id
                session()->put('cin_dbname',$yyres->cin_dbname);    //机构配置数据库
                //配置 18种 评估 权限
				if(session("ekang_id")=="262"||session("jg_id")=="341"||session("jg_id")=="118"||session("jg_id")=="437"||session("jg_id")=="755"||session("jg_id")=="762"||session("jg_id")=="763"||session("jg_id")=="764"){
                            //是 18
                            session()->put("zhname","zhname");
                            session()->put("mmpwd","dhcm2016");
				}else{
                            //是 3
                            session()->put("zhname","ldzg");
                            session()->put("mmpwd","123456");
                }
                //自定义机构权限
				if(session("jg_id") =='1' || session("jg_id") == 118 || session("jg_id") == 426 || session("jg_id") == 331){
                        session()->put("xzqx","cma_parentid!=3 and cma_parentid!=28 and cma_id!=3 and cma_id!=28 and cma_id!=104 and cma_parentid!=104");
				}else{
				    if(session("jg_id") == 427){
                        session()->put("xzqx","cma_parentid!=82 and cma_parentid!=3 and cma_parentid!=28 and cma_id!=82 and cma_id!=3 and cma_id!=28 and cma_id!=104 and cma_parentid!=104 and cma_id!=106 and cma_parentid!=106 and cma_id!=81 and cma_parentid!=81 and cma_id!=183 and cma_parentid!=184 and cma_id!=183 and cma_parentid!=184");
					}else{
                        session()->put("xzqx","cma_parentid!=82 and cma_parentid!=3 and cma_parentid!=28 and cma_id!=82 and cma_id!=3 and cma_id!=28 and cma_id!=104 and cma_parentid!=104 and cma_id!=106 and cma_parentid!=106");
					}
                }
                //登录外部链接
                if(isset($request['mem_state'])){
                    if($request['mem_state']=='2'){
                        return "<script>window.location.href='http://c.ekangcn.com/index.php/Index/index';</script>";
                    }else{
                        return 1; 
                    }
                }else{
                    return 1;
                }
			}else{
                //外部登录链接
                if(isset($request['mem_state'])){
                    if($request['mem_state']=='2'){
                        return "<script>window.location.href='".$url3."str=2';</script>";
                    }else{
                        return 2;
                    }
                }else{
                    return 2;
                }
			}			
        }
            
    }
    //退出登陆
	public function loginout(Request $request){
        if(isset($_GET['stase'])){
            if(session("ekang_id")){
				echo "<script>window.location.href='http://c.ekangcn.com/index.php/Index/index';</script>";
			}else{
				$config=M("config");
				$result=$config->where("con_sign='".$_GET['stase']."'")->find();
				$cinstitutions=M("cinstitutions");
				$cinstitutionsresult=$cinstitutions->where("cin_id='".$result['con_cid']."'")->find();
				setcookie("con_logo", $result['con_logo'], time()+3600*24*30,"/");
				setcookie("cin_name", $cinstitutionsresult['cin_name'], time()+3600*24*30,"/");
				setcookie("urlstase", $_GET['stase'], time()+3600*24*30,"/");
                $this->display("loginout");
                loginout();
			}
        }else{
            $url3=session("url3");
            Session()->flush();
            Session()->save();
			echo "<script>window.location.href='".$url3."';</script>";exit;
		}
	}
}
