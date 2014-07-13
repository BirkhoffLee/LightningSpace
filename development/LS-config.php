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
 * Defines the site's description.
 * Please replace "You've never seen a great network disk system."
 */
define('LS-SITE-NAME', "You've never seen a great network disk system.");

/**
 * Defines the templet folder that I will use.
 * Please replace "default"
 */
define('LS-TEMPLET-NAME', 'default');

/**
 * Defines the largest file size(bytes) can be uploaded.
 * Default: 500 MB(524288000 bytes)
 * Please replace "524288000"
 */
define('LS-FILE-SIZE', '524288000');

/**
 * Defines the directory which the tempory file save.
 * Base directory is where you saved LS-config.php.
 * Please replace "/downloading"
 *
 * NOT RECOMMENDED REPLACEING.
 */
define('LS-DOWNLOAD-TEMP', 'downloading');

/**
 * Defines the directory which the files save.
 * Base directory is where you saved LS-config.php.
 * Please replace "FileSystem/"
 *
 * NOT RECOMMENDED REPLACEING.
 */
define('LS-FILE-SAVE', 'FileSystem/');


//------------------------------------------------
/**
 * DO NOT TOUCH !
*/
define('LS-TEMPLET-DIR', 'templet/' . LS-TEMPLET-NAME);