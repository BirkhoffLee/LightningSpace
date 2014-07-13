<?php
header('Content-Type: text/html; charset=utf-8');

/*	解密檔案金鑰	*/
if(!isset($_GET['argu'])){
	header('Location: http://b.irkhoff.com');
	exit;
}
$argu = $_GET['argu'];

$webkey = base64_decode($argu);
$webkey = json_decode($webkey, true);

function mkdirs($dir){
  return is_dir($dir) or (mkdirs(dirname($dir)) and mkdir($dir,0777));
}
$key = $webkey['key'];
$file = $webkey['fn'];
if(!$key or !$file){
	header('Location: http://b.irkhoff.com');
	exit;
}

/* 下載 */
/* 防盜鏈臨時資料夾名稱 */
$folder = rand(0,300000) . '-' . rand(0,300000) . '-' . rand(0,300000) . '-' . rand(0,300000) . '/' . rand(0,300000) . '-' . rand(0,300000) . '-' . rand(0,300000) . '-' . rand(0,300000);

mkdirs("downloading/uid-$folder");
copy("dlexam", "downloading/uid-$folder/index.php");
chmod("downloading/uid-$folder/index.php", 0755);

$fp = fopen(dirname(__FILE__)."/downloading/uid-$folder/index.php", 'r');
$contents = fread($fp, filesize(dirname(__FILE__)."/downloading/uid-$folder/index.php"));
fclose($fp);

$contents = str_replace('@XDREPLACEME@',$file,$contents);

$fp = fopen(dirname(__FILE__)."/downloading/uid-$folder/index.php", 'w');
fwrite($fp, $contents);
fclose($fp);

copy("FileSystem/$key/$file", "downloading/uid-$folder/file");
chmod("downloading/uid-$folder/file", 0755);

$fp = fopen("downloading/uid-$folder/expire.txt", 'w');
fwrite($fp, time() + 172800);
fclose($fp);

$web = "http://filesys.irkhoff.com/downloading/uid-$folder";
header('Location: ' . $web);
exit;