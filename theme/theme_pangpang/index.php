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

<?php if($is_admin){ ?>

<style>
  .particle_container {
  	margin: 30px auto;
    width:100%;
    height: 1000px;
  	overflow: hidden;
  	cursor: pointer;
  }
</style>



  <div class="particle_container">
    <iframe src="effect_particle/index.html" style="border:0;width:100%;height:100%;"></iframe>
  </div>


  <?php //@include_once('lowpoly1.php') ?>

<?php } ?>

<div class="container">


  <div id="carouselExampleIndicators" class="carousel slide mt-5" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="d-block w-100 card shadow-lg" style="height:300px; background:#efefef"></div>
      </div>
      <div class="carousel-item">
        <div class="d-block w-100 card shadow-lg" style="height:300px;background:tomato"></div>
      </div>
      <div class="carousel-item">
        <div class="d-block w-100 card shadow-lg" style="height:300px;background:#cfcfcf"></div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
























</div>
<?php
include_once(G5_THEME_PATH.'/tail.php');
