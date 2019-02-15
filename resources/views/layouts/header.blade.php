<div class="minTopBox">
  <div class="adminLogoBox">
  @if(session("con_logo"))
  <img src="{{ session('con_logo') }}"  height="60px" style="margin:12px 34px;"/>
  @endif
  </div>
  <h1 class="companyname">@if(session("ekang_id") == '1')易康云（北京）健康科技股份有限公司@else{{ session('cin_name') }}@endif</h1>
  <div class="operationBox">
  <a class="top_gono" href="javascript:history.go(-1);" id="top_gono"><input type="button" value="返回上一页"></a>
  <a class="top_gono" onclick="preview(1);" id="top_gonodebug"><input type="button" value="打印"></a>
  <div class="rightInfoBox">{{ session('ekang_name') }}您好，欢迎登录{{ session('cin_name') }}！ <a href="/loginout">安全退出</a></div>
  </div>
</div>