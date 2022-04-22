<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');

include_once('./container.head.php');

if($_COOKIE["PANGPANG_WRITE"]=="checked"){
//  goto_url("/write?list=$list");
}
?>

<!-- container -->
<div class="container">
  <!-- wrapper -->
  <div class="pp-wrapper">

    <?php include_once("./list.nav.php"); ?>

    <!-- Page Content -->
    <div id="content" style="width:100%;margin:40px;">
    <?php if($showmode=="list"){?>

      <?php if($is_admin){?>
      <div class="float-right">
        <a href="/write?list=<?=$list?>" class="btn btn-secondary">편집</a>
        <a href="/qedit?list=<?=$list?>" class="btn">문제등록</a>
      </div>
      <?}?>

      <div class="f23 f9">
      <?=$listtitle?>
      </div>

      <hr>

      <div class="f15 f5" style="min-height:300px">
      <?=$listcontent?>
      </div>








<?php }else{ ?>

    <?if($is_admin){?>
      <div class="float-right">
        <a href="/edit?code=<?=$code?>" class="btn btn-secondary btn-pp">수정</a>

        <a href="/write?code=<?=$code?>" class=btn btn-success btn-pp>새 목록</a>
      </div>
    <?}?>
      <!--
      유형 : <?=$type?>
      -->
      <div class="f23 f9">
        <?=$title?>
          <?php if(isset($is_subtitle)){?>
              <?=$subtitle?>
          <?php } ?>
      </div>

      <hr>

      <div class="f15 f5" style="min-height:300px">
        <?=$content?>
      </div>

      <?=$is_link_buttons?>



<?php }?>



    </div><!--/ Page Content -->
  </div><!-- / wrapper -->
</div><!-- /container -->

<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
