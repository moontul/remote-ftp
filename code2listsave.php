<?php
include_once('./_common.php');

$targetcode=$_POST['targetcode'];
$destcode=$_POST['destcode'];

echo "이것을:".$targetcode;
echo "<br>이것의 하위로:".$destcode;

$listtitle=$_POST["listtitle"];
//////$subtitle=$_POST["subtitle"];
$listcontent=$_POST["listcontent"];

$listtitleimg=$_POST["listtitleimg"];
$listtitleimgpath=$_POST["listtitleimgpath"];


$code=$destcode;
//destcode로 list는 생성
//고유코드 연월일시분초 13중 뒤 6자리
$rand = strtoupper(substr(uniqid(sha1()),7));
$list= "L".date("YmdHis").$rand;

$listtitle=trim($listtitle);
$listcontent=trim($listcontent);
$listtitleimg=trim($listtitleimg);
$listtitleimgpath=trim($listtitleimgpath);

$pidx=0;
$listorder=0;
$sql="insert into tb_list(code, list, listtitle, listtitleimg, listtitleimgpath, listcontent, youtube, pidx, listorder)
      values('$code','$list','$listtitle','$listtitleimg', '$listtitleimgpath','$listcontent', '$youtube', -1, -1)";
sql_query($sql);
$my_idx=sql_insert_id();
echo($sql."<br>");

//내가 갖는 리스트의 레벨을 1 증가 시키고
$sql="update tb_list set listorder=listorder+1 where code='$targetcode'";
echo($sql."<br>");
sql_query($sql);

//내가 갖는 pidx를 나의 idx로 변경
$sql="update tb_list set pidx='$my_idx' where code='$targetcode' and pidx=0";
echo($sql."<br>");
sql_query($sql);

//임시 pidx -1을 다시 0으로 변경
$sql="update tb_list set pidx=0, listorder=0 where code='$code' and pidx=-1 and listorder=-1";
echo($sql."<br>");
sql_query($sql);

//내가 갖는 문제리스트의 모든 코드를 destcode로 업데이트
$sql="update tb_qlist set code='$destcode' where code='$targetcode'";
echo($sql."<br>");
sql_query($sql);

//내 코드가 갖는 리스트의 모든 코드를 destcode로 업데이트
$sql="update tb_list set code='$destcode' where code='$targetcode'";
echo($sql."<br>");
sql_query($sql);

//기존 tb_container는 삭제
$sql="delete from tb_container where code='$targetcode'";
echo($sql."<br>");
sql_query($sql);

//tb_elist, tb_exam, tb_exam_idx, groups, codes의 코드들
//시험 처리는 삭제해야 할듯 ..............................
//하위로 들어가기때문에 code는 destcode로 list는 대 list로 업데이트....
//$sql="update tb_exam set code='$destcode', list where code='$targetcode'";
//echo($sql."<br>");

//tb_answerlog의 코드값들은 어떻게 할 것인가
//destcode로 바꾸면 문제되는가..................................
$sql="update tb_answerlog set code='$destcode' where code='$targetcode'";
echo($sql."<br>");
sql_query($sql);

goto_url("view?code=$destcode");
?>
