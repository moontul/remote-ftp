<?php
if (!defined('_INDEX_')) define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');
?>

<?php
/**************************************************************************
GNUBOARD 5.4

[라이선스]
팡팡
**************************************************************************/
?>

<!-------------------------- 슬라이드 -------------------------->
<header>

<div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel" data-interval="5000">

	<ol class="carousel-indicators">
    <?php //캐러셀을 수정하려면 관리자 내용관리에서 ID를 carousel_번호 로 저장하세요. 이미지는 상단이미지를 사용합니다.
        $sql="select * from ". $g5['content_table']." where co_id like 'carousel_%' order by co_id";
        $result = sql_query($sql);
        $counter = 0;
        for ($i=0; $row=sql_fetch_array($result); $i++){
    ?>
	  <li data-target="#carouselExampleIndicators" data-slide-to="<?=$i?>" class="<?=($i==0)?'active':''?>"></li>
    <?php } ?>
	</ol>

	<div class="carousel-inner" role="listbox">
<?php
    sql_data_seek($result,0);
    for ($i=0; $row=sql_fetch_array($result); $i++){
       $co_id=($row['co_id']);
       $co_subject=($row['co_subject']);
       $co_content=($row['co_content']);
       $co_include_head=($row['co_include_head']);
?>
	  <div class="carousel-item <?=($i==0)?'active':''?>" style="background-image: url('<?=G5_DATA_URL?>/content/<?=$co_id?>_h')">
		<div class="carousel-caption d-md-block">

		  <h3 class="ks4"><?=$co_subject?></h3>
		  <p class="ks4 f20">
        <?=$co_content?>
      </p>
		</div>
	  </div>
<?php  } ?>
	</div>

	<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
	  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	  <span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
	  <span class="carousel-control-next-icon" aria-hidden="true"></span>
	  <span class="sr-only">Next</span>
	</a>
</div>
</header>

<!-------------------------- ./슬라이드 -------------------------->




<div class="margin-bottom-50"></div>

<!-------------------------- 게시판 -------------------------->
<div class="container">
	<div class="row">
		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<?php echo latest('theme/basic_main_one', 'notice', 5, 40);?>
		</div>
		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<?php echo latest('theme/basic_main_one', 'free', 5, 40);?>
		</div>
	</div>
</div>
<div class="margin-bottom-50"></div>











<!-------------------------- USE A LIBRARY -------------------------->
<div class="padding-top-120 padding-bottom-140">
	<div class="container">
		<div class="center-heading">
			<h2 class="en1">USE A <strong>LIBRARY</strong> </h2>
			<span class="center-line"></span>
		</div>
		  <div class="row f16">

			<div class="col-lg-6">
			  <h2 class="en1">JavaScript Library</h2>
			  <p class="ks4 f20">테마폴더내 라이선스 문서 확인</p>
			  <ul class="en2">
				<li><strong>GNUboard5 (5.4.5.1)</strong></li>
				<li><strong>Bootstrap4</strong></li>
				<li>jQuery</li>
				<li>Font Awesome5</li>
				<li>Working contact form with validation</li>
				<li>Unstyled page elements for easy customization</li>
				<li>Parallax</li>
				<li>Owl</li>
			  </ul>
			  <p class="ks5">
			  현제 제작되는 모든 테마는 에티테마 에서 제작되고 있으며 무료 테마 및 템플릿의 경우에는 이미지가 포함 되어 있지 않습니다. 또한 에티테마로 오시면 추가적인 업데이트된 파일을 다운로드 하실 수 있습니다.</p>
			</div>

			<div class="col-lg-6 text-right">
				<img class="img-fluid rounded" src="<?php echo G5_THEME_URL?>/img/s-3.png" alt="">
			</div>

		  </div>
	  <!-- /.row -->
	</div>
</div>




<?php
include_once(G5_THEME_PATH.'/tail.php');
