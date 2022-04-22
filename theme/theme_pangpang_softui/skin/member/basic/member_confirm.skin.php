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
      <div class="col-xl-5 col-lg-6 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
        <div class="card card-plain">
          <div class="card-header pb-0 text-left">
            <h4 class="font-weight-bolder">비밀번호 확인</h4>

            <?php if ($url == 'member_leave.php') { ?>
            <p class="mb-0">비밀번호를 입력하시면 회원탈퇴가 완료됩니다.</p>
            <?php }else{ ?>
            <p class="mb-0">비밀번호를 한번 더 입력해주세요.</p>
            <!--회원님의 정보를 안전하게 보호하기 위해 비밀번호를 한번 더 확인합니다.-->
            <?php }  ?>

          </div>
          <div class="card-body">

            <form name="fmemberconfirm" action="<?php echo $url ?>" onsubmit="return fmemberconfirm_submit(this);" method="post">
            <input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>">
            <input type="hidden" name="w" value="u">

              <div class="mb-3 text-bold">
                <span class="confirm_id">회원아이디 : </span>
                <span id="mb_confirm_id"><?php echo $member['mb_id'] ?></span>
              </div>
              <div class="mb-3">
                <input type="password" name="mb_password" id="confirm_mb_password" required
                  class="form-control form-control-lg" placeholder="비밀번호"
								  aria-label="Password" aria-describedby="password-addon" required>

              </div>
              <!--div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="auto_login" id="login_auto_login">
                <label class="form-check-label" for="rememberMe">아이디 저장</label>
              </div-->
              <div class="text-center">
                <button type="submit" id="btn_submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">확인</button>
              </div>
            </form>
          </div>

          <div class="card-footer text-center pt-0 px-lg-2 px-1">
            <!--
            <p class="mb-4 text-sm mx-auto">
              <a href="<?php echo G5_BBS_URL ?>/member_leave.php" class="fw-1">회원탈퇴</a>
  						<a href="<?php echo G5_BBS_URL ?>/password_lost.php" target="_blank" id="login_password_lost" class="fw-1">정보찾기</a>
							<a href="<?=G5_URL?>/register" class="text-primary text-gradient font-weight-bold">회원탈퇴</a>
            </p>
            -->
          </div>

        </div>
      </div>
      <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
        <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center">
          <img src="<?=G5_THEME_URL?>/assets/img/shapes/pattern-lines.svg" alt="pattern-lines" class="position-absolute opacity-4 start-0">
          <div class="position-relative">
            <img class="max-width-500 w-100 position-relative z-index-2" src="<?=G5_THEME_URL?>/assets/img/illustrations/chat.png">
          </div>
          <!--
          <h4 class="mt-5 text-white font-weight-bolder">"Attention is the new currency"</h4>
          <p class="text-white">The more effortless the writing looks, the more effort the writer actually put into the process.</p>
        -->
        </div>
      </div>
    </div>
  </div>
</div>
</section>


<script>
function fmemberconfirm_submit(f)
{
    document.getElementById("btn_submit").disabled = true;
    return true;
}
</script>
<!-- } 회원 비밀번호 확인 끝 -->
<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
