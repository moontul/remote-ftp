<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');

include_once('./container.head.php');
?>
<!-- container -->
<div class="container">
  <!-- wrapper -->
  <div class="pp-wrapper">
    <nav id="sidebar">
      <?php include_once("./list.nav.php"); ?>
    </nav>

    <!-- Page Content -->
    <div id="content" style="width:100%;margin:10px;">
      <?=$listtitle?> 문제목록

      <table border=1 class="table table-sm">
        <?php
        $sql="select *, (select qtext from tb_question where qcode=A.qcode) as qtext from tb_qlist A where list='$list'";
        $result=sql_query($sql);
        for($i=0;$rs=sql_fetch_array($result);$i++){
      ?>
      <tr>
      <td><?=$rs["qtext"]?></td>
      </tr>
      <?php
      }
      ?>
      </table>
      <br>
      <input type="button" value="새문제" onclick="location.href='/qedit?list=<?=$list?>'">

    </div><!--/ Page Content -->
  </div><!-- / wrapper -->
</div><!-- /container -->

<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
