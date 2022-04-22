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
    font-family:'NanumSquare';
    display: flex;
    align-items: stretch;
}

#sidebar {
    min-width: 250px;
    max-width: 250px;
    background:pink;
    font-family: "NanumSquare";
    font-size:16px;
}

#sidebar.active {
    margin-left: -250px;
}
</style>

<div class="container" style="background:#f8f8f8;overflow:hidden;">
  <!-- Wrapper -->
  <div class="wrapper">

    <!-- Sidebar -->
    <nav id="sidebar">

      <a href="bookview?bkcode=<?=$bkcode?>">소개</a>

      <br>
  <?php
  $sql="select * from tb_bookunit where bkcode='$bkcode' order by unitorder";
  $result=mysqli_query($conn, $sql);
  $row=$result->num_rows;
  foreach($result as $list){
  ?>
    <?for($t=0;$t<$list["u_tab"];$t++){echo(" &nbsp; ");}?>
    <a href="bookview?bkcode=<?=$bkcode?>&bkucode=<?=$list["bkucode"]?>"><?=$list["unitname"]?></a><br>
  <?php
  }
  ?>
    </nav>

    <!-- Page Content -->
    <div id="content" style="background:#efefef;">
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
</div>









<?php include_once(G5_THEME_PATH.'/tail.php');?>
