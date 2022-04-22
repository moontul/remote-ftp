<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');

$background_images = G5_THEME_IMG_URL.'/bg/banner2560x740_2.jpg';
$title = "과목 문풀";
#$title_sub =$l;

include_once(G5_THEME_PATH.'/page.sub.php');
?>

<?php include_once('admin/_conn.php');

$sjucode=$_GET["sjucode"];
$sql="select * from tb_subjectunit where sjucode ='$sjucode' ";
$result = mysqli_query($conn, $sql);
$row=$result->num_rows;
foreach($result as $list){
  $subjectunitname=$list["subjectunitname"];
  $sjcode=$list["sjcode"];
}

if($sjcode==""){$sjcode=$_GET["sjcode"];}
$sql="select * from tb_subject where sjcode ='$sjcode' ";
$result = mysqli_query($conn, $sql);
$row=$result->num_rows;
foreach($result as $list){
  $subjectname=$list["subjectname"];
}
//echo($sql);
?>

<style>
.wrapper {
    display: flex;
    align-items: stretch;
}

#sidebar {
    min-width: 250px;
    max-width: 250px;
    font-family: "NanumSquare";
    font-size:12px;
}

#sidebar.active {
    margin-left: -250px;
}
</style>

<!-- Wrapper -->
<div class="wrapper">

  <!-- Sidebar -->
  <nav id="sidebar">
<?php
$sql="select * from tb_subjectunit where sjcode='$sjcode' order by unitorder";
$result=mysqli_query($conn, $sql);
$row=$result->num_rows;
foreach($result as $list){
?>
  <?for($t=0;$t<$list["u_tab"];$t++){echo(" &nbsp; ");}?>
  <a href="subjectq?sjucode=<?=$list["sjucode"]?>"><?=$list["unitname"]?></a><br>
<?php
}
?>

  </nav>

  <!-- Page Content -->
  <div id="content">


              <!-- Section Heading -->
              <div class="section-heading">
                  <h3>과목 문풀 - <?=$subjectname?></h3>
                  <p>과목별 문제풀이</p>
              </div>


              <div class="row">

                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">문제</th>

                    </tr>
                  </thead>
                  <tbody>
                <?php
                //최상위
                $sql="select * from tb_question where sjucode='$sjucode' ";
                $result = mysqli_query($conn, $sql);

                foreach($result as $list)
                {
                  $qcode=$list["qcode"];
                  $qnum=$list["qnum"];
                  $qtext=$list["qtext"];
                ?>
                  <tr>
                  <td>
                    문제<?=$qnum?>
                  </td>
                  <td>
                    <?if(isset($_SESSION["memail"])){?>
                      <a href="qview.php?qcode=<?=$qcode?>" class="pp-btn">문제풀기</a>
                    <?}else{?>
                      <a href="javascript:alert('로그인하세요')" class="pp-btn disabled">문제풀기</a>
                    <?}?>

                  </td>
                  </tr>

                <?
                }
                ?>
              </tbody>
            </table>

            <br><br><br><br><br><br>

              </div>

            </div>
</div>

<?php include_once(G5_THEME_PATH.'/tail.php');?>
