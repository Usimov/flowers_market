<?php
header("Content-type: text/html; charset=utf-8");
session_start();
require_once "functions.php";
if(!$_POST['cat']){$_POST['cat']=$_GET['list'];}
?>
<link href="/js/tipTip.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/jquery.tipTip.js"></script>
<script type="text/javascript">$(document).ready(function(){$("input, select").tipTip({maxWidth: "auto", defaultPosition: "top", edgeOffset: 0});});</script>
<?
$settingsX = @file("./gallery/settings/settings.txt");
for ($i=0; $i<count($settingsX); $i++){
$settings[$i] = trim($settingsX[$i]);
}


if (checkUser($_POST['password']) OR checkUser($_SESSION['password']) AND $_GET['list'] != ''){
if($_GET['nm']!=''){if($_GET['nm']=='0'){$_SESSION['nm']='';}else{$_SESSION['nm']=$_GET['nm'];}}
if($_GET['pr']!=''){if($_GET['pr']=='0'){$_SESSION['pr']='';}else{$_SESSION['pr']=$_GET['pr'];}}
if($_GET['str']!=''){if($_GET['str']=='0'){$_SESSION['str']='';}else{$_SESSION['str']=$_GET['str'];}}
if($_GET['prz']!=''){if($_GET['prz']=='0'){$_SESSION['prz']='';}else{$_SESSION['prz']=$_GET['prz'];}}
if($_GET['typecolor']!=''){if($_GET['typecolor']=='0'){$_SESSION['typecolor']='';}else{$_SESSION['typecolor']=$_GET['typecolor'];}}
if($_GET['colors']!=''){if($_GET['colors']=='0'){$_SESSION['colors']='';}else{$_SESSION['colors']=$_GET['colors'];}}
if($_GET['top']!=''){if($_GET['top'] == '0'){$_SESSION['top']='';}else{if($_SESSION['top']==1){$_SESSION['top']=0;}else{$_SESSION['top']=1;}}}
if($_GET['search']!=''){if($_GET['search']=='0'){$_SESSION['search']='';}else{$_SESSION['search']=$_GET['search'];}}
if($_GET['tvpz']!=''){if($_GET['tvpz']=='null'){$_SESSION['tvpz']='';}else{$_SESSION['tvpz']=$_GET['tvpz'];}}

$list='';$price='';
$i = $_GET['list'];
$dirs = @file("./gallery/otdel".$i."/text/list.txt");
if($dirs){foreach ($dirs as $dr){
$dr = trim($dr);
if($dr == '') {continue;}
$filearray = @file("./gallery/otdel".$i."/text/".$dr.'.txt');
for($xzx=0;$xzx<count($filearray);$xzx++){$filearray[$xzx] = trim($filearray[$xzx]);}
$OK=1;
if(!$filearray[8]){$filearray[8]=0;}
if($_SESSION['str'] AND $_SESSION['str'] != $filearray[4]){$OK='';}
if($_SESSION['prz'] AND $_SESSION['prz'] != $filearray[11]){$OK='';}
if($_SESSION['typecolor'] AND $_SESSION['typecolor'] != $filearray[15]){$OK='';}
if($_SESSION['colors'] AND $_SESSION['colors'] != $filearray[10]){$OK='';}

if($_SESSION['tvpz']!=''){

	$tovars = explode(',',$filearray[12]);
	$ok = '0';
	foreach ($tovars as $t) {
		$t = explode('-',$t);
		if($t[1] > 0) {$ok = '1';}
	}

	if($_SESSION['tvpz'] == 1 AND $ok == '0'){
		$OK='';
	}
	if($_SESSION['tvpz'] == 0 AND $ok == '1'){
		$OK='';
	}
}

if($OK){
if($_SESSION['search']){
if (strtolower_ru(mb_substr($filearray[0], 0, mb_strlen($_SESSION['search'], 'UTF-8'), "UTF-8")) == strtolower_ru($_SESSION['search'])) {
$list[$i][$dr][0]=$filearray[0];
$list[$i][$dr][1]=$filearray[1];
$list[$i][$dr][2]=$filearray[2];
$list[$i][$dr][3]=$filearray[3];
$list[$i][$dr][4]=$filearray[4];
$list[$i][$dr][5]=$filearray[5];
$list[$i][$dr][6]=$filearray[6];
$list[$i][$dr][7]=$filearray[7];
$list[$i][$dr][8]=$filearray[8];
$list[$i][$dr][9]=$filearray[9];
$list[$i][$dr][10]=$filearray[10];
$list[$i][$dr][11]=$filearray[11];
$list[$i][$dr][12]=$filearray[12];
$list[$i][$dr][13]=$filearray[13];
$list[$i][$dr][14]=$filearray[14];
$list[$i][$dr][15]=$filearray[15];
$name[$i][$dr]=$filearray[0];
$price[$i][$dr]=$filearray[2];
$rayting[$i][$dr]=$filearray[8];
}}
else{
$list[$i][$dr][0]=$filearray[0];
$list[$i][$dr][1]=$filearray[1];
$list[$i][$dr][2]=$filearray[2];
$list[$i][$dr][3]=$filearray[3];
$list[$i][$dr][4]=$filearray[4];
$list[$i][$dr][5]=$filearray[5];
$list[$i][$dr][6]=$filearray[6];
$list[$i][$dr][7]=$filearray[7];
$list[$i][$dr][8]=$filearray[8];
$list[$i][$dr][9]=$filearray[9];
$list[$i][$dr][10]=$filearray[10];
$list[$i][$dr][11]=$filearray[11];
$list[$i][$dr][12]=$filearray[12];
$list[$i][$dr][13]=$filearray[13];
$list[$i][$dr][14]=$filearray[14];
$list[$i][$dr][15]=$filearray[15];
$name[$i][$dr]=$filearray[0];
$price[$i][$dr]=$filearray[2];
$rayting[$i][$dr]=$filearray[8];
}}
$OK='';
}}


if($_SESSION['pr'] == 'up'){
// по возрастанию
@asort($price[$i]);
}
if($_SESSION['pr'] == 'down'){
// по убыванию
@arsort($price[$i]);
}
if($_SESSION['nm'] == 'up'){
// по возрастанию
@asort($name[$i]);
}
if($_SESSION['nm'] == 'down'){
// по убыванию
@arsort($name[$i]);
}
if($_SESSION['top'] == 1){
@arsort($rayting[$i]);
}

 $qw=1;

if($_SESSION['pr'] == 'up' OR $_SESSION['pr'] == 'down'){
$echo = $price[$i];
}
elseif($_SESSION['nm'] == 'up' OR $_SESSION['nm'] == 'down'){
$echo = $name[$i];
}
elseif($_SESSION['top'] == 1){
$echo = $rayting[$i];
}
else{
$echo = $list[$i];
}

if($echo!=''){foreach ($echo as $dir => $file){
$file_array=$list[$i][$dir];

if($file_array[7] == 1){$file_array[7] = 'checked';}else{$file_array[7] = '';}
if(@file_exists($_SERVER['DOCUMENT_ROOT'].'/gallery/otdel'.$i.'/m/'.$dir.'.gif')){$img = '.gif';}
elseif(@file_exists($_SERVER['DOCUMENT_ROOT'].'/gallery/otdel'.$i.'/m/'.$dir.'.bmp')){$img = '.bmp';}
elseif(@file_exists($_SERVER['DOCUMENT_ROOT'].'/gallery/otdel'.$i.'/m/'.$dir.'.jpeg')){$img = '.jpeg';}
elseif(@file_exists($_SERVER['DOCUMENT_ROOT'].'/gallery/otdel'.$i.'/m/'.$dir.'.png')){$img = '.png';}
else{$img = '.jpg';}
?>
					<script type="text/javascript" >
						$(function(){
							new AjaxUpload($('#U<?=$dir?>'), {
							action: 'upload-file.php?dir=<?=$i?>&name=<?=$dir?>',
							name: 'uploadfile',
							onSubmit: function(file, ext){
				 			if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
								status.text('Поддерживаемые форматы JPG, PNG или GIF');
								return false;
							}
							$('#U<?=$dir?>').html('<div style="width: 160px;height: 150px;margin-left: 17px;">Загрузка...</div>');
						},
						onComplete: function(file, response){
							if(response!="error"){
							var dirS = response.split('.');
								$('#U<?=$dir?>').html('<img src="./gallery/otdel<?=$i?>/m/'+response+'?v='+Math.random()+'" border="0">');
							}
						}
							});
					});
				</script>
<?
echo '<li><div id="U'.$dir.'"><img src="./gallery/otdel'.$i.'/m/'.$dir.$img.'?v='.rand().'" border="0"></div><p><input name="cat" type="hidden" value="'.$i.'"><input name="list[]" type="hidden" value="'.$dir.'"><input name="list_id[]" type="hidden" value="'.$qw.'">';
echo '<input name="'.$dir.'[0]" type="text" value="'.$file_array[0].'" size="19" placeholder="Название" title="Название">
<input name="'.$dir.'[1]" type="text" value="'.$file_array[1].'" size="19" placeholder="Размер" title="Размер">
<input name="'.$dir.'[9]" type="text" value="'.$file_array[9].'" size="19" placeholder="Вес" title="Вес">
<input name="'.$dir.'[2]" type="text" value="'.$file_array[2].'" size="19" placeholder="Цена" title="Цена">
<input name="'.$dir.'[3]" type="text" value="'.$file_array[3].'" size="19" placeholder="Колличество в упаковке" title="Колличество в упаковке">';

echo '<input name="'.$dir.'[11]" type="hidden" value="<?=$dir[11]?>">';
echo '<input name="'.$dir.'[4]" type="hidden" value="<?=$dir[4]?>">';
echo '<select size="1" name="'.$dir.'[10]" placeholder="Цвет" title="Цвет">';
echo '<option>'.$file_array[10].'</option>';
$color = explode(",", $settings[7]);
for($q=0;$q<count($color);$q++){
echo '<option>'.$color[$q].'</option>';
}
$group = @file("./gallery/settings/group.txt");
for ($r=0; $r<count($group); $r++){
$group[$r] = trim($group[$r]);
$gr = explode("|", $group[$r]);
$gr_name[$gr[0]] = $gr[2];
}
echo '</select>';
echo '<select size="1" name="'.$dir.'[15]" placeholder="Тип цвета" title="Тип цвета">';
echo '<option>'.$file_array[15].'</option>';
$color = explode(",", $settings[16]);
for($q=0;$q<count($color);$q++){
echo '<option>'.$color[$q].'</option>';
}
echo '</select>';
echo '<input name="'.$dir.'[5]" type="text" value="'.$file_array[5].'" size="19" placeholder="Упаковки через запятую" title="Упаковки через запятую">
<input name="'.$dir.'[6]" type="text" value="'.$file_array[6].'" size="19" style="width: 108px;" placeholder="'.$gr_name[$i].'" title="'.$gr_name[$i].'">';
$selectusd=$selecteur=$selectrub=$selectena='';
if($file_array[13] == 'usd'){$selectusd=' selected';}elseif($file_array[13] == 'eur'){$selecteur=' selected';}elseif($file_array[13] == 'uan'){$selectena=' selected';}else{$selectrub=' selected';}
echo '<select style="width: 65px;" size="1" name="'.$dir.'[13]"><option value="rub"'.$selectrub.'>руб.</option><option value="usd"'.$selectusd.'>дол.</option><option value="eur"'.$selecteur.'>евр.</option><option value="uan"'.$selectena.'>юань</option></select>';
if($file_array[12] == 1){$selected='selected';}
echo '<input name="'.$dir.'[12]" type="text" value="'.$file_array[12].'" size="19" placeholder="В наличии" title="В наличии">';
$selected='';
echo '<select size="1" name="'.$dir.'[14]" placeholder="Дней доставки" title="Дней доств">';
echo '<option>'.$file_array[14].'</option>';
$proiz = explode(",", $settings[15]);
for($q=0;$q<count($proiz);$q++){
echo '<option>'.$proiz[$q].'</option>';
}
echo '</select>';
echo '<input name="'.$dir.'[8]" type="text" value="'.$file_array[8].'" size="19" placeholder="Кол. заказов" title="Кол. заказов">
</p><sx class="buts"><input name="'.$dir.'[7]" type="hidden" value="0"><input name="'.$dir.'[7]" type="checkbox" value="1" '.$file_array[7].' id="id'.$dir.'"> <label for="id'.$dir.'">Показать</label></sx>';
echo '<a href="?group='.$i.'&del='.$dir.'&cat='.$i.'" class="buts" style="margin-left: 11px;">Удалить</a><p></p>';
echo '<input name="list_num[]" type="hidden" value="'.$qw.'" size="1" placeholder="Номер" title="Номер" style="text-align: center;margin-left: 55px;"></li>';
$qw++;
}}
}
?>