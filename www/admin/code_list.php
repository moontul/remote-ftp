<?php include_once("_admintop.php");?>

<?php include_once("code_sub.php");?>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h4 class="h5 text-gray-900"><?=$code_name?> 목록</h4>
<hr>

<?php include_once('_conn.php');

    $sql="select * from ".$code_table." ";
    $result = mysqli_query($conn, $sql);
  //  $row=$result->num_rows;
?>

	<!-- DataTales Example -->
			<div class="XXXtable-responsive">
				<table class="table table-sm" id="dataTable" width="100%" cellspacing="0">
				<thead>
				<tr>
				<th nowrap style="width:5%">No</th>
        <? for($i=0;$i<count($code_col_name);$i++) {?>
				<th nowrap><?=$code_col_name[$i]?></th>
        <? } ?>
				<th nowrap>단원관리</th>
				</tr>
				</thead>
				<!--tfoot>
				<tr>
				<th>No</th>
				<th nowrap>시험이름</th>
				<th nowrap>시행일자</th>
				<th nowrap>시험지</th>
				<th nowrap>문제목록</th>
				</tr>
				</tfoot-->
				<tbody>

<?php
foreach($result as $list)
{
?>
				<tr>
				<td><input type="checkbox" name="" value="<?=$list[$code_code]?>"></td>
        <? for($i=0;$i<count($code_col);$i++) {?>
        <? if($i==0){?>
        <td><a href="code_view.php?code=<?=$list[$code_code]?>"><?=$list[$code_col[$i]]?></a></td>
        <? }else{ ?>
        <td><?=$list[$code_col[$i]]?></td>
        <? }?>
        <? } ?>
				<td><a href="codeunit_list.php?code=<?=$list[$code_code]?>">단원관리</a></td>
				</tr>
<?php
}
?>
				</tbody>
				</table>
			</div>

			<a href="code_edit.php?code=<?=$code?>" class="btn btn-primary btn-sm">새 <?=$code_name?> 만들기</a>

	<!-- DataTales Example end-->







</div>
<!-- /.container-fluid -->
<?php require("_adminbottom.php");?>

<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<xxxscript src="js/demo/datatables-demo.js"></xxxscript>
