<?php include_once('./_common.php');
@include_once("./page.head.php");
include_once(G5_THEME_PATH.'/head.php');
?>


<?php include_once("page.wraptop.php");?>

<?php
  $question_search_page="false"; //모든 페이지
  $page_code="0";
  $page_lvl="1";
  $question_filedown="false";
?>
<?php @include_once("page.nav.php");?>
<div class="col-lg-9 col-md-9 col-sm-12 pp-mainpage">

  <div class="ct-docs-page-title">
    <span class="ct-docs-page-h1-title">메릴 분류</span>
  </div>
  <hr class="ct-docs-hr">

<?php
  $sql="
  select
   count(*) as cnt
  , sum(case when merrillx='사실' then 1 end) as x1
  , sum(case when merrillx='개념' then 1 end) as x2
  , sum(case when merrillx='절차' then 1 end) as x3
  , sum(case when merrillx='원리' then 1 end) as x4
  , sum(case when merrilly='기억' then 1 end) as y1
  , sum(case when merrilly='활용' then 1 end) as y2
  , sum(case when merrilly='발견' then 1 end) as y3
  , sum(case when merrilly='창조' then 1 end) as y4

  , sum(case when merrillx='사실' then 1 end) as xo1
  , sum(case when merrillx='개념' then 1 end) as xo2
  , sum(case when merrillx='절차' then 1 end) as xo3
  , sum(case when merrillx='원리' then 1 end) as xo4
  , sum(case when merrilly='기억' then 1 end) as yo1
  , sum(case when merrilly='발견' then 1 end) as yo3
  , sum(case when merrilly='활용' then 1 end) as yo2
  , sum(case when merrilly='창조' then 1 end) as yo4

  , sum(case when merrillx='사실' and merrilly='기억' then 1 end) as xy11

  , sum(case when merrillx='개념' and merrilly='기억' then 1 end) as xy21
  , sum(case when merrillx='절차' and merrilly='기억' then 1 end) as xy31
  , sum(case when merrillx='원리' and merrilly='기억' then 1 end) as xy41

  , sum(case when merrillx='개념' and merrilly='활용' then 1 end) as xy22
  , sum(case when merrillx='절차' and merrilly='활용' then 1 end) as xy32
  , sum(case when merrillx='원리' and merrilly='활용' then 1 end) as xy42

  , sum(case when merrillx='개념' and merrilly='발견' then 1 end) as xy23
  , sum(case when merrillx='절차' and merrilly='발견' then 1 end) as xy33
  , sum(case when merrillx='원리' and merrilly='발견' then 1 end) as xy43

  , sum(case when merrillx='개념' and merrilly='창조' then 1 end) as xy24
  , sum(case when merrillx='절차' and merrilly='창조' then 1 end) as xy34
  , sum(case when merrillx='원리' and merrilly='창조' then 1 end) as xy44


  from
  (
      SELECT 'q' as q, merrillx as merrillx, merrilly as merrilly
      FROM tb_question B
      where 1=1
  ) C
  group by q
  ";

  $rs=sql_fetch($sql);
  $cnt=$rs["cnt"];

  $labels="'사실','개념','절차','원리','기억','활용','발견','창조'";

  $data1=$rs["x1"] . ",".$rs["x2"].",".$rs["x3"].",".$rs["x4"].",";
  $data1.=$rs["y1"] .",".$rs["y2"].",".$rs["y3"].",".$rs["y4"];

  $data2=$rs["xo1"] . ",".$rs["xo2"].",".$rs["xo3"].",".$rs["xo4"].",";
  $data2.=$rs["yo1"] .",".$rs["yo2"].",".$rs["yo3"].",".$rs["yo4"];

  $labelz="'사실x기억','개념x기억','절차x기억','원리x기억', '개념x활용','절차x활용','원리x활용', '개념x발견','절차x발견','원리x발견', '개념x창조','절차x창조','원리x창조' ";

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

  ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="h5">전체 <?=$cnt?>문제</div>
