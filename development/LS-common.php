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

checkexpire(dirname(__FILE__) . LS-DOWNLOAD-TEMP);