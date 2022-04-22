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
  $qtext=$resultq["qtext"];
  $qm1text=$resultq["qm1text"];
  $qm2text=$resultq["qm2text"];
  $qm1correct=$resultq["qm1correct"];
  $qm2correct=$resultq["qm2correct"];

}
?>
    <!-- Page Content -->
    <div id="content" style="width:100%;margin:10px;">
      문제

      <form name=f method="post" action="./qsave.php">
      <input type=hidden name=code value="<?=$code?>">
      <input type=hidden name=list value="<?=$list?>">
      <input type=hidden name=mode value="">
      <input type=hidden name=qcode value="<?=$qcode?>">

      <table>
      <tr>
      <td><?=$listtitle?></td>
      </tr>
      <tr>
      <td>새문제 : <input type="text" name="qtext" value="<?=$qtext?>" autocomplete="off"></td>
      </tr>
      <tr>
      <td>지문1 : <input type="text" name="qm1text" value="<?=$qm1text?>" autocomplete="off">정답
        <input type="checkbox" name="qm1correct" value="1" <?=($qm1correct=="1")?"checked":""?>></td>
      </tr>
      <tr>
      <td>지문2 : <input type="text" name="qm2text" value="<?=$qm2text?>" autocomplete="off">정답
        <input type="checkbox" name="qm2correct" value="1"<?=($qm2correct=="1")?"checked":""?>></td>
      </tr>

      </table>

      <table>
      <tr>
      <td>기존문제에서 선택</td>
      </tr>
      <?php
        $sql="select *
            , (select listtitle from tb_list where list=A.list) as listtitle
            , (select qtext from tb_question where qcode=A.qcode) as qtext
            from tb_qlist A where code='$code'";
        $result=sql_query($sql);
        for($i=0;$rs=sql_fetch_array($result);$i++){?>
      <tr>
      <td><input type="checkbox" name="a_qtext[]">[<?=$rs["listtitle"]?>]<?=$rs["qtext"]?></td>
      </tr>
    <?php } ?>
      </table>


        <input type="submit" value="저장"><input type="button" value="새목록" onclick="location.href='/write?code=<?=$code?>'">
        <input type="button" value="삭제" onclick="if(confirm('정말 삭제할까요?')){document.f.mode.value='d';document.f.submit();}">
      </form>

    </div><!--/ Page Content -->
  </div><!-- / wrapper -->
</div><!-- /container -->

<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
