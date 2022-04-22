<?php
include_once('./_common.php');
$this_menu="오답노트";
include_once(G5_THEME_PATH.'/head.php');
?>

<?php
  $qs=$_SERVER['QUERY_STRING'];
  if($qs=="today"){
    $this_title="오늘 틀린 문제";
  }elseif($qs=="star"){
    $this_title="중요 표시 문제  <sub class='ms-2'>별표한 문제만 볼 수 있어요</sub>";
  }elseif($qs=="bad"){
      $this_title="자꾸 틀리는 문제 <sub class='ms-2'>많이 틀린 순서대로 볼 수 있어요</sub>";
  }else{
    $this_title="타임라인 <sub class='ms-2'>내가 푼 문제를 날짜 시간 순으로 볼 수 있어요</sub>";
  }
?>
<!-- wrapper -->
<div class="ct-docs-main-container" >
  <?php @include_once("./myq.nav.php"); ?>
  <main class="ct-docs-content-col" style="background-image:url('<?=G5_THEME_URL?>/assets/img/notebg2.jpg');padding-right:15px;">
    <div class="ct-docs-page-title" style="padding-top:15px;border-bottom:1px solid #999999">
      <span class="ct-docs-page-h1-title"><?=$this_title?></span>
    </div>

<?php

if($is_member){ /////////////////////////////////////////////////// 로그인 되어 있을 경우 디비 쿼리

    $member_id=$member['mb_id'];
    $sqlq_prepare="select B.qnum as qnum, qtype, A.qcode as qcode, qtext, qtextsub, qimg, B.imgpath, is_compiler
      , qm1text, qm2text, qm3text, qm4text, qm5text
      , qm1img, qm2img, qm3img, qm4img, qm5img
      , qm1correct, qm2correct, qm3correct, qm4correct, qm5correct
      , qanswer, qessay, qexplain
      , A.anum as u_anum
      , A.answer as u_answer
      , A.essay as u_essay
      , A.opt1 as u_opt1
      , (DATE_FORMAT(A.in_date,'%Y/%m/%d %H:%m')) as my_in_date
      , listtitle
      , title
      , counttrue, countfalse, A.list as list, C.code as code
      , star
      from tb_answerlog A, tb_question B, tb_list C, tb_container D
      where A.qcode=B.qcode and A.mb_id='$member_id' and A.list=C.list and C.code=D.code ";

    if($qs=="today"){
      $sqlq_prepare.="  and A.countfalse>=0 and DATE_FORMAT(A.in_date, '%Y-%m-%d') = CURDATE() ";
    }else if($qs=="star"){
      $sqlq_prepare.=" and A.star=1";
    }else if($qs=="bad"){
      $sqlq_prepare.="  and A.countfalse>=0 order by A.countfalse desc, A.in_date desc";
    }else{
      $sqlq_prepare.="  and A.countfalse>=0  order by A.in_date desc";
    }

    $is_myq="timeline";
    //  echo($sqlq_prepare);

}else{ ///////////////////////// 로그인안되었을경우 쿠키사용

    if (isset($_COOKIE['pangd'])) {
          foreach ($_COOKIE['pangd'] as $name => $value) {

              $name = htmlspecialchars($name);
              $value = htmlspecialchars($value);

              //echo "$name : $value :";  코드 시간
              //echo $_COOKIE['panga'][$name]." : "; anum
              //echo $_COOKIE['pangn'][$name]." : "; answer
              //echo $_COOKIE['pange'][$name]." : "; essay
              //echo $_COOKIE['pangs'][$name]." : "; star
                  $user_in_date.=" when QT.qcode='$name' then DATE_FORMAT(FROM_UNIXTIME($value), '%Y-%m-%d %H:%i:%S') ";

                  $my_count_false=$_COOKIE['pangx'][$name]; if($my_count_false==""){$my_count_false=0;}
                  $user_count_false.=" when QT.qcode='$name' then $my_count_false ";

                  $my_star=$_COOKIE['pangs'][$name]; if($my_star==""){$my_star=0;}
                  $user_stars.=" when QT.qcode='$name' then $my_star ";

                  if( (($qs=="star")&&($my_star==1)) || ($qs=="") || ($qs=="bad") || ($qs=="today")  ){
                    if($user_qcodes==""){
                      $user_qcodes .= "'".$name."'";
                    }else{
                      $user_qcodes .= ",'".$name."'";
                    }
                  }


          }

          if($user_qcodes!=""){
          //echo $user_qcodes;
          $sqlq_prepare="select QT.qnum as qnum, qtype, QT.qcode as qcode, qtext, qtextsub, qimg, QT.imgpath, is_compiler
            , qm1text, qm2text, qm3text, qm4text, qm5text
            , qm1img, qm2img, qm3img, qm4img, qm5img
            , qm1correct, qm2correct, qm3correct, qm4correct, qm5correct
            , qanswer, qessay, qexplain
            , '' as u_anum
            , '' as u_answer
            , '' as u_essay
            , '' as u_opt1
            , (case ";
            $sqlq_prepare .= $user_in_date;
            $sqlq_prepare .= "
              end) as my_in_date
            , listtitle
            , title
            , '' as counttrue
            , (case ";
            $sqlq_prepare .= $user_count_false;
            $sqlq_prepare .= "
              end) as countfalse
            , L.list as list, C.code as code
            , (case ";
            $sqlq_prepare .= $user_stars;
            $sqlq_prepare .= "
              end) as star
            from tb_question QT, tb_qlist QL, tb_list L, tb_container C
            where QT.qcode=QL.qcode and QL.list=L.list and L.code=C.code and  QT.qcode in ($user_qcodes) ";
            if($qs=="bad"){
              $sqlq_prepare .= " order by countfalse desc ";
            }else{
              $sqlq_prepare .= " order by my_in_date desc ";
            }

            $is_myq="cookie";
          }
          //echo $sqlq_prepare;
    }

}
?>

    <?php include_once("qview.detail.php"); ?>




  </main>
</div><!-- /wrapper -->


<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
