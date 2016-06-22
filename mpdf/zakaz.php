<?php header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('UTC');
include_once('jcart/jcart.php');
require_once "functions.php";
session_start();

require_once 'phpexcel/Classes/PHPExcel.php';
$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("phpexcel/template.xls");
//$objPHPExcel->removeSheetByIndex(0);

$settingsX = @file("./gallery/settings/settings.txt");
for ($i=0; $i<count($settingsX); $i++){
$settings[$i] = trim($settingsX[$i]);
$settings[$i] = trim($settingsX[$i]);
$settings[$i] = trim($settingsX[$i]);
}
$x=0;
$dirs=directory("./zakaz/",'pdf');
foreach ($dirs as $dir){
$x++;
}
$x++;

$na_fa = htmlspecialchars($_POST['na_fa']);
$p_email = htmlspecialchars($_POST['p_email']);
$p_phote = htmlspecialchars($_POST['p_phote']);
$p_adress = htmlspecialchars($_POST['p_adress']);
$p_times = htmlspecialchars($_POST['p_times']);
$mynim_name = htmlspecialchars($_POST['mynim_name']);
$mynim_item = htmlspecialchars($_POST['mynim_item']);


for($i=0;$i<count($_POST['jcartItemId']);$i++){
$jcartItemId=explode ("|", $_POST['jcartItemId'][$i]);
$filearray = @file("./gallery/otdel".$_POST['jcarCat'][$i]."/text/".$jcartItemId[0].'.txt');
for($xzx=0;$xzx<count($filearray);$xzx++){$filearray[$xzx] = trim($filearray[$xzx]);}

if($filearray[2]){
$filearray[8] = $filearray[8] + 1;

$ost=explode (",", $filearray[12]);
if($ost[1]!=''){
$ostatot='';
foreach ($ost as $d){
$o=explode ("-", $d);
if($o[0] == $jcartItemId[1]){$o[1] = $o[1] - $_POST['jcartItemQty'][$i];if($o[1]<0){$o[1]=0;}}
if($ostatot == ''){$ostatot = $o[0].'-'.$o[1];}else{$ostatot .= ','.$o[0].'-'.$o[1];}
}
$filearray[12] = $ostatot;
}
else {
$filearray[12] = $filearray[12] - $_POST['jcartItemQty'][$i];
if($filearray[12]<0){$filearray[12]=0;}
}

$fp = @fopen("./gallery/otdel".$_POST['jcarCat'][$i]."/text/".$jcartItemId[0].'.txt', "w");
$test = fwrite($fp, $filearray[0].'
'.$filearray[1].'
'.$filearray[2].'
'.$filearray[3].'
'.$filearray[4].'
'.$filearray[5].'
'.$filearray[6].'
'.$filearray[7].'
'.$filearray[8].'
'.$filearray[9].'
'.$filearray[10].'
'.$filearray[11].'
'.$filearray[12].'
'.$filearray[13].'
'.$filearray[14].'
'.$filearray[15]);
fclose($fp);
}
}

$HTML = "<html>
<head>
<meta http-equiv=Content-Type content=\"text/html; charset=utf-8\">
<meta name=Generator content=\"Microsoft Word 15 (filtered)\">>
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Times New Roman;
	panose-1:2 7 4 9 2 2 5 2 4 4;}
@font-face
	{font-family:\"Times New Roman\";
	panose-1:2 4 5 3 5 4 6 3 2 4;}
