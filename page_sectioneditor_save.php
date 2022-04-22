<?php
$filenameorg=$_POST["f"];
$filename="pagesection/".$filenameorg.".ini";
$content=$_POST["content"];

echo($content);
$myfile = fopen($filename, "w") or die("Unable to open file!");
$txt = $content;
fwrite($myfile, $txt);
fclose($myfile);
?>
