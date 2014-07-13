<?php
require 'LS-common.php';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>LightningSpace</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<style>
	body {
		margin-top: 45px;
	}
	input {
	    border: 1px solid #BBBBBB;
	    background: #fff;
	    -moz-border-radius:3px;
	    -webkit-border-radius: 3px;
	    border-radius: 3px;
	}
</style>
</head>
<body>
	<div class="container">
        <div class="jumbotron">
            <h1 class="title">Birkhoff's Web FileSystem</h1>
            <p id='content'><br />
<?php
if(@$_POST['action'] == 'write' && $_FILES["file"]["error"] == 0 && checksafe($_FILES["file"]["name"])) {

 	/*	產生檔案儲存金鑰	*/
 	$pattern = "1234567890abcdefghijklmnopqrstuvwxyz1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$key = '';
	for($i=0;$i<8;$i++){
		$key .= $pattern{rand(0,35)};
	}
	$key .= '-' . rand(0,300000);

	/*	產生下載鏈接金鑰	*/
	$webkey = base64_encode(json_encode(array(
		'key' => $key,
		'fn' => $_FILES["file"]["name"]
		)));

	/*	移動檔案至特定資料夾、建立過期檢測檔案	*/
	$serverPath = 'FileSystem/' . $key; 
	mkdirs($serverPath);
	$serverPath .= '/' . $_FILES["file"]["name"];
	move_uploaded_file($_FILES["file"]["tmp_name"], $serverPath);

	/*	輸出檔案詳細資訊	*/
	echo "檔案名稱: " . $_FILES["file"]["name"]."<br/>";
	echo "檔案類型: " . $_FILES["file"]["type"]."<br/>";
	echo "檔案大小: " . round(($_FILES["file"]["size"] / 1024),2) ." KB<br />";

	/*	輸出檔案外部鏈接	*/
	$web = 'http://filesys.irkhoff.com/download/' . $webkey;
	echo '外部鏈接: <a href="' . $web . '">' . $web . '</a><br/><br/>';
	?>
<a href=//filesys.irkhoff.com/adgen.php>回前頁</a>
	<?php
} else {
	?>
            	<form method="post" enctype="multipart/form-data">
					<span style="font-size:20px">上傳檔案: </span><input type="file" name="file" id="file" /><br />
					<input type="submit" value="提交" />
					<input type="hidden" name="action" id="action" value="write" />
				</form>
<?php
}
?>
            </p>
        </div>
    </div>
    <div style="text-align:center">All rights reserved by <a href="http://b.irkhoff.com">Birkhoff Lee</a>
    </div>
</body>
</html>