<?php
header("Content-type: text/html; charset=utf-8");
require_once "functions.php";
include_once('jcart/jcart.php');
session_start();

if($_GET['top']==''){$_SESSION['top']=1;}
if($_GET['group']!=''){$_SESSION['group']=$_GET['group'];$_SESSION['groups']=$_GET['group'];}
if($_GET['nm']!=''){if($_GET['nm']=='0'){$_SESSION['nm']='';}else{$_SESSION['nm']=$_GET['nm'];}}
if($_GET['pr']!=''){if($_GET['pr']=='0'){$_SESSION['pr']='';}else{$_SESSION['pr']=$_GET['pr'];}}
if($_GET['str']!=''){if($_GET['str']=='0'){$_SESSION['str']='';}else{$_SESSION['str']=$_GET['str'];}}
if($_GET['prz']!=''){if($_GET['prz']=='0'){$_SESSION['prz']='';}else{$_SESSION['prz']=$_GET['prz'];}}
if($_GET['typecolor']!=''){if($_GET['typecolor']=='0'){$_SESSION['typecolor']='';}else{$_SESSION['typecolor']=$_GET['typecolor'];}}
if($_GET['colors']!=''){if($_GET['colors']=='0'){$_SESSION['colors']='';}else{$_SESSION['colors']=$_GET['colors'];}}
if($_GET['top']!=''){if($_GET['top'] == '0'){$_SESSION['top']='';}else{if($_SESSION['top']==1){$_SESSION['top']=0;}else{$_SESSION['top']=1;}}}
if($_GET['search']!=''){if($_GET['search']=='0'){$_SESSION['search']='';}else{$_SESSION['search']=$_GET['search'];}}
if($_GET['tvpz']!=''){if($_GET['tvpz']=='null'){$_SESSION['tvpz']='';}else{$_SESSION['tvpz']=$_GET['tvpz'];}}
if($_GET['lsttyp']!=''){$_SESSION['lsttyp']=$_GET['lsttyp'];}

$settingsX = @file("./gallery/settings/settings.txt");
for ($i=0; $i<count($settingsX); $i++){
$settings[$i] = trim($settingsX[$i]);
}

