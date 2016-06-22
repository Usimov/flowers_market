<?php
header("Content-type: text/html; charset=utf-8");
require_once "functions.php";
include_once('jcart/jcart.php');
session_start();

if($_GET['top']==''){$_SESSION['top']=1;}
if($_GET['pr']!=''){if($_GET['pr']=='0'){$_SESSION['pr']='';}else{$_SESSION['pr']=$_GET['pr'];}}
if($_GET['str']!=''){if($_GET['str']=='0'){$_SESSION['str']='';}else{$_SESSION['str']=$_GET['str'];}}
if($_GET['prz']!=''){if($_GET['prz']=='0'){$_SESSION['prz']='';}else{$_SESSION['prz']=$_GET['prz'];}}
if($_GET['colors']!=''){if($_GET['colors']=='0'){$_SESSION['colors']='';}else{$_SESSION['colors']=$_GET['colors'];}}
if($_GET['top']!=''){if($_GET['top'] == '0'){$_SESSION['top']='';}else{if($_SESSION['top']==1){$_SESSION['top']=0;}else{$_SESSION['top']=1;}}}
if($_GET['search']!=''){if($_GET['search']=='0'){$_SESSION['search']='';}else{$_SESSION['search']=$_GET['search'];}}
if($_GET['tvpz']!=''){if($_GET['tvpz']=='null'){$_SESSION['tvpz']='';}else{$_SESSION['tvpz']=$_GET['tvpz'];}}

$settingsX = @file("./gallery/settings/settings.txt");
for ($i=0; $i<count($settingsX); $i++){
$settings[$i] = trim($settingsX[$i]);
}
?>
<script type="text/javascript" src="/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.chained.min.js"></script>
<script type="text/javascript">jQuery(document).ready(function(){jQuery("#kol").chained("#razmer");});</script>
<?
$rayting='';
$dirs = @file("./gallery/otdel".$_GET['dir']."/text/list.txt");
foreach ($dirs as $dr){
$dr = trim($dr);
$filearray = @file("./gallery/otdel".$_GET['dir']."/text/".$dr.'.txt');
for($xzx=0;$xzx<count($filearray);$xzx++){$filearray[$xzx] = trim($filearray[$xzx]);}
if($filearray[7] == 1){
$OK=1;
if(!$filearray[8]){$filearray[8]=0;}
if($_SESSION['str'] AND $_SESSION['str'] != $filearray[4]){$OK='';}
if($_SESSION['prz'] AND $_SESSION['prz'] != $filearray[11]){$OK='';}
if($_SESSION['colors'] AND $_SESSION['colors'] != $filearray[10]){$OK='';}
if($_SESSION['tvpz']!=''){if($_SESSION['tvpz'] == 1 AND $filearray[12] <= 0){$OK='';}if($_SESSION['tvpz'] == 0 AND $filearray[12] > 0){$OK='';}}

if($filearray[2] AND $OK){
if($_SESSION['search']){
if (strtolower_ru(mb_substr($filearray[0], 0, mb_strlen($_SESSION['search'], 'UTF-8'), "UTF-8")) == strtolower_ru($_SESSION['search'])) {
$drq[]=$dr;
$rayting[$dr]=$filearray[8];
}}
else{
$drq[]=$dr;
$rayting[$dr]=$filearray[8];
}}
$OK='';
}
}

if($_SESSION['top'] == 1){
@arsort($rayting);
$i=0;
if($rayting){foreach ($rayting as $id => $num){
$drq[$i]=$id;
$i++;
}}
}

for($i=0;$i<count($drq);$i++){if($_GET['id'] == $drq[$i]){$dri=$i;}}



$file_array = @file("./gallery/otdel".$_GET['dir']."/text/".$_GET['id'].'.txt');
for($xz=0;$xz<count($file_array);$xz++){$file_array[$xz] = trim($file_array[$xz]);}

