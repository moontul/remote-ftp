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

<?php

?>
    <!-- Page Content -->
    <div id="content" style="width:100%;margin:10px;">
      <h5><?=$listtitle?> 시험 <?=($is_exam)?"수정":"생성"?></h5>

      <hr>
      <form name=f method="post" action="./esave.php">
      <input type=hidden name=code value="<?=$code?>">
      <input type=hidden name=list value="<?=$list?>">
      <input type=hidden name=mode value="">
      <input type=hidden name=qcode value="<?=$qcode?>">




      <table class="table table-sm">
      <tr>
      <td>선택된 시험 문제</td>
      </tr>
      <?php
        $sql="select *
            from tb_question A , tb_qlist B where A.qcode=B.qcode ";
        $sql.=" and B.list='$list'";

        $result=sql_query($sql);
        for($i=0;$rs=sql_fetch_array($result);$i++){?>
      <tr>
      <td><input type="checkbox" name="s_qcode[]" value="<?=$rs["qcode"]?>">[<?=$rs["listtitle"]?>]<?=$rs["qtext"]?></td>
      </tr>
      <?php } ?>
      </table>

      <input type="button" value="시험해제" onclick="if(confirm('시험해제할까요?')){document.f.mode.value='dis';document.f.submit();}">
      <br>

      <table class="table table-sm">
      <tr>
      <td>문제 선택</td>
      </tr>
      <?php
        $sql="select *
            , (select listtitle from tb_list where list=A.list) as listtitle
            , (select qtext from tb_question where qcode=A.qcode) as qtext
            from tb_qlist A where code='$code'";
        $result=sql_query($sql);
        for($i=0;$rs=sql_fetch_array($result);$i++){?>
      <tr>
      <td><input type="checkbox" name="a_qcode[]" value="<?=$rs["qcode"]?>">[<?=$rs["listtitle"]?>]<?=$rs["qtext"]?></td>
      </tr>
    <?php } ?>
      </table>

        <input type="submit" value="만들기" class="btn">

      </form>

    </div><!--/ Page Content -->
  </div><!-- / wrapper -->
</div><!-- /container -->

<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
