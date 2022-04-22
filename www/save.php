<?php include_once('./_common.php');

  $code=$_POST["code"];
  $type=$_POST["type"];
  $title=$_POST["title"];
  $subtitle=$_POST["subtitle"];
  $content=$_POST["content"];

  $mode=$_POST["mode"];

if($mode=="d"){

  //문제 목록 삭제
  $sql="delete from tb_qlist where code='$code'";
  sql_query($sql);

  //목록 삭제
  $sql="delete from tb_list where code='$code'";
  sql_query($sql);

  //컨테이너 삭제
  $sql="delete from tb_container where code='$code'";
  sql_query($sql);

  if($type=="과목"){
    goto_url("/subject");
  }
  if($type=="자격시험"){
    goto_url("/license");
  }
  if($type=="도서"){
    goto_url("/book");
  }

}else{


  if($code==""){
    //고유코드 연월일시분초 13중 뒤 6자리
     $rand = strtoupper(substr(uniqid(sha1()),7));
     $code= "C".date("YmdHis").$rand;

    $sql="insert into tb_container(code, type, title, subtitle, content) values('$code','$type','$title','$subtitle','$content')";
    sql_query($sql);
  }else{

    $sql="update tb_container set
    type='$type'
    ,title='$title'
    ,subtitle='$subtitle'
    ,content='$content'
    where code='$code'";
    sql_query($sql);
  }
  goto_url("/view?code=$code");
}
?>
