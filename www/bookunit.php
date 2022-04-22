<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');

$background_images = G5_THEME_IMG_URL.'/bg/banner2560x740_1.jpg';
$title = "도서 문풀";
$title_sub =$l;

include_once(G5_THEME_PATH.'/page.sub.php');
?>

<?php include_once('admin/_conn.php');
$bkcode=$_GET["bkcode"];
$sql="select * from tb_book where bkcode ='$bkcode' ";
$result = mysqli_query($conn, $sql);
$row=$result->num_rows;
foreach($result as $list){
  $bookname=stripslashes($list["bookname"]);
  $author=stripslashes($list["author"]);
  $publisher=stripslashes($list["publisher"]);
  $bookdesc=stripslashes($list["bookdesc"]);
}

$bkucode=$_GET["bkucode"];
$sql="select * from tb_content where unitcode ='$bkucode' ";
$result = mysqli_query($conn, $sql);
$row=$result->num_rows;
foreach($result as $list){
  $title=stripslashes($list["title"]);
  $content=stripslashes($list["content"]);
  $youtube=stripslashes($list["youtube"]);

}

//echo($sql);
?>


<div class="container-fluid" style="background:#f5f5f5; border-bottom:1px solid #e1e1e1;">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="home">
					<i class="fas fa-home"></i> HOME
				</div>
				<div class="menu">
					<select name="" class="select-menu" onchange="location.href=this.value">
						<option value="<?php echo G5_URL?>/pages/about.php">도서문풀</option>
					</select>
				</div>

			</div><!-- /col -->
		</div><!-- /row -->
	</div><!-- /container -->
</div><!-- /container-fluid -->





<style>
.wrapper {
    display: flex;
    align-items: stretch;
}

#sidebar {
    min-width: 250px;
    max-width: 250px;
    font-family: "NanumSquare";
    font-size:14px;
}

#sidebar.active {
    margin-left: -250px;
}
</style>

<!-- Wrapper -->
<div class="wrapper">

  <!-- Sidebar -->
  <nav id="sidebar">

    <a href="bookunit?bkcode=<?=$bkcode?>">소개</a>

    <br>
<?php
$sql="select * from tb_bookunit where bkcode='$bkcode' order by unitorder";
$result=mysqli_query($conn, $sql);
$row=$result->num_rows;
foreach($result as $list){
?>
  <?for($t=0;$t<$list["u_tab"];$t++){echo(" &nbsp; ");}?>
  <a href="bookunit?bkcode=<?=$bkcode?>&bkucode=<?=$list["bkucode"]?>"><?=$list["unitname"]?></a><br>
<?php
}
?>
  </nav>

  <!-- Page Content -->
  <div id="content">
    <?php if($bkucode==""){?>
    <?=$bookname?>
    <br>
    <?=$author?>
    <?=$publisher?>
    <br>
    <?=$bookdesc?>
  <?php } ?>


  <?=$title?>

<?=$content?>

<?php if($youtube!=""){?>

  <?php $onlytag=substr($youtube, strrpos($youtube, "?v=")+3)?>
  <br>
  <iframe width="560" height="315" src="https://www.youtube.com/embed/<?=$onlytag?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<?php } ?>

  </div>
</div>



























<!-- ##### Contact Area Start ##### -->
<section class="contact-area">
<div class="container">

      <div class="row align-items-center justify-content-between">
          <div class="col-12">
              <!-- Section Heading -->

              <div class="row">

                <?php
                $sql="select * , (select count(*) from tb_question where bkucode=A.bkucode) as qcnt from tb_bookunit A where bkcode='$bkcode' order by unitorder";
                $result = mysqli_query($conn, $sql);
                //echo($sql);
                foreach($result as $list)
                {
                  $unitorder=$list["unitorder"];
                  $unitname=$list["unitname"];
                  $u_tab=$list["u_tab"];
                  $qcnt=$list["qcnt"];
                ?>
                <div class="container" style="margin-top:10px;">
                  <h6>
                    <?for($i=0;$i<$u_tab;$i++){echo(" &nbsp; &nbsp;  &nbsp; ");}?><?=$unitname?>
                    <?if($qcnt>0){echo(" ............. <a href='bookq?bkucode=".$list["bkucode"]."' style='font-size:17px;''><b>문제수 [$qcnt]</a></b> ");}?>
                  </h6>
                </div>
                <hr>

                <?php } ?>


<br><br><br><br><br><br>

              </div>



          </div>

          <div class="col-12 col-lg-6">
              <!-- Google Maps -->

          </div>

      </div>




</div>
</section>
<!-- ##### Contact Area End ##### -->

<?php include_once(G5_THEME_PATH.'/tail.php');?>
