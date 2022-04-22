
<style>
table {
  font-size: 13px; color:#101010;
}

table tr,table td {height: 25px;}
table textarea{height: 25px;width:95%;}

td>div{max-height:15px;overflow:hidden;}

table>tbody>tr>td, table>tbody>tr>th, table>tfoot>tr>td, table>tfoot>tr>th, table>thead>tr>td, table>thead>tr>th {
  padding:0;
}
</style>
<?php
  $list=$_REQUEST["list"];


  $qtext_q=$_REQUEST["q"];
  $qtext_q1=$_REQUEST["qtext_q1"];
  $qtext_opt1=$_REQUEST["qtext_opt1"];
  if($qtext_opt1==""){$qtext_opt1="and";}

  $qlog_q=$_REQUEST["qlog_q"];
  $qlog_q1=$_REQUEST["qlog_q1"];
  $qlog_opt1=$_REQUEST["qlog_opt1"];
  if($qlog_opt1==""){$qlog_opt1="and";}

  $qtype_q=$_REQUEST["qtype_q"];

  $title_q=$_REQUEST["title_q"];
  $title_q1=$_REQUEST["title_q1"];
  $title_opt1=$_REQUEST["title_opt1"];
  if($title_opt1==""){$title_opt1="and";}

  $merrilltrue=$_REQUEST["merrilltrue"];
  $merrillfalse=$_REQUEST["merrillfalse"];
  $merrillnone=$_REQUEST["merrillnone"];

  $merrillx=$_REQUEST["merrillx"];
  $merrilly=$_REQUEST["merrilly"];

  $pcount=$_REQUEST["pcount"];
  $qorder=$_REQUEST["qorder"];
  //if($qorder==""){$qorder="num";}
  $qlimits=$_REQUEST["qlimits"];
  if($qlimits==""){$qlimits=20;}
  if($is_admin){
  }else{
    if($qlimits>100){$qlimits=100;} //최대 1페이지 최대 100
  }
?>



<form name=f method=post action="?">
<input type=hidden name=list value="<?=$list?>" size=1>

