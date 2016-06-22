<?php
$image_x_b = "680px"; //Максимальная ширинаы большой картинки
$image_y_b = "680px"; //Максимальная ширинаы большой картинки
$image_y = 305; //Высата маленькой картинки
$image_x = 300; //Ширина маленькой картинки
$uploaddir = './gallery/otdel'.$_GET['dir'].'/'; //Папка галереи

if($_GET['name'] != ''){$time = $_GET['name'];}else{$time = mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));}
$file = $uploaddir . basename($_FILES['uploadfile']['name']);

$ext = substr($_FILES['uploadfile']['name'],strpos($_FILES['uploadfile']['name'],'.'),strlen($_FILES['uploadfile']['name'])-1);
$filetypes = array('.jpg','.gif','.bmp','.png','.JPG','.BMP','.GIF','.PNG','.jpeg','.JPEG');

if(in_array($ext,$filetypes)){
include ('class.upload.php');

$foo = new Upload($_FILES['uploadfile']['tmp_name']);
if ($foo->uploaded) {
$foo->allowed = array('image/*');
$foo->file_new_name_body    = $time;
$foo->image_convert         = 'jpg';
$foo->file_overwrite        = true;
$foo->auto_create_dir       = true;
$foo->file_max_size         = 5*1024*1024;
$foo->image_resize          = true;
$foo->image_ratio_crop      = true;
$foo->image_ratio_x         = true;
$foo->image_y              	= $image_y_b;
$foo->image_x               = 680;

$foo->Process($uploaddir);

$foo->allowed = array('image/*');
$foo->file_new_name_body    = $time;
$foo->image_convert         = 'jpg';
$foo->file_overwrite        = true;
$foo->auto_create_dir       = true;
$foo->file_max_size         = 5*1024*1024;
$foo->image_resize          = true;
$foo->image_ratio_crop      = true;
$foo->image_y               = $image_y;
$foo->image_x               = $image_x;

$foo->Process($uploaddir."m/");
$return['new'] = $foo->file_dst_name;
$foo-> Clean();
if($return['new']){
if($_GET['name'] == ''){
$dirS=explode(".",$return['new']);$list = $dirS[0].'
';
$dirs = @file($uploaddir."/text/list.txt");
foreach ($dirs as $dir){
$dir = str_replace("\r\n", '', $dir);
$list = $list.$dir.'
';}
$fp = fopen($uploaddir."/text/list.txt", "w");
$test = fwrite($fp, $list);
fclose($fp);
}	echo $return['new'];
} else {echo "error";}
}
}


?>