$list='';$price='';
$i=$_SESSION['group'];
$group22 = @file("./gallery/settings/group.txt");
foreach($group22 as $stran){
    $stran = split('|',$stran);
    if ($stran[0]==$i)
        {$strana_pok = $stran[3];}
}
$dirs = @file("./gallery/otdel".$i."/text/list.txt");
if($dirs){foreach ($dirs as $dr){
$dr = trim($dr);
$filearray = @file("./gallery/otdel".$i."/text/".$dr.'.txt');
for($xzx=0;$xzx<count($filearray);$xzx++){$filearray[$xzx] = trim($filearray[$xzx]);}
if($filearray[7]==1){
$OK=1;
if(!$filearray[8]){$filearray[8]=0;}
if($_SESSION['str'] AND $_SESSION['str'] != $filearray[4]){$OK='';}
if($_SESSION['prz'] AND $_SESSION['prz'] != $filearray[11]){$OK='';}
if($_SESSION['typecolor'] AND $_SESSION['typecolor'] != $filearray[15]){$OK='';}
if($_SESSION['colors'] AND $_SESSION['colors'] != $filearray[10]){$OK='';}

if($_SESSION['tvpz']!=''){
$ost=explode (",", $filearray[12]);
if($ost[1]!=''){
foreach ($ost as $d){
$o=explode ("-", $d);
if($_SESSION['tvpz'] == 1){
if($o[1] <= 0){$OKx[]=$o[0];}
}
if($_SESSION['tvpz'] == 0){
if($o[1] > 0){$OKx[]=$o[0];}
}
}
if(count($ost) == count($OKx)){$OK='';}
}
else {
	if($_SESSION['tvpz'] == 1 AND $filearray[12] <= 0){$OK='';}
	if($_SESSION['tvpz'] == 0 AND $filearray[12] > 0){$OK='';}
}
}
if($filearray[2] AND $OK){
if($_SESSION['search']){
if (strtolower_ru(mb_substr($filearray[0], 0, mb_strlen($_SESSION['search'], 'UTF-8'), "UTF-8")) == strtolower_ru($_SESSION['search'])) {
$list[$i][$dr][0]=$filearray[0];
$list[$i][$dr][1]=$filearray[1];
$list[$i][$dr][2]=$filearray[2];
$list[$i][$dr][3]=$filearray[3];
$list[$i][$dr][4]=$filearray[4];
$list[$i][$dr][5]=$filearray[5];
$list[$i][$dr][6]=$filearray[6];
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
}
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
?>
<link href="/js/tipTip.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/jquery.tipTip.js"></script>
<link href="/js/perfect-scrollbar.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="/js/device.min.js"></script>

<a id="top"><img src="fancybox/next2.png" border="0"></a>
<div class="blok">
<?php
if($_SESSION['lsttyp'] == 'tb'){echo '<div class="thumbs"><table width="97%" cellpadding="0" cellspacing="0">
<tr style="font-weight:bold;cursor: default;background: none;">
        <td></td>
        <td>Страна&nbsp;</td>
        <td>Название&nbsp;</td>
        <td></td>
        <td>Цена</td>
        <td>Цвет&nbsp;</td>
    </tr>

';}else{echo '<ul class="thumbs">';}
$x=1;
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

if($echo!=''){
foreach ($echo as $dir => $file){
$file_array=$list[$i][$dir];
$val1=$val2='';
if($file_array[13] == 'usd'){$val1='$ ';$tochka=2;}elseif($file_array[13] == 'eur'){$val1='€ ';$tochka=2;}elseif($file_array[13] == 'uan'){$val1='¥ ';$tochka=2;}else{$val2=' р.';$tochka=0;}

$info_tc_shop = '<table cellpadding=0 cellspacing=0>';
if($file_array[0]){$info_tc_shop .= '<tr><td colspan=2 align=center><b>'.$file_array[0].'</b></td></tr>';}
if($file_array[4]){$info_tc_shop .= '<tr><td>Страна &nbsp;&nbsp;</td><td><b>'.$file_array[4].'</b></td></tr>';}

$OKost=0;
$ost=explode (",", $file_array[12]);
if($ost[1]!=''){
foreach ($ost as $d){
$o=explode ("-", $d);
if($o[1] > 0){$OKost=1;}
}
//if(count($ost) == count($OKx)){$OKost=1;}
}
else {
if($filearray[12] > 0){$OKost=1;}
}

if($file_array[13] == 'usd'){$sm = number_format(($file_array[2] * $settings[12]), 0, '.', ',');}
elseif($file_array[13] == 'eur'){$sm = number_format(($file_array[2] * $settings[13]), 0, '.', ',');}
elseif($file_array[13] == 'uan'){$sm = number_format(($file_array[2] * $settings[14]), 0, '.', ',');}
else{$sm = number_format($file_array[2], 0, '.', ',');}
$nac = $sm/100*$file_array[6];
$sm = $sm+$nac;
if($file_array[2]){$info_tc_shop .= '<tr><td>Цена &nbsp;&nbsp;</td><td><b>'.$sm.'</b> р.</td></tr>';}


$info_tc_shop .= '</table>';

if($file_array[6]){$cena=$file_array[2]+($file_array[2]/100*$file_array[6]);}else{$cena=$file_array[2];}
if(@file_exists($_SERVER['DOCUMENT_ROOT'].'/gallery/otdel'.$i.'/m/'.$dir.'.gif')){$img = '.gif';}
elseif(@file_exists($_SERVER['DOCUMENT_ROOT'].'/gallery/otdel'.$i.'/m/'.$dir.'.bmp')){$img = '.bmp';}
elseif(@file_exists($_SERVER['DOCUMENT_ROOT'].'/gallery/otdel'.$i.'/m/'.$dir.'.jpeg')){$img = '.jpeg';}
elseif(@file_exists($_SERVER['DOCUMENT_ROOT'].'/gallery/otdel'.$i.'/m/'.$dir.'.png')){$img = '.png';}
else{$img = '.jpg';}
if($_SESSION['lsttyp'] == 'tb'){
echo '<tr onclick="tovar_view('.$i.','.$dir.');">
        <td><img src="./gallery/otdel'.$i.'/m/'.$dir.$img.'"/></td>
        <td><b>'.$strana_pok.'</b></td>
        <td><b>'.$file_array[0].'</b></td>
        <td><b>'.$file_array[11].'</b></td>';
echo '<td><b>'.$sm.'</b> р.</td>';
echo '<td><b>'.$file_array[10].'</b></td></tr>';
}
else {
echo '<li><img onclick="tovar_view('.$i.','.$dir.');" src="./gallery/otdel'.$i.'/m/'.$dir.$img.'" title="'.$info_tc_shop.'"/></li>';
}
}
}
else{
echo '<div class="null">Нет данных.</div>';
}
if($_SESSION['lsttyp'] == 'tb'){echo '</table></div>';}else{echo '</ul>';}
?>
</div>
<a id="dwn"><img src="fancybox/previous2.png" border="0"></a>
<script type="text/javascript">
$(document).ready(function(){
$('.thumbs').perfectScrollbar({useKeyboard:true});
if(device.mobile() || device.tablet()){}else{
$(".thumbs li img").tipTip({maxWidth: "auto", defaultPosition: "top", edgeOffset: 0});
}
$("#dwn").click(function(){
var s = $(".thumbs").scrollTop() + $(".thumbs").height();
$('.thumbs').animate({scrollTop: s}, 800);
});
$("#top").click(function(){
var s = $(".thumbs").scrollTop() - $(".thumbs").height();
$('.thumbs').animate({scrollTop: s}, 800);
});
});
</script>