<?php if(1==2){   ////멀티셀렉터 작업중 ?>
  <script type="module">
      import Tags from "<?=G5_THEME_URL?>/assets/js/tags.js?v5";
      Tags.init("select[multiple]:not(#regular)");

      // Reset does not fire a change input
    //  document.getElementById("regular").addEventListener("change", function (ev) {
    //    console.log(this.selectedOptions);
    //  });
  </script>
    <div class="row mb-3 g-3 d-none">
        <div class="col-md-4">
          <label for="validationTagsNew" class="form-label">Tags (allow new)</label>
          <select class="form-select" id="validationTagsNew" name="tags_new[]" multiple="" data-allow-new="true" style="display: none;">

            <option value="1" selected="selected" data-init="1">Apple</option>
            <option value="2">Banana</option>
            <option value="3">Orange</option>
            <option value="adfda">adfda</option>
          </select><div class="form-control dropdown"><div>
            <span class="badge bg-primary me-2" data-value="1">Apple</span><span class="badge bg-primary me-2" data-value="adfda">adfda</span>
            <input type="text" autocomplete="off" aria-label="Type a value" placeholder=""
            size="1" style="border: 0px; outline: 0px; max-width: 100%;"></div>
            <ul class="dropdown-menu p-0" style="max-height: 280px; overflow-y: auto; left: 69px;">
              <li style="display: none;"><a class="dropdown-item" data-value="1" href="#">Apple</a></li>
              <li style="display: none;"><a class="dropdown-item" data-value="2" href="#">Banana</a></li>
              <li style="display: none;"><a class="dropdown-item" data-value="3" href="#">Orange</a></li></ul>
            </div>
          <div class="invalid-feedback">Please select a valid tag.</div>
        </div>
  </div>
<?php } ?>


  <?php
  $sqlq="
  select qtype, qnum, qcode, qtext, qtextsub
    , merrillx, merrilly, merrilljson
    , qlog, in_date, pcount, lists, titles, fullidxs, pcount
  from(
      select
          QS.qcode
  ";
  $sqlq.="
          , qtext, qtextsub, merrillx, merrilly, merrilljson
  ";
  $sqlq.="
          ,QS.qlog, QS.in_date as in_date
          ,QS.qtype
          ,qnum
          , group_concat(P.list) as lists
      	  , group_concat(P.title) as titles
  		    , group_concat(P.fullidx) as fullidxs
      	  , sum(case when P.title is not null then 1 else 0 end) as pcount
          from (
              select * from tb_question
              where 1=1 ";

if($qtext_q!=""&&$qtext_q1!=""){
    $sqlq.=" and ( qtext like '%$qtext_q%' $qtext_opt1 qtext like '%$qtext_q1%' )";
}elseif($qtext_q!=""&&$qtext_q1==""){
    $sqlq.=" and ( qtext like '%$qtext_q%' )";
}elseif($qtext_q!=""&&$qtext_q1==""){
  $sqlq.=" and ( qtext like '%$qtext_q1%' )";
}

if($qlog_q!=""&&$qlog_q1!=""){
    $sqlq.=" and ( qlog like '%$qlog_q%' $qlog_opt1 qlog like '%$qlog_q1%' )";
}elseif($qlog_q!=""&&$qlog_q1==""){
    $sqlq.=" and ( qlog like '%$qlog_q%' )";
}elseif($qlog_q!=""&&$qlog_q1==""){
    $sqlq.=" and ( qlog like '%$qlog_q1%' )";
}

if($qtype_q!=""){
    $sqlq.=" and ( qtype like '%$qtype_q%' )";
}

if($merrilltrue!=""){
    $sqlq.=" and ( merrillx != '' and merrilly !='')";
}
if($merrillfalse!=""){
    $sqlq.=" and ( (merrillx = '' or merrillx is null) and (merrilly ='' or merrilly is null))";
}
if($merrillnone!=""){
    $sqlq.=" and ( merrillx = 'none' or merrilly ='none')";
}

if($merrillx!=""){
    $sqlq.=" and ( merrillx = '$merrillx' )";
}
if($merrilly!=""){
    $sqlq.=" and ( merrilly = '$merrilly' )";
}




$sqlq.="
              ) QS
          left outer JOIN
      		(select PG.list, title, qcode, PG.fullidx
               from tb_pageq PQ, tb_page PG
               where PQ.list=PG.list ";

$sqlq.="
          ) P
          on QS.qcode=P.qcode

          group by QS.qcode
  ) A
  where 1=1
  ";
  if($title_q!=""&&$title_q1!=""){
      $sqlq.=" and ( titles like '%$title_q%' $title_opt1 titles like '%$title_q1%' )";
  }elseif($title_q!=""&&$title_q1==""){
      $sqlq.=" and ( titles like '%$title_q%' )";
  }elseif($title_q!=""&&$title_q1==""){
      $sqlq.=" and ( titles like '%$title_q1%' )";
  }


  if($pcount!=""){
    $sqlq.="  and pcount=$pcount";
  }

//lists is not null
  if($qorder=="num"){
    $sqlq.="   order by A.qnum asc";
  }elseif($qorder=="rand"){
    $sqlq.="   order by rand()";
  }else{
    $sqlq.="   order by in_date desc";
  }

  if($qlimits!=""){
    $sqlq.=" limit ".$qlimits;
  }

  $result=sql_query($sqlq);

  //////////////////////////////////////////echo($sqlq);
?>

<table width="100%">
<tr>
<td style="font-size:14px;">

  <table class="pptable" style="width:90%">
  <tr style="border-top:1px solid #cccccc;height:1px;">
  <td width=10% nowrap align=center valign=center bgcolor="#efefef">
      <b>문제검색</b>
  </td>
  <td>

          <table class="pptable" width=100% style="margin:5px">
          <tr>
          <td width="80px" nowrap>문제에 포함 &nbsp; </td>
          <td>
            <input type=text size=15 name=q class="form-control form-control-sm d-inline-block w-auto p-1"
            value="<?=$qtext_q?>"><select name=qtext_opt1
            class="form-control form-control-sm d-inline-block w-auto p-1">
              <option value="and">and</option>
              <option value="or" <?=($qtext_opt1=="or")?"selected":""?>>or</option></selct>
            <input type=text size=15 name=qtext_q1 class="form-control form-control-sm d-inline-block w-auto p-1" value="<?=$qtext_q1?>">
          </td>
          </tr>
          <?php if($is_admin){?>
          <tr>
          <td>히스토리</td>
          <td>
            <input type=text size=15 name=qlog_q class="form-control form-control-sm d-inline-block w-auto p-1"
            value="<?=$qlog_q?>"><select name=qlog_opt1
            class="form-control form-control-sm d-inline-block w-auto p-1" ><option value="and">and</option>
            <option value="or" <?=($qlog_opt1=="or")?"selected":""?>>or</option></selct>
            <input type=text size=15 name=qlog_q1 value="<?=$qlog_q1?>" class="form-control form-control-sm d-inline-block w-auto p-1">
          </td>
          </tr>
          <?php } ?>
          <tr><td>문제유형</td>
          <td>
            <input type=text size=15 name=qtype_q value="<?=$qtype_q?>" class="form-control form-control-sm d-inline-block w-auto p-1" >

          </td>
          </tr></table>
    </td>
    </tr>
