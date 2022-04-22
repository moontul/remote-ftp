<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');

include_once('./container.head.php');
?>
<!-- wrapper -->
<div class="container">
    <?php include_once("./list.nav.php"); ?>

    <!-- Page Content -->
    <div class="pp-sidecontent">
      <div class="contenttitle">
        <?php if($listtitle==""){ ?>
          <?=$title?> <?=$subtitle?>
        <?php }else{?>
          <?=$listtitle?>
      <?php } ?>
        문제풀기
      </div>
      <hr>
      <?php include_once("qview.detail.php"); ?>
      <br>
    </div><!--/ Page Content -->

</div><!-- /container -->
<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
