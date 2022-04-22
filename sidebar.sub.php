<span id="pp_sidebar_toggle" style="display:none;position:fixed;z-index:1010;left:1px;">
  <input id="pp_sidebar_show_btn" type=button value="목록→" class="btn-pp-sx shadow-sm" style="border:0; background:#ff00ff;color:white;" onclick="pp_sidebar_show()">
  <button id="pp_sidebar_hide_btn" type=button value="hide" class="btn-close btn-pp-sx" style="margin-left:210px;" aria-label="목록숨김" onclick="pp_sidebar_hide()"></button>
</span>
<script>
function pp_sidebar_show(){
    $(".pp-sidebar").css("left","0");
    $("#pp_sidebar_show_btn").hide();
    $("#pp_sidebar_hide_btn").show();
}
function pp_sidebar_hide(){
    $(".pp-sidebar").css("left","-240px");
    $("#pp_sidebar_show_btn").show();
    $("#pp_sidebar_hide_btn").hide();
}

function viewport()
{
  var e = window
  , a = 'inner';
  if ( !( 'innerWidth' in window ) )
  {
  a = 'client';
  e = document.documentElement || document.body;
  }
  return { width : e[ a+'Width' ] , height : e[ a+'Height' ] }
}

function chk_pp_sidebar(){

  if (matchMedia("screen and (min-width: 768px)").matches) {
    // 000px 이상에서 사용할 JavaScript
    $(".pp-sidebar").css("left","auto");
    $("#pp_sidebar_toggle").hide();

    $(".qchk_num_toggle").removeClass("qchk_num")

  } else {
    // 000px 미만에서 사용할 JavaScript
    $(".pp-sidebar").css("left","-240px");
    $("#pp_sidebar_show_btn").show();
    $("#pp_sidebar_hide_btn").hide();
    $("#pp_sidebar_toggle").show();

    $(".qchk_num_toggle").addClass("qchk_num");

  }

  if(matchMedia("(max-height: 600px)").matches){
    //  console.log("높이 600이하");
  } else {
    //    console.log("높이 600이상");
  }


  window_height=parseInt(window.innerHeight);

  //사이드의 실제높이
  var side_height=0;
  $(".pp-sidebardiv").each(function(){
      side_height = side_height + $(this).outerHeight(true);
  })
  var header_height=0;
  var footer_height=0;
  var footer_height_all=0;
  var content_height=0;
  var gap=57; //nav fixed top 높이
  header_height = $("header").outerHeight(true);
  content_height = parseInt($(".pp-sidecontent").outerHeight(true));
  footer_height = $("footer").outerHeight();
  footer_height_all = parseInt($("footer").outerHeight(true));

  //console.log(  "윈도우:"+window_height+"=메뉴:"+ header_height +"푸터:"+footer_height+"("+footer_height_all+")+내용"+content_height);
  $(".pp-sidebar").css("height",footer_height_all+content_height-footer_height);

  var scrolltop = parseInt($(document).scrollTop());
  var scrollheight=parseInt($("body").prop("scrollHeight"));

  //console.log("스크롤높이:" + scrollheight + ":0까지" + scrolltop);
  $(".pp-sidebar").css("top",header_height-scrolltop+gap);

  if(scrolltop>header_height){
    //console.log("메뉴 안보임-------윈도우높이:"+ window_height + "스크롤포함높이:"+scrollheight + "위에서 높이" + scrolltop + "계산:" +parseInt(scrollheight-scrolltop))
    $(".pp-sidebar").css("top",0);
    $(".pp-sidebar").css("height",window_height);
    if(parseInt(footer_height_all) > parseInt(parseInt(scrollheight)-parseInt(scrolltop)-(parseInt(window_height))) ){
      $(".pp-sidebar").css("height",window_height - (parseInt(footer_height_all) - parseInt(parseInt(scrollheight)-parseInt(scrolltop)-(parseInt(window_height)))));
    }
  }else{
    //console.log("메뉴 보임++++++++")
  }
  return;
}

$(window).resize(function(){
 chk_pp_sidebar();
});
$(window).scroll(function(){
 chk_pp_sidebar();
});
$(function(){
 chk_pp_sidebar();
})

</script>
