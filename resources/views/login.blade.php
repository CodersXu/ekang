<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
@include('layouts.common')
<script>
	function check(){
		$.post("{{ url('profile') }}",{'types':'','cin_name':$("#cin_name").val(),'cad_login':$("#cad_login").val(),'cad_password':$("#cad_password").val()},function(data){
			/*if(data==3){
				$("#warn").html("系统维护中");
				return false;
			}*/
			if(data==1){
				$("#warn").html("");
				$("#formsub").submit();
			}else{
				$("#warn").html("登录信息不正确");
			}
		},'html');
	}
	
</script>
</head>
<body>
<!--<<背景层-->
<div class="institutionallandingBox">
    <!--<<内容层-->
    <div class="loginscontentBox">
    	<!--<<logo标题区-->
    	<div class="logostitles">
    		<span class="picsBox"><img src="{{ URL::asset('images/images_front/newmianlogo_01.png') }}"></span>
    		<p>中国健康管理大数据应用云平台</p>
    	</div>	
    	<!--logo标题区>>-->	
        <!--<<登陆信息框-->
        <div class="loginstextLinesBox">
        	<p class="titles"><span>机构登陆</span></p>
            <form method="POST" action="/index" id="formsub">
			{{csrf_field()}}
            <ul class="messagesListBox"> 	
		        <li>机构名称：<input placeholder="请输入机构名称" type="text" autocomplete="off" onkeyup="search_cin_name();" name="cin_name" id="cin_name">
		            <div class="promptsBox" id="cad_cid_listshow">
				        <ul id="cad_cid_list">
					    </ul>
			        </div>
		        </li>
			    <li>登陆账号：<input placeholder="请输入登陆账号" type="text" name="cad_login" oninput="nunehtml();" id="cad_login" /></li>
			    <li>登陆密码：<input placeholder="请输入登陆密码" type="password" name="cad_password" id="cad_password" /></li>
            </ul>
            <p class="errorsLines" id='warn'></p>
            <input class="loginsBtn" type="button"  onclick="check();" value="登陆" />
            </form>
        </div>
        <!--登陆信息框>>-->
        <!--<<底部内容层-->
        <div class="footersBox">
    	    <p class="names">中国卫生信息与健康医疗大数据学会<br/>中国老年保健医学研究会<br/>健康管理大数据应用研究基地</p>
    	    <p>中国健康促进基金会<br/>健康管理信息化与大数据应用专项基金<br/>平台技术支持单位：易康云（北京）健康科技股份有限公司</p>
        </div>	
        <!--底部内容层>>-->	
    
    </div>
    <!--内容层>>-->
    <!--<<背景动效展示层-->
    <div id="canvas-frame" class="dynamicsmianBox">
		<script type="text/javascript" src="{{ URL::asset('js/dynamic.js') }}"></script> 
    </div>	
    <!--背景动效展示层>>-->	
</div>
<!--<<引用百度统计-->
@include('layouts.overlay')
<!--引用百度统计>>-->
</body>
</html>
<script>
//Ajax csrf防注入 
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$(document).ready(function(){
	$(".institutionallandingBox").css( "height", $(window).height());
	var canvasmain =$("#canvas-frame").find("canvas").length;
	if(canvasmain == 0){
		$(".dynamicsmianBox").addClass("on");
	}else{
		$(".dynamicsmianBox").removeClass("on");
	}
		
});
//登录账号
function nunehtml(){
	$("#cad_cid_listshow").hide();
}
//jq json 解析
function jqObject(value){
return JSON.parse(value);
}
//搜索所属机构
function search_cin_name(){
	$("#cad_cid_select").val("");
	var cin_name=$("#cin_name").val();
	if(cin_name!=""){
		$.post("{{ url('logins') }}",{'type':9,'cin_name':cin_name},function(data){
		   $("#cad_cid_list").html("");
		    data=jqObject(data);
			for(var i=0;i<data.length;i++){
				$("#cad_cid_list").append("<li onclick=search_cname('"+data[i]['cin_name']+"')>"+data[i]['cin_name']+"</li>");
			}
			$("#cad_cid_listshow").show();
		})
	}else{
		$("#cad_cid_listshow").hide();
	}	
	return true;
}
//选择机构点击操作
	function search_cname(cin_name){
		$("#cin_name").val(cin_name);
		$("#cad_cid_listshow").hide();
		return true;
	}
//背景高度赋值
$(window).resize(function(){
    $(".institutionallandingBox").css( "height", $(window).height());
});
</script>