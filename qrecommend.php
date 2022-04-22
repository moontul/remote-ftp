<?php include_once('./_common.php');
$this_menu="오답노트";
$this_title="추천문제";
include_once(G5_THEME_PATH.'/head.php');
include_once("page.wraptop.php");

//특수문자 처리
function repMark($str){
  $str=str_replace("("," (",$str);
  $str=str_replace(")",") ",$str);
  $str=str_replace("  "," ",$str);

  $str=str_replace("(","",$str);
  $str=str_replace(")","",$str);
  $str=str_replace("?","",$str);
  $str=str_replace("!","",$str);
  $str=str_replace(".","",$str);
  $str=str_replace(",","",$str);
  $str=str_replace(";","",$str);
  $str=str_replace(":","",$str);
  $str=str_replace("'","",$str);
  $str=str_replace('"',"",$str);
  return $str;
}

//불용
function isnone($str) {
  $strnone="다음 중 같 것 짧 두 일관 방식 기법 그림 후 가장 작성 항목 의미 처리 올바르게 옳 옳지 바르게 아닌 않 관한 설명 내용 사용 목적 해당 ";
  $strnone.="이해 그 모든 어떤 갖고 있 주요 기능 정 및 등 과정 구성 대 거리 먼 대해 가지 해석될 속 때 맞 있어서 간 위해 무엇이라고 하는 따른 ";
  $strnone.=" 같다 이 의 하고자 할 행 위 틀린 단 있다 아래 또 개 ";
  $strnone.=" 무엇인지 고르세요 가능 않아도 각 한다 구 갖 놓 이때 각각 세 그리고 있게 했고 쓰시오 ";
  $strnone.=" a the an for of is are am this that and or who what how when ";
  $strnone.=" 1 2 3 4 5 6 7 8 9 ";

  $a_none = explode(' ',$strnone);
  for($i=0;$i<count($a_none);$i++){
    if(strtolower($str)==strtolower($a_none[$i])){
      return  "";
    }
  }
  return $str;
}


//조사제외
function josa($str) {
  $a_josa = explode(' ','하라 은 하는 하지 되는 시 되게 되고 있는지 없는지 하고 는 이 가 을 를 과 와 으로만 으로 로 에서 에 부터 까지 의 한 된 이면 면 하여 하며 있도록');
  //echo($str."-->");
  for($i=0;$i<count($a_josa);$i++){
    $l=mb_strlen($a_josa[$i], "UTF-8");
    $tl=mb_strlen($str, "UTF-8");

    if($tl>=$l&&(mb_substr($str, -($l))==$a_josa[$i])){

      return  mb_substr($str, 0, $tl-$l);
    }
  }
  return $str;
}



$qcode=$_REQUEST["qcode"];

//이 문제의 추천문제
$sql="select qtext, qtextsub, qm1text, qm2text, qm3text, qm4text, qm5text, merrillx, merrilly from tb_question where qcode='$qcode'";
$rs=sql_fetch($sql);

$my_merrillx=$rs["merrillx"];
$my_merrilly=$rs["merrilly"];

$qtext=$rs["qtext"];
$qtext=repMark($qtext);

$arr=explode(" ",$qtext);
$qarr=[];
$qstr="";
//문제 단어 후 처리
foreach( $arr as $key => $value ){
  $g=isnone(josa($value)); //조사 처리 후 불용처리
  if($g!=""&&(!in_array($g, $qarr))){  //// 중복값
    array_push($qarr, $g);
  }
}

$qmtext="";
if($rs["qm1text"]!=""){$qmtext.=$rs["qm1text"]." ";}
if($rs["qm2text"]!=""){$qmtext.=$rs["qm2text"]." ";}
if($rs["qm3text"]!=""){$qmtext.=$rs["qm3text"]." ";}
if($rs["qm4text"]!=""){$qmtext.=$rs["qm4text"]." ";}
if($rs["qm5text"]!=""){$qmtext.=$rs["qm5text"]." ";}

$qmtext=repMark($qmtext);
//echo($qmtext."<br>");
$arrqm=explode(" ",$qmtext);
$qmarr=[];
$qmstr="";
//문제 단어 후 처리
foreach( $arrqm as $key => $value ){
  $g=isnone(josa($value)); //조사 처리 후 불용처리
  if($g!=""&&(!in_array($g, $qmarr))){  //// 중복값
    array_push($qmarr, $g);
  }
}
?>


<?php include_once("mynote.nav.php");?>
<div class="col-lg-9 col-md-9 col-sm-12 pp-mainpage shadow" style="background-image:url('<?=G5_THEME_URL?>/assets/img/notebg2.jpg');padding-right:15px;">

    <div class="ct-docs-page-title">
      <span class="ct-docs-page-h1-title"><?=$this_title?></span>
    </div>
    <hr class="ct-docs-hr">






<?php



$sqlunion="";
foreach( $qarr as $key => $value ){
  if($sqlunion!=""){$sqlunion.=" union ";}
  $sqlunion.=("(select qcode, qtext, merrillx, merrilly, qm1text, qm2text, qm3text, qm4text, qm5text from tb_question where qcode!='$qcode' and qtext like '%".$value."%')");
}


//$sqlq="select qcode, qtext from tb_question where qcode!='$qcode' ".$sqlonly." ";
//$result=sql_query($sqlq);
if($is_admin){
  echo("<!--".$sqlunion."-->");
}
$result=sql_query($sqlunion);

//추출된 문제에서 우선순위 값을 넣음
$a_qmulti=[];
for($i=0;$rs=sql_fetch_array($result);$i++){
    $hit=0;
    $qtext=$rs["qtext"];
    $qmtext="";
    foreach( $qarr as $key => $value ){
      if(strpos($qtext, $value)!==false){ //일치하는 단어가 있으면
        $hit=$hit+10;
      }
    }
    if($rs["qm1text"]!=""){$qmtext.=$rs["qm1text"]." ";};
    if($rs["qm2text"]!=""){$qmtext.=$rs["qm2text"]." ";};
    if($rs["qm3text"]!=""){$qmtext.=$rs["qm3text"]." ";};
    if($rs["qm4text"]!=""){$qmtext.=$rs["qm4text"]." ";};
    if($rs["qm5text"]!=""){$qmtext.=$rs["qm5text"]." ";};

    if($qmtext!=""){
      foreach( $qmarr as $key => $value ){
        if(strpos($qmtext, $value)!==false){ //일치하는 단어가 있으면
          $hit=$hit+2;
        }
      }
    }

    $merrillx=$rs["merrillx"];
    $merrilly=$rs["merrilly"];
    if($merrillx==$my_merrillx&&$my_merrillx!=""){$hit=$hit+1;}
    if($merrilly==$my_merrilly&&$my_merrilly!=""){$hit=$hit+1;}

    array_push($a_qmulti, array('hit'=>$hit, 'qtext'=> $rs["qtext"], 'qcode' => $rs["qcode"] ) );
}

foreach ((array) $a_qmulti as $key => $value) {
	$sort[$key] = $value['hit'];
}

array_multisort($sort, SORT_DESC, $a_qmulti);
$qcodes="";
foreach($a_qmulti as $key => $value){

  if($key<10){  ///////////10문제 추천
    //echo($value["hit"].":".$value["qcode"].":".$value["qtext"]."<br>");
    if($qcodes!=""){$qcodes.=",";}
    $qcodes.="'".$value["qcode"]."'";
  }
}
$qcode="";
if($qcodes!=""){
?>


<div class="container">
<?php include_once("page.qview.detail.php")?>
</div>
<?php } ?>

</div>
<?php include_once("page.wrapbottom.php");?>
<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