$val1=$val2=$val3='';
if($file_array[13] == 'usd'){$val1='$ ';$tochka=2;$val3=$settings[12];}elseif($file_array[13] == 'eur'){$val1='€ ';$tochka=2;$val3=$settings[13];}elseif($file_array[13] == 'uan'){$val1='¥ ';$tochka=2;$val3=$settings[14];}else{$val2=' руб.';$val02=' р.';$tochka=0;$val3=1;}


if(@file_exists($_SERVER['DOCUMENT_ROOT'].'/gallery/otdel'.$_GET['dir'].'/m/'.$_GET['id'].'.gif')){$img = '.gif';}
elseif(@file_exists($_SERVER['DOCUMENT_ROOT'].'/gallery/otdel'.$_GET['dir'].'/m/'.$_GET['id'].'.bmp')){$img = '.bmp';}
elseif(@file_exists($_SERVER['DOCUMENT_ROOT'].'/gallery/otdel'.$_GET['dir'].'/m/'.$_GET['id'].'.jpeg')){$img = '.jpeg';}
elseif(@file_exists($_SERVER['DOCUMENT_ROOT'].'/gallery/otdel'.$_GET['dir'].'/m/'.$_GET['id'].'.png')){$img = '.png';}
else{$img = '.jpg';}
if($drq[$dri-1]){$colive .= '<div onclick="tovar_view('.$_GET['dir'].','.$drq[$dri-1].');" id="prev"></div>';}
if($drq[$dri+1]){$colive .= '<div onclick="tovar_view('.$_GET['dir'].','.$drq[$dri+1].');" id="next"></div>';}

$colive .= "<div class='modal_main_cont' id='V".$_GET['id']."'>
        <div class='title' style='width: 40%;'>".$file_array[0]."</div><div class='title'>".$_GET['stran']."</div>
<div id='basketList'>
<img src='./gallery/otdel".$_GET['dir']."/".$_GET['id'].$img."?v=".rand()."' title='".$info_tc_shop."' style='max-width:550px'/>
<form method='post' id='".$_GET['id']."' onsubmit='return false;'>
<table class='formtovar'>";
$colive .= "<tr><td class='fs21''>Размер</td><td style='text-align: center;'>";

$razmer=explode (",", $file_array[1]);
if($razmer[1]){
$ost=explode (",", $file_array[12]);
if($ost[1]!=''){
for($v=0;$v<count($ost);$v++){
$ostat=explode ("-", $ost[$v]);
$kesh['ostat'][$ostat[0]] = $ostat[1];
}
}
else{
$kesh['ostat']['null'] = $file_array[12];
}


$colive .= "<select size='1' name='razmer' id='razmer' class='korzina'>";
for($q=0;$q<count($razmer);$q++){
$raz=explode ("-", $razmer[$q]);
$kesh['razmer'][$raz[0]]=$raz[1];
$kesh['raz'][]=$raz[0];

if($_SESSION['tvpz'] == '1'){
if($kesh['ostat'][$raz[0]] > 0 OR $kesh['ostat']['null'] > 0){
$colive .= "<option value='".$razmer[$q]."'>".$raz[0]." см. + ".number_format($raz[1]*$val3, 0, '.', ',')." р.</option>";
}}
elseif($_SESSION['tvpz'] == '0'){
if($kesh['ostat'][$raz[0]] <= 0 AND $kesh['ostat']['null'] <= 0){
$colive .= "<option value='".$razmer[$q]."'>".$raz[0]." см. + ".$val1.number_format($raz[1], $tochka, '.', ',').$val02."</option>";
}}
else{
if($kesh['ostat'][$raz[0]] > 0 OR $kesh['ostat']['null'] > 0){
$colive .= "<option value='".$razmer[$q]."'>".$raz[0]." см. + ".number_format($raz[1]*$val3, 0, '.', ',')." р.</option>";
}
else{
$colive .= "<option value='".$razmer[$q]."'>".$raz[0]." см. + ".$val1.number_format($raz[1], $tochka, '.', ',').$val02."</option>";
}}
}
$colive .= "</select>";
}
else {
$colive .= $file_array[1]." см.<input name='razmer1' type='hidden' value='".$razmer[0]."'>";
}

