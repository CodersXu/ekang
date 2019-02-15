<div class="minLeftsidebar">
  <ul class="itemBox classAList">
    <li onclick="openNavigation(this,'149')" id="Kwo149" class="on"><a href="/index"><img src="{{ URL::asset('images/icons/newicon01.png') }}">首页</a></li>
    <foreach name="functionslist.0" item="v">
	    <if condition="$v.cma_id eq '42'">
		    <li onclick="openNavigation(this,'{$v.cma_id}')" id="Kwo{$v.cma_id}"><a href="__APP__/Medical/index"><img src="{$v.cma_img}">{$v.cma_name}</a></li>
		<else /> 
		    <li onclick="openNavigation(this,'{$v.cma_id}')" id="Kwo{$v.cma_id}"><a href="##"><i></i><span></span>{$v.cma_name}</a>
		        <ul>
			    <foreach name="functionslist[$v['cma_id']]" item="chlid_functions">
					<li><a href="__APP__/{$chlid_functions.cma_action}/index" <if condition="$chlid_functions.cma_action eq 'Memberhealth'">target="_blank"</if>><img src="{$chlid_functions.cma_img}">{$chlid_functions.cma_name}</a></li>
				</foreach>
			    </ul>
	        </li>
	    </if>
	</foreach>
    <li><a  href="##" onclick="genxin()"><img src="{{ URL::asset('images/icons/newicon05-5.png') }}">操作手册</a></li>
  </ul>
</div>
