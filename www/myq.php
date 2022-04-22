<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.php');
include_once('adm/pangpang/_conn.php');
$background_images = G5_THEME_IMG_URL.'/bg/banner2560x740_1.jpg';
$title = "";
$title_sub =$l;

$mb_id=$member['mb_id'];

include_once(G5_THEME_PATH.'/page.sub.php');
?>

<section>
<div class="container">
<?php
$sql = <<<EOT
  select
  qcode, max(in_date) as in_date, count(*) as cnt
  ,sum(CASE WHEN correctval='1' THEN 1 END) AS t
  ,sum(CASE WHEN correctval='-1' THEN 1 END) AS f
  ,(select qtext from tb_question where qcode=A.qcode) as qtext
  ,(select merrill_x from tb_question where qcode=A.qcode) as merrill_x
  ,(select merrill_y from tb_question where qcode=A.qcode) as merrill_y
  ,(select concat('[',subjectname,']') from tb_subject where sjcode=(select sjcode from tb_question where qcode=A.qcode)) as subjectname
  ,(select concat('[',licensename,licensedate,']') from tb_license where lccode=(select lccode from tb_question where qcode=A.qcode)) as licensename
  ,(select concat('[',bookname,']') from tb_book where bkcode=(select bkcode from tb_question where qcode=A.qcode)) as bookname

  ,(select concat('[',unitname,']') from tb_subjectunit where sjucode=(select sjucode from tb_question where qcode=A.qcode)) as subjectunitname
  ,(select concat('[',unitname,']') from tb_licenseunit where lcucode=(select lcucode from tb_question where qcode=A.qcode)) as licenseunitname
  ,(select concat('[',unitname,']') from tb_bookunit where bkucode=(select bkucode from tb_question where qcode=A.qcode)) as bookunitname

  ,(select sjcode from tb_question where qcode=A.qcode) as sjcode
  ,(select lccode from tb_question where qcode=A.qcode) as lccode
  ,(select bkcode from tb_question where qcode=A.qcode) as bkcode

  ,(select sjucode from tb_question where qcode=A.qcode) as sjucode
  ,(select lcucode from tb_question where qcode=A.qcode) as lcucode
  ,(select bkucode from tb_question where qcode=A.qcode) as bkucode

  from tb_qsheet_log A where mb_id='$mb_id'
  group by qcode
  order by in_date desc
EOT;
$result = mysqli_query($conn, $sql);
//echo($sql);
?>
<h5>내가 푼 문제</h5>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">문제</th>
        <th scope="col">최근 응시</th>
        <th scope="col">맞은횟수</th>
        <th scope="col">틀린횟수</th>
        <th scope="col">문제보기</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($result as $list){

        $code="";
        $sjcode=$list['sjcode']; if($code==""&&$sjcode!=""){$code=$sjcode;}
        $lccode=$list['lccode']; if($code==""&&$lccode!=""){$code=$lccode;}
        $bkcode=$list['bkucode']; if($code==""&&$bkcode!=""){$code=$bkcode;}

        $ucode="";
        $sjucode=$list['sjucode']; if($ucode==""&&$sjucode!=""){$ucode=$sjcode;}
        $lcucode=$list['lcucode']; if($ucode==""&&$lcucode!=""){$ucode=$lccode;}
        $bkucode=$list['bkucode']; if($ucode==""&&$bkucode!=""){$ucode=$bkcode;}
      ?>
      		<tr>
      		<td width=3%><input type="checkbox"></td>
      		<td>
            <span style="color:#999999;font-size:12px;">
              <?=$list['subjectname']?><?=$list['licensename']?><?=$list['bookname']?>
              <?=$list['subjectunitname']?><?=$list['licenseunitname']?><?=$list['bookunitname']?>
            </span>


            <span style="color:#999999;font-size:11px;"><?=$list['merrill_x']?>x<?=$list['merrill_y']?></span><br>
            <?=mb_substr($list['qtext'],0,30)?>..<br>

          </td>
      		<td><?=$list['in_date']?></td>
          <td><?=$list['t']?></td>
          <td><?=$list['f']?></td>
          <td width=5%>
                <!--a href="qview.php?qcode=<?=$list['qcode']?>" class="btn pp-btn">보기</a-->

                <a href="view.php?vtype=all&qcode=<?=$list['qcode']?>&code=<?=$code?>&ucode=<?=$ucode?>" class="btn pp-btn">보기</a>

          </td>
      		</tr>
      <?php } ?>

    </tbody>
  </table>

<br>
<br>
<br>

</div>
</section>



<section>
<div class="container">
<?php
$sql = <<<EOT
  select *
  ,(select left(qtext, 20) from tb_question where qcode=A.qcode) as qtext
  ,(select merrill_x from tb_question where qcode=A.qcode) as merrill_x
  ,(select merrill_y from tb_question where qcode=A.qcode) as merrill_y
  ,(select concat('[',subjectname,']') from tb_subject where sjcode=(select sjcode from tb_question where qcode=A.qcode)) as subjectname
  ,(select concat('[',licensename,']') from tb_license where lccode=(select lccode from tb_question where qcode=A.qcode)) as licensename
  ,(select concat('[',bookname,']') from tb_book where bkcode=(select bkcode from tb_question where qcode=A.qcode)) as bookname

  ,(select sjcode from tb_question where qcode=A.qcode) as sjcode
  ,(select lccode from tb_question where qcode=A.qcode) as lccode
  ,(select bkcode from tb_question where qcode=A.qcode) as bkcode

  ,(select sjucode from tb_question where qcode=A.qcode) as sjucode
  ,(select lcucode from tb_question where qcode=A.qcode) as lcucode
  ,(select bkucode from tb_question where qcode=A.qcode) as bkucode

  from tb_qmemo A where mb_id='$mb_id'
  order by in_date desc
EOT;
$result = mysqli_query($conn, $sql);
//echo($sql);
?>
<h5>학습메모</h5>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">날짜</th>
        <th scope="col">문제</th>
        <th scope="col">메모</th>
        <th scope="col">보기</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($result as $list){
        $code="";
        $sjcode=$list['sjcode']; if($code==""&&$sjcode!=""){$code=$sjcode;}
        $lccode=$list['lccode']; if($code==""&&$lccode!=""){$code=$lccode;}
        $bkcode=$list['bkucode']; if($code==""&&$bkcode!=""){$code=$bkcode;}

        $ucode="";
        $sjucode=$list['sjucode']; if($ucode==""&&$sjucode!=""){$ucode=$sjcode;}
        $lcucode=$list['lcucode']; if($ucode==""&&$lcucode!=""){$ucode=$lccode;}
        $bkucode=$list['bkucode']; if($ucode==""&&$bkucode!=""){$ucode=$bkcode;}
      ?>
      		<tr>
      		<td><input type="checkbox"></td>
          <td><?=$list['in_date']?></td>
      		<td>
            <span style="color:#999999;font-size:12px;"><?=$list['subjectname']?><?=$list['licensename']?></span> <span style="color:#999999;font-size:11px;"><?=$list['merrill_x']?>x<?=$list['merrill_y']?></span><br>
            <?=mb_substr($list['qtext'],0,30)?>..<br>
          </td>
          <td><?=$list['memo']?></td>
          <td>

                <a href="view.php?vtype=all&qcode=<?=$list['qcode']?>&code=<?=$code?>&ucode=<?=$ucode?>" class="btn pp-btn">보기</a>
          </td>
      		</tr>
      <?php } ?>

    </tbody>
  </table>

<br>
<br>
<br>

</div>
</section>




<?php include_once(G5_THEME_PATH.'/tail.php');?>
