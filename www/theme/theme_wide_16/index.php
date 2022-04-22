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

**************************************************************************/
?>
<!-------------------------- 슬라이드 -------------------------->
<header>
  <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel" data-interval="15000">
	<ol class="carousel-indicators">
	  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
	  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
	  <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
	</ol>
	<div class="carousel-inner" role="listbox">
	  <!-- Slide One - Set the background image for this slide in the line below -->
	  <div class="carousel-item active" style="background-image: url('<?=G5_THEME_IMG_URL?>/bg/banner2560x740_C.jpg')">
		<div class="carousel-caption d-md-block">
      <div style="width:300px;margin-top:-200px;margin-left:600px;">
  		  <h3 style="font-family:'NanumSquare';letter-spacing:-1px;">C 로드맵</h3>
  		  <p><a href="" class="btn pp-btn" style="color:#333">바로가기</a></p>
      </div>
		</div>
	  </div>
	  <!-- Slide Two - Set the background image for this slide in the line below -->
	  <div class="carousel-item" style="background-image: url('<?=G5_THEME_IMG_URL?>/bg/banner2560x740_PYTHON.jpg')">
		<div class="carousel-caption d-md-block">
      <div style="width:300px;margin-top:0px;margin-left:500px;">
  		  <h3 style="font-family:'NanumSquare';letter-spacing:-1px;">파이썬 로드맵</h3>
  		  <p class="f20"><a href="" class="btn pp-btn" style="color:#333">바로가기</a></p>
      </div>
		</div>
	  </div>
	  <!-- Slide Three - Set the background image for this slide in the line below -->
    <!--
	  <div class="carousel-item" style="background-image: url('<?=G5_THEME_IMG_URL?>/bg/banner2560x740_3.jpg')">
		<div class="carousel-caption d-md-block">
		  <h3>코딩 학습 메모장</h3>
		  <p class="ks4 f20">책이나 사이트 강의 코딩 테스트하고 메모 기록 해 둡니다</p>
		</div>
	  </div>
    -->
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


<div class="margin-top-100"></div>
<div class="container">
  <h2>사이트 작업중입니다</h2>
  <h4>under construction</h4>
</div>
<div class="margin-top-100"></div>

