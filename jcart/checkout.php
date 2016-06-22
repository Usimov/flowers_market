<?php header("Content-type: text/html; charset=utf-8");
include_once('jcart/jcart.php');
session_start();

$settingsX = @file("./gallery/settings/settings.txt");
for ($i=0; $i<count($settingsX); $i++){
$settings[$i] = trim($settingsX[$i]);
}
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
		$items['settings'][$i] = str_replace("\r\n", '', $settingsX[$i]);
		}


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
<td><input type='text' id='datetimepicker' name='p_times' placeholder='ДАТА И ВРЕМЯ ДОСТАВКИ'></td>
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
jQuery('#datetimepicker').datetimepicker({minDate:0,format:'d.m.Y в H:i',lang:'ru',allowTimes:['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00']});
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