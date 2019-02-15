<script>
function genxin(){
    alert("抱歉！手册正在更新中。。。");
    return false;
}
//导航淡出淡入
function openNavigation(HTMLOBJ,id) {
        if($("#Kwo"+id).attr('class')=="on"){
            $(HTMLOBJ).removeClass("on").siblings("li");
            $("#Kwo149").removeClass("on");
        }else{
            $(HTMLOBJ).addClass("on").siblings("li");
            $("#Kwo149").removeClass("on");
        }	
    
    //
    return true;
}
//jq解析json
function jqObject(value){
return JSON.parse(value);
}
//加载左侧导航
/* window.onload=function(){
    var a= window.location.href;
    var aa=(a.split("/"));
    if(a.indexOf("?")>=0){
        var b=aa[5].substr(0, aa[5].indexOf('?'));

        }else{
        var  b=aa[5];
    }
    $.post('__APP__/Member/validation',{'shou':1,'cma_action':aa[4],'cma_function':b},function(data){
            var data = Object(data); 
                $("#Kwo"+data['fu']['cma_id']).addClass("on");
                $("#Kwo"+data['fu']['cma_id']).fadeIn(1000);
                if(data['fu']['cma_id']=="149"){
                    
                }else{
                $("#Kwo149").removeClass("on");
                }
                
            },'html'); 
} */
//编辑
function validation(num,ids,id,str,table,key){
    if(num == "1" || num == "2"){
        if($('#editid').val()&&$("#edit").attr('style')=='display: block;'){
                var idv=$('#editid').val();
            }else{
                var idv='0';
            }
            $.post('__APP__/Member/validation',{'key':key,'table':table,'type':ids,'value':$("#"+ids).val(),'id':idv,'num':num},function(result){
                if(result=='0'){
                    $("#"+id).html("");
                    if(num == '1'){
                        $("#password1").removeAttr("readonly");
                        $("#password2").removeAttr("readonly");
                    }
                }else{
                    $("#"+id).html(str);
                }
            },'html');
    }else{
        //ajax 请求编辑数据
            $.post('__APP__/Member/validation',{'key':key,'mem_cardnum':ids,'table':table,'num':num},function(result){
                var result = toObject(result);
                $('#info_year').attr('value',result['info_year']);
                $('#info_mouth').attr("value",result['info_mouth']);
                $('#info_day').attr("value",result['info_day']);

                $('#info_deviceid').attr("value",result['info_deviceid']);
                $('#info_jbqid_edit').attr("value",result['info_jbqid']);
                $('#info_id').attr("value",result['info_id']);
                
                if(result['info_sex'] =='1'){
                $('#sex1').attr("checked",true);
                $('#sex2').attr("checked",false);
                }else{
                $('#sex1').attr("checked",false);
                $('#sex2').attr("checked",true);
                }
            });
    }
            
}
//校验输入框内容长度
function check_length(content,conlength,show_id) {
    if(content.length>conlength){
        $("#"+show_id).html("超出允许最大长度");
    }else{
        $("#"+show_id).html("");
    }
    return true;
}
//判定联系方式的格式
function phone_way(HTMLOBJ) {
    $(HTMLOBJ).val($(HTMLOBJ).val().replace(/[^0-9\-]/g,''));
    return true;
}
//邮箱验证 type="1"必填 type='2'选填 show_id提示框id
function email_way(HTMLOBJ,show_id,type) {
    var pattern = /^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;  
    if($(HTMLOBJ).val()=="" && type=="2"){
            $("#"+show_id).html("");
    }else{
        if (!pattern.test($(HTMLOBJ).val())) {  
            $("#"+show_id).html("邮箱格式错误");
        }else{
                $("#"+show_id).html("");
        } 
    }
    return true;
}
	//重置搜索
function reset_search() {
	$("#search_centent input[type=text]").val("");
	$("#search_centent select").val("");
	return true;
}
//单页存在多处搜索重置
function reset_searchs(type) {
	$("#search_centents"+type+" input[type=text]").val("");
	$("#search_centents"+type+" select").val("");
	$("#search_centents"+type+" textarea").val("");
	return true;
}
</script>