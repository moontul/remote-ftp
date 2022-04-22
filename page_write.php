<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');
include_once(G5_EDITOR_LIB);
@include_once("./page.head.php");
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


<?php include_once("page.wraptop.php"); ?>
    <?php include_once("./page.nav.php"); ?>

<?php //tb_page를 편집, 수정, 삭제하는 부분
  $edit_list=$_GET["edit_list"]; //list값이 있으면 수정, 복제, 삭제 없으면 삽입
  if($edit_list==""){

      $titlemsg=" 하위목록 만들기";
      $list=$_GET["list"]; //이 list를 부모로 해서 새로운 것 인서트
      $sql="select * from tb_page where list='$list'";
      $rs=sql_fetch($sql);

      $edit_type=$rs["type"];
      $edit_code=$rs["code"];

      $edit_pidx=$rs["idx"];
      $edit_fullidx="".$rs["fullidx"]."[".$edit_pidx."]";

      $edit_lvl=$rs["lvl"]+1;

  }else{

    $titlemsg=" 내용편집";
    $sql="select * from tb_page where list='$edit_list'";
    $rs=sql_fetch($sql);
    $edit_isopen=$rs["isopen"];
    $edit_title=$rs["title"];
    $edit_titleorder=$rs["titleorder"];
    $titleicon=stripslashes($rs["titleicon"]);
    $edit_titleicon=str_replace("\"","&quot;",$titleicon);


    $edit_content=$rs["content"];
    $edit_type=$rs["type"];
    $edit_code=$rs["code"];

    $edit_pidx=$rs["pidx"];
    $edit_idx=$rs["idx"];
    $edit_fullidx=$rs["fullidx"];
    $edit_lvl=$rs["lvl"];

    $edit_youtube=$rs["youtube"];
    $edit_issublist=$rs["issublist"];
    $edit_pageid=$rs["pageid"];
  }
  if($edit_isopen==""){$edit_isopen="1";}

?>
<div class="col-lg-9 col-md-9 col-sm-12 pp-mainpage">
  <?php include_once("page.adm.btns.php");?>


      <div class="ct-docs-page-title">
        <span class="ct-docs-page-h1-title">
          <?=$page_title?> <sub><?=$titlemsg?></sub>
        </span>
      </div>
      <hr>


      <form name=f method="post" action="./page_save.php" enctype="MULTIPART/FORM-DATA">

      <input type=hidden name=list  value="<?=$edit_list?>" size=5>
      <input type=hidden name=type  value="<?=$edit_type?>" size=5>
      <input type=hidden name=code  value="<?=$edit_code?>" size=5>
      <input type=hidden name="lvl" value="<?=$edit_lvl?>" size=5>

      <input type=hidden name=fullidx value="<?=$edit_fullidx?>">

      <input type=hidden name=mode value="">
      <table width=100%>
      <tr>
      <td class="f16 fw7" style="width:100px;">목록</td>
      <td><div class="d-flex">
            <div class="col-8"><input type=text name=title value="<?=$edit_title?>" class="form-control"></div>
            <div class="col-2 text-center pt-2 text-secondary">
              (순서정렬)
            </div>
            <div class="col-2">
              <input type=text name=titleorder value="<?=$edit_titleorder?>" class="form-control">
            </div>
          </div>
      </td>
      </tr>
      <tr>
      <td class="f16 fw7" class="droppable">
        부모목록
      </td>
      <td>
        <div class="d-flex">
          <div class="w-75">