<? if(1==2) { ?>}
<!-------------------------- 아이콘박스 -------------------------->
<div class="margin-top-100"></div>
<div class="container">
	<div class="center-heading ks4">
		<h2>WIDE FREE <strong>THEME</strong> </h2>
		<span class="center-line"></span>
		<p class="sub-text margin-bottom-80 ks5 f19">
		무료 폰트어썸5 버전을 사용합니다.
		</p>
	</div>

	<div class="row padding-top-20">
		<div class="col-lg-3 col-md-3 col-sm-12 col-12">
			<div class="box">
				<div class="icon">
					<div class="info-pink">
						<i class="fas fa-chart-line"></i>
						<p class="ks4 f15 h75">
							애플사의 IOS 부터 안드로이드 운영체제까지 모두 지원되는 무료 비즈니스 반응형 홈페이지 입니다.
						</p>
						<div class="margin-top-20 margin-bottom-20">
							<button type="button" class="btn btn-secondary btn-sm ks4" onclick="location.href='#'">바로가기</button>
						</div>
					</div>
				</div>
				<div class="space"></div>
			</div>
		</div><!-- ./col -->
		<div class="col-lg-3 col-md-3 col-sm-12 col-12">
			<div class="box">
				<div class="icon">
					<div class="info-pink-2">
						<i class="fas fa-cloud-moon-rain"></i>
						<p class="ks4 f15 h75">
							갤럭시 시리즈의 모든 기종에서도 문제 없이 최적화된 사이트로 적용됩니다.
						</p>
						<div class="margin-top-20 margin-bottom-20">
							<button type="button" class="btn btn-secondary btn-sm ks4" onclick="location.href='#'">바로가기</button>
						</div>
					</div>
				</div>
				<div class="space"></div>
			</div>
		</div><!-- ./col -->
		<div class="col-lg-3 col-md-3 col-sm-12 col-12">
			<div class="box">
				<div class="icon">
					<div class="info">
						<i class="fas fa-cog"></i>
						<p class="ks4 f15 h75">
							갤럭시 시리즈의 모든 기종에서도 문제 없이 최적화된 사이트로 적용됩니다.
						</p>
						<div class="margin-top-20 margin-bottom-20">
							<button type="button" class="btn btn-secondary btn-sm ks4" onclick="location.href='#'">바로가기</button>
						</div>
					</div>
				</div>
				<div class="space"></div>
			</div>
		</div><!-- ./col -->
		<div class="col-lg-3 col-md-3 col-sm-12 col-12">
			<div class="box">
				<div class="icon">

					<div class="info">
						<i class="fas fa-sliders-h"></i>
						<p class="ks4 f15 h75">
							문의사항은 질문게시판에 글 남겨주세요.
						</p>
						<div class="margin-top-20 margin-bottom-20">
							<button type="button" class="btn btn-secondary btn-sm ks4" onclick="location.href='#'">바로가기</button>
						</div>
					</div>
				</div>
				<div class="space"></div>
			</div>
		</div><!-- ./col -->
	</div><!-- /row -->

	<div class="d-none d-sm-block margin-top-30"></div><!-- pc 만 적용 -->

	<!-------------------------- 두번째줄 -------------------------->
	<div class="row">
		<div class="col-lg-3 col-md-3 col-sm-12 col-12">
			<div class="box">
				<div class="icon">
					<div class="info">
						<i class="far fa-hospital"></i>
						<p class="ks4 f15 h75">
							애플사의 IOS 부터 안드로이드 운영체제까지 모두 지원되는 무료 비즈니스 반응형 홈페이지 입니다.
						</p>
						<div class="margin-top-20 margin-bottom-20">
							<button type="button" class="btn btn-secondary btn-sm ks4" onclick="location.href='#'">바로가기</button>
						</div>
					</div>
				</div>
				<div class="space"></div>
			</div>
		</div><!-- /col -->
		<div class="col-lg-3 col-md-3 col-sm-12 col-12">
			<div class="box">
				<div class="icon">
					<div class="info">
						<i class="far fa-lightbulb"></i>
						<p class="ks4 f15 h75">
							갤럭시 시리즈의 모든 기종에서도 문제 없이 최적화된 사이트로 적용됩니다.
						</p>
						<div class="margin-top-20 margin-bottom-20">
							<button type="button" class="btn btn-secondary btn-sm ks4" onclick="location.href='#'">바로가기</button>
						</div>
					</div>
				</div>
				<div class="space"></div>
			</div>
		</div><!-- /col -->

		<div class="col-lg-3 col-md-3 col-sm-12 col-12">
			<div class="box">
				<div class="icon">
					<div class="info">
						<i class="fab fa-php"></i>
						<p class="ks4 f15 h75">
							갤럭시 시리즈의 모든 기종에서도 문제 없이 최적화된 사이트로 적용됩니다.
						</p>
						<div class="margin-top-20 margin-bottom-20">
							<button type="button" class="btn btn-secondary btn-sm ks4" onclick="location.href='#'">바로가기</button>
						</div>
					</div>
				</div>
				<div class="space"></div>
			</div>
		</div><!-- /col -->

		<div class="col-lg-3 col-md-3 col-sm-12 col-12">
			<div class="box">
				<div class="icon">

					<div class="info-pink">
						<i class="fab fa-rocketchat"></i>
						<p class="ks4 f15 h75">
							문의사항은 질문게시판에 글 남겨주세요.
						</p>
						<div class="margin-top-20 margin-bottom-20">
							<button type="button" class="btn btn-secondary btn-sm ks4" onclick="location.href='#'">바로가기</button>
						</div>
					</div>
				</div>
				<div class="space"></div>
			</div>
		</div><!-- /col -->
	</div><!-- /row -->
	<div class="margin-bottom-40"></div>
</div><!-- /container -->
<? } ?>



<!-------------------------- 게시판 -------------------------->
<div class="container">
	<div class="row">
		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<?php echo latest('theme/basic_main_one', 'notice', 5, 40);?>
		</div>
		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<?php echo latest('theme/basic_main_one', 'qa', 5, 40);?>
		</div>
	</div>
</div>
<div class="margin-bottom-150"></div>




