<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');
?>

<div class="container-fluid">
  <div class="container">

    내가 푼 문제
    <?php
    $sql="select *
      , (select listtitle from tb_list where list=A.list) as listtitle
      , (select qtext from tb_question where qcode=A.qcode) as qtext
      from tb_answerlog A
      where mb_id='".$member["mb_id"]."'
      order by  in_date desc";
    $result=sql_query($sql);
    for($i=0;$rs=sql_fetch_array($result);$i++){
    ?>

    <div>
      [<?=$rs["in_date"]?>][<?=$rs["listtitle"]?>][<?=$rs["qtext"]?>]
      [맞음<?=$rs["counttrue"]?>]
      [틀림<?=$rs["countfalse"]?>]
    </div>


    <?php   }
    ?>







  </div>
</div>

<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
