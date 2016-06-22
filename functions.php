<?php
function strtolower_ru($text) {
 $alfavitlover = array('ё','й','ц','у','к','е','н','г', 'ш','щ','з','х','ъ','ф','ы','в', 'а','п','р','о','л','д','ж','э', 'я','ч','с','м','и','т','ь','б','ю');
 $alfavitupper = array('Ё','Й','Ц','У','К','Е','Н','Г', 'Ш','Щ','З','Х','Ъ','Ф','Ы','В', 'А','П','Р','О','Л','Д','Ж','Э', 'Я','Ч','С','М','И','Т','Ь','Б','Ю');
 return str_replace($alfavitupper,$alfavitlover,strtolower($text));
}

function checkUser($password){	global $settings;
	$real_password = trim($settings[1]);
	if($real_password == $password) return true;
}
function checkSite($password){	global $settings;
	$real_password = trim($settings[6]);
	if($real_password == $password) return true;

}

function isSecurity($avatar){
	$name = $avatar['name'];
	$type = $avatar['type'];
	$size = $avatar['size'];
	$blacklist = array(".php",".phtml",".php3",".php4");
	foreach($blacklist as $item){
		if(preg_match("/$item\$/i".$name)) return false;
	}
		if(($type != "image/gif") && ($type != "image/jpg") && ($type != "image/png") && ($type != "image/jpeg")) return false;
		if($size > 5 * 1024 * 1024) return FALSE;
		return true;
}
function directory($dir,$filters){
	$handle=opendir($dir);
	$files=array();
	if ($filters == "all"){while(($file = readdir($handle))!==false){if ($file != '..' AND $file != '.'){$files[] = $file;}}}
	else {
		$filters=explode(",",$filters);
		while (($file = readdir($handle))!==false) {
			for ($f=0;$f<sizeof($filters);$f++):
				$system=explode(".",$file);
				if($system[2]!=''){$system[1]=$system[2];}
				if($system[3]!=''){$system[1]=$system[3];}
				if ($system[1] == $filters[$f] AND $file != '..' AND $file != '.'){$files[] = $file;}
			endfor;
		}
	}
       sort ($files);
	closedir($handle);
	return $files;
}
function semantic($i,&$words,&$fem,$f){
$_1_2[1]="одна ";
$_1_2[2]="две ";

$_1_19[1]="один ";
$_1_19[2]="два ";
$_1_19[3]="три ";
$_1_19[4]="четыре ";
$_1_19[5]="пять ";
$_1_19[6]="шесть ";
$_1_19[7]="семь ";
$_1_19[8]="восемь ";
$_1_19[9]="девять ";
$_1_19[10]="десять ";

$_1_19[11]="одиннацать ";
$_1_19[12]="двенадцать ";
$_1_19[13]="тринадцать ";
$_1_19[14]="четырнадцать ";
$_1_19[15]="пятнадцать ";
$_1_19[16]="шестнадцать ";
$_1_19[17]="семнадцать ";
$_1_19[18]="восемнадцать ";
$_1_19[19]="девятнадцать ";

$des[2]="двадцать ";
$des[3]="тридцать ";
$des[4]="сорок ";
$des[5]="пятьдесят ";
$des[6]="шестьдесят ";
$des[7]="семьдесят ";
$des[8]="восемьдесят ";
$des[9]="девяносто ";

$hang[1]="сто ";
$hang[2]="двести ";
$hang[3]="триста ";
$hang[4]="четыреста ";
$hang[5]="пятьсот ";
$hang[6]="шестьсот ";
$hang[7]="семьсот ";
$hang[8]="восемьсот ";
$hang[9]="девятьсот ";

$namerub[1]="рубль ";
$namerub[2]="рубля ";
$namerub[3]="рублей ";

$nametho[1]="тысяча ";
$nametho[2]="тысячи ";
$nametho[3]="тысяч ";

$namemil[1]="миллион ";
$namemil[2]="миллиона ";
$namemil[3]="миллионов ";

$namemrd[1]="миллиард ";
$namemrd[2]="миллиарда ";
$namemrd[3]="миллиардов ";

$kopeek[1]="копейка ";
$kopeek[2]="копейки ";
$kopeek[3]="копеек ";
$words="";
$fl=0;
if($i >= 100){
$jkl = intval($i / 100);
$words.=$hang[$jkl];
$i%=100;
}
if($i >= 20){
$jkl = intval($i / 10);
$words.=$des[$jkl];
$i%=10;
$fl=1;
}
switch($i){
case 1: $fem=1; break;
case 2:
case 3:
case 4: $fem=2; break;
default: $fem=3; break;
}
if( $i ){
if( $i < 3 && $f > 0 ){
if ( $f >= 2 ) {
$words.=$_1_19[$i];
}
else {
$words.=$_1_2[$i];
}
}
else {
$words.=$_1_19[$i];
}
}
}

