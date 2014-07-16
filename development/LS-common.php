<?php
/*
  @package  LS-common.php
  @since    1.0       First version.
  @author   Birkhoff  b@irkhoff.com
  @see      http://b3h.xyz
  @License  http://b3h.xyz/License/LS
*/

header('Content-Type: text/html; charset=utf-8');
require 'LS-config.php';
require 'LS-function.php';
require 'Mustache/Autoloader.php';

global $LightningSpace;
$LightningSpace = new LightningSpace;
$LightningSpace->mustache_init();
$LightningSpace->CheckExpire(dirname(__FILE__) . LS_DOWNLOAD_TEMP);
define('LS_ERROR_CHECK', false);

/**
 * Process Uploading
*/
if (isset($_POST['action'])){
	if ($_POST['action'] == 'upload'){
		if ($_FILES["file"]["error"] == 0){
			if ($LightningSpace->CheckSafe($_FILES["file"]["name"])){
				 	/*	產生檔案儲存金鑰	*/
					$key = $LightningSpace->RandomString(8) . '-' . rand(0,300000);

					/*	產生下載鏈接金鑰	*/
					$webkey = base64_encode(json_encode(array(
						'key' => $key,
						'fn' => $_FILES["file"]["name"]
						)));

					/*	移動檔案至特定資料夾、建立過期檢測檔案	*/
					$LightningSpace->mkdirs(LS_FILE_SAVE . $key);
					move_uploaded_file($_FILES["file"]["tmp_name"], LS_FILE_SAVE . $key . '/' . $_FILES["file"]["name"]);

					/*	記錄檔案詳細資訊	*/
					global $LS_UPLOADED_FILE;
					$LS_UPLOADED_FILE = array(
						'FileName' => $_FILES["file"]["name"],
						'FileType' => $_FILES["file"]["type"],
						'FileSize' => round(($_FILES["file"]["size"] / 1024),2) . ' KB',
						'FileKey' => $webkey,
					);
					define('LS_UPLOADED', true);
			} else {
				define('LS_ERROR_CHECK', true);
				define('LS_ERROR', 'InvalidFileType');
				define('LS_ERROR_FILENAME', $_FILES["file"]["name"]);
			}
		} else {
			define('LS_ERROR_CHECK', true);
			define('LS_ERROR', $_FILES["file"]["error"]);
			define('LS_ERROR_FILENAME', $_FILES["file"]["name"]);
		}
	}
}