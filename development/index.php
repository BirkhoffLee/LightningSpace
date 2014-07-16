<?php
/*
  @package  index.php
  @since    1.0       First version.
  @author   Birkhoff  b@irkhoff.com
  @see      http://b3h.xyz
  @License  http://b3h.xyz/License/LS
*/
require 'LS-common.php';


if(defined('LS_UPLOADED') && LS_UPLOADED) {
	$FileName = $LS_UPLOADED_FILE['FileName'];
	$FileType = $LS_UPLOADED_FILE['FileType'];
	$FileSize = $LS_UPLOADED_FILE['FileSize'];
	$FileKey = $LS_UPLOADED_FILE['FileKey'];
	echo $LightningSpace->Templet(
		'uploaded',
		array(
			'SiteName' => LS_SITE_NAME,
			'Description' => LS_DESCRIPTION,
			'FileName' => $FileName,
			'FileType' => $FileType,
			'FileSize' => $FileSize,
			'FileKey' => $FileKey,
			'SiteURL' => LS_SITE_URL,
		)
	);
} else if(LS_ERROR_CHECK) {
	switch (LS_ERROR){
		case 1:
			$LS_ErrInfo = '檔案大小超出了伺服器上傳限制!';
			break ;
		case 2:
			$LS_ErrInfo = '要上傳的檔案大小超出了你的瀏覽器限制!';
			break ;
		case 3:
			$LS_ErrInfo = '檔案驗證失敗!';
			break ;
		case 4:
			$LS_ErrInfo = '未找到上傳的檔案!';
			break ;
		case 5:
			$LS_ErrInfo = '未找到上傳的檔案!';
			break ;
		case 6:
			$LS_ErrInfo = '未找到上傳的檔案!';
			break ;
		case 7:
			$LS_ErrInfo = '伺服器錯誤!';
			break ;
		default:
			$LS_ErrInfo = '未知錯誤!';
			break ;
	}
	echo $LightningSpace->Templet(
		'uploaderr',
		array(
			'SiteName' => LS_SITE_NAME,
			'Description' => LS_DESCRIPTION,
			'ErrInfo' => $LS_ErrInfo,
			'FileName' => LS_ERROR_FILENAME
		)
	);
} else {
	echo $LightningSpace->Templet(
		'index',
		array(
			'SiteName' => LS_SITE_NAME,
			'Description' => LS_DESCRIPTION
		)
	);
}