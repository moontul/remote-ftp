<?php include_once('./_common.php');

  $mode=$_POST["mode"];

  $code=$_POST["code"];
  $list=$_POST["list"];
  $listtitle=$_POST["listtitle"];
  $listcontent=$_POST["listcontent"];
  $youtube=$_POST["youtube"];


  $pidx=$_POST["pidx"];
  if($pidx==""){$pidx=0;}

  $pangpang_write=$_POST["pangpang_write"];

if($mode=="d"){

    $sql="select idx, pidx from tb_list where list='$list'";
    $result=sql_fetch($sql);
      $d_pidx=$result["pidx"];
      $d_idx=$result["idx"];
    $sql="update tb_list set pidx=$d_pidx where pidx=$d_idx";
    sql_query($sql);
    //echo($sql);
    $sql="delete from tb_list where list='$list'";
    sql_query($sql);
    goto_url("/view?code=$code");

}else{



  if($pidx>0){
    $sql="select listorder+1 as listorder from tb_list where idx=$pidx";
    $result=sql_fetch($sql);
    $listorder=$result["listorder"];
  }else{$listorder=0;}

  if($list==""){
    //고유코드 연월일시분초 13중 뒤 6자리
     $rand = strtoupper(substr(uniqid(sha1()),7));
     $list= "L".date("YmdHis").$rand;

     $sql="insert into tb_list(code, list, listtitle, listcontent, youtube, pidx, listorder)
     values('$code','$list','$listtitle','$listcontent', '$youtube', $pidx, $listorder)";
     sql_query($sql);
    echo($sql);

  }else{

    $sql="update tb_list set
    listtitle='$listtitle'
    , listcontent='$listcontent'
    , youtube='$youtube'
    , pidx=$pidx
    , listorder=$listorder
    where list='$list'";
    sql_query($sql);
    echo($sql);
  }


  if($pangpang_write=="checked"){
    setcookie("PANGPANG_WRITE", $pangpang_write, 0, '/');
  //  goto_url("/write?list=$list");

  }else{
    unset($_COOKIE["PANGPANG_WRITE"]);setcookie('PANGPANG_WRITE', '', time() - 3600, '/');
  //  goto_url("/view?list=$list");

  }
}

?>
