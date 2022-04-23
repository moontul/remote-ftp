<?php include_once('./_common.php');
@include_once("./page.head.php");
include_once(G5_THEME_PATH.'/head.php');
?>
<?php include_once("page.wraptop.php");?>

<div class="container">
<form name=f method=post action="moodlexml2html_do.php" target="_do" enctype="MULTIPART/FORM-DATA">

xml 파일 업로드 <input type=file name=xmlfile>


<input type=submit value="변환">
</form>



<iframe name="_do" style="width:100%;height:500px;"></iframe>











</div>






<?php include_once("page.wrapbottom.php");?>
<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
