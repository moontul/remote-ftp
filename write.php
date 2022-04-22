<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');
include_once(G5_EDITOR_LIB);

include_once('./container.head.php');
?>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <script>
$( function() {
  $( "#drag_box" ).draggable({ revert: true });
  $( "#drag_box2" ).draggable({ revert: true, helper: "clone" });
} );
</script>
<script>
$( function() {
  $( ".draggable" ).draggable({ revert: false, helper: "clone" });
  $( ".droppable" ).droppable({
    drop: function( event, ui ) {
      $( this )
        var list=ui.draggable.attr('list');
        var idx=ui.draggable.attr('idx');
        console.log('Dropped ' + list + ':' + idx);

        $("#pidx").val(idx).prop("selected", true);
        //.addClass( "ui-state-highlight" )
        //.find( "p" )
        //  .html( "Dropped!" );
    }
  });
} );
</script>

<!-- wrapper -->
<div class="ct-docs-main-container">
    <?php include_once("./list.nav.php"); ?>
    <main class="ct-docs-content-col" role="main" style="">

      <div class="ct-docs-page-title" id="drag_box2">
        <span class="ct-docs-page-h1-title">
      <? if(isset($list)){?>
        <?=$listtitle?>
      <?}else{?>
        새로운 목록을 만듭니다
      <?}?>
        </span>
      </div>
      <hr>

      <form name=f method="post" action="./savelist.php" enctype="MULTIPART/FORM-DATA">
      <input type=hidden name=code value="<?=$code?>">
      <input type=hidden name=list value="<?=$list?>">
      <input type=hidden name=mode value="">
      <table width=100% style="max-width:800px">
      <tr>
      <td class="f16 fw7" style="width:100px;">목록</td>
      <td><input type=text name=listtitle value="<?=$listtitle?>" class="form-control"></td>
      </tr>
      <tr>
      <td class="f16 fw7" class="droppable">
        부모목록
      </td>
      <td>
        <select name="pidx" id="pidx" class="form-control droppable">
          <option value="0">(없음)</option>
        <?php
          for($i=0;$i<count($a_idx);$i++){
          if( (int)$idx!=(int)$a_idx[$i] ){
          ?>
            <option value="<?=$a_idx[$i]?>"
              <?=((int)$pidx==(int)$a_idx[$i])?'selected':''?>
              <?=($_GET["plist"]==$a_list[$i])?'selected':''?>
            >
            <?for($y=0;$y<$a_listorder[$i];$y++){echo(" &nbsp; ");}?>
            <?=$a_listtitle[$i]?>
            </option>
          <?}
          }?>
        </select>
      </td>
      </tr>
      <tr>
      <td class="f16 fw7" valign=top>공개여부</td>
      <td><input type="radio" name="is_open" value="1">공개 &nbsp; <input type="radio" name="is_open" value="0">비공개</td>
      </tr>

      <tr>
      <td class="f16 fw7" valign=top>내용</td>
      <td><?php echo editor_html('listcontent', get_text(html_purifier($listcontent), 0)); ?></td>
      </tr>

      <tr>
      <td class="f16 fw7">YOUTUBE</td>
      <td><input type=text name=youtube class="form-control" value="<?=$youtube?>"></td>
      </tr>

      <tr>
      <td class="f16 fw7">파일</td>
      <td>
        <input type=file name="fileup" class="form-control" value="<?=$file?>">
        <?php
        if ($list!=""){
          $sql="select * from tb_list_files where list='$list'";
          $result=sql_query($sql);
          for($i=0;$rs=sql_fetch_array($result);$i++){
        ?>
          <div class="h6 mt-2">
            <span>파일삭제 : </span>
            <span><input type=checkbox name="filedel[]" value="<?=$rs['idx']?>">&nbsp;<?=$rs['fileorgname']?></span>
            <span><input type=button value="다운로드" class="btn btn-sm btn-light shadow-sm" onclick="js_filedown('data<?=$rs["filepath"]?><?=$rs["filename"]?>','<?=$rs["fileorgname"]?>')"></span>
          </div>
        <?php
          }
        }
        ?>
      </td>
      </tr>

      </table>

      <div class="text-center">
        <br>
        <input type="button" value="저장" onclick="f_check(document.f)" class="btn btn-dark btn-sm shadow-sm">
        <input type=checkbox name="pangpang_write" value="checked" <?=$_COOKIE["PANGPANG_WRITE"]?> id=btn_pangpang_write> 편집모드
        <input type="button" value="취소" onclick="location.href=/view?list=<?=$list?>" class="btn btn-light btn-sm shadow-sm">


        <? if(isset($list)){?>
          <input type="button" value="새목록" onclick="location.href='/write?code=<?=$code?>&pidx='+document.getElementById('pidx').value" class="btn btn-sm shadow-sm">

          <input type="button" value="삭제" onclick="if(confirm('정말 삭제할까요?')){document.f.mode.value='d';document.f.submit();}" class="btn btn-secondary btn-sm shadow-sm">
        <? } ?>
      </div>

      </form>

    </main>
</div><!-- /wrapper -->

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


  <?php //echo chk_editor_js('listcontent'); ?>
    if(f.listtitle.value==""){alert("목록명을 입력하세요.");return false;};

//    check_field(f.listcontent, "내용을 입력하세요.");

//    if (errmsg != "") {
//        alert(errmsg);
//        errfld.focus();
//        return false;
//    }

    f.submit();
}

</script>

<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