<?php if($is_admin){?>
    <tr style="border-top:1px solid #cccccc;height:1px;">
    <td bgcolor="#efefef"  align=center valign=center>
      <b>메릴</b>
    </td>
    <td>
          <table class="pptable" width=100% style="margin:5px">
          <tr>
          <td>내용요소</td>
          <td>
            <select name="merrillx" class="form-control form-control-sm d-inline-block w-auto p-1">
            <option value="">::내용범주::</option>
            <option value="사실" <?=($merrillx=="사실")?"selected":""?>>사실</option>
            <option value="개념" <?=($merrillx=="개념")?"selected":""?>>개념</option>
            <option value="절차" <?=($merrillx=="절차")?"selected":""?>>절차</option>
            <option value="원리" <?=($merrillx=="원리")?"selected":""?>>원리</option>
            </select>

            <select name="merrilly" class="form-control form-control-sm d-inline-block w-auto p-1">
            <option value="">::수행수준::</option>
            <option value="기억" <?=($merrilly=="기억")?"selected":""?>>기억</option>
            <option value="활용" <?=($merrilly=="활용")?"selected":""?>>활용</option>
            <option value="발견" <?=($merrilly=="발견")?"selected":""?>>발견</option>
            <option value="창조" <?=($merrilly=="창조")?"selected":""?>>창조</option>
            </select>
          </td>
          </tr>


          <tr>
          <td>설정여부</td>
          <td>
            <div class="form-check d-inline-block">
            <input type="checkbox" class="form-check-input p-1" name="merrilltrue" value=1 <?php if($merrilltrue=="1"){echo "checked";}?>> 있음
            </div>
            <div class="form-check d-inline-block">
            <input type="checkbox" class="form-check-input p-1" name="merrillfalse" value=1 <?php if($merrillfalse=="1"){echo "checked";}?>> 없음
            </div>

            <div class="form-check d-inline-block">
            <input type="checkbox" class="form-check-input p-1" name="merrillnone" value=1 <?php if($merrillnone=="1"){echo "checked";}?>> none
            </div>

          </td>
          </tr>
          </table>
  </td>
  </tr>
<?php }?>

    <tr style="border-top:1px solid #cccccc;height:1px;">
    <td bgcolor="#efefef"  align=center valign=center>
      <b>목차</b>
    </td>
    <td>
        <table class="pptable" width=100% style="margin:5px">
        <tr>
        <td width="80px" nowrap>목차이름</td>
        <td>
          <input type=text size=15 name=title_q class="form-control form-control-sm d-inline-block w-auto p-1"
          value="<?=$title_q?>"><select name=title_opt1
          class="form-control form-control-sm d-inline-block w-auto p-1">
            <option value="and">and</option>
            <option value="or" <?=($title_opt1=="or")?"selected":""?>>or</option></selct>
          <input type=text size=15 name=title_q1 class="form-control form-control-sm d-inline-block w-auto p-1" value="<?=$title_q1?>">
        </td>
        </tr>
        <tr>
        <td>연결수</td><td><input type=text size=2 name=pcount value="<?=$pcount?>" class="form-control form-control-sm d-inline-block w-auto p-1" ></td>
        </tr>
        </table>
  </td>
  </tr>
  <tr style="border-top:1px solid #cccccc;height:1px;border-bottom:1px solid #cccccc;height:1px;">
  <td bgcolor="#efefef" align=center valign=center>
      <b>정렬결과</b>
  </td>
  <td>
      <table class="pptable" width=100% style="margin:5px">
      <tr>
      <td>

        <div class="form-check d-inline-block">
          <input class="form-check-input" type="radio" name="qorder" id="radio-num" value="rand" <?=($qorder=="rand")?"checked":""?>>
          <label class="form-check-label" for="radio-num">번호 순</label> &nbsp;  &nbsp;
        </div>

        <div class="form-check d-inline-block">
          <input class="form-check-input" type="radio" name="qorder" id="radio-rand" value="rand" <?=($qorder=="rand")?"checked":""?>>
          <label class="form-check-label" for="radio-rand">랜덤</label> &nbsp;  &nbsp;
        </div>

        <div class="form-check d-inline-block">
          <input class="form-check-input" type="radio" name="qorder" id="radio-in_date" value="in_date" <?=($qorder=="in_date")?"checked":""?>>
          <label class="form-check-label" for="radio-in_date">최근순</label> &nbsp;  &nbsp;
        </div>
      </td>
      <td width=55%>
        <b>결과수 : </b> <input type=text name=qlimits value="<?=$qlimits?>" size=4 class="form-control form-control-sm d-inline-block w-auto">

        <b>검색수 :  <?=mysqli_num_rows($result);?></b>
      </td>
      </tr>
      </table>
  </td>
  </tr>
  </table>

