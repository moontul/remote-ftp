
<script><?php //본문 내용중에 첨부 파일 등 파일을 직접 다운로드 받을때 사용하는 함수 ?>
  function js_filedown(p, n){
     window.open('/download.php?filepath='+p+'&filename='+n); return false;
  }
 </script>

<?php if(1==2){ //xxxxxxxxxxxxxxxxxxxxxxxxxxxx?>
<!--
<footer class="footer mt-auto py-3 pp-footer">
  <div class="container">
    Copyright 팡팡 Since 2021

    <?php //echo visit("theme/basic"); // 접속자집계, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정 ?>

    <hr class="align-center">

    팡팡, 동백꽃, 어린왕자, 사막여우, 장미, 해마, 키다리, 반딧불이, 나비
  </div>
</footer>
--><?php } //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx ?>
<footer style="height:230px;" class="footer py-5 bg-gradient-dark position-relative overflow-hidden">
    <img src="<?=G5_THEME_URL?>/assets/img/shapes/waves-white.svg" alt="pattern-lines"
    class="position-absolute start-0 top-0 w-100 opacity-6">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 me-auto mb-lg-0 mb-4 text-lg-start text-center">

          <span class="text-white font-weight-bolder text-uppercase mb-lg-4 mb-1 h4">에듀텍연구소</span>

          <a href="https://www.youtube.com/channel/UCzYklTk2lJmD_ind0xJw6WA" target="_blank" title="youtube" class="text-white me-xl-2 me-2 ms-3 opacity-5">
            <span class="fab fa-youtube" aria-hidden="true"></span>
          </a>
          <a href="mailto:pangpangolive@gmail.com" target="_blank" title="mail" class="text-white opacity-5">
            <i class="fas fa-envelope"></i>
          </a>

          <?php if(1==2){ //xxxxxxxxxxxxxxxxxxxxxxxxxxxxx?>
          <ul class="nav flex-row ms-n3 justify-content-lg-start justify-content-center mb-4 mt-sm-0">
            <li class="nav-item">
              <a class="nav-link text-white opacity-8" href="/">
                Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white opacity-8" href="#">
                About
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white opacity-8" href="#" target="_blank">
                FAQ
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white opacity-8" href="#" target="_blank">
                Services
              </a>
            </li>
          </ul><?php } //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx?>

          <div class="text-sm text-white opacity-8 mb-0">
            Copyright ©edutechlab Since 2021   <?php echo visit("theme/basic"); // 접속자집계, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정 ?>
          </div>
        </div>
<?php
$sql="select B.listcontent as listcontent from tb_container A, tb_list B where A.code=B.code and A.title like '%명언%' order by rand()";
$result=sql_fetch($sql);
?>
        <div class="col-lg-6 ms-auto text-lg-end text-center">
          <div class="mb-2 text-lg text-white font-weight-bold">
            <?=$result["listcontent"]?>
        </div>


          <!--
          <a href="#" target="_blank" class="text-white me-xl-4 me-4 opacity-5">
            <span class="fab fa-twitter" aria-hidden="true"></span>
          </a>
          <a href="#" target="_blank" class="text-white me-xl-4 me-4 opacity-5">
            <span class="fab fa-pinterest" aria-hidden="true"></span>
          </a>
          <a href="javascript:;" target="_blank" class="text-white opacity-5">
            <span class="fab fa-github" aria-hidden="true"></span>
          </a>
          -->
        </div>
      </div>
    </div>
  </footer>
<?php if(1==2){ //xxxxxxxxxxxxxxxxxxxxxxxxxxxxx?><!--
<footer class="footer" style="background:navy;">
  <hr class="horizontal dark mb-5">
  <div class="container">
    <div class=" row">
      <div class="col-md-3 mb-4 ms-auto">
        <div>
          <h6 class="text-gradient text-primary font-weight-bolder">PangPang IT & Coding Question Bank System</h6>
        </div>
        <div>
          <h6 class="mt-3 mb-2 opacity-8">Social</h6>
          <ul class="d-flex flex-row ms-n3 nav">
            <li class="nav-item">
              <a class="nav-link pe-1" href="#" target="_blank">
                <i class="fab fa-facebook text-lg opacity-1"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link pe-1" href="#" target="_blank">
                <i class="fab fa-twitter text-lg opacity-3"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link pe-1" href="#" target="_blank">
                <i class="fab fa-dribbble text-lg opacity-5"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link pe-1" href="#" target="_blank">
                <i class="fab fa-github text-lg opacity-7"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link pe-1" href="#" target="_blank">
                <i class="fab fa-youtube text-lg opacity-9"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-2 col-sm-6 col-6 mb-4">
        <div>
          <h6 class="text-gradient text-primary text-sm">소개</h6>
          <ul class="flex-column ms-n3 nav">
            <li class="nav-item">
              <a class="nav-link" href="#" target="_blank">
                팡팡
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" target="_blank">
                Prof.SangMi
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" target="_blank">
                pangpangolive.gmail.com
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-2 col-sm-6 col-6 mb-4">
        <div>
          <h6 class="text-gradient text-primary text-sm">도움말</h6>
          <ul class="flex-column ms-n3 nav">
            <li class="nav-item">
              <a class="nav-link" href="#" target="_blank">
                Illustrations
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" target="_blank">
                Bits & Snippets
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" target="_blank">
                Affiliate Program
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-2 col-sm-6 col-6 mb-4">
        <div>
          <h6 class="text-gradient text-primary text-sm">Help & Support</h6>
          <ul class="flex-column ms-n3 nav">
            <li class="nav-item">
              <a class="nav-link" href="#" target="_blank">
                Contact Us
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" target="_blank">
                Knowledge Center
              </a>
            </li>

          </ul>
        </div>
      </div>
      <div class="col-md-2 col-sm-6 col-6 mb-4 me-auto">
        <div>
          <h6 class="text-gradient text-primary text-sm">책임&의무</h6>
          <ul class="flex-column ms-n3 nav">
            <li class="nav-item">
              <a class="nav-link" href="#" target="_blank">
                사용약관
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" target="_blank">
                개인정보 보호정책
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-12">
        <div class="text-center">
          <p class="my-4 text-sm">
            All rights reserved. Copyright © Since 2021 PangPang IT&Coding Question Bank System</a>.
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>
--><?php } //xxxxxxxxxxxxxxxxxxxxxxxxxxxxx ?>