$colive .= "</td><td style='text-align: right;' class='fs24' id=summ></td></tr>";


if($file_array[9]){
$colive .= "<tr><td class='fs21'>Вес</td><td style='text-align: center;'>";
$ves=explode (",", $file_array[9]);
if($ves[1]){
$colive .= "<select size='1' name='ves' id='ves' class='korzina'></select>";
}
else{
$colive .= $file_array[9]." г.<input name='ves1' type='hidden' value='".$ves[0]."'>";
}
}
else{
$colive .= "<tr><td><input name='ves' type='hidden' value=''><input name='ves1' type='hidden' value=''></td><td>";
}

$shtx=explode (",", $file_array[3]);
if(!$shtx[1]){
$sht = 	$file_array[3];
}


$colive .= "</td><td style='text-align: right;' class='fs20'><div id='star'>*</div>&nbsp;&nbsp;&nbsp;<div id='sht' class='fs24' style='margin-top: -30px;'>".$sht."</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <p><small style='margin-top: -23px;display: block;'>шт. в уп.</small></p></td></tr>
<tr><td class='fs21'>Колличество</td><td style='text-align: center;'>";

$kol=explode (",", $file_array[5]);
$colive .= "<select size='1' id='kol' name='my-item-qty' class='korzina'>";
for($q=0;$q<count($kol);$q++){
$ost=explode (",", $file_array[12]);
if($ost[1]!=''){
for($v=0;$v<count($ost);$v++){
$ostat=explode ("-", $ost[$v]);
if($ostat[1] > 0){if($kol[$q] <= $ostat[1]){
$colive .= "<option value='".$kol[$q]."' class='".$ostat[0].'-'.$kesh['razmer'][$ostat[0]]."'>".$kol[$q]." уп.</option>";
}}
else{$colive .= "<option value='".$kol[$q]."' class='".$ostat[0].'-'.$kesh['razmer'][$ostat[0]]."'>".$kol[$q]." уп.</option>";}
}
}
else{
if($file_array[12] > 0){if($kol[$q] <= $file_array[12]){
$colive .= "<option value='".$kol[$q]."'>".$kol[$q]." уп.</option>";
}}
else{$colive .= "<option value='".$kol[$q]."'>".$kol[$q]." уп.</option>";}
}
}
$colive .= "</select>";

$colive .= "</td><td style='text-align: right;padding-top: 10px;' class='fs24' id=summa></td></tr>";
$ost='';
$ostat=explode (",", $file_array[12]);
if($ostat[1]!=''){
for($v=0;$v<count($ostat);$v++){
$ostatok=explode ("-", $ostat[$v]);
if($_SESSION['tvpz'] == '0'){$ostatok[1]=0;}
if($kesh['raz'][0] != $ostatok[0]){$class = ' style="display:none" class="ost"';}else{$class = ' style="display:block" class="ost"';}
if($ostatok[1] == 0){$ost .= '<div id="x'.md5($ostatok[0].'-'.$kesh['razmer'][$ostatok[0]]).'"'.$class.'>На заказ</div>';}else{$ost .= '<div id="x'.md5($ostatok[0].'-'.$kesh['razmer'][$ostatok[0]]).'"'.$class.'>Остаток: '.$ostatok[1].' уп.</div>';}
}
}
else{
if($file_array[12] == 0){$ost = 'На заказ';}else{$ost = 'Остаток: '.$file_array[12].' уп.';}
}
$group = @file("./gallery/settings/group.txt");
for ($r=0; $r<count($group); $r++){
$group[$r] = trim($group[$r]);
$gr = explode("|", $group[$r]);
$gr_name[$gr[0]] = $gr[2];
}
//if($file_array[6]>0){$colive .= "<tr><td class='fs19' style='text-align: right;'>".$gr_name[$_GET['dir']]." +".number_format($file_array[6], 0, '.', ',')."%</td><td style='text-align: center;'><input name='kachestvo' type='checkbox' value='1' class='korzina chk'></td><td class='fs19' style='text-align: right;'>".$ost."</td></tr>";}
$colive .= "<tr><td></td><td colspan='2' class='fs19' style='text-align: right;'>".$ost."</td></tr>";

