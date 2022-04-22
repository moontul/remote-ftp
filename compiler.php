<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');
?>

<?php
  $l=$_SERVER['QUERY_STRING'];
  if($l==""){$l="PYTHON";}
?>



<!-- container -->
<div class="container">
  <!-- wrapper -->
  <div class="pp-wrapper">

  <?php @include_once("./compiler.nav.php"); ?>

  <!-- Page Content -->
  <div id="content" style="width:100%;margin:40px;">
    <div class="f23 f9">
    컴파일러 <?=$l?>
    </div>
    <hr>



    <div class="xxx">
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


  </div><!--/ Page Content -->
</div><!-- / wrapper -->
</div><!-- /container -->
<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