<?php include_once("page.listall.query.php");?>
        <select name="pidx" id="pidx" class="form-control droppable">
            <option value="<?=$edit_pidx?>">(TOP목록)</option>
        <?php
          $result=sql_query($sql_listall);
          for($yy=0;$rs=sql_fetch_array($result);$yy++){
          ?>
          <option value="<?=$rs["idx"]?>"  <?=((int)$edit_pidx==(int)$rs["idx"])?'selected':''?> ><?=$rs["tabtitle"]?></a></option>
          <?
            }
          ?>


        <?php
          for($i=0;$i<count($a_idx);$i++){
          if( (int)$idx!=(int)$a_idx[$i] ){
          ?>
            <option value="<?=$a_idx[$i]?>"
              <?=((int)$edit_pidx==(int)$a_idx[$i])?'selected':''?>
            >
            <?for($y=0;$y<$a_lvl[$i];$y++){echo("&nbsp;");}?>
            <?=$a_tabtitle[$i]?>
            </option>
          <?}
          }?>
        </select>
      </div>

        <div class="w-25">
          <input type=button value="최근사용" class="btn btn-sm p-1 pt-2 pb-2 mt-1" onclick="$('#pidx').val('<?=$_COOKIE['PANGPANG_PIDX']?>').prop('selected',true);" pidx="<?=$_COOKIE['PANGPANG_PIDX']?>">
        </div>
        </div>

      </td>
      </tr>
      <tr>
      <td class="h6 f16 fw7">공개여부</td>
      <td>
        <div class="d-flex">
          <div class="col-6">
                      <div class="form-check d-inline-block">
                        <input class="form-check-input cursor-pointer" type="radio" name="isopen" style="margin:0;margin-top:4px;"
                         value="1" <?=($edit_isopen=="1")?"checked":""?> id="isopen1"><label class="form-check-label"
                         for="isopen1">공개</label></div>
                      <div class="form-check d-inline-block">
                        <input class="form-check-input cursor-pointer" type="radio" name="isopen" style="margin:0;margin-top:4px;" value="0" <?=($edit_isopen=="0")?"checked":""?> id="isopen0" >
                        <label class="form-check-label" for="isopen0">
                          비공개
                        </label>
                      </div>
          </div>
          <div class="col-6">
              <div class="d-inline-block w-auto">
                 <span class="h6 f16 fw7">하위뷰</span>
                 <div class="form-check d-inline-block">
                   <input class="form-check-input cursor-pointer" type="radio" name="issublist" style="margin:0;margin-top:4px;" value="card" <?=($edit_issublist=="card")?"checked":""?> id="issublist1" >
                   <label class="form-check-label" for="issublist1">카드</label>
                 </div>
                 <div class="form-check d-inline-block">
                   <input class="form-check-input" type="radio" name="issublist" style="margin:0;margin-top:4px;" value="list" <?=($edit_issublist=="list")?"checked":""?> id="issublist2" >
                   <label class="form-check-label" for="issublist2">목록</label>
                 </div>
               </div>
               <div class="d-inline-block w-auto text-right">
                   <span class="h6 f16 fw7">페이지ID</span>
                   <input type=text size=5 name="pageid" value="<?=$edit_pageid?>" class="d-inline form-control form-control-sm w-auto">
               </div>
          </div>
        </div>
      </td>
      </tr>

      <tr>
      <td class="f16 fw7">대표이미지</td>
      <td>
        <?php if($page_titleimg!=""){ ?>
          <div class="ms-3 me-3">
          <img src="<?=G5_DATA_URL?><?=$page_titleimgpath?><?=$page_titleimg?>" width=50 border=0><input type="checkbox" name="titleimg_del"
            value="<?=$page_titleimgpath?><?=$page_titleimg?>">이미지 삭제
          <input type="hidden" name="titleimg" value="<?=$page_titleimg?>">
          <input type="hidden" name="titleimgpath" value="<?=$page_titleimgpath?>">
          </div>
        <?php } ?>
        <input type="file" name="titleimg_up" class="form-control">
      </td>
      </tr>

      <?php //iconpicker ?>

      <tr>
      <td class="f16 fw7">아이콘</td>
      <td>
        <link rel="stylesheet" href="<?=G5_THEME_URL?>/assets/iconpicker/assets/fonts/all.css">
        <link rel="stylesheet" href="<?=G5_THEME_URL?>/assets/iconpicker/assets/css/style.css">
            <div class="icon-picker-wrap" id="icon-picker-wrap"></div>


            <span class="d-none icon-none" title="None"><i class="fas fa-ban"></i></span>
            <div class="input-group">
              <?php if($titleicon==""){$titleicon="fas fa-search";} ?>
              <span id='select-icon' class="input-group-text select-icon cursor-pointer" title="아이콘 선택"><i class="<?=$titleicon?>"></i></span>
              <input type=text name=titleicon id=titleicon value="<?=$edit_titleicon?>" class="form-control">
            </div>


                	<script src="<?=G5_THEME_URL?>/assets/iconpicker/assets/js/aesthetic-icon-picker.js"></script>
                	<script>

                		var newIcon = {
                			"material":{
                				"regular":{
                					"list-icon":"",
                					"icon-style":"mt-regular",
                					"icons":["some","some2"],
                				}
                			}
                		}


                		AestheticIconPicker({
                			'selector': '#icon-picker-wrap', // must be an ID
                			'onClick': '#select-icon',  // must be an ID
                			"iconLibrary": newIcon
                		});

                	</script>





      </td>
      </tr>
      <tr>
      <td class="f16 fw7" valign=top>내용</td>
      <td><?php echo editor_html('content', get_text(($edit_content), 0)); ///////html_purifier?></td>
      </tr>

      <tr>
      <td class="f16 fw7">YOUTUBE</td>
      <td><input type=text name=youtube class="form-control" value="<?=$edit_youtube?>"></td>
      </tr>

      <tr>
      <td class="f16 fw7">첨부파일</td>
      <td>
        <input type=file name="fileup" class="form-control" value="<?=$edit_file?>">
        <?php
        if ($list!=""){
          $sql="select * from tb_page_files where list='$list'";
          $result=sql_query($sql);
          for($i=0;$rs=sql_fetch_array($result);$i++){
        ?>
          <div class="ms-2 mt-2">
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
        <input type="button" value="저장" onclick="f_check(document.f)" class="btn btn-sm bg-gradient-primary">
        <!--
        <input type=checkbox name="pangpang_write" value="checked" <?=$_COOKIE["PANGPANG_WRITE"]?> id=btn_pangpang_write> 편집모드
        -->
        <input type="button" value="돌아가기" onclick="location.href='page?<?=$list?>'" class="btn btn-light btn-sm shadow-sm">


        <? if(isset($list)){?>
          <!--
          <input type="button" value="새목록" onclick="location.href='/write?code=<?=$code?>&pidx='+document.getElementById('pidx').value" class="btn btn-sm shadow-sm">
        -->
          <input type="button" value="삭제" onclick="if(confirm('정말 삭제할까요?')){document.f.mode.value='d';document.f.submit();}" class="btn btn-secondary btn-sm shadow-sm">
        <? } ?>
      </div>

      </form>

</div>

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

  <?php echo get_editor_js('content'); ?>

  <?php //echo chk_editor_js('listcontent'); ?>
    if(f.title.value==""){alert("목록명을 입력하세요.");return false;};

//    check_field(f.listcontent, "내용을 입력하세요.");

//    if (errmsg != "") {
//        alert(errmsg);
//        errfld.focus();
//        return false;
//    }

    f.submit();
}

</script>

<?php include_once("page.wrapbottom.php"); ?>

<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
