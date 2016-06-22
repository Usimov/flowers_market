<?php
header("Content-type: text/html; charset=utf-8");
session_start();
require_once "functions.php";
if(!$_POST['cat']){$_POST['cat']=$_GET['menu'];}
if(!$_POST['cat']){$_POST['cat']=$_GET['group'];}
if($_POST['send'] AND $_POST['settings']){
$fp = fopen("./gallery/settings/settings.txt", "w");
$nnn = 0;
while ($nnn != 17){
$test = fwrite($fp, trim($_POST['settings'][$nnn])."\n");
$nnn=$nnn+1;
}
fclose($fp);

if($_POST['agreement']){$fp = fopen("./gallery/settings/agreement.txt", "w");
$test = fwrite($fp, $_POST['agreement']);
fclose($fp);}
if($_POST['zakaz']){$fp = fopen("./gallery/settings/zakaz.txt", "w");
$test = fwrite($fp, $_POST['zakaz']);
fclose($fp);}
}

$settingsX = @file("./gallery/settings/settings.txt");
for ($i=0; $i<count($settingsX); $i++){
$settings[$i] = trim($settingsX[$i]);
}
// select стран
$strans = explode(',',$settings[9]);

// Сортировка групп
if($_POST['sortable']){
$group = @file("./gallery/settings/group.txt");
for ($i=0; $i<count($group); $i++){
$group[$i] = trim($group[$i]);
$gr = explode("|", $group[$i]);
$gp[$gr[0]] = $gr[1];
$gpx[$gr[0]] = $gr[2];
$gpxx[$gr[0]] = $gr[3];
}
$grp='';
$sort = explode(",", $_POST['sortable']);
for ($i=0; $i<count($sort); $i++){
if($grp!=''){$grp .= '
';}
$grp .= $sort[$i].'|'.$gp[$sort[$i]].'|'.$gpx[$sort[$i]].'|'.$gpxx[$sort[$i]];
}

$fp = fopen("./gallery/settings/group.txt", "w");
$test = fwrite($fp, $grp);
fclose($fp);
}
// Добавление группы
if ($_POST['add_group'] == 1 AND $_POST['name_group'] != ''){
$group = @file("./gallery/settings/group.txt");
$grID=0;
for ($i=0; $i<count($group); $i++){
$group[$i] = trim($group[$i]);
$gr = explode("|", $group[$i]);
if($grID < $gr[0]){$grID=$gr[0];}
}
$grID = $grID + 1;
$fp = @fopen("./gallery/settings/group.txt", "a");
$test = @fwrite($fp, '
'.$grID.'|'.$_POST['name_group'].'|'.$_POST['name2_group'].'|'.$_POST['str']);
@fclose($fp);
@mkdir('./gallery/otdel'.$grID);
@mkdir('./gallery/otdel'.$grID.'/m');
@mkdir('./gallery/otdel'.$grID.'/text');
$fp = @fopen('./gallery/otdel'.$grID.'/text/list.txt', "w");
$test = @fwrite($fp, '');
@fclose($fp);
$fp = @fopen('./gallery/otdel'.$grID.'/text/.htaccess', "w");
$test = @fwrite($fp, '<FilesMatch "\.(txt)$">
Order allow,deny
Deny from all
<FilesMatch>');
@fclose($fp);
}
// Редактирование группы
if ($_POST['edit_group'] == 1 AND $_POST['id_group'] != '' AND $_POST['name_group'] != ''){
$grp='';
$group = @file("./gallery/settings/group.txt");
for ($i=0; $i<count($group); $i++){
$group[$i] = trim($group[$i]);
$gr = explode("|", $group[$i]);
if($grp!=''){$grp .= '
';}
if($gr[0] == $_POST['id_group']){$grp .= $gr[0].'|'.$_POST['name_group'].'|'.$_POST['name2_group'].'|'.$_POST['str'];}
else{$grp .= $group[$i];}
}
$fp = fopen("./gallery/settings/group.txt", "w");
$test = fwrite($fp, $grp);
fclose($fp);
}
// Удаление группы
if ($_POST['delete_group'] == 1 AND $_POST['id_group'] != ''){
$dir = directory('./gallery/otdel'.$_POST['id_group'].'/m','all');
foreach ($dir as $x){@unlink('./gallery/otdel'.$_POST['id_group'].'/m/'.$x);}
$dir = directory('./gallery/otdel'.$_POST['id_group'].'/text','all');
foreach ($dir as $x){@unlink('./gallery/otdel'.$_POST['id_group'].'/text/'.$x);}
$dir = directory('./gallery/otdel'.$_POST['id_group'],'all');
foreach ($dir as $x){@unlink('./gallery/otdel'.$_POST['id_group'].'/'.$x);@rmdir('./gallery/otdel'.$_POST['id_group'].'/'.$x);}
@rmdir('./gallery/otdel'.$_POST['id_group']);

$grp='';
$group = @file("./gallery/settings/group.txt");
for ($i=0; $i<count($group); $i++){
$group[$i] = trim($group[$i]);
$gr = explode("|", $group[$i]);
if($gr[0] != $_POST['id_group']){
if($grp!=''){$grp .= '
';}
$grp .= $group[$i];}
}
$fp = fopen("./gallery/settings/group.txt", "w");
$test = fwrite($fp, $grp);
fclose($fp);
}

if (checkUser($_POST['password']) OR checkUser($_SESSION['password'])){if($_POST['password']){$_SESSION['password'] = $_POST['password'];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
 <head>
 	<title><?=$settings[0]?></title>
 		<link rel="SHORTCUT ICON" href="fancybox/logo.ico"type="image/x-icon">
 	 	<meta http-equiv="Content-Type" content="text/html: charset=utf-8">
 	    <meta http-equiv="Content-Style-Type" content="text/css">
		<link href="main.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		<script type="text/javascript" src="js/ajaxupload.3.5.js"></script>
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
		<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="/ckeditor/adapters/jquery.js"></script>
        <script type="text/javascript" src="/ckeditor/config.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#panel_upr_ul3").sortable({handle:".drag-handle",cursor:'move', forcePlaceholderSize: true,placeholder:'#panel_upr_ul3',revert: true,update: function( event, ui ) {
$.ajax({
            url: 'admin.php',
            type: 'post',
        	cache: false,
            data: {sortable:$(this).sortable('toArray').toString()}
});
}});
<? if($_GET['go']){?>$("#files").sortable({connectWith:".connect",cursor:'move', forcePlaceholderSize: true,placeholder:'#files',revert: true});<?}?>

function puffAnime(which,img,width,count) {
	var $this = $(which),
		image_width = width,
		scale_factor = $this.outerWidth() / image_width,
		frame_count = count,
		$trash, $puff;

	// create container
	$trash = $('<div class="puff"></div>')
		.css({
			height: $this.outerHeight(),
			left: $this.offset().left,
			top: $this.offset().top,
			width: $this.outerWidth(),
			position: 'absolute',
			overflow: 'hidden'
		})
		.appendTo('body');

	// add the animation image
	$puff = $('<img class="puff" src="'+img+'"/>')
		.css({
			width: image_width * scale_factor,
			height: (frame_count * image_width) * scale_factor
		})
		.data('count', frame_count)
		.appendTo($trash);

		// remove the original element
		$this.animate({
			opacity: 0
		}, 'fast');

		// or even
		// $this.fadeOut('fast');

	(function animate() {

		var count = $puff.data('count');

		if(count) {
			var top = frame_count - count;
			var height = $puff.height() / frame_count;
			$puff.css({
				"top": - (top * height),
				'position': 'absolute'
			});
			$trash.css({
				'height': height
			})
			$puff.data("count", count - 1);
			setTimeout(animate, 75);
		}
		else {
			$puff.parent().remove();
		}
	})();

}
$("#menu").click(function(){
if ($("#panel_upr_ul1").is(':hidden')) {$("#panel_upr_ul1").fadeIn("fast");}
else {$("#panel_upr_ul1").fadeOut("fast");}
return false;
});
});

$(document).ready(function(){
$('#add_group').click(function(){
$('.group').remove();
$('<div></div>').prependTo('body').html('<a href="/admin.php?<?if($_GET['group']!=''){echo 'group='.$_GET['group'];}if($_GET['menu']!=''){echo 'menu='.$_GET['menu'];}?>" class="cls"><img src="fancybox/fancy_close.png" border="0"></a><form method="post" action="/admin.php?<?if($_GET['group']!=''){echo 'group='.$_GET['group'];}if($_GET['menu']!=''){echo 'menu='.$_GET['menu'];}?>"><input name="add_group" type="hidden" value="1"><h3>Добавление</h3><p><input name="name_group" type="text" placeholder="Название производителя"><br><input name="name2_group" type="text" placeholder="Название %"><br><select name="str"><? for($q=0;$q<count($strans);$q++){
echo "<option>".$strans[$q]."</option>";} ?></select></p><input class="buts" type="submit" value="Отправить"></form>').addClass('group');
});
$('.edit_group').click(function(){
$('.group').remove();
$('<div></div>').prependTo('body').html('<a href="/admin.php?<?if($_GET['group']!=''){echo 'group='.$_GET['group'];}if($_GET['menu']!=''){echo 'menu='.$_GET['menu'];}?>" class="cls"><img src="fancybox/fancy_close.png" border="0"></a><form method="post" action="/admin.php?<?if($_GET['group']!=''){echo 'group='.$_GET['group'];}if($_GET['menu']!=''){echo 'menu='.$_GET['menu'];}?>"><input name="edit_group" type="hidden" value="1"><h3>Редактирование</h3><p><input name="id_group" type="hidden" value="'+$(this).attr("id")+'"><input name="name_group" type="text" value="'+$(this).attr("name")+'" placeholder="Название производителя"><br><input name="name2_group" type="text" value="'+$(this).attr("name2")+'" placeholder="Название %"><br><select id="stra" name="str"><? for($q=0;$q<count($strans);$q++){
echo "<option id=".$strans[$q].">".$strans[$q]."</option>";} ?></select></p><br /><input class="buts" type="submit" value="Отправить"></form>').addClass('group');
$('#'+$(this).attr("str")).attr('selected','selected');
});
$('.delete_group').click(function(){
$('.group').remove();
$('<div></div>').prependTo('body').html('<a href="/admin.php?<?if($_GET['group']!=''){echo 'group='.$_GET['group'];}if($_GET['menu']!=''){echo 'menu='.$_GET['menu'];}?>" class="cls"><img src="fancybox/fancy_close.png" border="0"></a><form method="post" action="/admin.php?<?if($_GET['group']!=''){echo 'group='.$_GET['group'];}if($_GET['menu']!=''){echo 'menu='.$_GET['menu'];}?>"><input name="delete_group" type="hidden" value="1"><h3>Удаление</h3><p><input name="id_group" type="hidden" value="'+$(this).attr("id")+'">Все данные и производитель<br />"<b>'+$(this).attr("name")+'</b>"<br />будет удален!<br />Удалить?</p><br /><input class="buts" type="submit" value="Да"></form>').addClass('group');
});
});
</script>
 </head>
<body class="div_ap"><input type="submit" value="МЕНЮ" class="but2" id="menu">
 	<h1 id="admin_h1"><?=$settings[0]?></h1>
 	<ul id="panel_upr_ul1">
		<li class="admin_li1"><a href="index.php">->Перейти на сайт</a></li>
		<li class="admin_li1"><a href="" class="panel_a2">->Банеры</a></li>
			<ul id="panel_upr_ul2" <?if($_GET['menu'] > 3 AND $_GET['menu']){?>style="display: block;"<?}?>>
				<li class="admin_li2"><a href="?menu=4" <?if($_GET['menu'] == 4 AND $_GET['menu']){?>class="active"<?}?>>->Верхний</a></li>
				<li class="admin_li2"><a href="?menu=5" <?if($_GET['menu'] == 5 AND $_GET['menu']){?>class="active"<?}?>>->Нижний</a></li>
				<li class="admin_li2"><a href="?menu=6" <?if($_GET['menu'] == 6 AND $_GET['menu']){?>class="active"<?}?>>->Открытка</a></li>
				<li class="admin_li2"><a href="?menu=7" <?if($_GET['menu'] == 7 AND $_GET['menu']){?>class="active"<?}?>>->Фон</a></li>
				<li class="admin_li2"><a href="?menu=9" <?if($_GET['menu'] == 9 AND $_GET['menu']){?>class="active"<?}?>>->Логотип</a></li>
			</ul>
		<li class="admin_li1"><a href="" class="panel_a5">->Производители</a><a id="add_group" title="Добавить"><img src="fancybox/Folders-Add-Folder-icon.png" border="0"></a></li>
			<ul id="panel_upr_ul3" <?if($_GET['group'] AND $_GET['menu'] == ''){?>style="display: block;"<?}?>>
<?
$group = @file("./gallery/settings/group.txt");
for ($i=0; $i<count($group); $i++){
$group[$i] = trim($group[$i]);
$gr = explode("|", $group[$i]);
$gr_title[$gr[0]] = $gr[1];
$gr_name[$gr[0]] = $gr[2];
if($gr[1]!=''){?><li class="admin_li3" id="<?=$gr[0]?>"><span class="drag-handle">☰</span><a href="?group=<?=$gr[0]?>" <?if($_GET['group'] == $gr[0] AND $_GET['group']){?>class="active"<?}?>><?=$gr[1]?></a><div class="bbtt"><a class="edit_group" id="<?=$gr[0]?>" name2="<?=$gr[2]?>" name="<?=$gr[1]?>" str="<?=$gr[3]?>" title="Редактировать"><img src="fancybox/Pencil-icon.png" border="0"></a> <a class="delete_group" id="<?=$gr[0]?>" name="<?=$gr[1]?>" title="Удалить"><img src="fancybox/Editing-Delete-icon.png" border="0"></a></div></li><?}
}
?>
			</ul>
		<li class="admin_li1"><a href="?menu=8" <?if($_GET['menu'] == 8 AND $_GET['menu']){?>class="active"<?}?>>->Настройки</a></li>
	</ul>
<?
if($_POST['save']){
	if($_POST['go']){
		for($i=0; $i<count($_POST['list_id']); $i++){
			if($_POST['list_id'][$i] != $_POST['list_num'][$i])$savevar = 1;
		}

		if($savevar!=''){
			for($i=0; $i<count($_POST['list']); $i++){$lsnum[$_POST['list_num'][$i]] = $_POST['list'][$i];
		}
		for($i=0; $i<count($lsnum); $i++){
			$x=$i+1;
			if($lsnum[$x])$lssave[] = $lsnum[$x];
			}
			if(count($_POST['list']) == count($lssave)){
				$fp = fopen("./gallery/otdel".$_POST['cat']."/text/list.txt", "w");for($i=0;$i<count($lssave);$i++){$num = $num.$lssave[$i]."\n";}
				$test = fwrite($fp, $num);
				fclose($fp);
			}
		}
		else {
			if($_POST['list']){
				$fp = fopen("./gallery/otdel".$_POST['cat']."/text/list.txt", "w");
				for($i=0;$i<count($_POST['list']);$i++){$num = $num.$_POST['list'][$i]."\n";}
				$test = fwrite($fp, $num);
				fclose($fp);
			}
		}
	}
	else{
		$aa = 1;
		foreach ($_POST as $s_var => $s_value) {
			if($s_var != 'save' AND $s_var != 'list' AND $s_var != 'cat' AND $s_var != 'list_id' AND $s_var != 'list_num' AND $s_var != 'go'){
				$fp = fopen("./gallery/otdel".$_POST['cat']."/text/".$s_var.'.txt', "w");
				$nnn2 = 0;
				while ($nnn2 != 16){
					//echo $s_value[10];
					$test = fwrite($fp, trim($s_value[$nnn2])."\n");
					$nnn2=$nnn2+1;
				}
				fclose($fp);
				$aa = $aa +1;
			}
		}

	}
}

if($_GET['del']){$dirs = @file("./gallery/otdel".$_GET['cat']."/text/list.txt");
foreach ($dirs as $dir){
$dir = trim($dir);if($dir != $_GET['del']){$list = $list.$dir.'
';}
}
$fp = fopen("./gallery/otdel".$_GET['cat']."/text/list.txt", "w");
$test = fwrite($fp, $list);
fclose($fp);
	@unlink("./gallery/otdel".$_GET['cat']."/text/".$_GET['del'].".txt");
	@unlink("./gallery/otdel".$_GET['cat']."/m/".$_GET['del'].".jpg");
	@unlink("./gallery/otdel".$_GET['cat']."/".$_GET['del'].".jpg");
}
if($_GET['group'] AND $_GET['menu'] == ''){
$i = $_GET['group'];
?>
<form action="/admin.php" method="get">
<input name="group" type="hidden" value="<?=$_GET['group']?>">
<? if(!$_GET['go']){?>
<input name="go" type="hidden" value="1">
<input type="submit" value="Перемещать" class="but3">
<?}else{?>
<input type="submit" value="Редактировать" class="but3">
<?}?>
</form>
<? if(!$_GET['go']){?><div id="mainbody" ><div id="upload"><span>Выбрать файл<span></div><span id="status"></span></div><?}?>
		<table border="1" style="max-width: 945px;width: 100%;margin: 15px auto;">
			<tr>
				<td>
					<p style="color:red;text-align: center;margin:5px;font-size:20;"><?=$gr_title[$_GET['group']]?></p>
				</td>
			</tr>
			<tr>
				<td>
					<script type="text/javascript" >
						$(function(){
							var btnUpload=$('#upload');
							var status=$('#status');
							new AjaxUpload(btnUpload, {
							action: 'upload-file.php?dir=<?=$i?>',
							name: 'uploadfile',
							onSubmit: function(file, ext){
				 			if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
								status.text('Поддерживаемые форматы JPG, PNG или GIF');
								return false;
							}
							$('#upload span').text('Загрузка...');
						},
						onComplete: function(file, response){
							$('#upload span').text('Выбрать файл');
							if(response!="error"){								var dirS = response.split('.');
								$('<li></li>').prependTo('#files').html('<img src="./gallery/otdel<?=$i?>/m/'+response+'" border="0"><p><input name="cat" type="hidden" value="<?=$i?>"><input name="list[]" type="hidden" value="'+dirS[0]+'"><input name="list_id[]" type="hidden" value=""><input name="list_num[]" type="hidden" value=""><input name="'+dirS[0]+'[cat]" type="hidden" value="<?=$i?>6"><input name="'+dirS[0]+'[0]" type="text" size="19" placeholder="Название" title="Название"><input name="'+dirS[0]+'[1]" type="text" size="19" placeholder="Размер" title="Размер"><input name="'+dirS[0]+'[9]" type="text" size="19" placeholder="Вес" title="Вес"><input name="'+dirS[0]+'[2]" type="text" size="19" placeholder="Цена" title="Цена"><input name="'+dirS[0]+'[3]" type="text" size="19" placeholder="Колличество в упаковке" title="Колличество в упаковке"><select size="1" name="'+dirS[0]+'[10]" placeholder="Цвет" title="Цвет"><option></option><?$color = explode(",", $settings[7]);for($q=0;$q<count($color);$q++){echo '<option>'.$color[$q].'</option>';}?></select><select size="1" name="'+dirS[0]+'[15]" placeholder="Тип цвета" title="Тип цвета"><option></option><?$color = explode(",", $settings[16]);for($q=0;$q<count($color);$q++){echo '<option>'.$color[$q].'</option>';}?></select><input name="'+dirS[0]+'[5]" type="text" size="19" placeholder="Упаковки через запятую" title="Упаковки через запятую"><input name="'+dirS[0]+'[6]" style="width: 108px;" type="text" size="19" placeholder="<?=$gr_name[$_GET['group']]?>" title="<?=$gr_name[$_GET['group']]?>"><select style="width: 65px;" size="1" name="'+dirS[0]+'[13]"><option value="rub">руб.</option><option value="usd">дол.</option><option value="eur">евр.</option><option value="uan">юань</option></select><input name="'+dirS[0]+'[12]" type="text" size="19" placeholder="В наличии" title="В наличии"><select size="1" name="'+dirS[0]+'[14]" placeholder="Дней доставки" title="Дней доств"><option></option><?$proiz = explode(",", $settings[15]);for($q=0;$q<count($proiz);$q++){echo '<option>'.$proiz[$q].'</option>';}?></select><input name="'+dirS[0]+'[8]" type="text" size="19" placeholder="Кол. заказов" title="Кол. заказов"></p><sx class="buts"><input name="'+dirS[0]+'[7]" type="hidden" value="0"><input name="'+dirS[0]+'[7]" type="checkbox" value="1" id="id'+dirS[0]+'"> <label for="id'+dirS[0]+'">Показать</label></sx><a href="?group=<?=$i?>&del='+dirS[0]+'&cat=<?=$i?>" class="buts" style="margin-left: 11px;">Удалить</a><p></p>').addClass('success');
							}
						}
							});
					});
<?if(!$_GET['go']){?>
$(document).ready(function(){
$('.search').change(function(){
        var chk = $(this).attr("name");
        var chkVal = $(this).attr("value");
        if(chk!='search'){$.ajax({
            url: 'admin_list.php',
            type: 'get',
            data: chk+'='+chkVal+'&list=<?=$_GET['group']?>',
            success: function(data) { $("#files").html(data);}
        });}
});
$('.search').keyup(function(){
        var chk = $(this).attr("name");
        var chkVal = $(this).attr("value");
        if(!chkVal){chkVal=0;}
        $.ajax({
            url: 'admin_list.php',
            type: 'get',
            data: chk+'='+chkVal+'&list=<?=$_GET['group']?>',
            success: function(data) { $("#files").html(data); }
        });
});
setTimeout(function() {$.ajax({url: 'admin_list.php',type: 'get',data:{tvpz:'null',pr:0,str:0,top:0,search:0,list:<?=$_GET['group']?>},success: function(data) { $("#files").html(data);}});}, 1);
});
<?}?>
				</script>
<?php
if(!$_GET['go']){
?>
<div align="center" class="filtr">
<select size="1" name="pr" class="search"><option value="0">Цена</option><option value="up">возрастание</option><option value="down">убывание</option></select>
<select size="1" name="typecolor" class="search"><option value="0">Тип</option>
	<? $typecolor = explode(",", $settings[16]);
	for($q=0;$q<count($typecolor);$q++){
		if(trim($typecolor[$q]) == '') {continue;}
		if($_SESSION['typecolor']==trim($typecolor[$q])){
			$qq='selected';
		}
		else {
			$qq='';
		}
		echo '<option '.$qq.'>'.$typecolor[$q].'</option>';}?></select>
<select size="1" name="colors" class="search"><option value="0">Цвет</option>
	<? $color = explode(",", $settings[7]);
	for($q=0;$q<count($color);$q++){
		if(trim($typecolor[$q]) == '') {continue;}
		if($_SESSION['colors']==trim($color[$q])){
			$qq='selected';
		}
		else {
			$qq='';
		}
		echo '<option '.$qq.'>'.$color[$q].'</option>';}?></select>
<select size="1" name="nm" class="search"><option value="0">Сортировка</option><option value="up">А-Я</option><option value="down">Я-А</option></select>
<input name="search" type="text" value="<? if($_SESSION['name']){echo $_SESSION['name'];} ?>" class="search" style="width: 115px;" placeholder="Название">
<select size="1" name="tvpz" class="search"><option value="null">Все</option><option value="1">в наличии</option><option value="0">под заказ</option></select>
</div>
<?}?>
<form method="post"><div align="center" ><br />
	<input type="submit" value="Сохранить изменения" class="but">
<input name="save" type="hidden" value="1"><input name="go" type="hidden" value="<?=$_GET['go']?>"></div><ul id="files" class="ui-widget connect">
<? if($_GET['go']){$qw=1;
$dirs = @file("./gallery/otdel".$i."/text/list.txt");
foreach ($dirs as $dir){
$dir = trim($dir);
if ($dir == '') {continue;}
$file_array = @file("./gallery/otdel".$i."/text/".$dir.'.txt');
for($xz=0;$xz<count($file_array);$xz++){$file_array[$xz] = trim($file_array[$xz]);}

if($file_array[7] == 1){$file_array[7] = 'checked';}else{$file_array[7] = '';}
if(@file_exists($_SERVER['DOCUMENT_ROOT'].'/gallery/otdel'.$i.'/m/'.$dir.'.gif')){$img = '.gif';}
elseif(@file_exists($_SERVER['DOCUMENT_ROOT'].'/gallery/otdel'.$i.'/m/'.$dir.'.bmp')){$img = '.bmp';}
elseif(@file_exists($_SERVER['DOCUMENT_ROOT'].'/gallery/otdel'.$i.'/m/'.$dir.'.jpeg')){$img = '.jpeg';}
elseif(@file_exists($_SERVER['DOCUMENT_ROOT'].'/gallery/otdel'.$i.'/m/'.$dir.'.png')){$img = '.png';}
else{$img = '.jpg';}

echo '<li><img src="./gallery/otdel'.$i.'/m/'.$dir.$img.'" border="0" style="cursor: all-scroll;"><p><input name="cat" type="hidden" value="'.$i.'"><input name="list[]" type="hidden" value="'.$dir.'"><input name="list_id[]" type="hidden" value="'.$qw.'"></p><input name="list_num[]" type="hidden" value="'.$qw.'" size="1" placeholder="Номер" title="Номер" style="text-align: center;margin-left: 55px;"></li>';

$qw++;
}}
?></ul></td>
		</tr>
			</form>

	</table>
<form method="post" id="admin_form1" style="position: fixed;top: 130px;right: 15px;" enctype="multipart/form-data">
<input name="settings[0]" type="hidden" value="<?=$settings[0]?>"><input name="settings[1]" type="hidden" value="<?=$settings[1]?>"><input name="settings[2]" type="hidden" value="<?=$settings[2]?>"><input name="settings[3]" type="hidden" value="<?=$settings[3]?>"><input name="settings[4]" type="hidden" value="<?=$settings[4]?>"><input name="settings[5]" type="hidden" value="<?=$settings[5]?>"><input name="settings[6]" type="hidden" value="<?=$settings[6]?>"><input name="settings[7]" type="hidden" value="<?=$settings[7]?>"><input name="settings[8]" type="hidden" value="<?=$settings[8]?>"><input name="settings[9]" type="hidden" value="<?=$settings[9]?>"><input name="settings[10]" type="hidden" value="<?=$settings[10]?>"><input name="settings[11]" type="hidden" value="<?=$settings[11]?>"><input name="settings[15]" type="hidden" value="<?=$settings[15]?>"><input name="settings[16]" type="hidden" value="<?=$settings[16]?>">
<table border="1" style="font-size: 12px;background-color: #ddd;">
	<tbody style="    background-color: #ddd;">
<tr><td>Доллар ($):</td><td><input name="settings[12]" type="text" value="<?=$settings[12]?>" style="width: 50px;"></td></tr>
<tr><td>Евро (€):</td><td><input name="settings[13]" type="text" value="<?=$settings[13]?>" style="width: 50px;"></td></tr>
<tr><td>Юань (¥):</td><td><input name="settings[14]" type="text" value="<?=$settings[14]?>" style="width: 50px;"></td></tr>
<tr><td colspan="2" style="text-align: center;"><input type="submit" name="send" value="Сохранить" class="but" style="position: initial;"></td></tr>
</tbody>
</table>
</form>
<?
}
if($_GET['menu'] > 3){
?>
		<table border="1" style="max-width: 740px;width: 100%;margin: 15px auto;">
						<?if(($_GET['menu'] > 3 AND $_GET['menu'] < 8) OR $_GET['menu'] == 9){?><tr><td><img style="width: 100%;" src="fancybox/<?if($_GET['menu'] == 4){echo 'logo.png';}?><?if($_GET['menu'] == 5){echo 'bottom_logo.png';}?><?if($_GET['menu'] == 6){echo 'mail.png';}?><?if($_GET['menu'] == 7){echo 'bg.png';}?><?if($_GET['menu'] == 9){echo 'logotip.png';}?>">
						<form action="add_img.php" method="post" id="admin_form1" enctype="multipart/form-data">
						    <input name="apend" type="hidden" value="<?if($_GET['menu'] == 4){echo 'logo';}?><?if($_GET['menu'] == 5){echo 'bottom_logo';}?><?if($_GET['menu'] == 6){echo 'mail';}?><?if($_GET['menu'] == 7){echo 'bg';}?><?if($_GET['menu'] == 9){echo 'logotip';}?>">
						    <input name="type" type="hidden" value="<?if($_GET['menu'] == 4){echo 'png';}?><?if($_GET['menu'] == 5){echo 'png';}?><?if($_GET['menu'] == 6){echo 'png';}?><?if($_GET['menu'] == 7){echo 'jpg';}?><?if($_GET['menu'] == 9){echo 'png';}?>">
							<input type="file" name="userfile">
							<input type="submit" name="upload" value="Изменить" class="but">
						</form></td></tr><?}else{?>
						<form method="post" id="admin_form1" enctype="multipart/form-data">
                            <tr><td>Имя сайта:</td><td><input name="settings[0]" type="text" value="<?=$settings[0]?>"></td></tr>
                            <tr><td>Админ пароль:</td><td><input name="settings[1]" type="text" value="<?=$settings[1]?>"></td></tr>
                            <tr><td>Стоимость доставки по Москве:</td><td><input name="settings[2]" type="text" value="<?=$settings[2]?>"></td></tr>
                            <tr><td>Стоимость доставки по подмосковье:</td><td><input name="settings[3]" type="text" value="<?=$settings[3]?>"></td></tr>
                            <tr><td>Почта для уведомлений:</td><td><input name="settings[5]" type="text" value="<?=$settings[5]?>"></td></tr>
                            <tr><td>Пароль на сайт:</td><td><input name="settings[6]" type="text" value="<?=$settings[6]?>"></td></tr>
                            <tr><td>Цвета (,):</td><td><input name="settings[7]" type="text" value="<?=$settings[7]?>"></td></tr>
                            <tr><td>Страны (,):</td><td><input name="settings[9]" type="text" value="<?=$settings[9]?>"></td></tr>
                            <tr><td>Дней доставки (,):</td><td><input name="settings[15]" type="text" value="<?=$settings[15]?>"></td></tr>
                            <tr><td>Тип (,):</td><td><input name="settings[16]" type="text" value="<?=$settings[16]?>"></td></tr>
                            <tr><td>Верхний баннер:</td><td><input name="settings[10]" type="checkbox" value="1" <?if($settings[10]){echo 'checked';}?>> Вкл.</td></tr>
                            <tr><td>Нижний баннер:</td><td><input name="settings[11]" type="checkbox" value="1" <?if($settings[11]){echo 'checked';}?>> Вкл.</td></tr>
                            <tr><td>Соглашение:</td><td><textarea name="agreement" class="ckeditor"><?echo fread(fopen("./gallery/settings/agreement.txt", 'r'),1000000);?></textarea></td></tr>
                            <tr><td>Успешный заказ:</td><td><textarea name="zakaz" class="ckeditor"><?echo fread(fopen("./gallery/settings/zakaz.txt", 'r'),1000000);?></textarea></td></tr>
<input name="settings[4]" type="hidden" value="<?=$settings[4]?>">
<input name="settings[8]" type="hidden" value="<?=$settings[8]?>">
<input name="settings[12]" type="hidden" value="<?=$settings[12]?>">
<input name="settings[13]" type="hidden" value="<?=$settings[13]?>">
<input name="settings[14]" type="hidden" value="<?=$settings[14]?>">
							<input type="submit" name="send" value="Сохранить" class="but">
						</form>
<?}?>
</table>
<?
}
?>

</body>

</html>
<?
}
else {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
 <head>
 	<title>Торг Цвет</title>
 		<link rel="SHORTCUT ICON" href="fancybox/logo.ico"type="image/x-icon">
 	 	<meta http-equiv="Content-Type" content="text/html: charset=windows-1251">
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
		<p class="pvp_p1">&laquo; Авторизация администратора &raquo;</p>
		<p>-->Для авторизации введите уникальный пароль администратора</p>
		<form action="admin.php" method="post">
			<br><br><br>
			<label>Пароль-><input type="password" name="password"></label>
			<input type="submit" value="Войти" name="vxod_akk">
		</form>
	</div>

 </body>
</html>
<?
}
?>