@font-face
	{font-family:Times New Roman;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0cm;
	margin-bottom:.0001pt;
	font-size:12.0pt;
	font-family:\"Times New Roman\",\"serif\";}
@page WordSection1
	{size:595.3pt 841.9pt;
	margin:27.0pt 42.5pt 2.0cm 27.0pt;}
-->
</style>

</head>

<body lang=RU>

<div class=WordSection1>";

$ostX='';
for($i=0;$i<count($_POST['jcartItemId']);$i++){
if($_POST['jcartItemName'][$i]){
$idcc=explode ("|", $_POST['jcartItemId'][$i]);
$ostatX=explode ("|", $_POST['jcartItemUrl'][$i]);
$ostat=explode (",", $ostatX[3]);

if($ostat[1]){
  for($v=0;$v<count($ostat);$v++){
    $ostatok=explode ("-", $ostat[$v]);
    for($b=0;$b<count($ostatok[0]);$b++){
      if($ostatok[0] == $idcc[1]){
        if($ostatok[0] == ''){$ostatok[0] = 0;}

        if($ostatok[1] > 0){
          if($idcc[3] == 1){
            $ostX[1][] = $i;
          }
          $ostX[0][] = $i;
        }
        else{
          if($idcc[3] == 1){
            $ostX[3][] = $i;
          }
          $ostX[2][] = $i;
        }

      }
    }
  }
}
else{
  if($ostat[0] == ''){$ostat[0] = 0;}

  if($ostat[0] > 0){
    if($idcc[3] == 1){
      $ostX[1][] = $i;
    }
    $ostX[0][] = $i;
  }
  else{
  if($idcc[3] == 1){
      $ostX[3][] = $i;
  }
  $ostX[2][] = $i;
  }
}}}
$z=0;
foreach($ostX as $key => $list){
$data = array();
$baseRow = 12;

if($z > 0){$HTML .= "<pagebreak />";}
if($key == 0){$name = 'ОПТОВЫЙ ЧЕК';}
if($key == 1){$name = 'РОЗНИЧНЫЙ ЧЕК';}
if($key == 2){$name = 'ПРЕДЗАКАЗ ОПТОВЫЙ';}
if($key == 3){$name = 'ПРЕДЗАКАЗ РОЗНИЧНЫЙ';}
if($key == 2){$colspan=6;}else{$colspan=5;}

//$objPHPExcel->createSheet($z);
$objPHPExcel->setActiveSheetIndex($key);
$objPHPExcel->getActiveSheet($key)->setTitle($name);
if ($key == 0 or $key == 1){$p_times = utf8_encode((date('d')+1).date('.m.y').' &#8722; '.substr($p_times, 12));}
else {$p_times = htmlspecialchars($_POST['p_times']);}
//if($key == 2){$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');}else{$objPHPExcel->getActiveSheet()->mergeCells('A2:F2');}
$objPHPExcel->getActiveSheet()->setCellValue('A2', $settings[0]);
$objPHPExcel->getActiveSheet()->setCellValue('A3', "$name № $x от ".date('d.m.Y')." г.");
$objPHPExcel->getActiveSheet()->setCellValue('A5', "Покупатель:      $na_fa");
$objPHPExcel->getActiveSheet()->setCellValue('A6', "Контакты:      телефон: $p_phote, e-mail: $p_email");
$objPHPExcel->getActiveSheet()->setCellValue('A7', "Адрес доставки:      $p_adress");
$objPHPExcel->getActiveSheet()->setCellValue('A8', "Доставка:      $p_times");

$HTML .= "<h3 style='text-align:center;'>".$settings[0]."</h3>

<p class=MsoNormal align=center style='text-align:center;text-autospace:none'><span>".$name." №</span> <span>".$x."</span><span> </span><span
style='font-size:10.0pt;'>от </span><span style='font-size:
10.0pt;'>".date('d.m.Y')."</span><span style='font-size:10.0pt;'> г.</span></p>

<p class=MsoNormal align=center style='text-align:center;text-autospace:none'><span>&nbsp;</span></p>

<p class=MsoNormal align=center style='text-align:center;text-autospace:none'><span
style='font-size:10.0pt;'>&nbsp;</span></p>

<p class=MsoNormal style='text-autospace:none'><span style='font-size:10.0pt;'>Покупатель:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$na_fa."</span></p>

<p class=MsoNormal style='text-autospace:none'><span style='font-size:10.0pt;'>Контакты:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;телефон: ".$p_phote.", e-mail: ".$p_email."</span></p>

<p class=MsoNormal style='text-autospace:none'><span style='font-size:10.0pt;'>Адрес доставки:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$p_adress."</span></p>

<p class=MsoNormal style='text-autospace:none'><span style='font-size:10.0pt;'>Доставка:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$p_times."</span></p>

<p class=MsoNormal align=center style='text-align:center;text-autospace:none'><span
style='font-size:10.0pt;'>&nbsp;</span></p>

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0
 style='margin-left:5.4pt;border-collapse:collapse;border:none'>
 <tr style='height:16.5pt'>
  <td width=24 style='width:18.0pt;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:16.5pt'>
  <p class=MsoNormal align=center style='text-align:center;text-autospace:none'><span
  style='font-size:9.0pt;'>№</span></p>
  </td>
  <td width=400 style='width:299.8pt;border:solid windowtext 1.0pt;border-left:
  none;padding:0cm 5.4pt 0cm 5.4pt;height:16.5pt' align=\"center\">
  <p class=MsoNormal align=center style='text-align:center;text-autospace:none'><span
  style='font-size:9.0pt;'>Наименование</span></p>
  </td>";
if($key == 2){
$HTML .= "<td width=68 style='width:51.2pt;border:solid windowtext 1.0pt;border-left:
  none;padding:0cm 5.4pt 0cm 5.4pt;height:16.5pt' align=\"center\">
  <p class=MsoNormal align=center style='text-align:center;text-autospace:none'><span
  style='font-size:9.0pt;'>Цена в валюте</span></p>
  </td>";
$HTML .= "<td width=68 style='width:51.2pt;border:solid windowtext 1.0pt;border-left:
  none;padding:0cm 5.4pt 0cm 5.4pt;height:16.5pt' align=\"center\">
  <p class=MsoNormal align=center style='text-align:center;text-autospace:none'><span
  style='font-size:9.0pt;'>Цена в рублях</span></p>
  </td>";
}
else{
$HTML .= "<td width=68 style='width:51.2pt;border:solid windowtext 1.0pt;border-left:
  none;padding:0cm 5.4pt 0cm 5.4pt;height:16.5pt' align=\"center\">
  <p class=MsoNormal align=center style='text-align:center;text-autospace:none'><span
  style='font-size:9.0pt;'>Цена</span></p>
  </td>";
}
$HTML .= "<td width=60 style='width:45.0pt;border:solid windowtext 1.0pt;border-left:
  none;padding:0cm 5.4pt 0cm 5.4pt;height:16.5pt' align=\"center\">
  <p class=MsoNormal align=center style='text-align:center;text-autospace:none'><span
  style='font-size:9.0pt;'>Кол. в упаковке</span></p>
  </td>
  <td width=72 style='width:54.0pt;border:solid windowtext 1.0pt;border-left:
  none;padding:0cm 5.4pt 0cm 5.4pt;height:16.5pt' align=\"center\">
  <p class=MsoNormal align=center style='text-align:center;text-autospace:none'><span
  style='font-size:9.0pt;'>Кол. упаковок</span></p>
  </td>
  <td width=84 style='width:63.0pt;border:solid windowtext 1.0pt;border-left:
  none;padding:0cm 5.4pt 0cm 5.4pt;height:16.5pt' align=\"center\">
  <p class=MsoNormal align=center style='text-align:center;text-autospace:none'><span
  style='font-size:9.0pt;'>Сумма</span></p>
  </td>
 </tr>";

foreach($list as $i){
$jcartItemId=explode ("|", $_POST['jcartItemId'][$i]);
$jcartItemUrl=explode ("|", $_POST['jcartItemUrl'][$i]);
$jcartItemPrice = $_POST['jcartItemPrice'][$i];

$val1=$val2=$val3='';
if($key == 2){
if($jcartItemUrl[4] == 'usd'){$val1='$ ';$tochka=2;}elseif($jcartItemUrl[4] == 'eur'){$val1='€ ';$tochka=2;}elseif($jcartItemUrl[4] == 'uan'){$val1='¥ ';$tochka=2;}else{$val2=' р.';$tochka=0;}
$val3=1;$jca=$jcartItemUrl[4];
}
else{
if($jcartItemUrl[4] == 'usd'){$val3=$settings[12];}elseif($jcartItemUrl[4] == 'eur'){$val3=$settings[13];}elseif($jcartItemUrl[4] == 'uan'){$val3=$settings[14];}else{$val3=1;}
$val2=' р.';$tochka=0;$jca='rub';
}

if($_SESSION['kratnost'][$_POST['jcartItemId'][$i]]){$_POST['jcartItemQty'][$i] = $_POST['jcartItemQty'][$i] * $_SESSION['kratnost'][$_POST['jcartItemId'][$i]];}

$jKol = explode (",", $_POST['jcartItemKol'][$i]);
if($jKol[1]!=''){
foreach ($jKol as $d){
$o=explode ("-", $d);
if($o[0] == $jcartItemId[1]){$jcartItemKol = $o[1];}
}
}
else{
$jcartItemKol = $_POST['jcartItemKol'][$i];
}

$summ = $jcartItemPrice * $jcartItemKol * $_POST['jcartItemQty'][$i] * $val3;
$sm[$jca] = $summ + $sm[$jca];
$s=$i+1;
if ($key==0 OR $key ==2){$cena = $val1.number_format($jcartItemPrice*$val3, $tochka, '.', ',').$val2;}
else {$cena = '';}

$HTML .= "<tr style='height:9.75pt'>
  <td width=24 valign=top style='width:18.0pt;border:solid windowtext 1.0pt;
  border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:9.75pt'>
  <p class=MsoNormal align=center style='text-align:center;text-autospace:none'><span
  style='font-size:10.0pt;'>".$s."</span></p>
  </td>
  <td width=400 valign=top style='width:299.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:9.75pt'>
  <p class=MsoNormal style='text-autospace:none'><span style='font-size:9.0pt;'>".$_POST['jcartItemName'][$i]."</span></p>
  </td>
  <td width=68 valign=top style='width:51.2pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:9.75pt' align=\"right\">
  <p class=MsoNormal align=right style='text-align:right;text-autospace:none'><span
  style='font-size:10.0pt;'>".$cena."</span></p>
  </td>";
if($key == 2){
if($jcartItemUrl[4] == 'usd'){$val03=$settings[12];}elseif($jcartItemUrl[4] == 'eur'){$val03=$settings[13];}elseif($jcartItemUrl[4] == 'uan'){$val03=$settings[14];}else{$val03=1;}
$HTML .= "<td width=68 valign=top style='width:51.2pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:9.75pt' align=\"right\">
  <p class=MsoNormal align=right style='text-align:right;text-autospace:none'><span
  style='font-size:10.0pt;'>".number_format($jcartItemPrice*$val03, 0, '.', ',')." р.</span></p>
  </td>";
$data[] = array('title' => $_POST['jcartItemName'][$i],'price' => $val1.number_format($jcartItemPrice*$val3, $tochka, '.', ',').$val2,'price2' => number_format($jcartItemPrice*$val03, 0, '.', ',')." р.",'kol' => $jcartItemKol,'upak' => $_POST['jcartItemQty'][$i],'summ' => $val1.number_format($summ, $tochka, '.', ',').$val2);
}
else{
$data[] = array('title' => $_POST['jcartItemName'][$i],'price' => $val1.number_format($jcartItemPrice*$val3, $tochka, '.', ',').$val2,'kol' => $jcartItemKol,'upak' => $_POST['jcartItemQty'][$i],'summ' => $val1.number_format($summ, $tochka, '.', ',').$val2);
}
if($key == 0 OR $key==2){$ssum = $val1.number_format($summ, $tochka, '.', ',').$val2;}
else {$ssum = '';}

$HTML .= "<td width=60 valign=top style='width:45.0pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:9.75pt' align=\"right\">
  <p class=MsoNormal align=right style='text-align:right;text-autospace:none'><span
  style='font-size:10.0pt;'>".$jcartItemKol."</span></p>
  </td>
  <td width=72 valign=top style='width:54.0pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:9.75pt' align=\"right\">
  <p class=MsoNormal align=right style='text-align:right;text-autospace:none'><span
  style='font-size:10.0pt;'>".$_POST['jcartItemQty'][$i]."</span></p>
  </td>
  <td width=84 valign=top style='width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:9.75pt' align=\"right\">
  <p class=MsoNormal align=right style='text-align:right;text-autospace:none'><span
  style='font-size:10.0pt;'>".$ssum."</span></p>
  </td>
 </tr>";
}

if($key == 2){
	$objPHPExcel->getActiveSheet()->setCellValue('A10', '№')
	                              ->setCellValue('B10', 'Наименование')
	                              ->setCellValue('C10', 'Цена в валюте')
	                              ->setCellValue('D10', 'Цена в рублях')
	                              ->setCellValue('E10', 'Кол. в упаковке')
	                              ->setCellValue('F10', 'Кол. упаковок')
	                              ->setCellValue('G10', 'Сумма');
}
else{
	$objPHPExcel->getActiveSheet()->setCellValue('A10', '№')
	                              ->setCellValue('B10', 'Наименование')
	                              ->setCellValue('C10', 'Цена')
	                              ->setCellValue('D10', 'Кол. в упаковке')
	                              ->setCellValue('E10', 'Кол. упаковок')
	                              ->setCellValue('F10', 'Сумма');
}

foreach($data as $r => $dataRow) {
	$row = $baseRow + $r;
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
  if($key == 1 or $key==3){$pr = ''.$val2;}else{$pr = $dataRow['price'];}
  if($key == 1 or $key==3){$sumex = ''.$val2;}else{$sumex = $dataRow['summ'];}
  
if($key == 2){
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $r+1)
	                              ->setCellValue('B'.$row, $dataRow['title'])
	                              ->setCellValue('C'.$row, $dataRow['price'])
	                              ->setCellValue('D'.$row, $dataRow['price2'])
	                              ->setCellValue('E'.$row, $dataRow['kol'])
	                              ->setCellValue('F'.$row, $dataRow['upak'])
	                              ->setCellValue('G'.$row, $dataRow['summ']);
}
else{
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $r+1)
	                              ->setCellValue('B'.$row, $dataRow['title'])
	                              ->setCellValue('C'.$row, $pr)
	                              ->setCellValue('D'.$row, $dataRow['kol'])
	                              ->setCellValue('E'.$row, $dataRow['upak'])
	                              ->setCellValue('F'.$row, $sumex);
}
$bRow = $row;
}
$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);

