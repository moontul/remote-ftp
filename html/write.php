<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');
include_once(G5_EDITOR_LIB);

include_once('./container.head.php');
?>

<!-- container -->
<div class="container">
  <!-- wrapper -->
  <div class="pp-wrapper">

    <?php include_once("./list.nav.php"); ?>

    <!-- Page Content -->
    <div id="content" style="width:100%;margin:10px;">


      <div class="f23 f9">
      <? if(isset($list)){?>
        <?=$listtitle?>
      <?}else{?>
        새로운 목록을 만듭니다
      <?}?>
      </div>
      <hr>

      <form name=f method="post" action="./savelist.php">
      <input type=hidden name=code value="<?=$code?>">
      <input type=hidden name=list value="<?=$list?>">
      <input type=hidden name=mode value="">
      <table width=100% style="max-width:800px">
      <tr>
      <td class="f16 fw7" style="width:100px;">목록</td>
      <td><input type=text name=listtitle value="<?=$listtitle?>" class="form-control"></td>
      </tr>
      <tr>
      <td class="f16 fw7">부모목록</td>
      <td>
        <select name="pidx" id="pidx" class="form-control">
          <option value="0">(없음)</option>
        <?php

          for($i=0;$i<count($a_idx);$i++){
          if( (int)$idx!=(int)$a_idx[$i] ){
          ?>
            <option value="<?=$a_idx[$i]?>" <?=((int)$pidx==(int)$a_idx[$i])?'selected':''?>>
            <?for($y=0;$y<$a_listorder[$i];$y++){echo(" &nbsp; ");}?>
            <?=$a_listtitle[$i]?>
            </option>
          <?}
          }?>
        </select>
      </td>
      </tr>

      <!--<tr>
      <td class="f16 fw7" valign=top>내용</td>
      <td><textarea name=listcontent rows=10 class="form-control"><?=$listcontent?></textarea></td>
      </tr>-->

      <tr>
      <td class="f16 fw7" valign=top>내용</td>
      <td><?php echo editor_html('listcontent', get_text(html_purifier($listcontent), 0)); ?></td>
      </tr>



      <tr>
      <td class="f16 fw7">YOUTUBE</td>
      <td><input type=text name=youtube class="form-control" value="<?=$youtube?>"></td>
      </tr>

      </table>

      <div style="text-align:center">
        <br>
        <input type="button" value="저장" onclick="f_check(document.f)" class="btn btn-secondary">

        <!--input type=checkbox name="pangpang-write"  id=btn_pangpang_write> 편집모드-->

        <input type=checkbox name="pangpang_write" value="checked" <?=$_COOKIE["PANGPANG_WRITE"]?> id=btn_pangpang_write> 편집모드


        <? if(isset($list)){?>
          <input type="button" value="새목록" onclick="location.href='/write?code=<?=$code?>&pidx='+document.getElementById('pidx').value" class="btn">

          <input type="button" value="삭제" onclick="if(confirm('정말 삭제할까요?')){document.f.mode.value='d';document.f.submit();}" class="btn">
        <? } ?>
      </div>

      </form>

    </div><!--/ Page Content -->
  </div><!-- / wrapper -->
</div><!-- /container -->

<script>
//편집모드
$("#btn_pangpang_write").click(function(){
//    if($(this).attr("checked")=="checked"){
//      set_cookie("PANGPANG_WRITE","checked");
//    }else{
//      set_cookie("PANGPANG_WRITE","");
//    }
});

function f_check(f){

    <?php echo get_editor_js('listcontent'); ?>
    <?php echo chk_editor_js('listcontent'); ?>
//    check_field(f.co_id, "ID를 입력하세요.");
//    check_field(f.co_subject, "제목을 입력하세요.");
    check_field(f.listtitle, "목록명을 입력하세요.");
    check_field(f.listcontent, "내용을 입력하세요.");

//    if (errmsg != "") {
//        alert(errmsg);
//        errfld.focus();
//        return false;
//    }

    f.submit();
}

</script>

<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
