<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');
?>

<div class="container-fluid">
  <div class="container">
    compiler
  </div>
</div>



<div class="container">
  <!--div id="pym" data-pym-src="https://www.jdoodle.com/embed/v0/3?stdin=0&arg=0&rw=1"></div-->
  <?if(strtoupper($l)=="C"){?>
  <div id="pym" data-pym-src="https://www.jdoodle.com/iembed/v0/mjS?stdin=0&arg=0&rw=1"></div>
  <?}?>
  <?if(strtoupper($l)=="CPP"){?>
  <div id="pym" data-pym-src="https://www.jdoodle.com/iembed/v0/mjQ?stdin=0&arg=0&rw=1"></div>
  <?}?>
  <?if(strtoupper($l)=="JAVA"){?>
  <div id="pym" data-pym-src="https://www.jdoodle.com/iembed/v0/mjR?stdin=0&arg=0&rw=1"></div>
  <?}?>
  <?if(strtoupper($l)=="PYTHON3"){?>
  <div id="pym" data-pym-src="https://www.jdoodle.com/iembed/v0/mjT?stdin=0&arg=0&rw=1"></div>
  <?}?>
  <?if(strtoupper($l)=="SQL"){?>
  <div id="pym" data-pym-src="https://www.jdoodle.com/iembed/v0/mYz"></div>
  <?}?>

  <script src="https://www.jdoodle.com/assets/jdoodle-pym.min.js" type="text/javascript"></script>
</div>



<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