$colive .= "<tr><td></td><td style='text-align: center;'><button name='my-add-button' class='button tip' onclick=\"AjaxFormRequest('".$_GET['id']."');\">В корзину</button></td><td></td></tr>";

$colive .= "</table>
						<input type='hidden' name='jcartToken' value='".$_SESSION['jcartToken']."' />
						<input type='hidden' name='my-add-button' value='add' />
						<input type='hidden' name='my-item-id' value='' />
						<input type='hidden' name='my-item-name' value='' />
						<input type='hidden' name='my-item-url' value='".$file_array[6].'|'.$file_array[5].'|'.$_GET['dir'].'|'.$file_array[12].'|'.$file_array[13].'|'.$file_array[14]."' />
						<input type='hidden' name='my-item-price' value='' />
						<input type='hidden' name='my-item-kol' value='".$file_array[3]."' />
				</form>
        	</div>
		</div>";
?>
<script type="text/javascript">
$(document).ready(function(){

$('#razmer').change(function(){
$(".ost").css("display", "none");
$("#x"+md5($(this).attr("value"))).css("display", "block");
});

$('.korzina').change(function(){summ();});
setTimeout(function() {summ();}, 1);
});

$('button').click(function(){
$(".close img").css("display", "none");
$(".close div").css("display", "block");
});
var ostatok = [];
<?
$ost='';
$ostat=explode (",", $file_array[12]);
if($ostat[1]!=''){
for($v=0;$v<count($ostat);$v++){
$ostatok=explode ("-", $ostat[$v]);
if($_SESSION['tvpz'] == '0'){$ostatok[1]=0;}
if($ostatok[1] == 0){echo 'ostatok["'.$ostatok[0].'-'.$kesh['razmer'][$ostatok[0]].'"]=0;';}
else{echo 'ostatok["'.$ostatok[0].'-'.$kesh['razmer'][$ostatok[0]].'"]='.$ostatok[1].';';}
}
}
else{
if($file_array[12] == 0){echo 'ostatok["undefined"]=0;';}else{echo 'ostatok["undefined"]='.$file_array[12].';';}
}
?>
var objves = document.getElementById("ves");

