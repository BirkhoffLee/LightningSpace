<?php
/*
  @package  LS-function.php
  @since    1.0       First version.
  @author   Birkhoff  b@irkhoff.com
  @see      http://b3h.xyz
  @License  http://b3h.xyz/License/LS
*/
class LightningSpace{

   /**
    * 初始化系統(自動執行)
    *
    * @return void
    */
  function __construct(){
    class_alias('LightningSpace', 'System');
  }


  /**
    * 初始化系統
    *
    * @return void
    */
  public static function Initalize(){
    Mustache_Autoloader::register();
    $options =  array('extension' => '.html');

    global $m;
    $m = new Mustache_Engine(array(
        'loader' => new Mustache_Loader_FilesystemLoader(LS_TEMPLET_DIR, $options),
    ));
  }


  /**
    * 處理首頁內容
    *
    * @return void
    */
  public static function mainUI(){
    if(defined('LS_UPLOADED') && LS_UPLOADED) {
      $FileName = $LS_UPLOADED_FILE['FileName'];
      $FileType = $LS_UPLOADED_FILE['FileType'];
      $FileSize = $LS_UPLOADED_FILE['FileSize'];
      $FileKey = $LS_UPLOADED_FILE['FileKey'];
      self::render(
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
    } else if(defined('LS_ERROR_CHECK') && LS_ERROR_CHECK) {
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
        case 8:
          $LS_ErrInfo = '我不知道怎麼上傳...空氣。';
          break ;
        case 9:
          $LS_ErrInfo = '這個好重...我搬不動! 超過大小限制 ' . self::bytesToSize(LS_FILE_SIZE) .  ' 了!';
          break ;
        default:
          $LS_ErrInfo = '未知錯誤!';
          break ;
      }
      self::render(
        'uploaderr',
        array(
          'SiteName' => LS_SITE_NAME,
          'Description' => LS_DESCRIPTION,
          'ErrInfo' => $LS_ErrInfo,
          'FileName' => LS_ERROR_FILENAME
        )
      );
    } else {
      self::render(
        'index',
        array(
          'SiteName' => LS_SITE_NAME,
          'Description' => LS_DESCRIPTION
        )
      );
    }
  }


  /**
   * 轉換大小
   *
   * @param integer 字節數
   * @return string
   */
  public static function bytesToSize($bytes, $precision = 2){  
      $kilobyte = 1024;
      $megabyte = $kilobyte * 1024;
      $gigabyte = $megabyte * 1024;
      $terabyte = $gigabyte * 1024;
     
      if (($bytes >= 0) && ($bytes < $kilobyte)) {
          return $bytes . ' B';
   
      } elseif (($bytes >= $kilobyte) && ($bytes < $megabyte)) {
          return round($bytes / $kilobyte, $precision) . ' KB';
   
      } elseif (($bytes >= $megabyte) && ($bytes < $gigabyte)) {
          return round($bytes / $megabyte, $precision) . ' MB';
   
      } elseif (($bytes >= $gigabyte) && ($bytes < $terabyte)) {
          return round($bytes / $gigabyte, $precision) . ' GB';
   
      } elseif ($bytes >= $terabyte) {
          return round($bytes / $terabyte, $precision) . ' TB';
      } else {
          return $bytes . ' B';
      }
  }


