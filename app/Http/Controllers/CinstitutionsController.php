<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CinstitutionsController extends Controller
{
    /*
    *
    *ajax验证登陆
    *
    */
    public function validation(){
		$request = request()->all();
		// $request['cin_name'] = "易康";
		// if(isset($request['cin_name'])){
		// 	$res=DB::table("cinstitutions")
		// 	->where('cin_name', 'like', '%'.$request['cin_name'].'%')
		// 	->orderBy('cin_id')
		// 	->limit(8)
		// 	->get();
		// }
		// foreach($res as $v){
		// 	$cin_name[]=$v->cin_name;
		// }
		// dump($cin_name);die;
		if($request['type']=='1'){
			//编辑机构
			$cinstitutions=M('cinstitutions');
			$config=M('config');
			$kxxx=$cinstitutions->where("cin_id=".$request['id'])->select();
			$kxxx1=$config->where("con_cid=".$request['id'])->find();
            $kxxx[0]['equipmentlist']=$kxxx1['equipmentlist'];
			$kxxx[0]['wxyy_url']=$kxxx1['wxyy_url'];
			$kxxx[0]['con_work']=$kxxx1['con_work'];
			foreach($kxxx as $key=>$value){
				      unset($value['cin_bgqy']);
					foreach($value as $k=>$v){
					   $kxxx[$key][$k] = urlencode($v);
					}
				}
			$ros=$cinstitutions->where("cin_id='".$kxxx[0]['cin_parentid']."'")->find();
			$kxxx[0]['keyijg']=$ros['cin_name'];	
				echo urldecode(json_encode($kxxx));
		}else if($request['type']=='2'){
			//编辑配置/审核
			$config=M('config');
			$kxxx=$config->where("con_cid=".$request['id'])->select();
			foreach($kxxx as $key=>$value){
					foreach($value as $k=>$v){
					   $kxxx[$key][$k] = urlencode($v);
					}
				}
				echo urldecode(json_encode($kxxx));
		}else if($request['type'] == "4"){
			$cadmin=M('cadmin');
			$result=$cadmin->where("cad_cid=".$request['id']." and cad_level ='2'")->find();
			if($result){
			}else{
				$result=$cadmin->where("cad_cid=".$request['id'])->order("cad_id asc")->limit(1)->find();
			}
			
			echo $result['cad_id'];
		}else if($request['type'] == "5"){
			$cin_id=$request['cin_id'];
			$where="cin_parentid=".$request['cin_id'];
			$group=$request['group']+1;
			unset($request);
			$page_info = R('Public/Page/SearchParamPage',array('Institutions',1,$where,100,'cin_stor,cin_id',''));
			$cinstitutions=M('cinstitutions');
			//$operate='';
			//foreach($_SESSION['functionslist']['10'] as $ks=>$vs){
			//	if($vs['cma_position']=='2'){
			//		if($vs['cma_jsfunction']!=''){
			//			$operate.='<span class="btn01 h24" onclick='.$vs['cma_jsfunction'].'(tihuanid);>'.$vs['cma_name'].'</span>';
			//		}else{
			//		$operate.='<a class="btn03 h24 white" href="'.$vs['cma_function'].'?cin_id=tihuanid">'.$vs['cma_name'].'</a>';
			//		}
			//	}
			//}
			$tingyong="'你确定停用该机构?'";
			$qiyong="'你确定启用该机构?'";
			
			foreach($page_info['list'] as $k=>$v){

					$operate='';
					foreach($_SESSION['functionslist']['10'] as $ks=>$vs){
						if($vs['cma_position']=='2'){
							if($vs['cma_jsfunction']!=''){
								if($vs['cma_jsfunction']=='changesta'){
									if($v['con_state']=='1'){
										$operate.='<span class="btn01 h24" onclick='.$vs['cma_jsfunction'].'('.$v['cin_id'].');>'.$vs['cma_name'].'<dd class="prompt_this">1</dd></span>';
									}else{
										$operate.='<span class="btn01 h24" onclick='.$vs['cma_jsfunction'].'('.$v['cin_id'].');>'.$vs['cma_name'].'</span>';
									}
								}else{
									$operate.='<span class="btn01 h24" onclick='.$vs['cma_jsfunction'].'('.$v['cin_id'].');>'.$vs['cma_name'].'</span>';
								}
							}else{
								if($vs['cma_function']=='enable'){
									if($v['cin_state']==2){
										//if($_SESSION['ekang_id']!='1'){
										//	if($v['cin_id']!=$_SESSION['jg_id']){
										//		$operate.='<a class="btn03 h24 white" href="'.$vs['cma_function'].'?cin_id='.$v['cin_id'].'" onclick="return confirm('.$qiyong.')">'.$vs['cma_name'].'</a>';
										//	}
										//}else{
											$operate.='<a class="btn03 h24 white" href="'.$vs['cma_function'].'?cin_id='.$v['cin_id'].'" onclick="return confirm('.$qiyong.')">'.$vs['cma_name'].'</a>';
										//}
									}
								}else if($vs['cma_function']=='disables'){
									if($v['cin_state']==1){
										//if($_SESSION['ekang_id']!='1'){
										//	if($v['cin_id']!=$_SESSION['jg_id']){
										//		$operate.='<a class="btn03 h24 white" href="'.$vs['cma_function'].'?cin_id='.$v['cin_id'].'" onclick="return confirm('.$tingyong.')">'.$vs['cma_name'].'</a>';
										//	}
										//}else{
											$operate.='<a class="btn03 h24 white" href="'.$vs['cma_function'].'?cin_id='.$v['cin_id'].'" onclick="return confirm('.$tingyong.')">'.$vs['cma_name'].'</a>';
										//}
									}
								}else{
									$operate.='<a class="btn03 h24 white" href="'.$vs['cma_function'].'?cin_id='.$v['cin_id'].'">'.$vs['cma_name'].'</a>';
								}
							}
						}
					}
				$sms_record = M("sms_record");//短信表
		        $config = M("config");//机构库
				$debug=$config->where("con_cid='".$v['cin_id']."' and con_account!='' and con_password!=''")->find();
	            if($debug){
	                
					$dataArr['username'] = $debug['con_account'];
					$dataArr['password'] = MD5($debug['con_account'].MD5($debug['con_password']));
					$url = "http://www1.jc-chn.cn/balanceQuery.do?username=".$dataArr['username']."&password=".$dataArr['password']."";
					$ServiceWebsh = A("ServiceWebsh");
	                $list[$k]['countdxsy'] = $ServiceWebsh->postHttp($url);
	                if($list[$k]['countdxsy'] < 0){
		               $list[$k]['countdxsy'] = "0";
	                }
	            }else{
	                $list[$k]['countdxsy'] = "0";
	            }
				$list[$k]['countdx']=$sms_record->where("sms_cid=".$v['cin_id'])->count();
					$res=$cinstitutions->where("cin_parentid=".$v['cin_id'])->find();
					if($res){
						$class="rootsClose";
					}else{
						$class="centerDocu";
					}
					if($v['cin_state']=='1'){
					$cin_state="正常";
					}else{
					$cin_state="停用";
					}
					/*<span class="operation">'.str_replace("tihuanid",$v['cin_id'],$operate).'</span> */
					$result.='
          <li id="html'.$v['cin_id'].'">
			  <div class="itemBox">
				  <em class="'.$class.'" onclick="getlist(this);" id="'.$v['cin_id'].'" group="'.$group.'"></em>
				  <strong><a href="/index.php/Cadmin/index?cin_name_select='.$v['cin_name'].'">'.$v['cin_name'].'</a></strong>
				  <span class="name">'.$v['cin_head'].'</span>
				  <span class="telephone">'.$v['cin_headmobile'].'</span>
				  <span class="institution">'.$cin_state.'</span>
				  <span class="auditing">'.$list[$k]['countdxsy'].'</span>
				  <span class="remarks">'.$list[$k]['countdx'].'</span>
				  <span class="operation">'.$operate.'</span>
			  </div>
		  </li>';
		   if($cin_id==118){
	                if($k==0){
					  	$rjos='<ul class="lineBox rank'.$group.'" id="list'.$cin_id.'">
					         '.$result.'
					         </ul>';
					    echo $rjos;exit;
			        }    
			    }
					
			}
			$rjos='<ul class="lineBox rank'.$group.'" id="list'.$cin_id.'">
		         '.$result.'
		         </ul>';
		    echo $rjos;exit;
		}else if($request['type'] == "6"){
			$member=M('member');
			if($request['number']=='1'){
				$arr=explode(",",$request['mem_cardnum']);
				$str="";
				foreach($arr as $k=>$v){
					$v=str_replace(" ","",$v);
					$v=str_replace("	","",$v);
					$v=str_replace("/n","",$v);
					if($v!=""){
						$str.="'".$v."',";
					}
				}
				$result=$member->where("mem_cadid=".$_SESSION['ekang_id']." and mem_states='1' and mem_cardnum in (".trim($str,",").")")->count();
				//echo $member->getlastsql();exit;
				echo "检索到".$result."个可分配卡号";
			}else if($request['number']=='2'){
				$result=$member->where("mem_cadid=".$_SESSION['ekang_id']." and mem_states='1' and mem_cardnum >='".$request['mem_cardnum']."' and mem_cardnum <= '".$request['mem_cardnum_on']."'")->count();
				echo "检索到".$result."个可分配卡号";
			}else{
				$result=$member->where("mem_cadid=".$_SESSION['ekang_id']." and mem_states='1'")->limit(100000)->select();
				//echo $member->getlastsql();exit;
				foreach ($result as $key => $value) {
					$arr[].=$value['mem_cardnum'];
				}
				$is_true=$this->getconsecutive($arr,$request['card_nums']);
				//var_dump($is_true);exit;
				/*foreach($result as $k=>$v){
					$stacar=$v['mem_cardnum'];
					$endcar=$stacar+$request['card_nums']-1;
					$key=$k+$request['card_nums']-1;
					if($result[$key]['mem_cardnum']==$endcar){
						$is_true="1";
						break;
					}
				}
				if($is_true=='1'){
					echo $stacar."-".$endcar;
				}else{
					echo "2";
				}*/
				if($is_true){
					$shu=explode(",",$is_true);
					$stacar=$shu[0];
					$endcar=$shu[1];
					echo $is_true; 
				}else{
					echo "2";
				}
			}
			
			
		}else if($request['type'] == "7"){
			$cinstitutions=M("cinstitutions");
			if(!$request['cin_id']){
				$where="cin_name='".$request['cin_name']."'";
			}else{
				$where="cin_name='".$request['cin_name']."' and cin_id!='".$request['cin_id']."'";
			}
			$cin_name=$cinstitutions->where($where)->find();
			if($cin_name){
				echo 2;
			}else{
				echo 1;
			}
		}else if($request['type'] == "8"){
			$cadmin=M("cadmin");
			$cmanagement=M("cmanagement");
			$admin_pow=$cadmin->where("cad_id=".$_SESSION['ekang_id'])->find();
			$user_pow=$cadmin->where("cad_id=".$request['user_id'])->find();
			$user_pow=explode(",",$user_pow['cad_permissions']);
			foreach($user_pow as $k=>$v){
				$userpow[$v]='1';
			}
			if($request['user_id']=='1'){
				$result = $cmanagement->where($_SESSION['xzqx'])->order("cma_sord,cma_id desc")->field('cma_id,cma_parentid,cma_name')->select();
			}else{
				$result = $cmanagement->where("cma_id in (".$admin_pow['cad_permissions'].") and ".$_SESSION['xzqx'])->order("cma_sord,cma_id desc")->field('cma_id,cma_parentid,cma_name')->select();
			}
			
			  foreach($result as $key=>$value){
				  foreach ($result as $key1=>$value1){
					  if($userpow[$value['cma_id']]=='1'){
						$new_result[$key]["checked"] = "true";
					  }
					 if (($key != $key1) && ($value['cma_id']==$value1['cma_parentid'])){
						$new_result[$key]['open'] = "true";
						break;
					 }
				  }
				$new_result[$key]['id']=$value['cma_id'];
				$new_result[$key]['pId']=$value['cma_parentid'];
				$new_result[$key]['name']=urlencode($value['cma_name']);
			  }
			  echo urldecode(json_encode($new_result)); 
		}else if($request['type'] == "9"){
            //检索可查看机构列表
			if(session("cad_level")){
				if(session("cad_level")==2){
					if(isset($request['cin_name'])){
                    $res=DB::table("cinstitutions")
                    ->where('cin_name', 'like', $request['cin_name'])
                    ->where('cin_parentall', 'like', session("jg_id"))
                    ->orWhere('cin_id', session("jg_id"))
                    ->orderBy('cin_id')
                    ->limit(8)
					->get();
					}
					foreach($res as  $k =>$v){
						$base[$k]['cin_name']=$v->cin_name;
					}
					//$res=$cinstitutions->where("cin_name like '%".$request['cin_name']."%' and (cin_parentall like '%,".$_SESSION['jg_id'].",%' or cin_id='".$_SESSION['jg_id']."')")->order('cin_id')->limit(8)->select();
				}else{
				   // $res=$cinstitutions->where("cin_name like '%".$request['cin_name']."%' and cin_id='".$_SESSION['jg_id']."'")->order('cin_id')->limit(8)->select();
				   if(isset($request['cin_name'])){
                    $res=DB::table("cinstitutions")
                    ->where('cin_name', 'like', $request['cin_name'])
                    ->where('cin_id', '=', session("jg_id"))
                    ->orderBy('cin_id')
                    ->limit(8)
					->get();
					foreach($res as  $k =>$v){
						$base[$k]['cin_name']=$v->cin_name;
					}
				   }
				}
			}else{
                //$res=$cinstitutions->where("cin_name like '%".$request['cin_name']."%'")->order('cin_id')->limit(8)->select();
				if(isset($request['cin_name'])){
					$res=DB::table("cinstitutions")
					->where('cin_name', 'like', '%'.$request['cin_name'].'%')
					->orderBy('cin_id')
					->limit(8)
					->get();
					foreach($res as  $k =>$v){
						$base[$k]['cin_name']=$v->cin_name;
					}
				}
            }
            
			echo urldecode(json_encode($base));
		}else if($request['type'] == "10"){
			//检索可查看机构列表
			$member_info=M("member_info");
            $res=$member_info->where("info_workunit like '%".$request['info_workunit']."%'")->order('info_id')->limit(8)->select();
			echo urldecode(json_encode($res));
		}else{
			$this->display();
		}
	}
}
