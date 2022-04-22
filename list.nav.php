<?php
$a_idx=array();
$a_pidx=array();
$a_path=array();
$a_list=array();
$a_listtitle=array();
$a_tabtitle=array();
$a_listorder=array();
$a_ccnt=array();
$a_qcnt=array();
$a_listcontent=array();
$a_youtube=array();
$a_files=array();

if(isset($code)){
  $start=0;
  $sqlh="

WITH RECURSIVE tmp1 AS
(
    SELECT list, idx, listtitle, pidx,
    listtitle AS path, 1 AS lvl
    ,listcontent, youtube
    FROM tb_list WHERE pidx=0 and code='$code'

    UNION ALL

    SELECT e.list, e.idx, e.listtitle, e.pidx,
    CONCAT(t.path,' > ',e.listtitle) AS path, t.lvl+1 AS lvl
    ,e.listcontent, e.youtube
    FROM tmp1 t JOIN (select * from tb_list where code='$code') e
    ON t.idx=e.pidx
)

SELECT list, idx, listtitle, pidx, path, lvl
,listcontent, youtube
,CONCAT(REPEAT(' ', (lvl-1)*4), listtitle) tabtitle
,(select count(*) from tb_qlist where list=A.list) as qcnt
,(select count(*) from tb_list where pidx=A.idx) as ccnt
,(select count(*) from tb_list_files where list=A.list) as fcnt
FROM tmp1 A
ORDER BY path;
 ";

// echo($sqlh);

  $resulth=sql_query($sqlh);
  for($h=0;$rsh=sql_fetch_array($resulth);$h++){
    array_push($a_idx, $rsh["idx"]);
    array_push($a_pidx, $rsh["pidx"]);
    array_push($a_path, $rsh["path"]);
    array_push($a_list, $rsh["list"]);
    array_push($a_listtitle, $rsh["listtitle"]);
    array_push($a_listorder, $rsh["lvl"]);
    array_push($a_qcnt, $rsh["qcnt"]);
    array_push($a_ccnt, $rsh["ccnt"]);

    array_push($a_listcontent, $rsh["listcontent"]);
    array_push($a_youtube, $rsh["youtube"]);
    array_push($a_files, $rsh["fcnt"]);

    array_push($a_tabtitle, $rsh["tabtitle"]);
  }
}

//echo($sqlh);
?>

<?php //@include_once("sidebar.sub.php");?>
<div class="ct-docs-sidebar-col">
<nav class="ct-docs-sidebar-collapse-links">

<!--
  <div class="ct-docs-sidebar-product">
    <div class="ct-docs-sidebar-product-image">
      [thumb]
    </div>
    <p class="ct-docs-sidebar-product-text">컨테이너 이름</p>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="ct-docs-toc-item-active">
    <a class="ct-docs-toc-link" href="javascript:void(0)">
      <div class="d-inline-block">
        <div class="icon icon-xs border-radius-md bg-gradient-primary text-center mr-2 d-flex align-items-center justify-content-center me-1">
          <i class="ni ni-active-40 text-white"></i>
        </div>
      </div>
      목록a
    </a>
    <ul class="ct-docs-nav-sidenav ms-4 ps-1">
      <li class="ct-docs-nav-sidenav-active ">
        <a href="../../bootstrap/overview/soft-ui-design-system">
          목록b
        </a>
      </li>
    </ul>
  </div>
-->

<?php if(isset($code)){ ?>
  <div class="ct-docs-sidebar-product">
    <a href="/view?code=<?=$code?>">
    <?=$title?><?=(isset($is_subtitle))?' '.$subtitle:''?>
    </a>
  </div>

  <hr class="horizontal dark mt-0">

  <?php if($is_admin){?>
  <div class="pp-sidebardiv p-1 nohover">
    <a href="/write?code=<?=$code?>" title="목록 추가"><i class="fas fa-plus-circle"></i> 목록추가 </a>
    <a href="/ledit.php?code=<?=$code?>" title="목록 편집"><i class="fas fa-plus-circle"></i> 목록편집 </a>
  </div>
  <?}?>

<? } ?>

<?php
$lvl_top=0;
$lvl_sub="";
for($x=0;$x<count($a_idx);$x++){
  if($a_listorder[$x]==1){
    $lvl_top++;
    $lvl_sub="";
  }else{
    $lvl_sub="_sub";
  }
?>
<div class="p-1 pp-sidebardiv lvl_<?=$lvl_top?><?=$lvl_sub?> draggable <?php if($_GET["list"]==$a_list[$x]){echo('hit');}?>" list="<?=$a_list[$x]?>" idx="<?=$a_idx[$x]?>">

   <?for($y=1;$y<$a_listorder[$x];$y++){echo(" &nbsp; &nbsp; ");}?>

                         <?
                          if($a_listorder[$x]==1){
                            if($a_ccnt[$x]==0){ //하위목록이 없으면 빈칸
                        ?>
                                <!--<i class="fas fa-caret-up" style="visibility:hidden;"></i>-->
                        <?
                            }else{
                         ?>
                                <!--<a class="btn_lvl" style="cursor:pointer" lvl="<?=$lvl_top?>">
                                  <i class="fas fa-caret-up"></i>
                                </a>-->
                         <?}
                          }?>

   <?if(($a_listcontent[$x]=="")&&($a_youtube[$x]=="")&&($a_qcnt[$x]==0)&&($a_files[$x]==0) ){ //내용이 없음?>
     <a href="/view?list=<?=$a_list[$x]?>">
       <span style="color:#999"><?=$a_listtitle[$x]?></span>
     </a>
   <?}else{?>
   <a href="/view?list=<?=$a_list[$x]?>">
     <?=$a_listtitle[$x]?>

           <?if ($a_qcnt[$x]>0){ ?>
           <span class="ct-docs-sidenav-q-badge"><?for($y=1;$y<$a_listorder[$x];$y++){echo("");}?>
             <?=$a_qcnt[$x]?>문제
           </span>
           <?}?>

   </a>
  <? } ?>

</div>
<?}?>
<div class="pp-sidebardiv nohover"></div>

</nav>
</div>
<!--
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

<?php if($list!=""){ ?>
$(function(){

  $sidebar = $(".pp-sidebar");
  $window = $(window);
  var sidebarOffset = $sidebar.offset();

    //console.log(sidebarOffset.bottom + ":" + $(".pp-sidebardiv[list='<?=$list?>']").offset().top);
    $('.pp-sidebar').animate({
        scrollTop: $(".pp-sidebardiv[list='<?=$list?>']").offset().top -150
    }, 'fast');
});
<?php } ?>

</script>
-->
