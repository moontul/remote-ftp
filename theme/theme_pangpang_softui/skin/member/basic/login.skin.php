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
            <h4 class="font-weight-bolder">로그인</h4>
            <p class="mb-0">아이디와 비밀번호를 입력하세요.</p>
          </div>
          <div class="card-body">


						<form name="flogin" class="form-signin" action="<?php echo $login_action_url ?>"
							 onsubmit="return flogin_submit(this);" method="post">
						<input type="hidden" name="url" value="<?php echo $login_url ?>">

              <div class="mb-3">
                <input type="text" name="mb_id" id="login_id" class="form-control form-control-lg" placeholder="아이디"
								aria-label="아이디" aria-describedby="아이디" required autofocus>
              </div>
              <div class="mb-3">
                <input type="password" name="mb_password" id="login_pw" class="form-control form-control-lg" placeholder="비밀번호"
								aria-label="Password" aria-describedby="password-addon" required>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="auto_login" id="login_auto_login">

                <label class="form-check-label" for="rememberMe">아이디 저장</label>
              </div>
              <div class="text-center">

                <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">로그인</button>

              </div>
            </form>


          </div>
          <div class="card-footer text-center pt-0 px-lg-2 px-1">
            <p class="mb-4 text-sm mx-auto">
  						<a href="<?php echo G5_BBS_URL ?>/password_lost.php" target="_blank" id="login_password_lost" class="fw-1">정보찾기</a>
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
            <img class="max-width-500 w-100 position-relative z-index-2" src="<?=G5_THEME_URL?>/assets/img/illustrations/chat.png">
          </div>
          <div class="text-white font-weight-bolder h4">
              <?php
                $sql="select content from tb_page where pageid='pplogin'";
                $rs=sql_fetch($sql);
              ?>
                <?=$rs["content"]?>
          </div>
<?php if(1==2){?>
          <!--
          <h4 class="mt-5 text-white font-weight-bolder">"Attention is the new currency"</h4>
          <p class="text-white">The more effortless the writing looks, the more effort the writer actually put into the process.</p>
          -->
<?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
</section>

<?php
// 소셜로그인 사용시 소셜로그인 버튼
//@include_once(get_social_skin_path().'/social_login.skin.php');
?>


<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="<?php echo G5_THEME_URL?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
$(function(){
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });
});

function flogin_submit(f)
{
    return true;
}
</script>


<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
