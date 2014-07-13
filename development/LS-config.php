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
 * Defines if in debug mode.
 * NO REPLACEING!
 */
define('LS-DEBUG', true);

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
 * Base directory is where you saved LS-config.php.
 * Please replace "/downloading"
 *
 * NOT RECOMMENDED REPLACEING.
 */
define('LS-DOWNLOAD-TEMP', '/downloading');

/**
 * Defines the directory which the files save.
 * Base directory is where you saved LS-config.php.
 * Please replace "FileSystem/"
 *
 * NOT RECOMMENDED REPLACEING.
 */
define('LS-FILE-SAVE', 'FileSystem/');

//------------------------------------------------------------

/**
 * Change something.
*/
define('LS-DOWNLOAD-TEMP', LS-ROOT . LS-DOWNLOAD-TEMP);