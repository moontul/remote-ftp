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
$qcode=$_GET["qcode"];
if($qcode!=""){
  $sqlq="select * from tb_question where qcode='$qcode'";
  $resultq=sql_fetch($sqlq);

  $qnum=$resultq["qnum"];
  $qtype=$resultq["qtype"];

  $qtext=$resultq["qtext"];
  $qtextsub=$resultq["qtextsub"];

  $qm1text=$resultq["qm1text"];
  $qm2text=$resultq["qm2text"];
  $qm3text=$resultq["qm3text"];
  $qm4text=$resultq["qm4text"];

  $qm1correct=$resultq["qm1correct"];
  $qm2correct=$resultq["qm2correct"];
  $qm3correct=$resultq["qm3correct"];
  $qm4correct=$resultq["qm4correct"];
  $qanswer=$resultq["qanswer"];

  $qexplain=$resultq["qexplain"];
}
if($qtype==""){$qtype="객관식";}
?>
    <!-- Page Content -->
    <div id="content" style="width:100%;margin:10px;">
      <h5>
        <?=$listtitle?>
        <?if(isset($qcode)){echo("문제 수정");}else{echo("문제 등록");}?>
      </h5>

      <hr>
      <form name=f method="post" action="./qsave.php">
      <input type=hidden name=code value="<?=$code?>">
      <input type=hidden name=list value="<?=$list?>">
      <input type=hidden name=mode value="">
      <input type=hidden name=qcode value="<?=$qcode?>">

      <table class="table table-sm">
      <tr>
      <td style="width:7%">번호</td>
      <td style="width:7%"><input type="text" name="qnum" value="<?=$qnum?>" class="form-control form-control-sm" autocomplete="off"></td>
      <td style="width:7%">유형</td>
      <td>
        <input type="radio" name="qtype" value="객관식" <?=($qtype=="객관식")?"checked":""?> onclick="$('#qtype1').show();$('#qtype2').hide();">객관식
        <input type="radio" name="qtype" value="주관식" <?=($qtype=="주관식")?"checked":""?> onclick="$('#qtype1').hide();$('#qtype2').show();">주관식
      </tr>

      <tr>
      <td style="width:7%">문제</td><td colspan=3><input type="text" name="qtext" value="<?=$qtext?>" class="form-control form-control-sm" autocomplete="off"></td>
      </tr>
      <tr>
      <td style="width:7%">지문</td><td colspan=3><textarea name="qtextsub" rows=3 class="form-control form-control-sm" autocomplete="off"><?=$qtextsub?></textarea></td>
      </tr>
      </table>

      <table class="table table-sm" id="qtype1" <?=($qtype=="객관식")?"style='display:'":"style='display:none;'"?>>
      <?for($q=1;$q<5;$q++){?>
      <tr>
      <td style="width:7%">보기<?=$q?></td>
      <td style="width:7%">정답<input type="checkbox" name="qm<?=$q?>correct" value="1" <?=(${"qm".$q."correct"}=="1")?"checked":""?>></td>
      <td colspan=2><input type="text" name="qm<?=$q?>text" value="<?=${"qm".$q."text"}?>" class="form-control form-control-sm"  autocomplete="off"></td>
      </tr>
      <?}?>
      </table>

      <table class="table table-sm" id="qtype2" <?=($qtype=="주관식")?"style='display:;'":"style='display:none;'"?>>
      <tr>
      <td style="width:7%">정답</td><td colspan=3><textarea name="qanswer" rows=3 class="form-control form-control-sm" autocomplete="off"><?=$qanswer?></textarea></td>
      </tr>
      </table>


      <table class="table table-sm">
      <tr>
      <td style="width:7%">해설</td><td colspan=3><textarea name="qexplain" rows=3 class="form-control form-control-sm" autocomplete="off"><?=$qexplain?></textarea></td>
      </tr>
      </table>

        <input type="submit" value="저장" class="btn">
        <input type="button" value="새목록"  class="btn" onclick="location.href='/write?code=<?=$code?>'">
        <input type="button" value="삭제" class="btn" onclick="if(confirm('정말 삭제할까요?')){document.f.mode.value='d';document.f.submit();}">
      </form>

    </div><!--/ Page Content -->
  </div><!-- / wrapper -->
</div><!-- /container -->

<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
