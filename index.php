<?php

header("Content-type: text/html; charset=utf-8");
include_once('jcart/jcart.php');
require_once "functions.php";
session_start();
if($_SESSION['groups']==''){$_SESSION['groups']=1;}
$settingsX = @file("./gallery/settings/settings.txt");
for ($i=0; $i<count($settingsX); $i++){
$settings[$i] = trim($settingsX[$i]);
}

if (checkSite($_POST['pass']) OR checkSite($_SESSION['pass'])){
	if($_POST['pass']){$_SESSION['pass'] = $_POST['pass'];}

$group = @file("./gallery/settings/group.txt");
$grp = explode("|", trim($group[0]));

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
 <head>
 	<title><?=$settings[0]?></title>
 		<link rel="SHORTCUT ICON" href="fancybox/logo.ico"type="image/x-icon">
 		<meta name="viewport" content="width=device-width, initial-scale=1">
 	 	<meta http-equiv="Content-Type" content="text/html: charset=utf-8">
		<link href="main.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" media="screen, projection" href="/jcart/css/jcart.css" />
		<script type="text/javascript" src="/js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="/js/script.js"></script>
		<link rel="stylesheet" media="all" type="text/css" href="/js/jquery.datetimepicker.css" />
		<script type="text/javascript" src="/js/jquery.datetimepicker.js"></script>
		<script type="text/javascript" src="/js/jquery.chained.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
$('.search').change(function(){
        var chk = $(this).attr("name");
        var chkVal = $(this).attr("value");
        if(chk!='search'){$.ajax({
            url: 'tovar_list.php',
            type: 'get',
            data: chk+'='+chkVal+'&width='+document.body.clientWidth,
            success: function(data) { $("#body").html(data);}
        });}
});
$('.search').keyup(function(){
        var chk = $(this).attr("name");
        var chkVal = $(this).attr("value");
        if(!chkVal){chkVal=0;}
        $.ajax({
            url: 'tovar_list.php',
            type: 'get',
            data: chk+'='+chkVal+'&width='+document.body.clientWidth,
            success: function(data) { $("#body").html(data); }
        });
});
$('#bl').click(function(){
$("#tb").css({"background": "url(fancybox/tb0.png) no-repeat"});
$("#bl").css({"background": "url(fancybox/bl1.png) no-repeat"});
$.ajax({url: 'tovar_list.php',type: 'get',data: 'lsttyp=bl',success: function(data) { $("#body").html(data);}});
});
$('#tb').click(function(){
$("#bl").css({"background": "url(fancybox/bl0.png) no-repeat"});
$("#tb").css({"background": "url(fancybox/tb1.png) no-repeat"});
$.ajax({url: 'tovar_list.php',type: 'get',data: 'lsttyp=tb',success: function(data) { $("#body").html(data);}});
});
$('#aazz').click(function(){
if($(this).attr("value") == '0'){
$(this).css({"background": "url(fancybox/az.png) no-repeat"});
$(this).attr('value','up');
}
else if($(this).attr("value") == 'up'){
$(this).css({"background": "url(fancybox/za.png) no-repeat"});
$(this).attr('value','down');
}
else{
$(this).css({"background": "url(fancybox/aazz.png) no-repeat"});
$(this).attr('value','0');
}
$.ajax({url: 'tovar_list.php',type: 'get',data: 'nm='+$(this).attr("value"),success: function(data) { $("#body").html(data);}});
});

$('#cor1').click(function(){
if($(this).attr("value") == '1'){
$(this).css({"background": "url(fancybox/cor1.png) no-repeat"});
$('#cor0').css({"background": "url(fancybox/cor00.png) no-repeat"});
$.ajax({url: 'tovar_list.php',type: 'get',data: 'tvpz='+$(this).attr("value"),success: function(data) { $("#body").html(data);}});
$(this).attr('value','null');
$('#cor0').attr('value','0');
}
else {
$(this).css({"background": "url(fancybox/cor11.png) no-repeat"});
$.ajax({url: 'tovar_list.php',type: 'get',data: 'tvpz='+$(this).attr("value"),success: function(data) { $("#body").html(data);}});
$(this).attr('value','1');
}
});
$('#cor0').click(function(){
if($(this).attr("value") == '0'){
$(this).css({"background": "url(fancybox/cor0.png) no-repeat"});
$('#cor1').css({"background": "url(fancybox/cor11.png) no-repeat"});
$.ajax({url: 'tovar_list.php',type: 'get',data: 'tvpz='+$(this).attr("value"),success: function(data) { $("#body").html(data);}});
$(this).attr('value','null');
$('#cor1').attr('value','1');
}
else {
$(this).css({"background": "url(fancybox/cor00.png) no-repeat"});
$.ajax({url: 'tovar_list.php',type: 'get',data: 'tvpz='+$(this).attr("value"),success: function(data) { $("#body").html(data);}});
$(this).attr('value','0');
}
});

$('#x1122').click(function(){
if($(this).attr("value") == '0'){
$(this).css({"background": "url(fancybox/12.png) no-repeat"});
$(this).attr('value','up');
}
else if($(this).attr("value") == 'up'){
$(this).css({"background": "url(fancybox/21.png) no-repeat"});
$(this).attr('value','down');
}
else{
$(this).css({"background": "url(fancybox/1122.png) no-repeat"});
$(this).attr('value','0');
}
$.ajax({url: 'tovar_list.php',type: 'get',data: 'pr='+$(this).attr("value"),success: function(data) { $("#body").html(data);}});
});
setTimeout(function() {
$("#bl").css({"background": "url(fancybox/bl1.png) no-repeat"});
$.ajax({url: 'tovar_list.php',type: 'get',data:{lsttyp:'<?if($_SESSION['lsttyp']){echo $_SESSION['lsttyp'];}else{echo 'bl';}?>',tvpz:'<?if($_SESSION['tvpz']){echo $_SESSION['tvpz'];}else{echo 'null';}?>',group:'<?if($_SESSION['groups']){echo $_SESSION['groups'];}else{echo $grp[0];}?>',nm:'<?if($_SESSION['nm']){echo $_SESSION['nm'];}else{echo '0';}?>',pr:'<?if($_SESSION['pr']){echo $_SESSION['pr'];}else{echo '0';}?>',str:'<?if($_SESSION['str']){echo $_SESSION['str'];}else{echo '0';}?>',typecolor:'<?if($_SESSION['typecolor2']){echo $_SESSION['typecolor2'];}else{echo '0';}?>',prz:'<?if($_SESSION['prz']){echo $_SESSION['prz'];}else{echo '0';}?>',colors:'<?if($_SESSION['colors']){echo $_SESSION['colors'];}else{echo '0';}?>',top:'<?if($_SESSION['top']){echo $_SESSION['top'];}else{echo '0';}?>',search:'<?if($_SESSION['search']){echo $_SESSION['search'];}else{echo '0';}?>',width:document.body.clientWidth},success: function(data) { $("#body").html(data);}});
}, 1);
});
jQuery(document).ready(function(){jQuery("#typecolor").chained("#select");jQuery("#prz").chained("#select");jQuery("#str").chained("#select");jQuery("#colors").chained("#select");});
</script>
 </head>
 <body>
