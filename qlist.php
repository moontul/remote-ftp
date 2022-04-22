<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');

include_once('./container.head.php');
?>
<!-- wrapper -->
<div class="ct-docs-main-container">
    <?php include_once("./list.nav.php"); ?>
    <!-- Page Content -->
      <main class="ct-docs-content-col" role="main">

        <div class="ct-docs-page-title">
          <span class="ct-docs-page-h1-title">
            <?=$listtitle?> 문제목록
          </span>
        </div>
      <a href="/qview?v=all&list=<?=$list?>" class="btn btn-sm">미리보기</a>
      <hr>

      <table border=1 class="table table-sm">
        <?php
        $sql="select A.qnum as qnum, left(B.qtext, 40) as qtext, B.qtype as qtype
          from tb_qlist A, tb_question B
          where A.list='$list' and A.qcode=B.qcode
          order by A.qnum ";

        $result=sql_query($sql);
        for($i=0;$rs=sql_fetch_array($result);$i++){
      ?>
      <tr>
      <td width=5%><?=$rs["qnum"]?></td><td><?=$rs["qtext"]?></td><td width=10%><?=$rs["qtype"]?></td>
      </tr>
      <?php
      }
      ?>
      </table>
      <br>
      <input type="button" value="새문제" class="btn btn-sm btn-dark shadow-sm" onclick="location.href='/qedit?list=<?=$list?>'">
      <input type="button" value="취소" class="btn btn-sm btn-light shadow-sm" onclick="location.href='/view?list=<?=$list?>'">

    </main>
</div><!-- /wrapper -->

<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