</td>
<td width="10%"><input type=submit value="검색" class="btn btn-primary" style="width:80px;height:80px"></td>
</tr>
</table>

<hr>

<table class="pptable">
  <thead style="background-color:#efefef">
    <tr align=center>
      <th scope="col" style="width:6%">
        <div class="form-check">
        <input type="checkbox" class="form-check-input chkqall" onclick="$('.chkq').prop('checked',$(this).prop('checked'))">
        </div>
      </th>
      <th scope="col">문제</th>
      <th scope="col" style="width:4%">번호</th>
      <th scope="col" nowrap style="width:10%">유형</th>
      <?php if($is_admin){?>
      <th scope="col">히스토리</th>
      <th scope="col" nowrap style="width:10%">생성일</th>
      <th scope="col" nowrap style="width:18%">연결이름</th>
      <th scope="col" nowrap style="width:5%">연결수</th>
      <th scope="col" nowrap style="width:5%">응시수</th>
    <?php } ?>
      <th scope="col" nowrap style="width:5%">바로가기</th>
    </tr>
  </thead>
    <tbody>
<?php
  for($i=0;$rs=sql_fetch_array($result);$i++){
  ?>

  <tr style="border-bottom:1px solid #ccc" onmouseover="this.style.backgroundColor='#f2f2f2'" onmouseout="this.style.backgroundColor='#ffffff'">
    <td  style="padding:3px">
      <div class="form-check">
          <input class="form-check-input chkq" name="chkq[]" type="checkbox" value="<?=$rs['qcode']?>" qnum="<?=$rs['qnum']?>" pqnum="<?=$i+1?>">
          <?=$i+1?>
      </div>
    </td>
    <td nowrap  style="padding:3px">
      <textarea style="border:0" class="qtext_<?=$rs['qcode']?>"><?=$rs["qtext"]?></textarea>

    <?php if($is_admin){?>
      <br>
      <span class="merrill_<?=$rs['qcode']?>"><?=$rs["merrillx"]?><?=$rs["merrilly"]?></span>
      <textarea style="width:100px;height:10px;border:0px;"><?=$rs["merrilljson"]?></textarea>
    <?php } ?>
    </td>
    <td style="padding:3px" align=center class="text-bold"><?=$rs["qnum"]?></td>
    <td style="padding:3px" align=center><?=$rs["qtype"]?></td>

    <?php if($is_admin){ ?>
    <td style="padding:3px" ><textarea style="border:0px"><?=$rs["qlog"]?></textarea></td>
    <td style="padding:3px"  align=center><?=date("Y-m-d", strtotime($rs["in_date"]))?></td>
    <td style="padding:3px" ><textarea style="border:0px;"><?=$rs["titles"]?></textarea></td>
    <td style="padding:3px"  align=center><?=$rs["pcount"]?></td>
    <td style="padding:3px"  align=center><?=$rs["acnt"]?></td>
  <?php } ?>
    <td width=8%>
      <div style="height:20px;overflow:hidden"><a target="_blank" href="/page?list=<?=$rs['lists']?>#<?=$rs['qcode']?>"><?=$rs['titles']?></a></div>

      <?php if($is_admin){ ?>
      <a target="_blank" href="page_qedit?qcode=<?=$rs['qcode']?>" class="btn btn-sm p-1 mt-1">문제수정</a>
      <?php } ?>

    </td>
  </tr>


<?php
  }
?>
  </tbody>
  </table>

  <input type=hidden name=fileformat>
  </form>

  <hr>