function summ(){
if(ostatok[$('#razmer').attr("value")] > 0){
<?
if($file_array[9]){
echo "vessel = getSelectedIndexes(objves);if(vessel == ''){vessel=0;}";
$ves=explode (",", $file_array[9]);
if($ves[1]){
for($q=0;$q<count($ves);$q++){
$vs=explode ("-", $ves[$q]);
echo 'objves.options['.$q.'] = new Option("'.$vs[0].' г. + '.number_format($vs[1]*$val3, 0, '.', ',').' р.", "'.$ves[$q].'");';
}
}
echo "objves.selectedIndex = vessel;";
}
?>
}
else{
<?
if($file_array[9]){
echo "vessel = getSelectedIndexes(objves);if(vessel == ''){vessel=0;}";
$ves=explode (",", $file_array[9]);
if($ves[1]){
for($q=0;$q<count($ves);$q++){
$vs=explode ("-", $ves[$q]);
echo 'objves.options['.$q.'] = new Option("'.$vs[0].' г. + '.$val1.number_format($vs[1], $tochka, '.', ',').$val02.'", "'.$ves[$q].'");';
}
}
echo "objves.selectedIndex = vessel;";
}
?>
}

<?if($file_array[6]){?>kachestvo = $('[name="kachestvo"]:checked').parent().find('input').val();kachestvo = parseFloat(kachestvo);kachestvo = 1;<?}?>

razmer = $('[name="razmer"]').parent().find('select').val();
if(razmer){razmer = razmer.split('-');
rz = parseFloat(razmer[0]);
rzPrice = parseFloat(razmer[1]);}
else {rzPrice=0;rz = $('[name="razmer1"]').parent().find('input').val();}

ves = $('[name="ves"]').parent().find('select').val();
if(ves){ves = ves.split('-');
vs = parseFloat(ves[0]);
vsPrice = parseFloat(ves[1]);}
else {vsPrice=0;vs = $('[name="ves1"]').parent().find('input').val();
if (vs.length == 0){vs='0'}}

kol = $('[name="my-item-qty"]').parent().find('select').val();
kol = parseFloat(kol);

<?
$shtx=@explode (",", $file_array[3]);
if($shtx[1]){
foreach($shtx as $row){
$sht0=@explode ("-", $row);
echo 'if(rz == "'.$sht0[0].'" && vs == "'.$sht0[1].'"){$("#sht").html('.$sht0[2].');}';
}}
?>

<?if($file_array[6]){?>if(kachestvo == 1){
cena = ((parseFloat('<?=$file_array[2]?>') + rzPrice + vsPrice) * (kol * parseFloat('<?=$file_array[3]?>'))) + ((((parseFloat('<?=$file_array[2]?>') + rzPrice + vsPrice) * (kol * parseFloat('<?=$file_array[3]?>'))) / 100 ) * parseFloat('<?=$file_array[6]?>'));
cen = (parseFloat('<?=$file_array[2]?>') + rzPrice + vsPrice) + ((parseFloat('<?=$file_array[2]?>') + rzPrice + vsPrice) / 100) * parseFloat('<?=$file_array[6]?>');
}
else {<?}?>
cena = (parseFloat('<?=$file_array[2]?>') + rzPrice + vsPrice) * (kol * parseFloat('<?=$file_array[3]?>'));
cen = parseFloat('<?=$file_array[2]?>') + rzPrice + vsPrice;
<?if($file_array[6]){?>}<?}?>

if(ostatok[$('#razmer').attr("value")] > 0){
$('#summ').html((cen*<?=$val3?>).toFixed(0)+' руб.');
$('#summa').html((cena*<?=$val3?>).toFixed(0)+' руб.');
}
else{
$('#summ').html(<?if($val1){echo "'".$val1."'+";}?>(cen).toFixed(<?=$tochka?>)<?if($val2){echo "+'".$val2."'";}?><?if($val1){?>+'<br><div style="font-size: 70%;">цена в руб. '+(cen*<?=$val3?>).toFixed(0)+'р.</div>'<?}?>);
$('#summa').html(<?if($val1){echo "'".$val1."'+";}?>(cena).toFixed(<?=$tochka?>)<?if($val2){echo "+'".$val2."'";}?><?if($val1){?>+'<br><div style="font-size: 70%;">цена в руб. '+(cena*<?=$val3?>).toFixed(0)+'р.</div>'<?}?>);
}
$('input[name="my-item-price"]').val((cen).toFixed(<?=$tochka?>));
$('input[name="my-item-name"]').val('<?=$file_array[0]?> '+rz+'см. <?=$_GET["stran"]?>');

<?if($file_array[6]){?>if(kachestvo == 1){kct=1;}else{kct='';}<?}?>
$('input[name="my-item-id"]').val('<?=$_GET['id']?>'+'|'+rz+'|'+vs+'|'+'<?if($file_array[6]){?>'+kct+'<?}?>');

}

function getSelectedIndexes (oListbox)
{
  var arrIndexes = new Array;
  for (var i=0; i < oListbox.options.length; i++)
  {
      if (oListbox.options[i].selected) arrIndexes.push(i);
  }
  return arrIndexes;
};

