<?php include_once("_admintop.php");?>

<?php include_once("code_sub.php");?>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<?php if($code!=""){ ?>
<h5 class="h5 text-gray-900"><?=$code_name?> 정보 수정</h5>
<?php } else { ?>
<h5 class="h5 text-gray-900">새<?=$code_name?> 만들기</h5>
<?php } ?>
<hr>

<form name=f method=post action="code_save.php">
<input type=hidden name="code" value="<?=$code?>">

<?php
if($code!=""){
    include_once('_conn.php');

    $sql="select * from ".$code_table." where ".$code_code."='".$code."'";
    $result = mysqli_query($conn, $sql);
    $row=$result->num_rows;
    //echo($sql);
    foreach($result as $list)
    {

      for($i=0;$i<count($code_col_all);$i++){
        ${$code_col_all[$i]} = $list[$code_col_all[$i]];
      }
    }
}
?>

<? for($i=0;$i<count($code_col_all);$i++) { ?>
<div class="row">
  <div class="col-sm-1"><?=$code_col_name_all[$i]?></div>

  <?if($code_col_type_all[$i]=="textarea"){?>
    <div class="col-sm-11"><textarea name="<?=$code_col_all[$i]?>" class="form-control form-control-sm"
      autocomplete=off><?=${$code_col_all[$i]}?></textarea></div>

  <?}else{?>
    <div class="col-sm-11"><input type=text name="<?=$code_col_all[$i]?>" class="form-control form-control-sm"
      value="<?=${$code_col_all[$i]}?>"
      autocomplete=off></div>

  <?}?>

</div>
<? } ?>

<hr>

<input type=submit value="저장" class=" btn btn-primary btn-sm">

<a href="code_list.php?code=<?=$code?>" class="btn btn-secondary btn-sm">목록</a>

</form>






</div>
<!-- /.container-fluid -->
<?php
require("_adminbottom.php");
?>
