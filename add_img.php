<?php header("Content-type: text/html; charset=utf-8");?>
<link rel="SHORTCUT ICON" href="fancybox/logo.ico"type="image/x-icon">
<?php
include ('class.upload.php');
$text_upload = $_POST['textimage_upload'];
$uploaddir = 'fancybox/';
$apend=$_POST['apend'];

$foo = new Upload($_FILES['userfile']['tmp_name']);
if ($foo->uploaded) {
$foo->allowed = array('image/*');
$foo->file_new_name_body    = $apend;
$foo->image_convert         = $_POST['type'];
$foo->file_overwrite        = true;
$foo->auto_create_dir       = true;
$foo->file_max_size         = 5*1024*1024;
$foo->jpeg_quality          = 100;
$foo->Process($uploaddir);
}
			echo "Файл загружен.<a href='admin.php'>Назад</a>";
			$uploadimage_file = $foo->file_dst_name;
			echo "<br><img src='fancybox/$uploadimage_file' title='$text_upload'><br><p>$text_upload</p>";

?>