<table class="table">
<tr>
<td>창조</td>
<td><a href="/question?merrillx=사실&merrilly=창조" target="_blank"><?=$rs["xy12"]?><?=$rs["xy14"]?></a></td>
<td><a href="/question?merrillx=개념&merrilly=창조" target="_blank"><?=$rs["xy12"]?><?=$rs["xy24"]?></a></td>
<td><a href="/question?merrillx=절차&merrilly=창조" target="_blank"><?=$rs["xy12"]?><?=$rs["xy34"]?></a></td>
<td><a href="/question?merrillx=원리&merrilly=창조" target="_blank"><?=$rs["xy12"]?><?=$rs["xy44"]?></a></td>
</tr>

<tr>
<td>발견</td>
<td><a href="/question?merrillx=사실&merrilly=발견" target="_blank"><?=$rs["xy12"]?><?=$rs["xy13"]?></a></td>
<td><a href="/question?merrillx=개념&merrilly=발견" target="_blank"><?=$rs["xy12"]?><?=$rs["xy23"]?></a></td>
<td><a href="/question?merrillx=절차&merrilly=발견" target="_blank"><?=$rs["xy12"]?><?=$rs["xy33"]?></a></td>
<td><a href="/question?merrillx=원리&merrilly=발견" target="_blank"><?=$rs["xy12"]?><?=$rs["xy43"]?></a></td>
</tr>

<tr>
<td>활용</td>
<td><a href="/question?merrillx=사실&merrilly=활용" target="_blank"><?=$rs["xy12"]?></a></td>
<td><a href="/question?merrillx=개념&merrilly=활용" target="_blank"><?=$rs["xy22"]?></a></td>
<td><a href="/question?merrillx=절차&merrilly=활용" target="_blank"><?=$rs["xy32"]?></a></td>
<td><a href="/question?merrillx=원리&merrilly=활용" target="_blank"><?=$rs["xy42"]?></a></td>
</tr>

<tr>
<td>기억</td>
<td><a href="/question?merrillx=사실&merrilly=기억" target="_blank"><?=$rs["xy11"]?></a></td>
<td><a href="/question?merrillx=개념&merrilly=기억" target="_blank"><?=$rs["xy21"]?></a></td>
<td><a href="/question?merrillx=절차&merrilly=기억" target="_blank"><?=$rs["xy31"]?></a></td>
<td><a href="/question?merrillx=원리&merrilly=기억" target="_blank"><?=$rs["xy41"]?></a></td>
</tr>

<tr>
<td></td><td>사실</td><td>개념</td><td>절차</td><td>원리</td>
</tr>
</table>

    <div>
      <canvas id="myChart2"></canvas>
    </div>

    <div>
      <canvas id="myChart3"></canvas>
    </div>

    <script>
      const labels = [
        <?=$labelz?>
      ];

      const data = {
        labels: labels,
        datasets: [{
              label: '메릴 분류',
              data: [<?=$dataz?>],
              fill: true,
              backgroundColor: 'rgba(255, 99, 132, 0.2)',
              borderColor: 'rgb(255, 99, 132)',
              pointBackgroundColor: 'rgb(255, 99, 132)',
              pointBorderColor: '#fff',
              pointHoverBackgroundColor: '#fff',
              pointHoverBorderColor: 'rgb(255, 99, 132)'
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

<hr>

<table>
<?php
  $sql="select qcode, qtext, merrillx, merrilly from tb_question";
  $result=sql_query($sql);
  for($i=0;$rs=sql_fetch_array($result);$i++){
?>
<tr><td><?=$rs["qcode"]?></td><td><?=$rs["qtext"]?></td><td><?=$rs["merrillx"]?></td><td><?=$rs["merrilly"]?></td></tr>
<?php
  }
?>
</table>












</div>
<?php include_once("page.wrapbottom.php");?>
<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