if($key == 2){$cell='G';}else{$cell='F';}

$HTML .= "<tr style='height:10.4pt'>
  <td width=624 colspan=$colspan valign=top style='width:468.0pt;border:solid windowtext 1.0pt;
  border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:10.4pt' align=\"right\">
  <p class=MsoNormal align=right style='text-align:right;text-autospace:none'><span
  style='font-size:10.0pt;'>Итог:</span></p>
  </td>
  <td width=84 valign=top style='width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:10.4pt' align=\"right\">
  <p class=MsoNormal align=right style='text-align:right;text-autospace:none'><span
  style='font-size:10.0pt;'>";

if($key == 2){$f=0;$G=4;
$objPHPExcel->getActiveSheet()->setCellValue('G'.$G, 'Курс валют');
$tab = "<div style='padding:10px;position:fixed;top:0px;right:0px;border: 1px solid #000000;'>Курс валют<br />в накладной.<br />";
foreach($sm as $b => $c){
$v1=$v2=$v3=$tc='';
if($f>0){$HTML .= "<br />";$tab .= "<br />";$G++;}
if($b == 'usd'){$v1='$ ';$tc=2;$v3=$settings[12];$tab .= "1$ = ".$settings[12]." р.";$objPHPExcel->getActiveSheet()->setCellValue('G'.$G, "1$ = ".$settings[12]." р.");}
elseif($b == 'eur'){$v1='€ ';$tc=2;$v3=$settings[13];$tab .= "1€ = ".$settings[13]." р.";$objPHPExcel->getActiveSheet()->setCellValue('G'.$G, "1€ = ".$settings[13]." р.");}
elseif($b == 'uan'){$v1='¥ ';$tc=2;$v3=$settings[14];$tab .= "1¥ = ".$settings[14]." р.";$objPHPExcel->getActiveSheet()->setCellValue('G'.$G, "1¥ = ".$settings[14]." р.");}
else{$v2=' р.';$tc=0;$v3=1;}

$sm2 = $sm2 + ($c * $v3);
$aass = $v1.number_format($c, $tc, '.', ',').$v2;
if ($key == 1 or $key ==3){$aass = '';}
$HTML .= $aass;
$f++;
}
$tab .= "</div>";

$sm2 = $sm2 + $_SESSION['p_dostavka'];
}
elseif($key == 1 OR $key == 3){
$HTML .= '';
$sm2 = $sm[$jca];
}
else{
$HTML .= '';
$sm2 = $sm[$jca] + $_SESSION['p_dostavka'];
}
if($key == 1 or $key==3){$itex = ''.$val2;}else{$itex = $val1.number_format($sm[$jca], $tochka, '.', ',').$val2;}
$objPHPExcel->getActiveSheet()->setCellValue('A'.$bRow, 'Итог:   ');
$objPHPExcel->getActiveSheet()->setCellValue($cell.$bRow, $itex);
$HTML .= "</span></p>
  </td>
 </tr>";