  /**
    * 檢查上傳
    *
    * @return void
    */
  public static function CheckUpload(){
    if (isset($_POST['action'])){
      if ($_POST['action'] == 'upload'){
        if (isset($_GET['file'])){
          if ($_FILES["file"]["error"] == 0){
            if (self::CheckSafe($_FILES["file"]["name"])){
                if(filesize($_FILES["file"]["name"]) > LS_FILE_SIZE){
                  /*  產生檔案儲存金鑰  */
                  $key = $LightningSpace->RandomString(8) . '-' . rand(0,300000);

                  /*  產生下載鏈接金鑰  */
                  $webkey = base64_encode(json_encode(array(
                    'key' => $key,
                    'fn' => $_FILES["file"]["name"]
                    )));

                  /*  移動檔案至特定資料夾、建立過期檢測檔案 */
                  self::mkdirs(LS_FILE_SAVE . $key);
                  move_uploaded_file($_FILES["file"]["tmp_name"], LS_FILE_SAVE . $key . '/' . $_FILES["file"]["name"]);

                  /*  記錄檔案詳細資訊  */
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
                  define('LS_ERROR', 9);
                  define('LS_ERROR_FILENAME', $_FILES["file"]["name"]);
                }
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
        } else {
          define('LS_ERROR_CHECK', true);
          define('LS_ERROR', 8);
          define('LS_ERROR_FILENAME', 'The air');
        }
      }
    }
  }


   /**
    * 建立多級資料夾
    *
    * @param  string  $dir 目錄名稱
    *
    * @return boolean
    */
  public static function mkdirs($dir){
    return is_dir($dir) or (self::mkdirs(dirname($dir)) and mkdir($dir,0755));
  }


   /**
    * 刪除整個資料夾以及檔案
    *
    * @param  string  $dirPath 目錄名稱
    *
    * @return void
    */
  public static function deleteDir($dirPath) {
      if (! is_dir($dirPath)) {
          die("$dirPath must be a directory");
      }
      if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
          $dirPath .= '/';
      }
      $files = glob($dirPath . '*', GLOB_MARK);
      foreach ($files as $file) {
          if (is_dir($file)) {
              self::deleteDir($file);
          } else {
              unlink($file);
          }
      }
      rmdir($dirPath);
  }


   /**
    * 檢查是否有過期的檔案，有則刪除
    *
    * @param  string  $dir 目錄名稱
    *
    * @return void
    */
  public static function CheckExpire($dir) {
      static $alldirs = array();
      $dirs = glob($dir . '/*', GLOB_ONLYDIR);
      if (count($dirs) > 0) {
          foreach ($dirs as $d) $alldirs[] = $d;
      }
      foreach ($dirs as $dir) self::CheckExpire($dir);
      foreach ($alldirs as $filedir){
          if(file_exists($filedir . '/expire.txt')){
              $handlec = fopen($filedir . '/expire.txt', "r");
              $contentsc = fread($handlec, filesize($filedir . '/expire.txt'));
              fclose($handlec);
              if(time() > $contentsc) self::deleteDir($filedir);
          }
      }
  }


   /**
    * 檢查上傳檔案附檔名
    *
    * @param  string  $file 檔案名稱
    *
    * @return bool
    */
  public static function CheckSafe($file){
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    if ($ext == 'php' or $ext == 'asp' or $ext == 'aspx' or $ext == 'php' or $ext == 'jsp' or $ext == 'cgi'){
      return false;
    } else return true;
  }


   /**
    * 產生指定長度的字串
    *
    * @param  string  $length 長度
    *
    * @return string
    */
  public static function RandomString($length){
    $pattern = "1234567890abcdefghijklmnopqrstuvwxyz1234567890abcdefghijklmnopqrstuvwxyz";
    $key = '';
    for($i=0;$i<$length;$i++){
      $key .= $pattern{rand(0,35)};
    }
    return $key;
  }


  /**
    * 輸出 templet 的指定檔案內容
    *
    * @param  string  $file  檔案
    * @param  array   $array 參數
    *
    * @return void
    */
  public static function render($file, $array){
    global $m;
    echo $m->render($file, $array);
  }


  /**
    * 記錄日誌
    *
    * @param  string  $string 內容
    *
    * @return string
    */
  public static function log($string){
    self::mkdirs(LS_ROOT . '/' . LS_LOG_DIR);
    $date = date('Y-m-d H:i:s');
    $edate = base64_encode($date);
    $fp = fopen(LS_ROOT . '/' . LS_LOG_DIR . "/$edate.txt", 'w');
    fwrite($fp, $string . "\r\n\r\nTime: $date");
    fclose($fp);
    return $edate;
  }

}

/**
  * 錯誤管理(此函數為自動調用)
  *
  * @param  string  $msg  錯誤內容
  *
  * @return string
  */
function errorHandler($msg){
  global $LightningSpace;
  return '<h1>Error ID: ' . $LightningSpace->log($msg). '<br />Please give this ID to the site administrator. We are very apologize for this.</h1>';
}