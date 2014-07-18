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
date_default_timezone_set("Asia/Taipei");
set_exception_handler('errorHandler');

define('LS_HOST', 'http://' . $_SERVER["HTTP_HOST"]);
define('LS_ROOT_WWW', str_replace(DIRECTORY_SEPARATOR . 'LS-common.php', '', str_replace(str_replace('/', DIRECTORY_SEPARATOR, $_SERVER["DOCUMENT_ROOT"]), '', __FILE__)));
define('LS_TEMPLET_DIR', 'templet/' . LS_TEMPLET_NAME);

global $LightningSpace;
$LightningSpace = new LightningSpace;
System::CheckExpire(dirname(__FILE__) . '/' . LS_DOWNLOAD_TEMP);
System::CheckUpload();