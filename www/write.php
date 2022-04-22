<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');

include_once('./container.head.php');
?>

<!-- container -->
<div class="container">
  <!-- wrapper -->
  <div class="pp-wrapper">

    <?php include_once("./list.nav.php"); ?>

    <!-- Page Content -->
    <div id="content" style="width:100%;margin:10px;">

      <?php setcookie("PANGPANG_WRITE", "checked"); ?>

      <div class="float-right">
        <input type=checkbox <?=$_COOKIE["PANGPANG_WRITE"]?> id=btn_pangpang_write> 편집모드
      </div>

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
        <select name="pidx" class="form-control">
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

      <tr>
      <td class="f16 fw7" valign=top>내용</td>
      <td><textarea name=listcontent rows=10 class="form-control"><?=$listcontent?></textarea></td>
      </tr>
      </table>

      <div style="text-align:center">
        <br>
        <input type="submit" value="저장" class="btn btn-secondary">

        <? if(isset($list)){?>
          <input type="button" value="새목록" onclick="location.href='/write?code=<?=$code?>'" class="btn">

          <input type="button" value="삭제" onclick="if(confirm('정말 삭제할까요?')){document.f.mode.value='d';document.f.submit();}" class="btn">
        <? } ?>
      </div>

      </form>

    </div><!--/ Page Content -->
  </div><!-- / wrapper -->
</div><!-- /container -->
[]
<script>
//편집모드
$("#btn_pangpang_write").click(function(){
    if($(this).attr("checked")=="checked"){
      set_cookie("PANGPANG_WRITE","checked");
    }else{
      set_cookie("PANGPANG_WRITE","");
    }
})

</script>

<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