$HTML .= "<tr style='height:10.4pt'>";
if($key == 0 OR $key == 2){
$bRow++;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$bRow, 'Стоимость доставки:   ');
$objPHPExcel->getActiveSheet()->setCellValue($cell.$bRow, number_format($_SESSION['p_dostavka'], 0, '.', ',')." р.");
$HTML .= "<td width=624 colspan=$colspan valign=top style='width:468.0pt;border:solid windowtext 1.0pt;
  border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:10.4pt' align=\"right\">
  <p class=MsoNormal align=right style='text-align:right;text-autospace:none'><span
  style='font-size:10.0pt;'>Стоимость доставки:</span></p>
  </td>";
$HTML .= "<td width=84 valign=top style='width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:10.4pt' align=\"right\">
  <p class=MsoNormal align=right style='text-align:right;text-autospace:none'><span
  style='font-size:10.0pt;'>".number_format($_SESSION['p_dostavka'], 0, '.', ',')." р.</span></p>
  </td>
 </tr>";

if($key != 2){
$bRow++;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$bRow, 'Итого с доставкой:   ');
if($key == 1 or $key==3){$itex2 = ''.$val2;}else{$itex2 = $val1.number_format($sm2, $tochka, '.', ',').$val2;}

$objPHPExcel->getActiveSheet()->setCellValue($cell.$bRow, $itex2);
if ($key !=1 and $key!=3) {$sss=$val1.number_format($sm2, $tochka, '.', ',').$val2;}
else {$sss = '';}
$HTML .= "<tr style='height:10.4pt'>
  <td width=624 colspan=$colspan valign=top style='width:468.0pt;border:solid windowtext 1.0pt;
  border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:10.4pt' align=\"right\">
  <p class=MsoNormal align=right style='text-align:right;text-autospace:none'><span
  style='font-size:10.0pt;'>Итого с доставкой:</span></p>
  </td>
  <td width=84 valign=top style='width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:10.4pt' align=\"right\">
  <p class=MsoNormal align=right style='text-align:right;text-autospace:none'><span
  style='font-size:10.0pt;'>".$sss."</span></p>
  </td>
 </tr>";
} }
$HTML .= "</table>
<p class=MsoNormal style='text-autospace:none'><span style='font-size:10.0pt;'>&nbsp;</span></p>";
$itog = number_format($sm2, 0, '.', ',')." р. (".num2str($sm2).")";
if ($key == 1 or $key == 3) {$itog = '';}
$HTML .= "<p class=MsoNormal style='text-autospace:none'><span style='font-size:10.0pt;'>Итого: ".$itog."</span></p>";
$bRow++;$bRow++;
if($key == 1 or $key==3){$itex3 = ''.$val2;}else{$itex3 = number_format($sm2, 0, '.', ',')." р. (".num2str($sm2).")";}
$objPHPExcel->getActiveSheet()->setCellValue('A'.$bRow, "Итого: ".$itex3);

       $kl[1]=0;$kl[2]=0;$kl[3]=0;$day=array();
        	foreach($list as $i)	{
        		$summ += ($_POST['jcartItemQty'][$i] * $_POST['jcartItemPrice'][$i] * $_POST['jcartItemKol'][$i]);
        		$ur=explode ("|", $_POST['jcartItemUrl'][$i]);
        		$kl[$ur[2]] = $kl[$ur[2]] + $_POST['jcartItemQty'][$i] * $_POST['jcartItemKol'][$i];
        		if($day[$ur[2]]<$ur[5]){$day[$ur[2]]=$ur[5];}
        }
