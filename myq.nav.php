<?php ?>
<?php //@include_once("sidebar.sub.php");?>

<div class="ct-docs-sidebar-col" style="background-image:url('<?=G5_THEME_URL?>/assets/img/notebg2.jpg');border-right:1px solid #e3969e">
<nav class="ct-docs-sidebar-collapse-links">
  <div class="pp-sidebardiv nohover" style="margin-top:14px;height:44px;padding-top:12px;">
    <strong>오답노트</strong>
  </div>
  <div class="pp-sidebardiv" style="height:44px;padding-top:12px;">
    &nbsp; &nbsp; <a href="/myq">타임라인</a>
  </div>
<!--
  <div class="pp-sidebardiv"  style="height:44px;padding-top:12px;">
    &nbsp; &nbsp; <a href="/myq?today">오늘 틀린 문제</a>
  </div>
-->
  <div class="pp-sidebardiv"  style="height:44px;padding-top:12px;">
    &nbsp; &nbsp; <a href="/myq?bad">자꾸 틀리는 문제</a>
  </div>
  <div class="pp-sidebardiv"  style="height:44px;padding-top:12px;">
    &nbsp; &nbsp; <a href="/myq?star">중요표시문제</a>
  </div>


  <div class="pp-sidebardiv nohover"  style="height:44px;padding-top:12px;">
    <strong>내가 풀어야할 CBT</strong>
  </div>

<?php
  include_once("myq.myexam.query.php");

  $result=sql_query($sqlq);
  //echo($sql);
  for($i=0;$rs=sql_fetch_array($result);$i++){
?>

  <div class="pp-sidebardiv p-1">
    &nbsp; &nbsp;
    <a href="view?code=<?=$rs["code"]?>&list=<?=$rs["list"]?>">
      [<?=$rs["title"]?>] <?=$rs["listtitle"]?> (<?=$rs["my_cnt"]?>)
    </a>
  </div>

<? } ?>

<!--
  <div class="pp-sidebardiv">
    CBT결과
  </div>

  <div class="pp-sidebardiv">
  </div>

<?php
//내가 푼 문제중 cbt가 있는지 검사
$sqltmp="select code, list, count(*) as cnt
,(select title from tb_container where code=A.code) as title
,(select listtitle from tb_list where list=A.list) as listtitle
from tb_answerlog A
where A.mb_id='".$member["mb_id"]."' and A.fromcbt=1
group by A.code, A.list
";
//echo($sqltmp);
$resulttmp=sql_query($sqltmp);
for($i=0;$rstmp=sql_fetch_array($resulttmp);$i++){
?>
<div class="pp-sidebardiv">
  &nbsp; &nbsp; <a href="/mycbt?list=<?=$rstmp["list"]?>"><?=$rstmp["title"]?> <?=$rstmp["listtitle"]?></a>
</div>
<?php
}
?>
-->

<div class="pp-sidebardiv"></div>
</nav>
</div>
