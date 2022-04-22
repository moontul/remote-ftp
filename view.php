<?php
include_once('./_common.php');

include_once('./container.page.php');
include_once('./container.head.php');

include_once(G5_THEME_PATH.'/head.php');

if($_COOKIE["PANGPANG_WRITE"]=="checked"){
  //  goto_url("/write?list=$list");
}
?>


<!--
<link rel="stylesheet" href="/IconPicker/dist/fontawesome-5.11.2/css/all.min.css">
<link rel="stylesheet" href="/IconPicker/dist/iconpicker-1.5.0.css">
<script src="/IconPicker/dist/iconpicker-1.5.0.js"></script>
-->

<!-- wrapper -->
<div class="ct-docs-main-container">

    <?php @include_once("./list.nav.php"); ?>

    <!-- Page Content -->
    <main class="ct-docs-content-col" role="main">
    <?php if($showmode=="list"){?>

                <?php if($is_admin){?>
                          <span class="pp-adm-btns">
                            <a href="/write?list=<?=$list?>" class="badge btn btn-secondary-outline text-dark shadow-sm" title="지금 보이는 목록의 내용을 편집합니다">내용편집</a>

                            <?php if($list!=""){ ?>
                            <a href="/write?code=<?=$code?>&plist=<?=$list?>" class="badge btn btn-dark-outline text-dark shadow-sm"
                              title="지금 목록 아래에 새로운 목록을 만들어요">하위목록</a>
                            <?php } ?>
                            <a href="/qedit?list=<?=$list?>" class="badge btn btn-dark-outline text-dark shadow-sm"
                              title="새문제를 등록합니다">문제등록</a>

                            <a href="/qlist?list=<?=$list?>" class="badge btn btn-secondary-outline text-secondary shadow-sm"
                              title="등록되어 있는 문제목록을 보여줍니다">문제목록</a>

                            <?php if($is_exam==1){?>
                              <a href="/eedit?list=<?=$list?>" class="badge btn btn-secondary-outline text-secondary shadow-sm">시험수정</a>
                            <?php }else{?>
                              <a href="/eedit?list=<?=$list?>" class="badge btn btn-secondary-outline text-secondary shadow-sm">시험설정</a>
                            <?php } ?>
                          </span>
                <?}?>

      <div class="ct-docs-page-title">
        <span class="ct-docs-page-h1-title"><?=$listtitle?></span>

        <?php if($a_listorder[array_search($list, $a_list)]>1){?>
        <sub class="ms-3 text-muted"><?=$a_path[array_search($list, $a_list)];?></sub>
        <?php } ?>
      </div>

      <hr>

      <?php if(($listcontent)!=""){   ////strip_tags?>
      <div id="listcontent">
        <?php
        //  $tmp1=str_replace("<p>", "<div>", $listcontent);
        //  $tmp2=str_replace("</p>", "</div>",$tmp1 );
        //  $tmp2=$listcontent;
        ?>
        <?=$listcontent?>
      </div>
      <?php } ?>

      <?php if($youtube!=""){?>
        <?php
          if(strpos($youtube, "?v=")>0){
            $onlytag=substr($youtube, strrpos($youtube, "?v=")+3);
          }else{
            $onlytag=substr($youtube, strrpos($youtube, "/")+1);
          }
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
        $sql="select * from tb_list_files where list='$list' order by in_date";
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


      <?if($is_cbt==0){?>

            <?php include_once("qview.detail.php"); ?>


      <?}else if($is_cbt==1){ //////////////////////////////////////////////////////////////// cbt시험문제 ?>


        <?php
          //이 시험이 나와 관련있는지 검사
          $this_mb_id=""; //$member['mb_id'];
          $this_code=$code;
          $this_list=$list;
          include_once("myq.myexam.query.php");

          $result=sql_fetch($sqlq);
          //echo $sqlq;
          if($result!=""){//내용이 있으면 나와 관련있음을 의미
            //echo count($result);
            $is_my_exam=1;
            $is_my_exam_result=$result['my_cnt']; //시험을 봤으면 문제수만큼 결과값이 있음
            //이미 시험을 봤는지 검사
          }
        ?>


            <?php
          if(($is_admin)||($is_my_exam==1)){ /// 내가 볼 수 있는 시험이면

            $sqltmp="select count(*) as cnt from tb_answerlog A where mb_id='".$member['mb_id']."' and list='$list' ";
            $rstmp=sql_fetch($sqltmp);
            ?>

            <a href="/cbt?code=<?=$code?>&list=<?=$list?>" target="_blank" class="btn btn-primary btn-sm">  시험보기  </a>

            <?php if($is_my_exam_result>0){ //시험결과 있으면?>
              <a href="/mycbt?code=<?=$code?>&list=<?=$list?>" class="btn btn-light btn-sm shadow-sm text-white">시험결과보기</a>
            <?php }
          } //내가 볼 수 있는 조검 검색 종료
            ?>


                  <?php if($is_admin){ ?>
                      <hr>

                      <div class="alert alert-primary text-white font-weight-bold" role="alert">
                        cbt시험으로 설정되어 사용자들은 아래 문제가 보이지 않습니다.
                      </div>

                      <?php include_once("qview.detail.php"); ?>


                  <?php } ?>

      <?}?>


      <?php
      $now_list_i=array_search($list, $a_list);
      $pre_list=$a_list[$now_list_i-1];
      $post_list=$a_list[$now_list_i+1];

      $pre_listtitle=$a_listtitle[$now_list_i-1];
      $post_listtitle=$a_listtitle[$now_list_i+1];
      //echo($now_list);
      ?>

      <hr color="#ccc">
      <div class="m-2 position-relative">
        <?php if($pre_list!=""){?>
        <div class="start-0"><a href="view.php?list=<?=$pre_list?>" class="text-secondary"> <i class="fas fa-chevron-circle-left"></i> 이전 : <?=$pre_listtitle?></a></div>
        <?php } ?>

        <?php if($post_list!=""){?>
        <div class=" end-0"><a href="view.php?list=<?=$post_list?>" class="text-secondary"> <i class="fas fa-chevron-circle-right"></i> 다음 : <?=$post_listtitle?></a></div>
        <?php } ?>
      </div>



<?php }else{ //////////////////////////////////////////////////////////////////////////////////// code부분 컨테이너 영역 view ?>

    <?if($is_admin){?>
      <span class="pp-adm-btns">
        <a href="/edit?code=<?=$code?>" class="badge btn btn-outline-dark btn-sm shadow-sm text-dark"><?=$this_type?> 수정</a>
        <a href="/write?code=<?=$code?>" class="badge btn btn-outline-light btn-sm shadow-sm text-dark">새 목록</a>
        <a href="/eedit?code=<?=$code?>" class="badge btn btn-outline-secondary btn-sm shadow-sm text-dark">전체시험설정</a>
      </span>
    <?}?>

      <div class="ct-docs-page-title">

          <span class="ct-docs-page-h1-title"><?=$title?></span>

          <?php if(isset($is_subtitle)){?>
              <?=$subtitle?>
          <?php } ?>
      </div>
      <?php if($titleimg!=""){?>
      <div class="text-center p-3">
        <img src="<?=G5_DATA_URL?><?=$imgpath?><?=$titleimg?>" border="0" width=200>
      </div>
    <?php } ?>

    <div class="f15 f5" >
      <?=$content?>
    </div>

      <hr>


      <div class="margin-top-20">
      <?php
        //tb_container에 있는 0단계 목록을 보여줌
        $sqltmp="select listtitle, list from tb_list where code='$code' and pidx=0 order by listtitle";
        $resulttmp=sql_query($sqltmp);

        for($i=0;$rstmp=sql_fetch_array($resulttmp);$i++){
          echo("<div style='height:30px'><a href='/view?list=".$rstmp["list"]."'>".$rstmp["listtitle"]."</a></div>");
        }
       ?>
      </div>


      <?php //이 코드에 해당하는 시험설정 부분 호출 container.head에 설정되어 있음?>
        <?php if($is_test==1||$is_cbt==1){?>
          <hr>
        <?php } ?>
        <?php if($is_test==1){?>
          <a href="/qview?v=all&code=<?=$code?>" class="btn btn-sm btn-pp-outline-pink shadow-sm">전체 문제 풀어보기</a>
        <?php } ?>

        <?php if($is_cbt==1){?>
          <a href="/cbt?code=<?=$code?>" class="btn btn-sm btn-pp-outline-pink shadow-sm" target='_blank'>CBT 문제풀기</a>
        <?php } ?>


      <?php ///////=$is_link_buttons?>



<?php }?>
    </main><!--/ Page Content -->

</div><!-- /wrapper -->






<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
