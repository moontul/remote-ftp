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

      <div class="cd-dotc-page-title">
        <span class="ct-docs-page-h1-title">
          목록으로 변환합니다
        </span>
      </div>
      <form name=f method="post" action="./code2listsave.php" enctype="MULTIPART/FORM-DATA">
      <input type=hidden name=targetcode value="<?=$code?>">
      <input type=hidden name=mode>

      <table width=100% style="max-width:800px">
      <tr>
      <td>
        <span class="f16 fw7">
          <?=$this_menu?>
        </span>
      </td>
      </tr>
      <tr>
      <td>
<?php
  $sql="select * from tb_container order by type, title, subtitle";
  $result=sql_query($sql);
?>
        <select name=destcode id=destcode class="form-control text-primary">
        <option value="">:::어느 곳에 목록으로 변환할지 선택하세요:::</option>
<?php
  for($i=0;$rs=sql_fetch_array($result);$i++){
    if($rs["code"]==$code){
        $title=$rs["title"];
        $subtitle=$rs["subtitle"];
        $content=$rs["content"];

        $titleimg=$rs["titleimg"];
        $imgpath=$rs["imgpath"];

    }else{
?>
        <option value="<?=$rs["code"]?>">[<?=$rs["type"]?>] <?=$rs["title"]?> <?=$rs["subtitle"]?></option>
<?php
    }
  }
?>
        </select>
      </td>
      </tr>
      <tr><td>기존 이름 → 목록 이름</td></tr>
      <tr><td><input type=text name=listtitle class="form-control" value="<?=$title?> <?=$subtitle?>"></td></tr>
      <tr><td>기존 내용 → 목록 내용</td></tr>
      <tr>
      <td>
        <textarea name=listcontent class="form-control"><?=$content?></textarea>
      </td>
      </tr>
      <tr><td>이미지 정보</td></tr>
      <tr><td><input type=text name=listtitleimg class="form-control" value="<?=$titleimg?>">
      <input type=text name=listtitleimgpath class="form-control" value="<?=$imgpath?>"></td></tr>

      </table>

      <div class="mt-3 text-center">
        <input type="button" value="저장" onclick="chkf()" class="btn btn-dark btn-sm shadow-sm">
        <input type="button" onclick="location.href='/view?code=<?=$code?>'" value="목록" class="btn btn-light btn-sm shadow-sm">
      </div>
      </form>
    </main>

<script>
function chkf(){
  if( $("#destcode").val()=="" ){
    alert("어느 곳으로 변환할지 선택하세요.");
    $("#destcode").focus();
    return;
  }

  if(confirm('정말 변환할까요?')){
    document.f.submit();
  }

}
</script>





</div><!-- /wrapper -->
<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
