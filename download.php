<?
$filename=$_GET["filename"];
$filepath=$_GET["filepath"];
//$basename=basename($filename);

//echo is_file(iconv("UTF-8", "EUC-KR", "data/cdata/202203/문코수업_Chapter01.pdf"));
//echo is_file($Path);

if (is_file(iconv("UTF-8", "EUC-KR", $filepath))) {
	Header("Content-type:application/octet-stream");
	Header("Content-Length:".filesize($filepath));
	Header("Content-Disposition:attachment;filename=$filename");
	Header("Content-type:file/unknown");

	Header("Content-Description:PHP3 Generated Data");

	Header("Pragma: no-cache");
	Header("Expires: 0");

	$fp = fopen($filepath, "rb");
	if (!fpassthru($fp)) fclose($fp);
	clearstatcache();
}else {
	echo "<script> alert('해당 파일이나 경로가 존재하지 않습니다.'); </script>";
	echo "<script> window.close(); </script>";
	exit();
}

?>