<div id="main_block_all">
<?if($settings[10]){echo '<div id="header"><img src="fancybox/logo.png" alt=""></div>';}?>
<div id="cform">
<img src="fancybox/logotip.png" id="logo" align="absmiddle">
<select size="1" style="width: 240px;" name="group" id="select" class="search">
<?

for ($i=0; $i<count($group); $i++){
$group[$i] = trim($group[$i]);
$gr = explode("|", $group[$i]);
$dirs = @file("./gallery/otdel".$gr[0]."/text/list.txt");
foreach ($dirs as $dr){$filret[$gr[0]]['group']++;}
$gr_title[$gr[0]] = $gr[1];
if($_SESSION['groups'] == $gr[0]){$dcv = ' selected';}else{$dcv = '';}
if($gr[1]!='' AND $filret[$gr[0]]['group'] > 0){$filret[$gr[0]]['name'] = $gr[1];}
}


foreach ($filret as $id => $vl){
	echo $id.'<br>';
	$dirs = @file("./gallery/otdel".$id."/text/list.txt");
	foreach ($dirs as $dr){
		$dr = trim($dr);
		if($dr == '') {continue;}
		$filearray = @file("./gallery/otdel".$id."/text/".$dr.'.txt');
		if($filearray[7] == 1){
			$filret[$id]['status']++;
			if(strlen(str_replace("\n", '', strip_tags($filearray[11])))>1){$filret[$id]['prz'][str_replace("\n", '', strip_tags($filearray[11]))]++;}
			if(strlen(str_replace("\n", '', strip_tags($filearray[4])))>1){$filret[$id]['str'][str_replace("\n", '', strip_tags($filearray[4]))]++;}
			if(strlen(str_replace("\n", '', strip_tags($filearray[10])))>1){$filret[$id]['colors'][str_replace("\n", '', strip_tags($filearray[10]))]++;}
			if(strlen(str_replace("\n", '', strip_tags($filearray[15])))>1){$filret[$id]['typecolor'][str_replace("\n", '', strip_tags($filearray[15]))]++;}
		}
	}
}

