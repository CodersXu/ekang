<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
@include('layouts.common')
</head>
<body>
<!-- [[ 顶部 -->
@include('layouts.header')
<!-- 顶部 ]] -->
<!-- [[ 左侧 -->
@include('layouts.left')
<!-- 左侧 ]] -->
<!-- [[ 栏目标题 -->
<div class="rightAdminTopNameBox"><strong>首页</strong> </div>
<!-- 栏目标题 ]] -->
<!-- [[ 右侧 -->
<div class="minRightBodyBox" id="minRightBodyBox">
  <!-- [[ 右侧主体 -->
  <div class="adminContentBox">
    <div class="rightAdminTopNameBox"> <strong><a href="##">首页</a></strong> </div>
	<div style="text-align: center;font-size: 36px;line-height: 260px;">防病胜于治病、健康重在管理！</div>

  </div>
  <!-- 右侧主体 ]] -->
</div>
<!-- 右侧 ]] -->
<!--<<引用百度统计-->
@include('layouts.overlay')
<!--引用百度统计>>-->
<!-- [[ 底部 -->
@include('layouts.footer')
<!-- 底部 ]] -->
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
			console.log(data);
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