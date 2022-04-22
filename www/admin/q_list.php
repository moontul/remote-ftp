<?php include_once("_admintop.php");?>
<style>
.f11 {font-size:11px;}
.f12 {font-size:12px;}
.f13 {font-size:13px;}
</style>
<!-- Begin Page Content -->
<div class="container-fluid">
<?php include_once('_conn.php');

  $bkcode=$_GET["bkcode"];
  $bkucode=$_GET["bkucode"];
  $tcode=$_GET["tcode"];

  // 페이징 구현 --------------------------------------------------------
  $page=$_GET["page"];
  if($page==""){$page=1;}
  $sql = "SELECT * FROM tb_question";
  $result = mysqli_query($conn, $sql);
  $total_record=$result->num_rows;
  $list_record = 30; // 한 페이지에 보여줄 게시물 개수
  $block_cnt = 5; // 하단에 표시할 블록 당 페이지 개수
  $block_num = ceil($page / $block_cnt); // 현재 페이지 블록
  $block_start = (($block_num - 1) * $block_cnt) + 1; // 블록의 시작 번호
  $block_end = $block_start + $block_cnt - 1; // 블록의 마지막 번호
  $total_page = ceil($total_record / $list_record); // 페이징한 페이지 수
  if($block_end > $total_page){$block_end = $total_page;}// 블록 마지막 번호가 총 페이지 수보다 크면 마지막 페이지 번호를 총 페이지 수로 지정함
  $total_block = ceil($total_page / $block_cnt); // 블록의 총 개수
  $page_start = ($page - 1) * $list_record; // 페이지의 시작 (SQL문에서 LIMIT 조건 걸 때 사용)

  $sql="select * ";
  $sql=$sql . ",(select subjectname from tb_subject where sjcode=A.sjcode) as subjectname ";
  $sql=$sql . ",(select licensename from tb_license where lccode=A.lccode) as licensename ";
  $sql=$sql . ",(select bookname from tb_book where bkcode=A.bkcode) as bookname ";
  $sql=$sql . " from tb_question A where 1=1 ";

if($tcode!=""){   $sql=$sql . " and tcode='$tcode' "; }

if($bkcode!=""){   $sql=$sql . " and bkcode='$bkcode' "; }
if($bkucode!=""){   $sql=$sql . " and bkucode='$bkucode' "; }


  $sql=$sql . " order by in_date desc";
  $sql=$sql . " LIMIT $page_start, $list_record ";
  $result = mysqli_query($conn, $sql);

  //echo($sql);

  $hrefsrc="q_list.php?qcode=$qcode&bkcode=$bkcode&bkucode=$bkucode";
?>

<!-- Page Heading -->
<h5 class="h5 text-gray-900">
  문제 목록

  <span style="font-size:13px">
  한페이지
    <select>
    <option value=30>30
    <option value=100>100
    </select>
  </span>
  <span style="font-size:13px">
  문제
    <input type=text size=10>
  </span>
</h5>
<hr>


	<!-- DataTales Example -->

<div class="xxxtable-responsive">
  <form name=f method=post>
	<table class="table table-sm" id="dataTable" width="100%" cellspacing="0">
	<thead>
	<tr>
  <td style="width:5%;"><input type="checkbox" name="chk_qcode_all" id="chk_qcode_all"></td>
  <th nowrap style="width:9%;">문제유형</th>
	<th nowrap>번호. 문제</th>
  <th nowrap>제공방식</th>
  <th nowrap>문제풀기</th>
  <th nowrap>Merrill</th>
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
        <td><input type="checkbox" name="chk_qcode_a[]" class="chk_qcode_a" value="<?=$list['qcode']?>"></td>
        <td class="f11"><?=$list['qtype']?></td>
				<td class="f13"><a href="q_edit.php?qcode=<?=$list['qcode']?>"><?=$list['qnum']?>. <?=mb_substr($list['qtext'],0,40)?>..</a></td>
        <td class="f11"><?=$list['subjectname']?><?=$list['licensename']?><?=$list['bookname']?></td>
        <td><a href="q_test.php?qcode=<?=$list['qcode']?>">풀어보기</a></td>
        <td class="f11"><?=$list['merrill_x']?>X<?=$list['merrill_y']?></td>
				</tr>
