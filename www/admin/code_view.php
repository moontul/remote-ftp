<?php include_once("_admintop.php");?>

<?php include_once("code_sub.php");?>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<?php if($code!=""){ ?>
<h5 class="h5 text-gray-900"><?=$code_name?> 정보</h5>
<?php } else { ?>
<h5 class="h5 text-gray-900"><?=$code_name?> 만들기</h5>
<?php } ?>
<hr>

<h6>
<br>
<?php
if($code!=""){

    include_once('_conn.php');

    $sql="select * from ".$code_table." where ".$code_code."='".$code."'";
    $result = mysqli_query($conn, $sql);
    $row=$result->num_rows;
    //echo($sql);
    foreach($result as $list)
    {
    //    $bookname=$list["bookname"];
		//    $author=$list["author"];
  //      $publisher=$list["publisher"];
  //      $bookdesc=$list["bookdesc"];
      for($i=0;$i<count($code_col);$i++){
?>
<b><?=$code_col_name[$i]?> : </b><?=$list[$code_col[$i]]?>
<br><br>
<?    }
    }
}
?>
</h6>

<?php
if($code!=""){

    $sql="select * , (select count(*) from tb_question where $code_unitcode=A.$code_unitcode) as qcnt from $code_unittable A where $code_code='$code' order by unitorder";
    $result = mysqli_query($conn, $sql);
  //  $row=$result->num_rows;
  //echo($sql);
?>
<hr>
<!-- Page Heading -->
<h5 class="h5 text-gray-900">단원 정보</h5>

<div class="XXXtable-responsive">
	<table class="table table-sm" id="dataTable" width="100%" cellspacing="0">
	<thead>
	<tr>
	<th nowrap>단원</th>
	<th nowrap>문제등록</th>
  <th nowrap>등록수</th>
	</tr>
	</thead>
	<tfoot>
	</tfoot>
	<tbody>
<?php
foreach($result as $list)
{
?>
				<tr>
        <td><?for($i=0;$i<=$list['u_tab'];$i++){?> &nbsp;  &nbsp; <?}?><?=$list['unitname']?></td>
        <td>
          <a href="q_edit.php?<?=$code_code?>=<?=$code?>&<?=$code_unitcode?>=<?=$list[$code_unitcode]?>">등록</a>
        </td>
        <td>
          <a href="q_list.php?bkcode=<?=$bkcode?>&<?=$code_unitcode?>=<?=$list[$code_unitcode]?>"><?=$list['qcnt']?></a></td>
				</tr>
<?php } ?>

</table>
</div>

<hr>
<?php } ?>

<br><br>

<a href="code_edit.php?code=<?=$code?>" class="btn btn-primary btn-sm"><?=$code_name?> 정보 수정</a>
<a href="codeunit_list.php?code=<?=$code?>" class="btn btn-primary btn-sm">단원 정보 수정</a>
<a href="code_list.php?code=<?=$code?>" class="btn btn-secondary btn-sm"><?=$code_name?> 목록</a>

</form>

&nbsp;
<input type="button" value="<?=$code_name?> 삭제" class="btn btn-secondary btn-sm" onclick="isDel()">
<form name=fdel method=post action="code_del.php"><input type=hidden name=code value="<?=$code?>"></form>

<script>
function isDel()
{
  if(confirm("정말 삭제할까요?\n(<?=$code_name?>정보와 단원정보 모두 삭제되며 복구할 수 없습니다!)"))
  {
    document.fdel.submit();
  }
}
</script>














</div>
<!-- /.container-fluid -->
<?php
require("_adminbottom.php");
?>
