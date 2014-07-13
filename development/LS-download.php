<?php
/*
  @package  LS-download.php
  @since    1.0       First version.
  @author   Birkhoff  b@irkhoff.com
  @see      http://b3h.xyz
  @License  http://b3h.xyz/License/LS
*/
require 'LS-common.php';

if(!isset($_GET['argu'])){
	header('Location: index.php?404');
	exit;
}

/*	解密檔案金鑰	*/
$argu = $_GET['argu'];
$webkey = base64_decode($argu);
$webkey = json_decode($webkey, true);
$key = $webkey['key'];
$file = $webkey['fn'];

if(!$key or !$file){
	header('Location: index.php?404');
	exit;
}

/* 防盜鏈臨時資料夾名稱 */
$folder = LS-DOWNLOAD-TEMP . "uid-" . rand(0,300000) . '-' . rand(0,300000) . '-' . rand(0,300000) . '-' . rand(0,300000) . '/' . rand(0,300000) . '-' . rand(0,300000) . '-' . rand(0,300000) . '-' . rand(0,300000);

/* 建立臨時資料夾、index.php */
$LightningSpace->mkdirs($folder);
copy("data/index.php-FORBIDDEN", "$folder/index.php");
chmod("$folder/index.php", 0755);

$fp = fopen(dirname(__FILE__) . "$folder/index.php", 'r');
$contents = fread($fp, filesize(dirname(__FILE__) . "$folder/index.php"));
fclose($fp);

$contents = str_replace('@XDREPLACEME@',$file,$contents);

$fp = fopen(dirname(__FILE__) . "$folder/index.php", 'w');
fwrite($fp, $contents);
fclose($fp);

/* 複製原始檔案到臨時資料夾 */
copy(LS-FILE-SAVE . "$key/$file", "$folder/file");
chmod("$folder/file", 0755);

/* 建立過期檢測檔案 */
$fp = fopen("$folder/expire.txt", 'w');
fwrite($fp, time() + 172800);
fclose($fp);

header('Location: $folder');
exit;