<?php
}
?>
				</tbody>
				</table>
			</div>

<!-- 게시물 목록 중앙 하단 페이징 부분-->
<nav aria-label="Page navigation example">
<ul class="pagination justify-content-center">
<?php
           if ($page <= 1){
               // 빈 값
           } else {
               if(isset($unum)){
                   echo "<li class='page-item'><a class='page-link' href='$hrefsrc&page=1' aria-label='Previous'>처음</a></li>";
               } else {
                   echo "<li class='page-item'><a class='page-link' href='$hrefsrc&page=1' aria-label='Previous'>처음</a></li>";
               }
           }
           if ($page <= 1){
               // 빈 값
           } else {
               $pre = $page - 1;
               if(isset($unum)){
                   echo "<li class='page-item'><a class='page-link' href='$hrefsrc&page=$pre'>◀ 이전 </a></li>";
               } else {
                   echo "<li class='page-item'><a class='page-link' href='$hrefsrc&page=$pre'>◀ 이전 </a></li>";
               }
           }
           for($i = $block_start; $i <= $block_end; $i++){
               if($page == $i){
                   echo "<li class='page-item'><a class='page-link' disabled><b style='color: #df7366;'> $i </b></a></li>";
               } else {
                   if(isset($unum)){
                       echo "<li class='page-item'><a class='page-link' href='$hrefsrc&page=$i'> $i </a></li>";
                   } else {
                       echo "<li class='page-item'><a class='page-link' href='$hrefsrc&page=$i'> $i </a></li>";
                   }
               }
           }
           if($page >= $total_page){
               // 빈 값
           } else {
               $next = $page + 1;
               if(isset($unum)){
                   echo "<li class='page-item'><a class='page-link' href='$hrefsrc&page=$next'> 다음 ▶</a></li>";
               } else {
                   echo "<li class='page-item'><a class='page-link' href='$hrefsrc&page=$next'> 다음 ▶</a></li>";
               }
           }

           if($page >= $total_page){
               // 빈 값
           } else {
               if(isset($unum)){
                   echo "<li class='page-item'><a class='page-link' href='$hrefsrc&page=$total_page'>마지막</a>";
               } else {
                   echo "<li class='page-item'><a class='page-link' href='$hrefsrc&page=$total_page'>마지막</a>";
               }
           }
?>
</ul>
</nav>


<a href="q_edit.php" class="btn btn-primary">새 문제 만들기</a>

<input type=button class="btn btn-secondary" value="선택 문제 삭제" onclick="isSelDel()">


</form>
<!--a href="javascript:alert('문제복제 준비 중이에요....')" class="btn btn-secondary">문제 복제</a-->
<!-- DataTales Example end-->
<script>
$(function(){

  $("#chk_qcode_all").click(function(g){
    if($(this).prop("checked")){
      $(".chk_qcode_a").prop("checked", true );
    }else{
      $(".chk_qcode_a").prop("checked", false );
    }
  })
});
function isSelDel(){
  if(confirm("정말 삭제할까요?")){
    document.f.action="q_seldel.php";
    document.f.submit();
  }

}
</script>

</div>
<!-- /.container-fluid -->
<?php require("_adminbottom.php");?>

<!-- Page level plugins -->
<xxxscript src="vendor/datatables/jquery.dataTables.min.js"></xxxscript>
<xxxscript src="vendor/datatables/dataTables.bootstrap4.min.js"></xxxscript>

<!-- Page level custom scripts -->
<xxxscript src="js/demo/datatables-demo.js"></xxxscript>
