<?php
$l=$_SERVER['QUERY_STRING'];
//if($l==""){$l="PYTHON";}
?>
<html><head><style>html, body {margin:0;padding:0}</style></head><body>
<div class="compiler" style="">
<?if(strtoupper($l)=="C"){?>
<div id="pym" data-pym-src="https://www.jdoodle.com/iembed/v0/mjS?stdin=0&arg=0&rw=1"></div>
<?}?>
<?if(strtoupper($l)=="CPP"){?>
<div id="pym" data-pym-src="https://www.jdoodle.com/iembed/v0/mjQ?stdin=0&arg=0&rw=1"></div>
<?}?>
<?if(strtoupper($l)=="JAVA"){?>
<div id="pym" data-pym-src="https://www.jdoodle.com/iembed/v0/mjR?stdin=0&arg=0&rw=1"></div>
<?}?>
<?if(strtoupper($l)=="PYTHON"){?>
<div id="pym" data-pym-src="https://www.jdoodle.com/iembed/v0/mjT?stdin=0&arg=0&rw=1"></div>
<?}?>
<?if(strtoupper($l)=="SQL"){?>
<div id="pym" data-pym-src="https://www.jdoodle.com/embed/v0/4vut?stdin=0&arg=0&rw=1"></div>
<?}?>
<?if(strtoupper($l)=="PHP"){?>
<div id="pym" data-pym-src="https://www.jdoodle.com/embed/v0/4vuu?stdin=0&arg=0&rw=1"></div>
<?}?>

<?if(strtoupper($l)=="NODEJS"){?>
<div id="pym" data-pym-src="https://www.jdoodle.com/embed/v0/4vux?stdin=0&arg=0&rw=1&font=20"></div>
<?}?>

<script src="https://www.jdoodle.com/assets/jdoodle-pym.min.js" type="text/javascript"></script>
</div>

<!--
<form action="https://www.jdoodle.com/api/redirect-to-post/c-online-compiler" method="post" target="code_target">
<textarea name="initScript" rows="8"><?=$rs["qtextsub"]?></textarea>
<input type="submit" value="Submit">
</form>
<iframe name="code_target" id="code_target"></iframe>
-->
</body></html>
