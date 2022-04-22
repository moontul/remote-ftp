<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');

include_once('./container.head.php');
?>

<!-- container -->
<div class="container">
  <!-- wrapper -->
  <div class="pp-wrapper">
    <?php include_once("./list.nav.php"); ?>

    <!-- Page Content -->
    <div id="content" style="width:100%;margin:40px;">


      <form name=f method="post" action="./save.php">
      <input type=hidden name=type value="<?=$type?>">
      <input type=hidden name=code value="<?=$code?>">
      <input type=hidden name=mode>

      <table width=100% style="max-width:800px">
      <tr>
      <td>
        <span class="f16 fw7"><?=$is_title?></span>
      </td>
      </tr>
      <tr>
      <td><input type=text name=title value="<?=$title?>" class="form-control"></td>
      </tr>
      <?php if(isset($is_subtitle)){?>
      <tr>
      <td class="f16 fw7"><?=$is_subtitle?></td>
      </tr>
      <tr>
      <td><input type=text name=subtitle value="<?=$subtitle?>" class="form-control">
      </td>
      </tr>
      <?php
      }
      ?>

      <tr>
      <td class="f16 fw7"><?=$is_content?></td>
      </tr>

      <tr>
      <td><textarea name=content style="width:100%" rows=10 class="form-control"><?=$content?></textarea>
      </td>
      </tr>
      </table>

      <div class="margin-top-30">
        <input type="submit" value="저장" class="btn btn-secondary btn-pp">
        <? if(isset($code)){ ?>
        <input type="button" value="삭제" class="btn btn-secondary btn-pp" onclick="if(confirm('정말 삭제할까요?')){document.f.mode.value='d';document.f.submit()}">
      <? } ?>
      </div>

      </form>


    </div><!--/ Page Content -->
  </div><!-- / wrapper -->
</div><!-- /container -->

<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
