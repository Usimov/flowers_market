<?php
header("Content-type: text/html; charset=utf-8");
session_start();
require_once "functions.php";
if(!$_POST['cat']){$_POST['cat']=$_GET['group'];}
$settingsX = @file("./gallery/settings/settings.txt");
for ($i=0; $i<count($settingsX); $i++){
$settings[$i] = str_replace("\r\n", '', $settingsX[$i]);
}


if (checkUser($_POST['password']) OR checkUser($_SESSION['password'])){

}
?>