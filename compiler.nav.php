<?php ?>

<nav id="pp-sidebar">
  <div class="pp-sidebardiv header">
    <strong>컴파일러</strong>
  </div>

  <div class="pp-sidebardiv">
    &nbsp; &nbsp; <a href="/compiler?C">C</a>
  </div>
  <div class="pp-sidebardiv">
    &nbsp; &nbsp; <a href="/compiler?CPP">C++</a>
  </div>
  <div class="pp-sidebardiv">
    &nbsp; &nbsp; <a href="/compiler?Java">Java</a>
  </div>
  <div class="pp-sidebardiv">
    &nbsp; &nbsp; <a href="/compiler?Python">Python</a>
  </div>

  <div class="pp-sidebardiv">
    &nbsp; &nbsp; <a href="/compiler?SQL">SQL</a>
  </div>

  <div class="pp-sidebardiv">
    &nbsp; &nbsp; <a href="/compiler?PHP">PHP</a>
  </div>

  <div class="pp-sidebardiv">
    &nbsp; &nbsp; <a href="/compiler?NodeJS">NodeJS</a>
  </div>
</nav>
<script>
$(".btn_lvl").click(function(){

  var l=$(this).attr("lvl");
  var h=$(this).html();

  if(h.indexOf("-up")>0){
    $(".lvl_"+l+"_sub").hide();
    $(this).html("<i class='fas fa-caret-down'></i>");
  }else{
    $(".lvl_"+l+"_sub").show();
    $(this).html("<i class='fas fa-caret-up'></i>");
  }
});
</script>