function md5cycle(x, k)
{
    var a = x[0], b = x[1], c = x[2], d = x[3];

    a = ff(a, b, c, d, k[0], 7, -680876936);
    d = ff(d, a, b, c, k[1], 12, -389564586);
    c = ff(c, d, a, b, k[2], 17,  606105819);
    b = ff(b, c, d, a, k[3], 22, -1044525330);
    a = ff(a, b, c, d, k[4], 7, -176418897);
    d = ff(d, a, b, c, k[5], 12,  1200080426);
    c = ff(c, d, a, b, k[6], 17, -1473231341);
    b = ff(b, c, d, a, k[7], 22, -45705983);
    a = ff(a, b, c, d, k[8], 7,  1770035416);
    d = ff(d, a, b, c, k[9], 12, -1958414417);
    c = ff(c, d, a, b, k[10], 17, -42063);
    b = ff(b, c, d, a, k[11], 22, -1990404162);
    a = ff(a, b, c, d, k[12], 7,  1804603682);
    d = ff(d, a, b, c, k[13], 12, -40341101);
    c = ff(c, d, a, b, k[14], 17, -1502002290);
    b = ff(b, c, d, a, k[15], 22,  1236535329);

    a = gg(a, b, c, d, k[1], 5, -165796510);
    d = gg(d, a, b, c, k[6], 9, -1069501632);
    c = gg(c, d, a, b, k[11], 14,  643717713);
    b = gg(b, c, d, a, k[0], 20, -373897302);
    a = gg(a, b, c, d, k[5], 5, -701558691);
    d = gg(d, a, b, c, k[10], 9,  38016083);
    c = gg(c, d, a, b, k[15], 14, -660478335);
    b = gg(b, c, d, a, k[4], 20, -405537848);
    a = gg(a, b, c, d, k[9], 5,  568446438);
    d = gg(d, a, b, c, k[14], 9, -1019803690);
    c = gg(c, d, a, b, k[3], 14, -187363961);
    b = gg(b, c, d, a, k[8], 20,  1163531501);
    a = gg(a, b, c, d, k[13], 5, -1444681467);
    d = gg(d, a, b, c, k[2], 9, -51403784);
    c = gg(c, d, a, b, k[7], 14,  1735328473);
    b = gg(b, c, d, a, k[12], 20, -1926607734);

    a = hh(a, b, c, d, k[5], 4, -378558);
    d = hh(d, a, b, c, k[8], 11, -2022574463);
    c = hh(c, d, a, b, k[11], 16,  1839030562);
    b = hh(b, c, d, a, k[14], 23, -35309556);
    a = hh(a, b, c, d, k[1], 4, -1530992060);
    d = hh(d, a, b, c, k[4], 11,  1272893353);
    c = hh(c, d, a, b, k[7], 16, -155497632);
    b = hh(b, c, d, a, k[10], 23, -1094730640);
    a = hh(a, b, c, d, k[13], 4,  681279174);
    d = hh(d, a, b, c, k[0], 11, -358537222);
    c = hh(c, d, a, b, k[3], 16, -722521979);
    b = hh(b, c, d, a, k[6], 23,  76029189);
    a = hh(a, b, c, d, k[9], 4, -640364487);
    d = hh(d, a, b, c, k[12], 11, -421815835);
    c = hh(c, d, a, b, k[15], 16,  530742520);
    b = hh(b, c, d, a, k[2], 23, -995338651);

    a = ii(a, b, c, d, k[0], 6, -198630844);
    d = ii(d, a, b, c, k[7], 10,  1126891415);
    c = ii(c, d, a, b, k[14], 15, -1416354905);
    b = ii(b, c, d, a, k[5], 21, -57434055);
    a = ii(a, b, c, d, k[12], 6,  1700485571);
    d = ii(d, a, b, c, k[3], 10, -1894986606);
    c = ii(c, d, a, b, k[10], 15, -1051523);
    b = ii(b, c, d, a, k[1], 21, -2054922799);
    a = ii(a, b, c, d, k[8], 6,  1873313359);
    d = ii(d, a, b, c, k[15], 10, -30611744);
    c = ii(c, d, a, b, k[6], 15, -1560198380);
    b = ii(b, c, d, a, k[13], 21,  1309151649);
    a = ii(a, b, c, d, k[4], 6, -145523070);
    d = ii(d, a, b, c, k[11], 10, -1120210379);
    c = ii(c, d, a, b, k[2], 15,  718787259);
    b = ii(b, c, d, a, k[9], 21, -343485551);

    x[0] = add32(a, x[0]);
    x[1] = add32(b, x[1]);
    x[2] = add32(c, x[2]);
    x[3] = add32(d, x[3]);
}

