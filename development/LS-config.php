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
define('LS-ROOT', dirname(__FILE__));

/**
 * Defines the site name.
 * Please replace "LightningSpace"
 */
define('LS-SITE-NAME', 'LightningSpace');

/**
 * Defines the largest file size can be uploaded.
 * Please replace "LightningSpace"
 */
define('LS-FILE-SIZE', '');

/**
 * Defines the directory which the tempory file save.
 * Please replace "/downloading"
 */
define('LS-DOWNLOAD-TEMP', '/downloading');

//------------------------------------------------------------

/**
 * Change something.
*/
define('LS-DOWNLOAD-TEMP', LS-ROOT . LS-DOWNLOAD-TEMP);