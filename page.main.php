<?php include_once("page.wraptop.php");?>
<? $question_filedown="true"?>
<?php include_once("page.nav.php");?>
<div class="col-lg-9 col-md-9 col-sm-12 pp-mainpage">
<?php include_once("page.adm.btns.php");?>


<?php if($is_admin){ //드래그앤드롭?>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <script>
 $( function() {
   $( ".draggable" ).draggable({ revert: false, helper: "clone", opacity:0.5 });
   $( ".droppable" ).droppable({
     drop: function( event, ui ) {
       $( this )
         var child_list=ui.draggable.attr("list");
         var parent_list=$(this).attr("list");
         //console.log('Dropped');

         //$(this).addClass( "ui-state-highlight" );

         if((child_list!=""&&parent_list!="")&&(child_list!=parent_list)){

           var listtitle=$(".listtitle[list='"+parent_list+"']").text();

           if(confirm(listtitle + " 하위목록으로 이동할까요?")){
             $.ajax({
                    type : "POST",
                    async:false,
                    url : "/page_save.php",
                    data : {mode:"dragdrop", child_list:child_list, parent_list:parent_list },
                    error : function(){
                        //alert('error');
                    },
                    success : function(data){
                        //console.log(data);
                        location.reload();
                    }
              });
          }

         }
         //$("#pidx").val(idx).prop("selected", true);
         //.addClass( "ui-state-highlight" );
         //.find( "p" )
         //  .html( "Dropped!" );
     }
   });
 } );
 </script>
<?php } ?>



          <section>
            <div class="ct-docs-page-title">
              <?php if($total_type==$list){?>
              <?php }else{?>
                    <div class="ct-docs-page-h1-title"><?=$page_title?></div>
                    <?php if($page_fulltitles!=""){?>
                    <nav aria-label="breadcrumb">
                    <ol class="breadcrumb"><li class="breadcrumb-item active" aria-current="page"><?=$page_fulltitles?></li></ol>
                    </nav>
                <?php } ?>
                <?php if($page_title!=""){$page_title_hr=true;} ?>
              <?php }?>
            </div>
            <?php if($page_title_hr){?><hr class="ct-docs-hr"><?}?>
          </section>


          <section>
            <?php if($page_titleimg!=""){?>
            <div class="text-left p-1">
              <img src="<?=G5_DATA_URL?><?=$page_titleimgpath?><?=$page_titleimg?>" border="0" height=50>
            </div>
            <?php } ?>

                  <?php if(trim(strip_tags($page_content,'<img>'))!=""){   ////내용에 글 또는 이미지가 있는가?>
                  <div>
                    <?=$page_content?>
                  </div>
                  <?php } ?>

                  <?php if($page_youtube!=""){?>
                    <?php
                      if(strpos($page_youtube, "?v=")>0){$onlytag=substr($page_youtube, strrpos($page_youtube, "?v=")+3);
                      }else{$onlytag=substr($page_youtube, strrpos($page_youtube, "/")+1);}
                    ?>
                    <style>
                    /* Youtube fullpage */
                    .ytLandscape {
                        position: relative;
                        padding-bottom: 56.25%;
                    }
                    .ytLandscape iframe {
                        position: absolute;
                        width: 100%;
                        height: 100%;
                        left: 0;
                        right: 0;
                    }
                    </style>
                    <div class="ytLandscape">
                      <iframe
                        width="560"
                        height="315"
                        src="https://www.youtube.com/embed/<?=$onlytag?>"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                      </iframe>
                    </div>

                  <?php } ////////////////////////유튜브?>


                  <?php ////////////첨부파일
                    $sql="select * from tb_page_files where list='$list' order by in_date";
                    $result=sql_query($sql);
                    for($i=0;$rs=sql_fetch_array($result);$i++){
                      $ext = substr(strrchr($rs['fileorgname'], '.'), 1);
                  ?>
                    <?if(strtolower($ext)=="pdf"){?>
                    <div><iframe style="width:100%;height:500px;" src="pdfviewer/viewer.html?file=/data<?=$rs["filepath"]?><?=$rs["filename"]?>"></iframe></div>
                    <?}?>
                    <div><input type=button class="btn btn-sm btn-light shadow-sm" value="다운로드" onclick="js_filedown('data<?=$rs["filepath"]?><?=$rs["filename"]?>','<?=$rs["fileorgname"]?>')"><?=$rs["fileorgname"]?></div>
                  <?php
                    }
                  ?>
          </section>



          <?php include_once("page.main.listview.php")?>


          <section>

            <?php
              $sql="select * from tb_exam where list='$list'";
              $result=sql_fetch($sql);
              $is_cbt=$result["is_cbt"];
              if($is_cbt==1){
            ?>
              <div class="px-1 py-1">* CBT(Computer Based Test) 양식으로 새창에서 문제를 풉니다.</div>
              <div class="text-center">
                  <a href="/cbt?list=<?=$list?>" class="btn w-40 bg-gradient-primary" target="_blank">    CBT 문제풀기     </a>
              </div>
          <?php }else{ ?>
                <?php include_once("page.qview.detail.php") ?>
          <?php } ?>
          </section>



          <?php
          $now_list_i=array_search($list, $a_list);
          $pre_list=$a_list[$now_list_i-1];
          $post_list=$a_list[$now_list_i+1];

          $pre_title=$a_title[$now_list_i-1];
          $post_title=$a_title[$now_list_i+1];
          //echo($now_list);
          ?>
          <?php if($pre_list!=""&&$post_list!=""){?>
          <hr color="#ccc">
          <div class="m-2 pb-4 position-relative">
            <?php if($pre_list!=""){?>
            <div class="start-0"><a href="page?<?=$pre_list?>" class="text-black"> <i class="fas fa-chevron-circle-left"></i> 이전 : <?=$pre_title?></a></div>
            <?php } ?>

            <?php if($post_list!=""){?>
            <div class=" end-0"><a href="page?<?=$post_list?>" class="text-black"> <i class="fas fa-chevron-circle-right"></i> 다음 : <?=$post_title?></a></div>
            <?php } ?>
          </div>
          <?php } ?>


        </div><!--pp-mainpage-->

<?php include_once("page.wrapbottom.php");?>
