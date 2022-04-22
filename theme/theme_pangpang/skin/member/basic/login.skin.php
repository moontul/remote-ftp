<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<xxxxxlink href="<?php echo G5_THEME_URL?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<style>
.xxxxxcard-container.card{max-width:350px;padding:40px 40px}
.xxxxxbtn{font-weight:700;height:36px;-moz-user-select:none;-webkit-user-select:none;user-select:none;cursor:default}
.xxxxxcard{background-color:#f7f7f7;padding:20px 25px 30px;margin:0 auto 25px;margin-top:50px;-moz-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;-moz-box-shadow:0 2px 2px rgba(0,0,0,.3);-webkit-box-shadow:0 2px 2px rgba(0,0,0,.3);box-shadow:0 2px 2px rgba(0,0,0,.3)}.profile-img-card{width:96px;height:96px;margin:0 auto 10px;display:block;-moz-border-radius:50%;-webkit-border-radius:50%;border-radius:50%}.profile-name-card{font-size:16px;font-weight:700;text-align:center;margin:10px 0 0;min-height:1em}.reauth-email{display:block;color:#404040;line-height:2;margin-bottom:10px;font-size:14px;text-align:center;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box}.form-signin #login_id,.form-signin .form-signin button,.form-signin input[type=email],.form-signin input[type=password],.form-signin input[type=text]{width:100%;display:block;margin-bottom:10px;z-index:1;position:relative;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box}.form-signin .form-control:focus{border-color:#6891a2;outline:0;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px #6891a2;box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px #6891a2}.btn.btn-signin{background-color:#6891a2;padding:0;font-weight:700;font-size:14px;height:36px;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;border:none;-o-transition:all 218ms;-moz-transition:all 218ms;-webkit-transition:all 218ms;transition:all 218ms}.btn.btn-signin:active,.btn.btn-signin:focus,.btn.btn-signin:hover{background-color:#0c6121}.forgot-password{color:#6891a2}.forgot-password:active,.forgot-password:focus,.forgot-password:hover{color:#0c6121} .register{margin-top:10px}

.bg-pp-primary{
	background-color: #e6e7ee!important;
}
.border-light {
	border-color: #d1d9e6!important;
}
.shadow-soft {
    box-shadow: 6px 6px 12px #b8b9be,-6px -6px 12px #fff!important;
}

.form-group {
    position: relative;
		margin-bottom: 1rem;
}

.input-group {
    box-shadow: inset 2px 2px 5px #b8b9be, inset -3px -3px 7px #fff;
    border-radius: 0.55rem;
    transition: all .2s ease;
		position: relative;
    display: flex;
    flex-wrap: wrap;
    align-items: stretch;
    width: 100%;
}

.input-group-prepend {
    margin-right: -0.0625rem;
		display: flex;
}

.form-control {
    font-size: 1rem;
    border-radius: 0.55rem;
    box-shadow: inset 2px 2px 5px #b8b9be, inset -3px -3px 7px #fff;

		display: block;
    height: calc(1.5em + 1.2rem + 0.0625rem);
    padding: 0.6rem 0.75rem;
    font-weight: 300;
    line-height: 1.5;
    color: #44476a;
    background-color: #e6e7ee;
    background-clip: padding-box;
    border: 0.0625rem solid #d1d9e6;
}

.btn {
    position: relative;
    transition: all .2s ease;
    letter-spacing: .025em;
    font-size: 1rem;
    border-color: #d1d9e6;
    box-shadow: 3px 3px 6px #b8b9be, -3px -3px 6px #fff;
		font-family:'NanumSquare';
}
.btn-block {
    display: block;
    width: 100%;
}
.btn-pp-primary {
    color: #31344b;
    background-color: #e6e7ee;
}
.btn-pp-primary:hover {
    color: #31344b;
    background-color: #e6e7ee;
    border-color: #e6e7ee;
    box-shadow: inset 2px 2px 5px #b8b9be, inset -3px -3px 7px #fff;
}

.profile-image {
    width: 10rem;
    height: 10rem;
}
.rounded-circle {
    border-radius: 50%!important;
}
.shadow-inset {
    box-shadow: inset 2px 2px 5px #b8b9be,inset -3px -3px 7px #fff!important;
}
.border {
    border: 0.0625rem solid #fafbfe!important;
}
</style>
<form name="flogin" class="form-signin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
<input type="hidden" name="url" value="<?php echo $login_url ?>">

<section class="min-vh-100 d-flex bg-pp-primary bg-light align-items-center">
<div class="container-fluid row justify-content-center">
	<div class="col-12 col-md-8 col-lg-6 justify-content-center">

					<div class="card bg-pp-primary bg-light shadow-soft border-light p-4">

						<div class="profile-image shadow-inset border border-light bg-pp-primary rounded-circle p-3 mx-auto"><a href="<?=G5_URL?>"><img
							src="<?php echo G5_THEME_URL?>/img/profile_image.png"
							class="card-img-top shadow-soft p-2 border border-light rounded-circle"
							title="팡팡"></a></div>


						<p id="profile-name" class="profile-name-card"></p>
						<form class="form-signin">
							<span id="login_id" class="reauth-email"></span>
							<input type="text" name="mb_id" id="login_id" class="form-control" placeholder="아이디" required autofocus>
							<input type="password" name="mb_password" id="login_pw" class="form-control" placeholder="비밀번호" required>
							<div id="remember" class="checkbox p-2">
								<label>
									<input type="checkbox" name="auto_login" id="login_auto_login"> 자동로그인
								</label>
							</div>
							<button class="btn btn-block btn-pp-primary" type="submit">로그인</button>
						</form><!-- /form -->
						<a href="#" class="forgot-password" onclick="this.form.submit()"></a>
						<div class="register text-center">

							<a href="<?php echo G5_BBS_URL ?>/password_lost.php" target="_blank" id="login_password_lost" class="fw-1">정보찾기</a>
							<a href="<?=G5_URL?>/register">회원가입</a>
						</div>
						<?php
						// 소셜로그인 사용시 소셜로그인 버튼
						@include_once(get_social_skin_path().'/social_login.skin.php');
						?>

				</div><!-- /card-container -->
  </div>
</div><!-- /container -->
</section>
</form>

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
<!-- } 로그인 끝 -->
