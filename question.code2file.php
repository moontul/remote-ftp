<?php include_once('./common.php');

//문제번호를 원문자로 변경
function qnumReplace($g){
  $g1="";
  if($g==1){$g1="①";}
  elseif($g==2){$g1="②";}
  elseif($g==3){$g1="③";}
  elseif($g==4){$g1="④";}
  elseif($g==5){$g1="⑤";}
  else{$g1=$g;}
  return $g1;
}

$fileformat=$_POST["fileformat"];

$filename="팡팡문제".date("md");

//$a_chkq=$_POST["qcodes"];
//$qcodestr="";
//for($i=0;$i<count($a_chkq);$i++){
//    if($qcodestr!=""){$qcodestr.=",";}
//    $qcodestr.="'".$a_chkq[$i]."'";
//}

$qnumstr=stripslashes($_POST["qnums"]);
$a_qnumstr=explode(",",$qnumstr);
$qcodestr=stripslashes($_POST["qcodes"]);

$sql="select * from tb_question where qcode in (".$qcodestr.")";
$result=sql_query($sql);


if($fileformat=="doc"){
  header("Content-Type: application/msword");
  header("Content-Disposition: attachment; filename=".$filename.".doc");
}
if($fileformat=="xls"){
  header("Content-Type: application/msexcel");
  header("Content-Disposition: attachment; filename=".$filename.".xls");
}
if($fileformat=="hwp"){
  header("Content-Type: application/hwp");
  header("Content-Disposition: attachment; filename=".$filename.".hwp");
}
if($fileformat=="xml"){
  Header('Content-Type: application/xml');
  header("Content-Disposition: attachment; filename=".$filename.".xml");

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>". "\n";
echo "<quiz>"."\n";?>
<!-- question: 0  -->
  <question type="category">
    <category>
        <text>$course$/팡팡</text>
    </category>
  </question>
<?php

// moodle 제공 문제 multichoice|truefalse|shortanswer|matching|cloze|essay|numerical|description

for($i=0;$rs=sql_fetch_array($result);$i++){

  $qtype=$rs["qtype"];
  if($qtype=="코딩"){
    $this_qtype="essay";
  }elseif($qtype=="서술식"){
    $this_qtype="essay";
  }elseif($qtype=="주관식"){
    $this_qtype="shortanswer";
  }else{
    $this_qtype="multichoice";
  }

  $qtextsub=$rs["qtextsub"];
  $qcompilecode=$rs["qcompilecode"];

  $qimg=$rs["qimg"];
  if($qimg!=""){
    $org_img = G5_DATA_URL.$rs["imgpath"].$rs["qimg"];
    $abs_img = G5_PATH."/".G5_DATA_DIR.$rs["imgpath"].$rs["qimg"]; //echo("절대경로 : " . $abs_img);
    $name_img = basename($rs["qimg"]);
    $binary_img = fread(fopen($abs_img, "r"), filesize($abs_img));
    $string_img = base64_encode($binary_img);
    //echo("<img src='$org_img'>");
  }

echo "<!-- question: ".$rs['qcode']." -->\n";
?>
  <question type="<?=$this_qtype?>">
    <name>
      <text><?=$rs['qcode']?></text>
    </name>
    <questiontext format="html">
      <text><![CDATA[
        <?=$rs["qtext"]?>

        <?php if($qtextsub!=""){?>
          <div style="border:1px solid #cccccc;padding:10px;">
            <?=$qtextsub?>
          </div>
        <?php } ?>

        <?php if($qcompilecode!=""){?>
<pre style='border:1px solid #cccccc;padding:10px;'><?=$qcompilecode?></pre>
        <?php } ?>

        <?php if($string_img!=""){?>
          <div><img src="@@PLUGINFILE@@/<?=$name_img?>" role="presentation" class="img-responsive atto_image_button_text-bottom"></div>
        <?php } ?>
        ]]></text>
        <?php if($string_img!=""){?>
          <file name="<?=$name_img?>" path="/" encoding="base64"><?=$string_img?></file>
        <?php } ?>
    </questiontext>
    <generalfeedback format="html">
      <text></text>
    </generalfeedback>

    <defaultgrade>1.0000000</defaultgrade>
    <penalty>0.0000000</penalty>
    <hidden>0</hidden>
    <usecase>0</usecase>

    <?php //객관식일 경우
    if($this_qtype=="multichoice"){
      for($j=1;$j<=5;$j++){
        $this_qmtext="";

        if(($rs["qm".$j."text"]!="")||($rs["qm".$j."img"]!="")){

            $this_qm=$j;
            $this_qmtext=$rs["qm".$j."text"];
            if($rs["qm".$j."correct"]==1){
              $this_fraction="100";
            }else{
              $this_fraction="0";
            }

            if($rs["qm".$j."img"]!=""){
                $org_qmimg = G5_DATA_URL.$rs["imgpath"].$rs["qm".$j."img"];
                $abs_qmimg = G5_PATH."/".G5_DATA_DIR.$rs["imgpath"].$rs["qm".$j."img"]; //echo("절대경로 : " . $abs_img);
                $name_qmimg = basename($rs["qm".$j."img"]);
                $binary_qmimg = fread(fopen($abs_qmimg, "r"), filesize($abs_qmimg));
                $string_qmimg = base64_encode($binary_qmimg);
            }
    ?>
        <answer fraction="<?=$this_fraction?>" format="html">
          <text><![CDATA[
            <?=$this_qmtext?>
            <?php if($string_qmimg!=""){?>
              <span><img src="@@PLUGINFILE@@/<?=$name_qmimg?>" role="presentation" class="img-responsive atto_image_button_text-bottom"></span>
            <?php } ?>
           ]]></text>
           <?php if($string_qmimg!=""){?>
             <file name="<?=$name_qmimg?>" path="/" encoding="base64"><?=$string_qmimg?></file>
           <?php } ?>
          <feedback format="html">
            <text></text>
          </feedback>
        </answer>
    <?php }
      }
    ?>
    <single>true</single>
  <?php }
        else if($this_qtype=="shortanswer")
        { ////주관식
            $this_fraction="100";
  ?>
      <answer fraction="<?=$this_fraction?>" format="html">
        <text><![CDATA[
            <?=$rs["qanswer"]?>
         ]]></text>
        <feedback format="html">
          <text><![CDATA[

           ]]></text>
        </feedback>
      </answer>
  <?php
        } ////주관식 종료
        else ////////////////($this_qtype=="shortanswer")
        { ////서술식, 코딩
            $this_fraction="100";
  ?>
      <answer fraction="<?=$this_fraction?>" format="html">
        <text><![CDATA[
            <?=$rs["qanswer"]?>
         ]]></text>
        <feedback format="html">
          <text><![CDATA[

           ]]></text>
        </feedback>
      </answer>
  <?php
  } ////서술식 코딩 종료
  ?>


  </question>
<?php
} //문제루프
?>
</quiz>
<?php
} else { /////xml이 아닌 다른 양식
?>

<?php
} //다른양식종료
?>