foreach ($filret as $id => $vl){
if($_SESSION['groups'] == $id){$dcv = ' selected';}else{$dcv = '';}
if($id!='' AND $filret[$id]['status'] > 0){echo '<option value="'.$id.'"'.$dcv.'>'.$filret[$id]['name'].'</option>';}
}
?></select>
<input name="search" type="text" value="<?=$_SESSION['search']?>" class="search" style="width: 115px;" placeholder="Название">
<a id="x1122" title="Цена" value="0"></a>
<a id="aazz" title="Сортировка" value="0"></a>
<!--<select size="1" name="str" id="str" class="search"><?
$strana = explode(",", $settings[9]);
foreach ($filret as $i => $v){
echo '<option value="0" class="'.$i.'">Страна</option>';
if($v['str']){foreach ($v['str'] as $id => $vl){
if($id == $_SESSION['str']){echo '<option class="'.$i.'" selected>'.$id.'</option>';}else{echo '<option class="'.$i.'">'.$id.'</option>';}
}}
}
?></select>-->
<select size="1" name="typecolor" id="typecolor" class="search"><?
$typecolor = explode(",", $settings[16]);
foreach ($filret as $i => $v){
echo '<option value="0" class="'.$i.'">Тип</option>';
if($v['typecolor']){foreach ($v['typecolor'] as $id => $vl){
if($id == $_SESSION['typecolor2']){echo '<option class="'.$i.'" selected>'.$id.'</option>';}else{echo '<option class="'.$i.'">'.$id.'</option>';}
}}
}
?></select>

<select size="1" name="colors" id="colors" class="search"><?
$color = explode(",", $settings[7]);
foreach ($filret as $i => $v){
echo '<option value="0" class="'.$i.'">Цвет</option>';
if($v['colors']){foreach ($v['colors'] as $id => $vl){
if($id == $_SESSION['colors']){echo '<option class="'.$i.'" selected>'.$id.'</option>';}else{echo '<option class="'.$i.'">'.$id.'</option>';}
}}
}
?></select>
<a id="cor1" title="Товар в наличии" value="1"></a>
<a id="cor0" title="Товар под заказ" value="0"></a>
<a id="bl" title="ячейки"></a>
<a id="tb" title="структура"></a>
</div>

<div id="body"></div>
<?if($settings[11]){echo '<div id="footer"><img src="fancybox/bottom_logo.png"></div>';}?>
	</div>
<div class='modal-box'><div class='modal-close'></div><div class='box'><a href='#' class='close'><img src='/fancybox/fancy_close.png' style='display:none;' border='0'><div class="buts buts2">Продолжить заказ</div></a><div class='modal'></div></div></div>
 </body>
</html>
<?
}
else {
?>
<html>
 <head>
 	<title>Торг Цвет</title>
 		<link rel="SHORTCUT ICON" href="fancybox/logo.ico"type="image/x-icon">
 	 	<meta http-equiv="Content-Type" content="text/html: charset=utf-8">
 	    <meta http-equiv="Content-Style-Type" content="text/css">
 	    <style type="text/css">
 	    	.pvp_p1{
	position: absolute;
	top:-42px;
	left:100px;
	color:#fff;
}

#popul_vxod_panel{
	border-top:solid #921414 29px;
	border-bottom:solid black 2px;
	border-left:solid black 2px;
	border-right:solid black 2px;
	background-color: #fff;
	position: relative;
	z-index: 999;
	top:35%;
	left:35%;
	width: 400px;
	height:200px;
	padding: 10px;
	}
 	    </style>
	</head>
<body>
	<div id="popul_vxod_panel">
		<p class="pvp_p1">&laquo; Авторизация &raquo;</p>
		<p>-->Для авторизации введите уникальный пароль</p>
		<form action="index.php" method="post">
			<br><br><br>
			<label>Пароль-><input type="password" name="pass"></label>
			<input type="submit" value="Войти" name="vxod_akk">
		</form>
	</div>

 </body>
</html>
<?
}
?>