function cmn(q, a, b, x, s, t)
{
    a = add32(add32(a, q), add32(x, t));
    return add32((a << s) | (a >>> (32 - s)), b);
}

function ff(a, b, c, d, x, s, t)
{
    return cmn((b & c) | ((~b) & d), a, b, x, s, t);
}

function gg(a, b, c, d, x, s, t)
{
    return cmn((b & d) | (c & (~d)), a, b, x, s, t);
}

function hh(a, b, c, d, x, s, t)
{
    return cmn(b ^ c ^ d, a, b, x, s, t);
}

function ii(a, b, c, d, x, s, t)
{
    return cmn(c ^ (b | (~d)), a, b, x, s, t);
}

function md51(s)
{
    txt = '';
    var n = s.length,
    state = [1732584193, -271733879, -1732584194, 271733878], i;

    for (i=64; i<=s.length; i+=64)
    {
        md5cycle(state, md5blk(s.substring(i-64, i)));
    }

    s = s.substring(i-64);
    var tail = [0,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0];

    for (i=0; i<s.length; i++)
    {
        tail[i>>2] |= s.charCodeAt(i) << ((i%4) << 3);
    }

    tail[i>>2] |= 0x80 << ((i%4) << 3);

    if (i > 55)
    {
        md5cycle(state, tail);
        for (i=0; i<16; i++)
        {
            tail[i] = 0;
        }
    }

    tail[14] = n*8;
    md5cycle(state, tail);
    return state;
}

/* there needs to be support for Unicode here,
 * unless we pretend that we can redefine the MD-5
 * algorithm for multi-byte characters (perhaps
 * by adding every four 16-bit characters and
 * shortening the sum to 32 bits). Otherwise
 * I suggest performing MD-5 as if every character
 * was two bytes--e.g., 0040 0025 = @%--but then
 * how will an ordinary MD-5 sum be matched?
 * There is no way to standardize text to something
 * like UTF-8 before transformation; speed cost is
 * utterly prohibitive. The JavaScript standard
 * itself needs to look at this: it should start
 * providing access to strings as preformed UTF-8
 * 8-bit unsigned value arrays.
 */
function md5blk(s)
{
    var md5blks = [], i; /* Andy King said do it this way. */
    for (i=0; i<64; i+=4)
    {
        md5blks[i>>2] = s.charCodeAt(i)+(s.charCodeAt(i+1) << 8)+(s.charCodeAt(i+2) << 16)+(s.charCodeAt(i+3) << 24);
    }

    return md5blks;
}

var hex_chr = '0123456789abcdef'.split('');

function rhex(n)
{
    var s='', j=0;
    for(; j<4; j++)
    {
        s += hex_chr[(n >> (j * 8 + 4)) & 0x0F] + hex_chr[(n >> (j * 8)) & 0x0F];
    }

    return s;
}

function hex(x)
{
    for (var i=0; i<x.length; i++)
    {
        x[i] = rhex(x[i]);
    }

    return x.join('');
}

function md5(s)
{
    return hex(md51(s));
}

/* this function is much faster,
so if possible we use it. Some IEs
are the only ones I know of that
need the idiotic second function,
generated by an if clause.  */
function add32(a, b)
{
    return (a + b) & 0xFFFFFFFF;
}

if (md5('hello') != '5d41402abc4b2a76b9719d911017c592')
{
    function add32(x, y)
    {
        var lsw = (x & 0xFFFF) + (y & 0xFFFF),
        msw = (x >> 16) + (y >> 16) + (lsw >> 16);
        return (msw << 16) | (lsw & 0xFFFF);
    }
}
</script>
<?
echo $colive;
?>