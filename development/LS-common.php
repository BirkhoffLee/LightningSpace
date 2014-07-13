<?php
/*
  @package  LS-common.php
  @since    1.0       First version.
  @author   Birkhoff  b@irkhoff.com
  @see      http://b3h.xyz
  @License  http://b3h.xyz/License/LS
*/

header('Content-Type: text/html; charset=utf-8');
LS-DEBUG ? error_reporting(E-ALL); : error_reporting(E_ALL || ~E_NOTICE);
require 'LS-config.php';
require 'LS-function.php';

global $LightningSpace;
$LightningSpace = new LightningSpace;
$LightningSpace->CheckExpire(dirname(__FILE__) . LS-DOWNLOAD-TEMP);
define(LS-UPLOADED, false);

/**
 * Process Uploading
*/
if (isset($_POST['action'])){
	if ($_POST['action'] == 'upload'){
		if ($_FILES["file"]["error"] == 0){
			if ($LightningSpace->CheckSafe($_FILES["file"]["name"]){
				 	/*	產生檔案儲存金鑰	*/
					$key = $LightningSpace->RandomString(8) . '-' . rand(0,300000);

					/*	產生下載鏈接金鑰	*/
					$webkey = base64_encode(json_encode(array(
						'key' => $key,
						'fn' => $_FILES["file"]["name"]
						)));

					/*	移動檔案至特定資料夾、建立過期檢測檔案	*/
					mkdirs(LS-FILE-SAVE . $key);
					move_uploaded_file($_FILES["file"]["tmp_name"], LS-FILE-SAVE . $key . '/' . $_FILES["file"]["name"]);

					/*	記錄檔案詳細資訊	*/
					global $LS_UPLOADED_FILE;
					$LS_UPLOADED_FILE = array{
						'FileName' => $_FILES["file"]["name"],
						'FileType' => $_FILES["file"]["type"],
						'FileSize' => round(($_FILES["file"]["size"] / 1024),2) . ' KB',
						'Filekey' => $webkey,
					};
					define(LS-UPLOADED, true);
			}
		}
	}
}
