<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
        @include('layouts.common')
        {{-- 这里是Blade注释  <include file="../Public/common" /> --}} 
		<style>
			.guidesMainBox{background-image:url("{{ URL::asset('images/images_front/guidesmain_newbgs.jpg') }}");background-repeat:repeat-y;background-size:100% auto;width:100%;overflow-x:hidden;}
			.guidesMainBox .logosMainBox{width:1300px;display:block;margin:0 auto;}
			.guidesMainBox .logosMainBox img{display:block;width:100%;}
			.guidesMainBox .contersMainBox{padding:24px 0;width:1280px;display:block;margin:0 auto;height:552px;position:relative;}
			.guidesMainBox .contersMainBox .titlesText img{display:block;margin:0 auto;}
			.guidesMainBox .contersMainBox .leftsMainPicBox{position:absolute;top:100px;left:-120px;}
			.guidesMainBox .contersMainBox .leftsMainPicBox img{ display: block;transform-style: preserve-3d;transition: all 0.5s ease-out 0s}
			.guidesMainBox .contersMainBox .leftsMainPicBox img:hover{  -moz-transform: matrix( 1.05,0,0,1.05,0,0);-webkit-transform:matrix( 1.05,0,0,1.05,0,0);-ms-transform: matrix(1.05,0,0,1.05,0,0); z-index: 99;}
			.guidesMainBox .contersMainBox .areaFourMainBox{position:absolute;right:472px;top:230px;width:300px;height:300px;}
			.guidesMainBox .contersMainBox .areaFourMainBox span{display:block;width:148px;height:148px;position:absolute;cursor:pointer;transform-style: preserve-3d;transition: all 0.5s ease-out 0s}
			.guidesMainBox .contersMainBox .areaFourMainBox span:hover{  -moz-transform: matrix( 1.15,0,0,1.15,0,0);-webkit-transform:matrix( 1.15,0,0,1.15,0,0);-ms-transform: matrix(1.15,0,0,1.15,0,0); z-index: 99;-moz-box-shadow:5px 5px 16px #000000; -webkit-box-shadow:5px 5px 16px #000000; box-shadow:5px 5px 16px #000000;}
			.guidesMainBox .contersMainBox .areaFourMainBox span img{display:block;}
			.guidesMainBox .contersMainBox .areaFourMainBox .areaBtns01{left:0;top:0;}
			.guidesMainBox .contersMainBox .areaFourMainBox .areaBtns02{right:0;top:0;}
			.guidesMainBox .contersMainBox .areaFourMainBox .areaBtns03{left:0;top:152px;}
			.guidesMainBox .contersMainBox .areaFourMainBox .areaBtns04{right:0;top:152px;}
			.guidesMainBox .contersMainBox .areaThieeMainBox{position:absolute;right:0;top:230px;height:300px;width:450px;}
			.guidesMainBox .contersMainBox .areaThieeMainBox span{width:143px;height:300px;display:block;position:absolute;cursor:pointer;transform-style: preserve-3d;transition: all 0.5s ease-out 0s}
			.guidesMainBox .contersMainBox .areaThieeMainBox span:hover{  -moz-transform: matrix( 1.15,0,0,1.15,0,0);-webkit-transform:matrix( 1.15,0,0,1.15,0,0);-ms-transform: matrix(1.15,0,0,1.15,0,0); z-index: 99;-moz-box-shadow:5px 5px 16px #000000; -webkit-box-shadow:5px 5px 16px #000000; box-shadow:5px 5px 16px #000000;}
			.guidesMainBox .contersMainBox .areaThieeMainBox span img{display:block;width:100%;}
			.guidesMainBox .contersMainBox .areaThieeMainBox .areaBtns01{left:0;top:0;}
			.guidesMainBox .contersMainBox .areaThieeMainBox .areaBtns02{left:154px;top:0;}
			.guidesMainBox .contersMainBox .areaThieeMainBox .areaBtns03{right:0;top:0;}
			.guidesMainBox .linesMainBox {width: 1829px;display: block;margin: 0 auto;}
			.guidesMainBox .guidesBottomsBox{width: 1300px;display: block;margin: 0 auto;}
			.guidesMainBox .guidesBottomsBox img{display: block;width: 100%;}
		</style>
	</head>

	<body>
		<!--<<内容区域-->
		<div class="guidesMainBox">
			<!--<<顶部logo-->
			<div class="logosMainBox">
				<img src="{{ URL::asset('images/images_front/guidesmain_newlogos.png') }}">
			</div>
			<!--顶部logo>>-->
			<!--<<主内容区域-->
			<div class="contersMainBox">
				<!--<<标题区域-->
				<div class="titlesText">
					<img src="{{ URL::asset('images/images_front/guidesmain_titles.png') }}">
				</div>
				<!--标题区域>>-->
				<!--<<左侧图区-->
				<div class="leftsMainPicBox">
					<img src="{{ URL::asset('images/images_front/guidesmain_leftpic.png') }}">
				</div>
				<!--左侧图区>>-->
				<!--<<右侧四小块区域-->
				<div class="areaFourMainBox">
					<span class="areaBtns01" onClick="window.location.href='./login'">
						<img src="{{ URL::asset('images/images_front/guidesmain_box01.png') }}">
					</span>
					<span class="areaBtns02" onClick="window.location.href='./login'">
						<img src="{{ URL::asset('images/images_front/guidesmain_box02.png') }}">
					</span>
					<span class="areaBtns03" onClick="window.location.href='./login'">
						<img src="{{ URL::asset('images/images_front/guidesmain_box03.png') }}">
					</span>
					<span class="areaBtns04" onClick="window.location.href='./login'">
						<img src="{{ URL::asset('images/images_front/guidesmain_box04.png') }}">
					</span>
				</div>
				<!--右侧四小块区域>>-->
				<!--<<右侧三大块区域-->
				<div class="areaThieeMainBox">
					<span class="areaBtns01" onClick="window.location.href='./login'"><img src="{{ URL::asset('images/images_front/guidesmain_box05.png') }}"></span>
					<span class="areaBtns02" onClick="window.location.href='https://datav.aliyun.com/share/8053aab761ffdf74aeeab4d2cc7c1a7e?spm=datav.10712494.0.0.497d4a9ao610Y2&whatever=true'"><img src="{{ URL::asset('images/images_front/guidesmain_box06.png') }}"></span>
					<span class="areaBtns03" onClick="window.location.href='http://59.80.30.184:58081/rhip/?u=zht'"><img src="{{ URL::asset('images/images_front/guidesmain_box07.png') }}"></span>
				</div>
				<!--右侧三大块区域>>-->
			</div>
			<!--主内容区域>>-->
			<img class="linesMainBox" src="{{ URL::asset('images/images_front/guidesmain_lines.png') }}">
			<!--<<底部-->
			<div class="guidesBottomsBox">
				<img src="{{ URL::asset('images/images_front/guidesmain_footers.png') }}">
			</div>	
			<!--底部>>-->	
		</div>
		<!--内容区域>>-->
        <!--<<引用百度统计-->
        @include('layouts.overlay')
        <!--引用百度统计>>-->
		<!--<<获取屏幕高度-->
		<script>
			$(document).ready(function() {
				heights();
				mainwidths();
			})
			function heights() {
				var mainHeight = $(window).height();

				if(mainHeight < 920) {
					$(".guidesMainBox").css("height", '920px');
				} else {
					$(".guidesMainBox").css("height", mainHeight);
				}

				setTimeout("heights()", 1);
			}

			function mainwidths() {
				var mainWidth = $(window).width();
				if(mainWidth < 1829) {
					if(mainWidth < 1300){
					    $(".linesMainBox").css("margin-left", -264);
					}else{
						var resWidth = (mainWidth - 1829) / 2;
					    $(".linesMainBox").css("margin-left", resWidth);
					}
				}else{
					$(".linesMainBox").css("margin-left", 'auto');
				}
				setTimeout("mainwidths()", 1);
			}
		</script>

		<!--获取屏幕高度>>-->
	</body>

</html>