$bRow++;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$bRow, "Итого по отделам: ");
$bRow++;
$HTML .= "<p class=MsoNormal style='text-autospace:none'><span style='font-size:10.0pt;'>Итого по отделам: ";

$group = @file($_SERVER['DOCUMENT_ROOT']."/gallery/settings/group.txt");
for ($i=0; $i<count($group); $i++){
$HTMLXX = '';
if($ec==1){$HTML .= "<br>";$bRow++;}$ec=0;
$group[$i] = trim($group[$i]);
$gr = explode("|", $group[$i]);
if($kl[$gr[0]]>0){$HTMLXX .= $gr[1]." - ".$kl[$gr[0]]." шт.";$HTML .= $gr[1]." - ".$kl[$gr[0]]." шт.";$ec=1;}
if($day[$gr[0]]>0){$ec=1;
if($day[$gr[0]] == 1){$deyname = 'день';}
elseif($day[$gr[0]] > 1 AND $day[$gr[0]] < 5){$deyname = 'дня';}
elseif($day[$gr[0]] >= 5){$deyname = 'дней';}
if ($key!=0 and $key!=1){
$HTMLXX .= " Доставка: ".$day[$gr[0]]." $deyname";
$HTML .= " Доставка: ".$day[$gr[0]]." $deyname";
}
}
$objPHPExcel->getActiveSheet()->setCellValue('B'.$bRow, $HTMLXX);
}
$HTML .= "</span></p>";

