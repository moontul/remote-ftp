<?php
include_once('./_common.php');

include_once("./container.page.php");
include_once('./container.head.php');

include_once(G5_THEME_PATH.'/head.php');


?>

<!-- wrapper -->
<div class="ct-docs-main-container">
    <?php include_once("./list.nav.php"); ?>

    <main class="ct-docs-content-col" role="main">


      <form name=f method="post" action="./save.php" enctype="MULTIPART/FORM-DATA">
      <input type=hidden name=code value="<?=$code?>">
      <input type=hidden name=mode>

      <table width=100% style="max-width:800px">
      <tr>
      <td colspan=3>
        <span class="f16 fw7">
          <?=$this_menu?>
        </span>
      </td>
      </tr>
      <tr>
      <td  colspan=3><input type=text name=title value="<?=$title?>" class="form-control"></td>
      </tr>
      <?php if(isset($is_subtitle)){?>
      <tr>
      <td colspan=3 class="f16 fw7"><?=$is_subtitle?></td>
      </tr>
      <tr>
      <td colspan=3><input type=text name=subtitle value="<?=$subtitle?>" class="form-control"></td>
      </tr>
      <?php
      }
      ?>
      <tr>
      <td class="f16 fw7">대표이미지</td><td class="f16 fw7">공개여부</td><td class="f16 fw7">메뉴위치</td>
      </tr>
      <tr>
      <td>
        <div class="d-flex">
          <?php if($titleimg!=""){ ?>
            <div class="ms-3 me-3">
            <img src="<?=G5_DATA_URL?><?=$imgpath?><?=$titleimg?>" width=50 border=0><input type="checkbox" name="titleimg_del" value="<?=$imgpath?><?=$titleimg?>">이미지 삭제
            <input type="hidden" name="titleimg" value="<?=$titleimg?>">
            <input type="hidden" name="imgpath" value="<?=$imgpath?>">
            </div>
          <?php } ?>
            <div>
              <input type=file name=titleimg_up class="form-control">
            </div>
        </div>
      </td>
      <td>
        <input type=radio name=is_open value=1 <?=($is_open==1)?"checked":""?>>공개 <input type=radio name=is_open value=0 <?=($is_open==0)?"checked":""?>>비공개
      </td>
      <td>
        <input type=text name=type  class="form-control" value="<?=$this_type?>">
      </td>
      </tr>

      <tr>
      <td colspan=3 class="f16 fw7">내용</td>
      </tr>
      <tr>
      <td colspan=3><textarea name=content style="width:100%" rows=10 class="form-control"><?=$content?></textarea>
      </td>
      </tr>
      </table>

      <div class="mt-3 text-center">
        <input type="submit" value="저장" class="btn btn-dark btn-sm shadow-sm">
        <input type="button" onclick="location.href='/view?code=<?=$code?>'" value="목록" class="btn btn-light btn-sm shadow-sm">
        <? if(isset($code)){ ?>
        <input type="button" value="삭제" class="btn btn-secondary btn-sm shadow-sm" onclick="if(confirm('정말 삭제할까요?\n\n주의!! 연결된 목록도 모두 삭제됩니다!')){document.f.mode.value='d';document.f.submit()}">


            &nbsp; <a href="code2list.php?code=<?=$code?>">목록으로 변경하기</a>
      <? } ?>
      </div>

      </form>


    </main>
</div><!-- /wrapper -->
<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
