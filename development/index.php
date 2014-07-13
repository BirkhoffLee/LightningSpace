<?php
/*
  @package  index.php
  @since    1.0       First version.
  @author   Birkhoff  b@irkhoff.com
  @see      http://b3h.xyz
  @License  http://b3h.xyz/License/LS
*/
require 'LS-common.php';


if(LS-UPLOADED) {
	$FileName = $LS_UPLOADED_FILE['FileName'];
	$FileType = $LS_UPLOADED_FILE['FileType'];
	$FileSize = $LS_UPLOADED_FILE['FileSize'];
	$FileKey = $LS_UPLOADED_FILE['FileKey'];
	echo $LightningSpace->Templet(
		'uploaded.html',
		array(
			'SiteName' => LS-SITE-NAME,
			'Description' => LS-DESCRIPTION,
			'FileName' => $FileName,
			'FileType' => $FileType,
			'FileSize' => $FileSize,
			'FileKey' => $FileKey
		)
	);
}


echo $LightningSpace->Templet(
	'index.html',
	array(
		'SiteName' => LS-SITE-NAME,
		'Description' => LS-DESCRIPTION
	)
);