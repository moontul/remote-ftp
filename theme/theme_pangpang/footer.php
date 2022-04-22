
<script><?php //본문 내용중에 첨부 파일 등 파일을 직접 다운로드 받을때 사용하는 함수 ?>
  function js_filedown(p, n){
     window.open('/download.php?filepath='+p+'&filename='+n); return false;
  }
 </script>

<footer class="footer mt-auto py-3 pp-footer">
  <div class="container">
    Copyright 팡팡 Since 2021

    <?php echo visit("theme/basic"); // 접속자집계, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정 ?>

    <hr class="align-center">

    팡팡, 동백꽃, 어린왕자, 사막여우, 장미, 해마, 키다리, 반딧불이, 나비
  </div>
</footer>
