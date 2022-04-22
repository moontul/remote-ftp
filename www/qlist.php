<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');

include_once('./container.head.php');
?>


<style>
.wrapper {
    font-family:'NanumSquare';
    display: flex;
    align-items: stretch;
}

#sidebar {
    min-width: 250px;
    max-width: 250px;

    min-height: 600px;
    font-family: "NanumSquare";
    font-size:16px;
    border-right:1px solid darkgray;
    background:#efefef;
}
.sidebardiv{
  height:35px;
  padding-top:12px;
  padding-bottom:12px;
  overflow:;
}

#sidebar.active {
    margin-left: -250px;
}
</style>

<!-- container -->
<div class="container">
  <!-- wrapper -->
  <div class="wrapper">
    <nav id="sidebar">
      <?php include_once("./list.sub.php"); ?>
    </nav>

    <!-- Page Content -->
    <div id="content" style="width:100%;margin:10px;">
      <?=$listtitle?> 문제목록
      <table border=1>
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
