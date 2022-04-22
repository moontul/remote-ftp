<?php
$filenameorg=$_GET["f"];
$filename="pagesection/".$filenameorg.".ini";
if(filesize($filename)>0){
  $fp = fopen($filename, "r") or die("Unable to open file!");
  $fr = fread($fp,filesize($filename));
  fclose($fp);
}else{
  echo("filesize = 0 ");
  $fr="";
}
?>
<form name=f method=post target="iframe_section" action="page_sectioneditor_save.php">
<table style="width:100%">
<tr>
<td width=50%>편집 <input type=text name=f value="<?=$filenameorg?>"></td>
<td width=50%>원본</td>
</tr>
<tr>
<td><textarea name=content id=content style="font-size:13px;line-height:16px;width:100%;height:400px"
   ><?=$fr?></textarea>
</td>
<td><textarea name=orgcontent id=content style="background:#efefef;font-size:13px;line-height:16px;width:100%;height:400px"
   ><?=$fr?></textarea></td>
</tr>
<tr><td colspan=2><input type="submit" value="저장"></td></tr>
<tr><td colspan=2>저장결과</td></tr>
<tr>
<td colspan=2><iframe name=iframe_section id=iframe_section style="width:100%;height:300px;">
</iframe></td>
</tr>
</table>
</form>
