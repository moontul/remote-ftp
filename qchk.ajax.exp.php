<?php include_once('./_common.php');

function getRealClientIp() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP')) {
        $ipaddress = getenv('HTTP_CLIENT_IP');
    } else if(getenv('HTTP_X_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    } else if(getenv('HTTP_X_FORWARDED')) {
        $ipaddress = getenv('HTTP_X_FORWARDED');
    } else if(getenv('HTTP_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    } else if(getenv('HTTP_FORWARDED')) {
        $ipaddress = getenv('HTTP_FORWARDED');
    } else if(getenv('REMOTE_ADDR')) {
        $ipaddress = getenv('REMOTE_ADDR');
    } else {
        $ipaddress = '알수없음';
    }
    return $ipaddress;
}


  $mode=$_POST["mode"];
  $idx=$_POST["idx"]; ///해설 고유번호
  $qcode=$_POST["qcode"];
  $qexp=$_POST["qexp"];
  $mb_id=$_POST["mb_id"];

if($is_member){ ////////////////////////////////// 로그인되었을때만

  //포인트
  if($mode=="p"){
    $sql="update tb_qexplain set point=point+1 where idx=$idx";
    sql_query($sql);
  }else{

    //세션이 본인 이거나 관리자 일경우
    if(($mb_id==$member["mb_id"])||$is_admin){

      if($mode=="d"){
        $sql="delete from tb_qexplain where idx=$idx";
        sql_query($sql);
      }else if($mode=="u"){
        $sql="update tb_qexplain set qexplain='$qexp' where idx=$idx";
        sql_query($sql);
        echo($sql);
      }else{
        $my_id=getRealClientIp();
        $sql="insert into tb_qexplain(qcode, mb_id, qexplain, ip_address) values(
          '$qcode', '$mb_id', '$qexp', '$my_id'
          )";
        sql_query($sql);
        $idx = sql_insert_id();
        echo($idx);
      }

    }
  }
}
?>
