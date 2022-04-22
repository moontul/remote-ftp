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
    $this_title="중요 표시 문제";
  }elseif($qs=="chart"){
    $this_title="취약분석";
  }elseif($qs=="bad"){
      $this_title="자꾸 틀리는 문제 <sub class='ms-2'></sub>";
  }else{
    $this_title="타임라인 <sub class='ms-2'></sub>";
  }
?>

<?php include_once("page.wraptop.php");?>
<?php include_once("mynote.nav.php");?>
<div class="col-lg-9 col-md-9 col-sm-12 pp-mainpage shadow" style="background-image:url('<?=G5_THEME_URL?>/assets/img/notebg2.jpg');padding-right:15px;">

    <div class="ct-docs-page-title">
      <span class="ct-docs-page-h1-title"><?=$this_title?></span>
    </div>
    <hr class="ct-docs-hr">


<?php
if($qs=="chart"){
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<?php
$mb_id=$member["mb_id"];
$sql="
select mb_id
, count(*) as cnt
, sum(case when merrillx='사실' then countfalse end) as x1
, sum(case when merrillx='개념' then countfalse end) as x2
, sum(case when merrillx='절차' then countfalse end) as x3
, sum(case when merrillx='원리' then countfalse end) as x4
, sum(case when merrilly='기억' then countfalse end) as y1
, sum(case when merrilly='활용' then countfalse end) as y2
, sum(case when merrilly='발견' then countfalse end) as y3
, sum(case when merrilly='창조' then countfalse end) as y4

, sum(case when merrillx='사실' then counttrue end) as xo1
, sum(case when merrillx='개념' then counttrue end) as xo2
, sum(case when merrillx='절차' then counttrue end) as xo3
, sum(case when merrillx='원리' then counttrue end) as xo4
, sum(case when merrilly='기억' then counttrue end) as yo1
, sum(case when merrilly='발견' then counttrue end) as yo3
, sum(case when merrilly='활용' then counttrue end) as yo2
, sum(case when merrilly='창조' then counttrue end) as yo4





, sum(case when merrillx='사실' and merrilly='기억' then countfalse end) as xy11
, sum(case when merrillx='개념' and merrilly='기억' then countfalse end) as xy21
, sum(case when merrillx='절차' and merrilly='기억' then countfalse end) as xy31
, sum(case when merrillx='원리' and merrilly='기억' then countfalse end) as xy41

, sum(case when merrillx='개념' and merrilly='활용' then countfalse end) as xy22
, sum(case when merrillx='절차' and merrilly='활용' then countfalse end) as xy32
, sum(case when merrillx='원리' and merrilly='활용' then countfalse end) as xy42

, sum(case when merrillx='개념' and merrilly='발견' then countfalse end) as xy23
, sum(case when merrillx='절차' and merrilly='발견' then countfalse end) as xy33
, sum(case when merrillx='원리' and merrilly='발견' then countfalse end) as xy43

, sum(case when merrillx='개념' and merrilly='창조' then countfalse end) as xy24
, sum(case when merrillx='절차' and merrilly='창조' then countfalse end) as xy34
, sum(case when merrillx='원리' and merrilly='창조' then countfalse end) as xy44


, sum(case when merrillx='사실' and merrilly='기억' then counttrue end) as xyo11
, sum(case when merrillx='개념' and merrilly='기억' then counttrue end) as xyo21
, sum(case when merrillx='절차' and merrilly='기억' then counttrue end) as xyo31
, sum(case when merrillx='원리' and merrilly='기억' then counttrue end) as xyo41

, sum(case when merrillx='개념' and merrilly='활용' then counttrue end) as xyo22
, sum(case when merrillx='절차' and merrilly='활용' then counttrue end) as xyo32
, sum(case when merrillx='원리' and merrilly='활용' then counttrue end) as xyo42

, sum(case when merrillx='개념' and merrilly='발견' then counttrue end) as xyo23
, sum(case when merrillx='절차' and merrilly='발견' then counttrue end) as xyo33
, sum(case when merrillx='원리' and merrilly='발견' then counttrue end) as xyo43

, sum(case when merrillx='개념' and merrilly='창조' then counttrue end) as xyo24
, sum(case when merrillx='절차' and merrilly='창조' then counttrue end) as xyo34
, sum(case when merrillx='원리' and merrilly='창조' then counttrue end) as xyo44




from
(
    SELECT mb_id, A.qcode , merrillx, merrilly, countfalse, counttrue
    FROM tb_answerlog A, tb_question B
    where mb_id='$mb_id' and  A.qcode=B.qcode
) C
group by mb_id
";
$rs=sql_fetch($sql);
$labels="'사실','개념','절차','원리','기억','활용','발견','창조'";
$labelz="'사실x기억','개념x기억','절차x기억','원리x기억', '개념x활용','절차x활용','원리x활용', '개념x발견','절차x발견','원리x발견', '개념x창조','절차x창조','원리x창조' ";

$data1=$rs["x1"] . ",".$rs["x2"].",".$rs["x3"].",".$rs["x4"].",";
$data1.=$rs["y1"] .",".$rs["y2"].",".$rs["y3"].",".$rs["y4"];

$data2=$rs["xo1"] . ",".$rs["xo2"].",".$rs["xo3"].",".$rs["xo4"].",";
$data2.=$rs["yo1"] .",".$rs["yo2"].",".$rs["yo3"].",".$rs["yo4"];


$dataxy11=$rs["xy11"]; if($dataxy11==""){$dataxy11=0;}
$dataxy21=$rs["xy21"]; if($dataxy21==""){$dataxy21=0;}
$dataxy31=$rs["xy31"]; if($dataxy31==""){$dataxy31=0;}
$dataxy41=$rs["xy41"]; if($dataxy41==""){$dataxy41=0;}

$dataxy22=$rs["xy22"]; if($dataxy22==""){$dataxy22=0;}
$dataxy32=$rs["xy32"]; if($dataxy32==""){$dataxy32=0;}
$dataxy42=$rs["xy42"]; if($dataxy42==""){$dataxy42=0;}

$dataxy23=$rs["xy23"]; if($dataxy23==""){$dataxy23=0;}
$dataxy33=$rs["xy33"]; if($dataxy33==""){$dataxy33=0;}
$dataxy43=$rs["xy43"]; if($dataxy43==""){$dataxy43=0;}

$dataxy24=$rs["xy24"]; if($dataxy24==""){$dataxy24=0;}
$dataxy34=$rs["xy34"]; if($dataxy34==""){$dataxy34=0;}
$dataxy44=$rs["xy44"]; if($dataxy44==""){$dataxy44=0;}

$dataz=$dataxy11 . ",".$dataxy21.",".$dataxy31.",".$dataxy41.",";
$dataz.=$dataxy22 .",".$dataxy32.",".$dataxy42.",";
$dataz.=$dataxy23 .",".$dataxy33.",".$dataxy43.",";
$dataz.=$dataxy24 .",".$dataxy34.",".$dataxy44;



  $dataxyo11=$rs["xyo11"]; if($dataxyo11==""){$dataxyo11=0;}
  $dataxyo21=$rs["xyo21"]; if($dataxyo21==""){$dataxyo21=0;}
  $dataxyo31=$rs["xyo31"]; if($dataxyo31==""){$dataxyo31=0;}
  $dataxyo41=$rs["xyo41"]; if($dataxyo41==""){$dataxyo41=0;}

  $dataxyo22=$rs["xyo22"]; if($dataxyo22==""){$dataxyo22=0;}
  $dataxyo32=$rs["xyo32"]; if($dataxyo32==""){$dataxyo32=0;}
  $dataxyo42=$rs["xyo42"]; if($dataxyo42==""){$dataxyo42=0;}

  $dataxyo23=$rs["xyo23"]; if($dataxyo23==""){$dataxyo23=0;}
  $dataxyo33=$rs["xyo33"]; if($dataxyo33==""){$dataxyo33=0;}
  $dataxyo43=$rs["xyo43"]; if($dataxyo43==""){$dataxyo43=0;}

  $dataxyo24=$rs["xyo24"]; if($dataxyo24==""){$dataxyo24=0;}
  $dataxyo34=$rs["xyo34"]; if($dataxyo34==""){$dataxyo34=0;}
  $dataxyo44=$rs["xyo44"]; if($dataxyo44==""){$dataxyo44=0;}

  $datazo=$dataxyo11 . ",".$dataxyo21.",".$dataxyo31.",".$dataxyo41.",";
  $datazo.=$dataxyo22 .",".$dataxyo32.",".$dataxyo42.",";
  $datazo.=$dataxyo23 .",".$dataxyo33.",".$dataxyo43.",";
  $datazo.=$dataxyo24 .",".$dataxyo34.",".$dataxyo44;

?>


<script src="https://d3js.org/d3.v5.min.js"></script>
<script src="https://x3dom.org/release/x3dom.js"></script>
<!--link rel="stylesheet" href="https://x3dom.org/release/x3dom.css" /-->

<link rel="stylesheet" href="<?=G5_THEME_URL?>/xxxxx_assets/css/x3dom.css">
<!--script src="https://raw.githack.com/jamesleesaunders/d3-x3d/master/dist/d3-x3d.js"></script-->
<script src="<?=G5_THEME_URL?>/assets/js/d3-x3d.js"></script>

<div id="chartholder" style="margin:0 auto;width:100%"></div>
<script>

// Select chartholder
var chartHolder = d3.select("#chartholder");

// Generate some data
var myData = [
 {
   key: "사실",
   values: [
    { key: "기억", value: <?=$dataxy11?> }
   ]
 },
 {
   key: "개념",
   values: [
     { key: "창조", value: <?=$dataxy24?> },
     { key: "발견", value: <?=$dataxy23?> },
     { key: "활용", value: <?=$dataxy22?> },
     { key: "기억", value: <?=$dataxy21?> }
   ]
 },
 {
   key: "절차",
   values: [
     { key: "창조", value: <?=$dataxy34?> },
     { key: "발견", value: <?=$dataxy33?> },
     { key: "활용", value: <?=$dataxy32?> },
     { key: "기억", value: <?=$dataxy31?> }
   ]
 },
 {
   key: "원리",
   values: [
     { key: "창조", value: <?=$dataxy44?> },
     { key: "발견", value: <?=$dataxy43?> },
     { key: "활용", value: <?=$dataxy42?> },
     { key: "기억", value: <?=$dataxy41?> }
   ]
 }
];

// Declare the chart component
var myChart = d3.x3d.chart.barChartMultiSeries();

// Attach chart and data to the chartholder
chartHolder
 .datum(myData)
 .call(myChart);


</script>














    <div>
      <canvas id="myChart3"></canvas>
    </div>

    <div>
      <canvas id="myChart2"></canvas>
    </div>



    <script>

      const labels = [
        <?=$labelz?>
      ];

      const data = {
        labels: labels,
        datasets: [{
              label: '취약점',
              data: [<?=$dataz?>],
              fill: true,
              backgroundColor: 'rgba(255, 99, 132, 0.2)',
              borderColor: 'rgb(255, 99, 132)',
              pointBackgroundColor: 'rgb(255, 99, 132)',
              pointBorderColor: '#fff',
              pointHoverBackgroundColor: '#fff',
              pointHoverBorderColor: 'rgb(255, 99, 132)'
            }, {
              label: '강점',
              data: [<?=$datazo?>],
              fill: true,
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgb(54, 162, 235)',
              pointBackgroundColor: 'rgb(54, 162, 235)',
              pointBorderColor: '#fff',
              pointHoverBackgroundColor: '#fff',
              pointHoverBorderColor: 'rgb(54, 162, 235)'
            }]
      };
      /*
      const config = {
        type: 'line',
        data: data,
        options: {}
      };

      const config = {
        type: 'bar',
        data: data,
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        },
      };*/
      const config = {
        type: 'radar',
        data: data,
        options: {
          elements: {
            line: {
              borderWidth: 3
            }
          }
        },
      };

      const config1 = {
        type: 'bar',
        data: data,
        options: {
          elements: {
            line: {
              borderWidth: 3
            }
          }
        },
      };

    </script>
    <script>
      const myChart2 = new Chart(document.getElementById('myChart2'),config);

      const myChart3 = new Chart(document.getElementById('myChart3'),config1);

    </script>







<?php
}else{
?>




                    <?php

                    if($is_member){ /////////////////////////////////////////////////// 로그인 되어 있을 경우 디비 쿼리

                        $member_id=$member['mb_id'];
                    /*
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
                    */


                    $sqlq_prepare="
                        	select
                            my_in_date,
                            counttrue, countfalse, u_anum, u_answer, u_essay, u_opt1
                            ,A.qcode ,qnum, qtype,  qtext, qtextsub, qimg, imgpath, is_compiler
                            ,qm1text, qm2text, qm3text, qm4text, qm5text
                            ,qm1correct, qm2correct, qm3correct, qm4correct, qm5correct
                            ,merrillx, merrilly
                            , P.list
                            ,(select title from tb_page where list=P.list) as title
                            ,(select GET_PAGE_FULLTITLES(fullidx,'') from tb_page where list=P.list) as fullidx
                            from
                            (
                                select
                                 AL.counttrue, AL.countfalse
                                , AL.anum as u_anum
                                , AL.answer as u_answer
                                , AL.essay as u_essay
                                , AL.opt1 as u_opt1
                                , (AL.in_date) as my_in_date

                                , QL.qnum as qnum, QL.qtype, QL.qcode as qcode, QL.qtext, QL.qtextsub, QL.qimg, QL.imgpath, QL.is_compiler
                                , qm1text, qm2text, qm3text, qm4text, qm5text
                                , qm1img, qm2img, qm3img, qm4img, qm5img
                                , qm1correct, qm2correct, qm3correct, qm4correct, qm5correct
                                , merrillx, merrilly
                                from tb_answerlog AL, tb_question QL
                                where AL.mb_id='$member_id' and AL.qcode = QL.qcode
                            ) A
                            left outer join
                            (
                                select list,qcode
                                from tb_pageq
                            ) P
                            on A.qcode=P.qcode
                    ";

                    if($qs=="today"){
                      $sqlq_prepare.="  and A.countfalse>=0 and DATE_FORMAT(my_in_date, '%Y-%m-%d') = CURDATE() ";
                    }else if($qs=="star"){
                      $sqlq_prepare.=" and A.star=1";
                    }else if($qs=="bad"){
                      $sqlq_prepare.="  and A.countfalse>=0 order by A.countfalse desc, my_in_date desc";
                    }else{
                      $sqlq_prepare.="  and A.countfalse>=0  order by my_in_date desc";
                    }


                    $is_myq="timeline";
                    //echo($sqlq_prepare);

                    }else{ ///////////////////////// 로그인 안되었을경우 쿠키사용

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
                              $sqlq_prepare="select QT.qnum as qnum, qtype, QT.qcode as qcode, qtext, qtextsub, qimg, QT.imgpath
                                , is_compiler, is_compilerfirst, is_compilertheme
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
                                , title
                                , '' as counttrue
                                , (case ";
                                $sqlq_prepare .= $user_count_false;
                                $sqlq_prepare .= "
                                  end) as countfalse
                                , PG.list as list
                                , (case ";
                                $sqlq_prepare .= $user_stars;
                                $sqlq_prepare .= "
                                  end) as star

                                 ,(GET_PAGE_FULLTITLES( concat(fullidx,'[',PG.idx,']'),'')) as fullidx

                                from tb_question QT, tb_pageq PQ, tb_page PG
                                where QT.qcode=PQ.qcode and PQ.list=PG.list and QT.qcode in ($user_qcodes) ";
                                if($qs=="bad"){
                                  $sqlq_prepare .= " order by countfalse desc ";
                                }else{
                                  $sqlq_prepare .= " order by my_in_date desc ";
                                }

                                $is_myq="cookie";
                              }
                              //echo $sqlq_prepare; /////////////////////////////
                        }

                    }
                    ?>

                        <?php include_once("page.qview.detail.php"); ?>


<?
} //취약차트 종료
?>



<?php ///// if($qcodestr==""){?>
  <div class="py-9">
  <!-- -------- START Features w/ icons and text on left & gradient title and text on right -------- -->
  <?php @include_once("pagesection/section.mynote1.ini")?>
  <!-- -------- END Features w/ icons and text on left & gradient title and text on right -------- -->
  </div>

<?php ////// } ?>

</div>
<?php include_once("page.wrapbottom.php");?>

<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
