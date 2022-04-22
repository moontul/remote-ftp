<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');

include_once('./container.head.php');

if($_COOKIE["PANGPANG_WRITE"]=="checked"){
    goto_url("/write?list=$list");
}
?>

<!-- container -->
<div class="container">
  <!-- wrapper -->
  <div class="pp-wrapper">

    <?php include_once("./list.nav.php"); ?>

    <!-- Page Content -->
    <div id="content" style="width:100%;margin:40px;">
    <?php if($showmode=="list"){?>

      <?php if($is_admin){?>
      <div class="float-right">
        <a href="/write?list=<?=$list?>" class="btn btn-secondary">내용편집</a>
        <a href="/qedit?list=<?=$list?>" class="btn btn-sm">문제등록</a>
        <?php if($is_exam==1){?>
          <a href="/eedit?list=<?=$list?>" class="btn btn-secondary btn-sm">시험수정</a>
        <?php }else{?>
          <a href="/eedit?list=<?=$list?>" class="btn btn-sm">시험생성</a>
        <?php } ?>
      </div>
      <?}?>

      <div class="f23 f9">
      <?=$listtitle?>
      </div>

      <hr>

      <?php if($listcontent!=""){?>
      <div class="f15 f5" style="min-height:100px">
      <?=$listcontent?>
      </div>
      <?php }?>

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

      <?php } ?>




      <?if($is_exam==0){?>

                        <?php
                        if(isset($list)){
                        $sqlq="select A.qnum as qnum, qtype, A.qcode as qcode, qtext, qtextsub
                          , qm1text, qm2text, qm3text, qm4text, qm5text
                          , qm1correct, qm2correct, qm3correct, qm4correct, qm5correct
                          from tb_qlist A, tb_question B where A.qcode=B.qcode and A.list='$list'";
                       }elseif(isset($code)){
                         $sqlq="select B.qnum as qnum, qtype, C.qcode as qcode, qtext, qtextsub
                          , qm1text, qm2text, qm3text, qm4text, qm5text
                          , qm1correct, qm2correct, qm3correct, qm4correct, qm5correct
                          from tb_container A, tb_qlist B, tb_question C where A.code='$code' and A.code=B.code and B.qcode=C.qcode ";
                       }
                        $resultq=sql_query($sqlq);
                        for($i=0;$rs=sql_fetch_array($resultq);$i++){
                      ?>

                      <div>
                        <div><b><?=$rs["qnum"]?></b>. <b><?=$rs["qtext"]?></b></div>
                      </div>

                      <?php if(!empty($rs["qtextsub"])){?>
                      <div style="border:1px solid #c0c0c0;padding:15px;text-align:justify;">
                        <span>
                          <b><?=nl2br($rs["qtextsub"])?></b>
                        </span>
                      </div>
                      <?php } ?>

                      <?php if($rs["qtype"]=="주관식"){?>
                      <div>
                          <input type=text><input type="button" value="정답확인">
                      </div>
                      <?php }else{?>
                              <?for($j=1;$j<5;$j++){?>
                                <div>
                                  <span style="cursor:pointer" class="qchk_answer" qcode="<?=$rs["qcode"]?>" correct="<?=$rs["qm".$j."correct"]?>">
                                    <?=$j?>. <?=$rs["qm".$j."text"]?>
                                  </span>
                                </div>
                              <?}?>
                      <?php } ?>

                                    <?php if($is_admin){?>
                                    <div class="">
                                      <a href="./qedit?list=<?=$list?>&qcode=<?=$rs["qcode"]?>"
                                        class="btn btn-secondary btn-sm">문제수정</a>
                                    </div>
                                    <?php } ?>
                        <br>

                      <?}?>

      <?}?>
      <?if($is_exam==1){?>

          <a href="/cbt?code=<?=$code?>&list=<?=$list?>" target="_blank" class="btn btn-primary">시험보기</a>

      <?}?>

<?php }else{ /////////////////////////////////////////////////////// container view ?>

    <?if($is_admin){?>
      <div class="float-right">
        <a href="/edit?code=<?=$code?>" class="btn btn-secondary btn-pp">수정</a>

        <a href="/write?code=<?=$code?>" class=btn btn-success btn-pp>새 목록</a>

        <a href="/eedit?code=<?=$code?>" class=btn btn-secondary btn-pp>시험설정</a>

      </div>
    <?}?>
      <!--
      유형 : <?=$type?>
      -->
      <div class="f23 f9">
        <?=$title?>
          <?php if(isset($is_subtitle)){?>
              <?=$subtitle?>
          <?php } ?>
      </div>

      <hr>

      <div class="f15 f5" style="min-height:300px">
        <?=$content?>
      </div>

      <?=$is_link_buttons?>



<?php }?>



    </div><!--/ Page Content -->
  </div><!-- / wrapper -->
</div><!-- /container -->

<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
