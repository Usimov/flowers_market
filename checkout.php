<?php header("Content-type: text/html; charset=utf-8");
include_once('jcart/jcart.php');
session_start();

$settingsX = @file("./gallery/settings/settings.txt");
for ($i=0; $i<count($settingsX); $i++){
$settings[$i] = trim($settingsX[$i]);
}
$url11=explode ("|", $_POST['my-item-url']);

$ost=explode (",", $url11[3]);

$us=explode ("|", $_POST['my-item-id']);

foreach ($ost as $d){
    $o=explode ("-", $d);
    if($o[0] == $us[1]){$url[3]=$o[1];}
    }
if ($url[3]==0) {
    if(isset($_SESSION['dost1'.$url11[2]])){if($_SESSION['dost1'.$url11[2]]<$url11[5]){$dost = $urll[5];}else{$dost = $_SESSION['dost1'.$url11[2]];}}
    else {$dost = $url11[5];$_SESSION['dost1'.$url11[2]] = $url11[5];}
    
}
elseif(!isset($_SESSION['dost1'.$url11[2]])) {$dost=1;}
elseif (isset($_SESSION['dost1'.$url11[2]])) {$dost = $_SESSION['dost1'.$url11[2]];}

if($_SESSION['superdd']<$dost){$_SESSION['superdd']=$dost;}


$dost2 = 1;
if(date("H") >= 22){
$day = date('d')+1;
$ttimes = "08:00";
}  
else{
$day = date('d') + $dost2;
if(date("H")<8) {$ttimes = "08:00";}
else {$ttimes = date('H:i');}
}
$mm = date("m");
$year = date("y");
if(((date('m')==2 or date('m')==4 or date('m')==6 or date('m')==9 or date('m')==11) and $day > 30) or $day > 31){
    if(date('m') == 2 and $day > 28){$day = '01';$mm = date('m')+1;}
    $day = '01';$mm = date('m')+1;
    if($mm>12){$year = $year +1;$mm = '01';}
}
$_SESSION['dost1day']  = $day.".".$mm.".".$year.' в '.$ttimes;

$dost2 = $_SESSION['superdd'];
if(date("H") >= 22){
$day = date('d')+1;
$ttimes = "08:00";
}  
else{
$day = date('d') + $dost2;
if(date("H")<8) {$ttimes = "08:00";}
else {$ttimes = date('H:i');}
}
$mm = date("m");
$year = date("y");
if(((date('m')==2 or date('m')==4 or date('m')==6 or date('m')==9 or date('m')==11) and $day > 30) or $day > 31){
    if(date('m') == 2 and $day > 28){$day = '01';$mm = date('m')+1;}
    $day = '01';$mm = date('m')+1;
    if($mm>12){$year = $year +1;$mm = '01';}
}
$picker = $day.".".$mm.".".$year.' в '.$ttimes;
?>
<?if(!$_GET['update']){?>
<link rel="stylesheet" media="all" type="text/css" href="/js/jquery.datetimepicker.css" />
<script type="text/javascript" src="/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/jcart/js/jcart.js"></script>
<script type="text/javascript" src="/js/jquery.datetimepicker.js"></script>
<div class="form_zakaz_block">
<form action="zakaz.php" method="post" class="form_zakaz" id="zakazf" name="form1" onsubmit="return form ( );">
<?
		$settingsX = @file($_SERVER['DOCUMENT_ROOT']."/gallery/settings/settings.txt");
		for ($i=0; $i<count($settingsX); $i++){
		$items['settings'][$i] = trim($settingsX[$i]);
		}
//$day.$mm.$year в $ttimes

if($_SESSION['p_dostavka'] == $items['settings'][2]){$selected2 = 'selected';}
if($_SESSION['p_dostavka'] == $items['settings'][3]){$selected3 = 'selected';}
?>
<table cellpadding=0 cellspacing=0>
<tr>
<td>
<select size='1' name='p_dostavka'><option value=''>Способ доставки?</option>
<option value='<?=$items['settings'][2]?>' <?=$selected2?>>по Москве <?=$items['settings'][2]?> руб.</option>
<option value='<?=$items['settings'][3]?>' <?=$selected3?>>Подмосковье <?=$items['settings'][3]?> руб.</option>
</select>
</td>
<td><input type='text' id='datetimepicker' name='p_times' value="<? echo $picker; ?>" autocomplete="off" placeholder='ДАТА И ВРЕМЯ ДОСТАВКИ'></td>
</tr>
<tr>
<td><input type='text' name='na_fa' placeholder='ИМЯ'></td>
<td><input type='text' name='p_adress' placeholder='АДРЕС ДОСТАВКИ'></td>
</tr>
<tr>
<td><input type='text' name='p_email' placeholder='ЭЛЕКТРОННАЯ ПОЧТА'></td>
<td><input type='text' name='p_phote' placeholder='ТЕЛЕФОН'></td>
</tr>
</table>

<div id=jcart><?php }
if($_POST['kratnost']){
$option=explode ("|", $_POST['value']);
if($option[1]>0){$_SESSION['kratnost'][$option[0]]=$option[1];}
else{$_SESSION['kratnost'][$option[0]]='';}
}
if($_POST['kachestvo']){
if($_SESSION['kachestvo'][$_POST['kachestvo']]==1){$_SESSION['kachestvo'][$_POST['kachestvo']]=0;}else{$_SESSION['kachestvo'][$_POST['kachestvo']]=1;}
}
if($_POST['p_dostavka']){$_SESSION['p_dostavka'] = $_POST['value'];}

$jcart->display_cart();?><?if(!$_GET['update']){?>
</div></form>
<script type="text/javascript">
Date.prototype.addDays = function(days)
{
    var dat = new Date(this.valueOf());
    dat.setDate(dat.getDate() + days);
    return dat;
}
var ssss = new Date();
jQuery('#datetimepicker').datetimepicker({minDate:ssss.addDays(<? echo $dd; ?>),format:'d.m.Y в H:i',lang:'ru',allowTimes:['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00']});
$(document).ready (function(){
$('select[name="p_dostavka"]').change(function(){
        var chk = $(this).attr("name");
        var chkVal = $(this).attr("value");
        $.ajax({
            url: 'checkout.php?update=1',
            type: 'post',
            data: { value: chkVal, p_dostavka: chk },
            success: function(data) { $("#jcart").html(data); }
        });
});
});
</script>
</div>
<?}?>