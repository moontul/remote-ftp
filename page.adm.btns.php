<?php if($is_admin) { ?>
  <span class="pp-adm-btns e-0">
<!--
L:<?=$list?> &nbsp;
T:<?=$total_type?> &nbsp;
C:<?=$total_code?>
-->
    <a href="/page_write?list=<?=$page_list?>&edit_list=<?=$page_list?>" class="badge btn btn-outline-dark btn-sm shadow-sm bg-white text-dark">
    <?=mb_substr($page_title,0,6)?> &nbsp;
    <i class="fas fa-edit"></i>내용편집</a>

  <!--
  <a href="/page_write?list=<?=$page_list?>" class="badge btn btn-outline-dark btn-sm shadow-sm text-dark"> [<?=mb_substr($page_title,0,6)?>] 하위 목록 만들기</a>
  -->
  <?php if($_REQUEST["qcode"]!=""){?>
  <a href="/page_qedit?list=<?=$page_list?>" class="badge btn btn-outline-dark btn-sm shadow-sm bg-white text-dark"><i class="fas fa-pen"></i>새문제</a>
  <?php } ?>

  <a href="/page_q?list=<?=$page_list?>" class="badge btn btn-outline-dark btn-sm shadow-sm bg-white text-dark"><i class="fas fa-pen-square"></i> 문제</a>

  <!--
  <a href="/page_eedit?list=<?=$page_list?>" class="badge btn btn-outline-dark btn-sm shadow-sm text-dark">시험</a>
  -->

  <?php if($list==""){ ?>
    <a href="/page_write?list=0" class="badge btn btn-outline-dark btn-sm bg-white text-dark" title="목록 추가"><i class="fas fa-plus-circle"></i> 목록추가 </a>
  <?php }else{?>
    <a href="/page_write?list=<?=$list?>" class="badge btn btn-outline-dark btn-sm bg-white text-dark" title="목록 추가"><i class="fas fa-plus-circle"></i> 목록추가 </a>
  <?php } ?>

  <?php if($total_type==""&&$total_type==""&&$total_type==""){?><?}else{?>
    <?php if($total_code!=""){?>
      <a href="/page_ledit?list=<?=$total_code?>" class="badge btn btn-outline-dark btn-sm bg-white text-dark" title="목록 편집"><i class="fas fa-list"></i> 목록편집 </a>
    <?php } ?>
  <?}?>

  <?php if($list!=""){ ?>
    <a href="/page" class="badge btn btn-outline-secondary btn-sm shadow-sm bg-white text-secondary">목록TOP</a>

  <?php } ?>

</span>
<?php } ?>