function num2str($L){
$_1_2[1]="одна ";
$_1_2[2]="две ";

$_1_19[1]="один ";
$_1_19[2]="два ";
$_1_19[3]="три ";
$_1_19[4]="четыре ";
$_1_19[5]="пять ";
$_1_19[6]="шесть ";
$_1_19[7]="семь ";
$_1_19[8]="восемь ";
$_1_19[9]="девять ";
$_1_19[10]="десять ";

$_1_19[11]="одиннацать ";
$_1_19[12]="двенадцать ";
$_1_19[13]="тринадцать ";
$_1_19[14]="четырнадцать ";
$_1_19[15]="пятнадцать ";
$_1_19[16]="шестнадцать ";
$_1_19[17]="семнадцать ";
$_1_19[18]="восемнадцать ";
$_1_19[19]="девятнадцать ";

$des[2]="двадцать ";
$des[3]="тридцать ";
$des[4]="сорок ";
$des[5]="пятьдесят ";
$des[6]="шестьдесят ";
$des[7]="семьдесят ";
$des[8]="восемьдесят ";
$des[9]="девяносто ";

$hang[1]="сто ";
$hang[2]="двести ";
$hang[3]="триста ";
$hang[4]="четыреста ";
$hang[5]="пятьсот ";
$hang[6]="шестьсот ";
$hang[7]="семьсот ";
$hang[8]="восемьсот ";
$hang[9]="девятьсот ";

$namerub[1]="рубль ";
$namerub[2]="рубля ";
$namerub[3]="рублей ";

$nametho[1]="тысяча ";
$nametho[2]="тысячи ";
$nametho[3]="тысяч ";

$namemil[1]="миллион ";
$namemil[2]="миллиона ";
$namemil[3]="миллионов ";

$namemrd[1]="миллиард ";
$namemrd[2]="миллиарда ";
$namemrd[3]="миллиардов ";

$kopeek[1]="копейка ";
$kopeek[2]="копейки ";
$kopeek[3]="копеек ";

$s=" ";
$s1=" ";
$s2=" ";
$kop=intval( ( $L*100 - intval( $L )*100 ));
$L=intval($L);
if($L>=1000000000){
$many=0;
semantic(intval($L / 1000000000),$s1,$many,3);
$s.=$s1.$namemrd[$many];
$L%=1000000000;
}

if($L >= 1000000){
$many=0;
semantic(intval($L / 1000000),$s1,$many,2);
$s.=$s1.$namemil[$many];
$L%=1000000;
if($L==0){
$s.="рублей ";
}
}

if($L >= 1000){
$many=0;
semantic(intval($L / 1000),$s1,$many,1);
$s.=$s1.$nametho[$many];
$L%=1000;
if($L==0){
$s.="рублей ";
}
}

if($L != 0){
$many=0;
semantic($L,$s1,$many,0);
$s.=$s1.$namerub[$many];
}

if($kop > 0){
$many=0;
semantic($kop,$s1,$many,1);
$s.=$s1.$kopeek[$many];
}
else {
$s.=" 00 копеек";
}

return $s;
}
?>