<? if(1==2){ ?>
<!--------------------------------------------------------------------------------->
<!-------------------------- pallax box -------------------------->
<!--
<style>
.para-box{
    height: 550px; display: grid; align-items: center;
}
</style>
<div class="parallax-window" data-parallax="scroll" data-image-src="<?php echo G5_THEME_URL?>/img/bg/1.jpg"><!-- 이미지 주소 -->
	<div class="container">
		<div class="row">
			<div class="col-md-12 para-box text-center">

				<div class="">
					<h2 class='text-light ks5'>반응형 커뮤니티 , 반응형 와이드 에티테마 무료 다운로드 바로가기</h2>
					<br />
					<button type="button" class="btn btn-outline-light ks4" onclick='window.open("about:blank").location.href="http://ety.kr/board/theme_update"'>바로가기</button>
				</div>
			</div>

		</div>
	</div>
</div><!-- /parallax -->
-->

<!-------------------------- 테마소개 + 유튜브영상 -------------------------->

<div class="padding-top-120 padding-bottom-140" style="background:#f2f2f2;">
	<div class="container">
	<div class="center-heading">
		<h2 class="en1">USE A <strong>LIBRARY</strong> </h2>
		<span class="center-line"></span>
	</div>
	  <div class="row">
		<div class="col-lg-6">
		  <iframe width="100%" height="315" src="https://www.youtube.com/embed/PF0BcfP9pkc" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>
		<div class="col-lg-6">
		  <h2 class="en1">SERVICE</h2>
		  <p class="ks4"><strong>새롭게 7개의 페이지가 업로드 되었습니다.</strong></p>
		  <p class="ks4"><a href="http://ety.kr/shop/item/1623421493" target="_blank">http://ety.kr/shop/item/1623421493</a></p>
		  <p class="ks4">배포는 소프트존만 가능하며 배포처는 에티테마,SIR 만 제한하고 있습니다.</p>
		  <p class="ks4">설치방법안내 <strong><a href="http://ety.kr/board/free_theme_manual/42" target="_blank">http://ety.kr/board/free_theme_manual/42</a></strong> 에서 진행하고 있으므로 궁금점이나 문의사항이 있으시면 해당 게시판을 이용해주세요.</p>
		</div>
	  </div>
	</div>
</div>




<!-------------------------- 제품안내 갤러리 -------------------------->

<div class="container margin-top-120 margin-bottom-150">
	<div class="center-heading margin-top-40">
		<h2 class="ks4">제품안내</h2>
		<span class="center-line"></span>
		<p class="sub-text margin-bottom-80 ks5 f19">
		해당 제품에 대한 소개내용 입니다.
		</p>
	</div>
	<!-- LATEST : pic_basic_company -->
	<?php echo latest('theme/pic_basic_company', 'gallery', 6, 24); ?>
</div>


<!-------------------------- USE A LIBRARY -------------------------->
<div class="padding-top-120 padding-bottom-140" style="background:#f2f2f2;">
	<div class="container">
		<div class="center-heading">
			<h2 class="en1">USE A <strong>LIBRARY</strong> </h2>
			<span class="center-line"></span>
		</div>
	  <div class="row f16">

		<div class="col-lg-6 text-left">
			<img class="img-fluid rounded" src="<?php echo G5_THEME_URL?>/img/s-4.png" alt="">
		</div>

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
		  현제 제작되는 모든 테마 및 템플릿은 에티테마 에서 제작되고 있으며 무료 테마 및 템플릿의 경우에는 이미지가 포함 되어 있지 않습니다. 또한 에티테마로 오시면 추가적인 업데이트된 파일을 다운로드 하실 수 있습니다.</p>
		</div>

	  </div>
	  <!-- /.row -->
	</div>
</div>





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





<!-------------------------- parallax 박스 및 countdown -------------------------->
<div class="parallax-window" data-parallax="scroll" data-image-src="<?php echo G5_THEME_URL?>/img/bg/2.jpg">
	<div class="container">
		<div class="row" style="height:550px;">

			<div class="col-md-12 text-center p-center para-text">
				<h2 class='text-light ks5'>반응형 커뮤니티 , 반응형 와이드 에티테마 무료 다운로드 바로가기</h2>
				<button type="button" class="btn btn-outline-light ks4" onclick='window.open("about:blank").location.href="http://ety.kr/board/theme_update"'>바로가기</button>
			</div>
		</div>
	</div>
</div><!-- /parallax -->



<!-------------------------- GALLERY -------------------------->
<!--

테마폴더/tail.php : 43 번째줄에서 수정하시면 됩니다.
owlcarousel 시간조정, 개수조정, 오토플레이 조정
-->

<div class="container margin-top-100 margin-bottom-120">
	<h3 class="text-left">GALLERY</h3>
	<?php echo latest('theme/pic_basic_owl', 'gallery', 9, 24); ?>
</div>


<? } ?>




<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
