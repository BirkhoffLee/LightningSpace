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
    * 建立多級資料夾
    *
    * @param  string  $dir 目錄名稱
    *
    * @return boolean
    */
  public static function mkdirs($dir){
    return is_dir($dir) or (mkdirs(dirname($dir)) and mkdir($dir,0755));
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
    * 返回 templet 的指定檔案內容
    *
    * @param  string  $file 檔案
    *
    * @return string
    */
  public static function ReadTemplet($file){
    return readfile(LS_TEMPLET_DIR . "/$file");
  }


  /**
    * 返回 templet 的指定檔案內容
    *
    * @param  string  $file  檔案
    * @param  array   $array 參數
    *
    * @return string
    */
  public static function Templet($file, $array){
    Mustache_Autoloader::register();
    $m = new Mustache_Engine;
    var_dump($array);
    return $m->render(self::ReadTemplet($file), $array);
  }

}