$bRow++;$bRow++;$bRow++;$bRow++;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$bRow, 'Отпустил: _________________________                                          Получил: _________________________');
$HTML .= "<p class=MsoNormal style='text-autospace:none'><span style='font-size:10.0pt;'>&nbsp;</span></p>
<p class=MsoNormal style='text-autospace:none'><span style='font-size:10.0pt;'>&nbsp;</span></p>
<p class=MsoNormal style='text-autospace:none'><span style='font-size:10.0pt;'>&nbsp;</span></p>
<p class=MsoNormal style='text-autospace:none'><span style='font-size:10.0pt;'>&nbsp;</span></p>
<p class=MsoNormal style='text-autospace:none'><span style='font-size:10.0pt;'>Отпустил: _________________________                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Получил: _________________________</span></p>";

$z++;
$sm2=$sm=$summ='';
$HTML .= $tab;
}

$HTML .= "</div>
</body>
</html>";

for($key=0;$key<=3;$key++){if($ostX[$key] == ''){$objPHPExcel->removeSheetByIndex($key);$key=4;}}
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(str_replace('.php', '.xls', "./zakaz/$x.xls"));

include('mpdf/mpdf.php');
$mpdf=new mPDF();
$mpdf->WriteHTML($HTML);

$content = $mpdf->Output('', 'S');
$fp = fopen("./zakaz/$x.pdf", "w");
$test = fwrite($fp, $content);
fclose($fp);
$content = chunk_split(base64_encode($content));

