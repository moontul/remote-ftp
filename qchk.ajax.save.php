<?php include_once('./_common.php');

//사용자가 어떤 문제를 풀었을때 로그를 저장함
//cbt 문제 풀이와 분리하기 위해 fromcbt를 0인 값으로 처리

$qcode=$_GET["qcode"];
$mb_id=$_GET["mb_id"];

$code=$_GET["code"];
$list=$_GET["list"];

$anum=$_GET["anum"];
$answer=$_GET["answer"];
$essay=$_GET["essay"];

$correctval=$_GET["correctval"];

$opt1=$_GET["opt1"]; //코드 문제의 경우 컴파일 결과값
$opt2=$_GET["opt2"]; //코드 문제의 경우 컴파일언어

if($is_member!=""){ ///로그인 되어 있을경우 디비에 저장

          $sql="select count(*) as cnt from tb_answerlog where mb_id='$mb_id' and qcode='$qcode' and fromcbt=0";
          $row=sql_fetch($sql);
          if ($row['cnt']){

              if((int)$correctval==1){
                $sql = "update tb_answerlog set counttrue=counttrue+1, countall=countall+1, in_date=now(), anum='$anum', answer='$answer', essay='$essay', opt1='$opt1'
                        where mb_id='$mb_id' and qcode='$qcode' and fromcbt=0";
              }elseif((int)$correctval==-1){
                $sql = "update tb_answerlog set countfalse=countfalse+1, countall=countall+1, in_date=now(), anum='$anum', answer='$answer', essay='$essay', opt1='$opt1'
                        where mb_id='$mb_id' and qcode='$qcode' and fromcbt=0";
              }else{
                $sql = "update tb_answerlog set countall=countall+1, in_date=now(), anum='$anum', answer='$answer', essay='$essay', opt1='$opt1'
                        where mb_id='$mb_id' and qcode='$qcode' and fromcbt=0";
              }
              sql_query($sql);

          }else{

            if((int)$correctval==1){
              $sql = " insert into tb_answerlog (mb_id, qcode, code, list, anum, answer, essay, opt1, counttrue, countall, fromcbt)
                       values('$mb_id', '$qcode', '$code','$list', '$anum', '$answer', '$essay', '$opt1', 1, 1, 0)";
            }elseif((int)$correctval==-1){
              $sql = " insert into tb_answerlog (mb_id, qcode, code, list, anum, answer, essay, opt1, countfalse, countall, fromcbt)
                       values('$mb_id', '$qcode','$code', '$list', '$anum','$answer', '$essay', '$opt1',  1, 1, 0)";
            }else{
              $sql = " insert into tb_answerlog (mb_id, qcode, code, list, anum, answer, essay, opt1, countall, fromcbt)
                       values('$mb_id', '$qcode','$code','$list','$anum', '$answer', '$essay', '$opt1',  1, 0)";
            }
            sql_query($sql);
          }

          echo($sql);
}else{

  //setcookie("PANGPANG_WRITE", $pangpang_write, 0, '/');

  // set the cookies
  if((int)$correctval==-1){
    $x=$_COOKIE['pangx'][$qcode];
    if($x==""){$x=0;}
    setcookie("pangx[$qcode]", $x+1,  0, '/');
  }
  if((int)$correctval==1){
    $o=$_COOKIE['pango'][$qcode];
    if($o==""){$o=0;}
    setcookie("pango[$qcode]", $o+1,  0, '/');
  }
  setcookie("panga[$qcode]", $anum,  0, '/');
  setcookie("pangn[$qcode]", $answer,  0, '/');
  setcookie("pange[$qcode]", $essay,  0, '/');
  setcookie("pangd[$qcode]", time(),  0, '/');
  setcookie("pangv[$qcode]", $correctval,  0, '/');


//  setcookie("pangpang[two]", "cookietwo");
//  setcookie("cookie[one]", "cookieone");

  // after the page reloads, print them out
//  if (isset($_COOKIE['cookie'])) {
//      foreach ($_COOKIE['cookie'] as $name => $value) {
//          $name = htmlspecialchars($name);
//          $value = htmlspecialchars($value);
//          echo "$name : $value <br />\n";
//      }
//  }

  /*
  if($pangpang_write=="checked"){
    goto_url("/write?list=$list");

  }else{
    unset($_COOKIE["PANGPANG_WRITE"]);setcookie('PANGPANG_WRITE', '', time() - 3600, '/');
    goto_url("/view?list=$list");

  }
  */

  //로그인되어 있지 않으면 쿠키에 저장
  echo("cookie");


}
?>
