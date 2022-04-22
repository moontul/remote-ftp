<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
$navstyle="round";
include_once(G5_THEME_PATH.'/head.php');
?>


<section>
<div class="page-header min-vh-100">
  <div class="container">
    <div class="row">
      <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                                        <div class="card-header pb-0 text-left">
                                        <h4 class="font-weight-bolder">회원정보 찾기</h4>
                                        <p class="mb-0">
                                          회원가입 시 등록하신 이메일을 입력하세요.<br>
                                          아이디와 비밀번호 정보를 보내드립니다.
                                        </p>
                                      </div>
                                        <div class="card-body">

                        <form name="fpasswordlost" action="<?php echo $action_url ?>"
                        onsubmit="return fpasswordlost_submit(this);" method="post" autocomplete="off">

                          <!-- 회원정보 찾기 시작 { -->
                          <div class="mb-3">
                            <input type="text" name="mb_email" id="mb_email"
                            class="form-control form-control-lg" size="30" placeholder="E-mail 주소"
                            aria-label="이메일" aria-describedby="이메일" required autofocus>
                          </div>
                          <div class="mb-3">
                              <?php echo captcha_html();  ?>
                          </div>
                          <div class="text-center">
                            <input type="submit" value="확인" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">
                          </div>


                        </form>




          </div>
                    <div class="card-footer text-center pt-0 px-lg-2 px-1">

                      <p class="mb-4 text-sm mx-auto">
            						<a href="<?php echo G5_BBS_URL ?>/login.php" target="_blank" id="login_password_lost" class="fw-1">로그인</a>
          							<a href="<?=G5_URL?>/register" class="text-primary text-gradient font-weight-bold">회원가입</a>
          							<!--<a href="#" class="forgot-password" onclick="this.form.submit()"></a>-->
                      </p>



                    </div>
        </div>
      </div>
      <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
        <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center">
          <img src="<?=G5_THEME_URL?>/assets/img/shapes/pattern-lines.svg" alt="pattern-lines" class="position-absolute opacity-4 start-0">
          <div class="position-relative">
            <img class="max-width-500 w-100 position-relative z-index-2" src="<?=G5_THEME_URL?>/assets/img/illustrations/key-iso-gradient500.png">
          </div>
          <div class="text-white font-weight-bolder h4">
              <?php
                $sql="select content from tb_page where pageid='pplogin'";
                $rs=sql_fetch($sql);
              ?>
                <?=$rs["content"]?>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
</section>


<script>


$("#captcha_key").addClass("form-control form-control-lg mt-1");
$("#captcha_img").addClass("text-center");
$("#captcha_mp3").addClass("btn btn-sm bg-gradient-secondary");
$("#captcha_reload").addClass("btn btn-sm bg-gradient-secondary");
$("#captcha_info").addClass("d-block");

function fpasswordlost_submit(f){
    <?php echo chk_captcha_js();  ?>
    return true;
}

$(function() {
    var sw = screen.width;
    var sh = screen.height;
    var cw = document.body.clientWidth;
    var ch = document.body.clientHeight;
    var top  = sh / 2 - ch / 2 - 100;
    var left = sw / 2 - cw / 2;
    moveTo(left, top);
});
</script>
<!-- } 회원정보 찾기 끝 -->


<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