$filename = "./zakaz/$x.xls";
$handle = fopen($filename, "r");
$content2 = chunk_split(base64_encode(fread($handle, filesize($filename))));
fclose($handle);


$messages = '<pre style="color:black;font-size:15px;">Новый заказ на сайте сайта '.$settings[0].'</pre><p>'.$_POST['p_koment'].'<br /><a href="http://'.$_SERVER['SERVER_NAME'].'/zakaz/'.$x.'.pdf" align="center">Постоянная ссылка на PDF</a><br /><a href="http://'.$_SERVER['SERVER_NAME'].'/zakaz/'.$x.'.xls" align="center">Постоянная ссылка на XLS</a></p>';
$messages2 = '<div align="center"><img src="http://'.$_SERVER['SERVER_NAME'].'/fancybox/mail.png" border="0"></div>';

$name = 'Заказ на покупку № '.$x.' ('.$settings[0].')';
$name2 = 'Заказ № '.$x.' ('.$settings[0].')';
$otpr = 1;

if($otpr == 1){
$uid = md5(uniqid(time()));
$filename = 'Заказ № '.$x.'.pdf';
$filename2 = 'Заказ № '.$x.'.xls';

$header = 'From: '.'=?utf-8?b?' . base64_encode($na_fa) . '?=<info@'.$_SERVER['SERVER_NAME'].">\r\n";
$header .= "Reply-To: ".$p_email."\r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
$header .= "This is a multi-part message in MIME format.\r\n";
$header .= "--".$uid."\r\n";
$header .= "Content-type: text/html; charset=utf-8\r\n";
$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$header .= $messages."\r\n\r\n";
$header .= "--".$uid."\r\n";
$header .= "Content-Type: application/pdf; name=\"".$filename."\"\r\n";
$header .= "Content-Transfer-Encoding: base64\r\n";
$header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
$header .= $content."\r\n\r\n";
$header .= "--".$uid."\r\n";
$header .= "Content-Type: application/xls; name=\"".$filename2."\"\r\n";
$header .= "Content-Transfer-Encoding: base64\r\n";
$header .= "Content-Disposition: attachment; filename=\"".$filename2."\"\r\n\r\n";
$header .= $content2."\r\n\r\n";
$header .= "--".$uid."--";

$header1 = 'From: '.'=?utf-8?b?' . base64_encode($settings[0]) . '?=<info@'.$_SERVER['SERVER_NAME'].">\r\n";
$header1 .= "Reply-To: ".$settings[5]."\r\n";
$header1 .= "MIME-Version: 1.0\r\n";
$header1 .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
$header1 .= "This is a multi-part message in MIME format.\r\n";
$header1 .= "--".$uid."\r\n";
$header1 .= "Content-type: text/html; charset=utf-8\r\n";
$header1 .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$header1 .= $messages2."\r\n\r\n";
$header1 .= "--".$uid."\r\n";
$header1 .= "Content-Type: application/pdf; name=\"".$filename."\"\r\n";
$header1 .= "Content-Transfer-Encoding: base64\r\n";
$header1 .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
$header1 .= $content."\r\n\r\n";
$header1 .= "--".$uid."\r\n";
$header1 .= "Content-Type: application/xls; name=\"".$filename2."\"\r\n";
$header1 .= "Content-Transfer-Encoding: base64\r\n";
$header1 .= "Content-Disposition: attachment; filename=\"".$filename2."\"\r\n\r\n";
$header1 .= $content2."\r\n\r\n";
$header1 .= "--".$uid."--";

mail($settings[5], $name, $messages, $header);
mail($p_email, $name2, $messages2, $header1);

}

unset($_SESSION['jcart']);
unset($_SESSION['kratnost']);
unset($_SESSION['kachestvo']);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Спасибо,заказ принят!</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		body{
			background: grey;
			height:100%;
		}
		div{
			position: absolute;
			background:white;
			width:400px;
			left:50%;
			top:50%;
			margin-top:-125px;
			margin-left:-260px;
			box-shadow: 0 0 20px rgba(0,0,0,0.7);
			-webkit-box-shadow: 0 0 20px rgba(0,0,0,0.7);
			-moz-box-shadow: 0 0 20px rgba(0,0,0,0.7);
			border-radius: 8px;
			-webkit-border-radius: 8px;
			-moz-border-radius: 8px;
			padding: 10px 60px;
		}
		span{font-size: 0.9em;}
	</style>
</head>
<body>
	<div><?echo fread(fopen("./gallery/settings/zakaz.txt", 'r'),1000000);?></div>

</body>
</html>