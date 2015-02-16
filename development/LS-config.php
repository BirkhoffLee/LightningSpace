<?php
/*
  @package  LS-config.php
  @since    1.0       First version.
  @author   Birkhoff  b@irkhoff.com
  @see      http://b3h.xyz
  @License  http://b3h.xyz/License/LS
*/

/**
 * Defines the script root directory.
 * DO NOT CHANGE THIS.
 */
define('LS_ROOT', dirname(__FILE__));

/**
 * Defines if in debug mode.
 * NO REPLACEING!
 */
define('LS_DEBUG', false);

/**
 * Defines the site name.
 * Please replace "LightningSpace"
 */
define('LS_SITE_NAME', 'LightningSpace');

/**
 * Defines the site's description.
 * Please replace "You've never seen a great network disk system."
 */
define('LS_DESCRIPTION', "You've never seen a great network disk system.");

/**
 * Defines the templet folder that I will use.
 * Please replace "default"
 */
define('LS_TEMPLET_NAME', 'default');

/**
 * Defines the largest file size(MB) can be uploaded.
 * Please replace "1024"
 *
 * NOT RECOMMENDED FOR REPLACEING.
 */
define('LS_FILE_SIZE', '1024');

/**
 * Defines the directory which the tempory file save.
 * Base directory is where you saved LS-config.php.
 * Please replace "/downloading"
 *
 * NOT RECOMMENDED FOR REPLACEING.
 */
define('LS_DOWNLOAD_TEMP', 'downloading');

/**
 * Defines the directory which the log file save.
 * Base directory is where you saved LS-config.php.
 * Please replace "log"
 */
define('LS_LOG_DIR', 'log');

/**
 * Defines the directory which the files save.
 * Base directory is where you saved LS-config.php.
 * Please replace "FileSystem/"
 *
 * NOT RECOMMENDED FOR REPLACEING.
 */
define('LS_FILE_SAVE', 'FileSystem/');

/**
 * Defines what I say when a upload error occurred.
 * Please replace the string after => ' and before ',
 *
 * NOT RECOMMENDED FOR REPLACEING.
 */
$LS_UPLOAD_ERROR_MSG = array(
	'TooHeavyCausedbyServerINI' => '檔案大小超出了伺服器上傳限制!',
	'TooHeavyCausedbyBrowser' => '上傳的檔案大小超出了你的瀏覽器限制!',
	'CouldNotVerifyUploadedFile' => '檔案驗證失敗!',
	'CannotFindUploadedFile' => '未找到上傳的檔案!',
	'InternalServerError' => '伺服器錯誤!',
	'NothingUploaded' => '我不知道怎麼上傳...空氣。',
	'TooHeavy' => '這個好重...我搬不動! 超過大小限制 {{MaxSize}} 了!',
	'default' => '未知錯誤!'
	);