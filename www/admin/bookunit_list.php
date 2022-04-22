<?php include_once("_admintop.php");?>
<!-- Begin Page Content -->
<div class="container-fluid">

<?php include_once('_conn.php');

	$bkcode = $_GET['bkcode'];

if($bkcode!=""){

    $sql="select * from tb_book where bkcode='$bkcode'";
    $result = mysqli_query($conn, $sql);
    $row=$result->num_rows;
    foreach($result as $list)
    {
        $bookname=$list["bookname"];
				$author=$list["author"];
				$publisher=$list["publisher"];
				$bookdesc=$list["bookdesc"];
    }
}

  $sql="select * from tb_bookunit where bkcode='$bkcode' order by bookunitorder";
  $result = mysqli_query($conn, $sql);
  $row=$result->num_rows;
	$key=$row;
?>

<!-- Page Heading -->
<h5 class="h5 text-gray-900">
단원 관리 - <?=$bookname?>
</h5>
<hr>

	<!-- DataTales Example -->
	<form name=f method="post" action="bookunit_save.php">
	<input type=hidden name=bkcode value="<?=$bkcode?>">
			<div class="XXXtable-responsive">
				<table class="table table-sm" id="dataTable" width="100%" cellspacing="0">
				<thead>
				<tr>
				<th nowrap width=10%>No</th>
				<th nowrap>단원이름*</th>
				<th nowrap width=30% style="text-align:center;">위치조정</th>
				</tr>
				</thead>
				<tfoot>
					<?php for($i=0;$i<=2;$i++){ ?>
									<tr>
									<th>새단원
										<input type="hidden" name="new_unitorder_a[]" size=1  class="form-control form-control-sm" value="<?=($key+$i)?>" autocomplete="off">
										<input type="hidden" name="new_p_bku_idx_a[]" size=2  value="0"  autocomplete="off">
										<input type="hidden" name="new_bku_tab_a[]" size=2 value="0"  autocomplete="off">
									</th>
									<th nowrap><input type="text" name="new_unitname_a[]" size=15  class="form-control form-control-sm" autocomplete="off"></th>
					        <th nowrap>&nbsp;</th>
									</tr>
					<?php } ?>
				</tfoot>
				<tbody>


<?php
foreach($result as $key => $list)
{
?>
				<tr class="c_tr">
				<td>
					<input type=hidden size=1 value="<?=$list['bku_idx']?>" class="c_idx">
					<input type="checkbox" name="chk_bkucode_a[]" value="<?=$list['bkucode']?>">
					<input type=hidden name="bkucode_a[]" class="c_u_c" value="<?=$list['bkucode']?>">
					<input type=hidden name="bookunitorder_a[]" class="c_u_o" value="<?=$key?>" size=2 class="form-control form-control-sm">
					<input type=hidden name="p_bku_idx_a[]" class="c_p_idx" value="<?=$list['p_bku_idx']?>" size=2>
					<input type=hidden name="bku_tab_a[]" class="c_tab" value="<?=$list['bku_tab']?>" size=2>
				</td>
				<td style="text-align:right;">
												<? $myw=(100-($list['bku_tab']*10)) ?>
					<input type=text name="bookunitname_a[]" class="c_u_n __f12" style="width:<?=$myw?>%;" value="<?=$list['bookunitname']?>" autocomplete=off></td>
				<td nowrap>
					<input type=button value="+" class="btn btn-sm btnnew">
					<input type=button value="└" class="btn btn-sm btnadd">
					<input type=button value="↑" class="btn btn-sm btnup"><input type=button value="↓" class="btn btn-sm btndn">
						<input type=button value="→" class="btn btn-sm btabin"><input type=button value="←" class="btn btn-sm btabout">
				</td>
				</tr>
<?php } ?>
				</tbody>
				</table>
			</div>

			<input type=submit class="btn btn-primary btn-sm" value="단원 저장">
			<a href="book_view.php?bkcode=<?=$bkcode?>" class="btn btn-secondary btn-sm">도서 정보</a>
			<input type=button class="btn btn-secondary btn-sm" value="선택 단원 삭제" onclick="preDel()">
	</form>
	<!-- DataTales Example end-->
	<script>
	function preDel(){
		if(confirm("선택단원을 삭제할까요?")){
				document.f.action="bookunit_seldel.php";
				document.f.submit();
		}
	}

	$(document).on('click', '.btnnew', function(e) {
		var myi=parseInt($(".btnnew").index(this)); //내순서
		//if(myi==0){console.log("최상위");return;}
		var myo=parseInt($(".c_u_o:eq("+myi+")").val()); //내순서의 단원순서
		//var upo=$(".c_u_o:eq("+(myi-1)+")").val(); //내순서 한칸위의 단원순서
		var v=$(".c_tr:eq("+myi+")")[0].outerHTML; //내순서에 해당하는 tr
		$(".c_tr:eq("+(myi)+")").after(v)
		//$(".c_tr:eq("+(myi+1)+")").remove();
		$(".c_idx:eq("+(myi+1)+")").val("");
		$(".c_u_n:eq("+(myi+1)+")").val("");
		$(".c_u_c:eq("+(myi+1)+")").val("");

		$(".c_u_o:eq("+(myi+1)+")").val(myo+1);
		//새로 생긴 줄 아래 번호증가
		for(var i=(myi+2);i<=$(".c_tr").length;i++){
			$(".c_u_o:eq("+(i)+")").val(parseInt($(".c_u_o:eq("+(i)+")").val())+1);
		}
		return;
	});
//하위에 하나 추가함
	$(document).on('click', '.btnadd', function(e) {
		var myi=parseInt($(".btnadd").index(this)); //내순서
		var myo=parseInt($(".c_u_o:eq("+myi+")").val()); //내순서의 단원순서

		var myt=parseInt($(".c_tab:eq("+myi+")").val()); //내순서의 탭
		var myk=$(".c_idx:eq("+myi+")").val(); //내키
		if(myk==""){console.log("키없음");return;}
		myk=parseInt(myk);
		var v=$(".c_tr:eq("+myi+")")[0].outerHTML; //내순서에 해당하는 tr
		$(".c_tr:eq("+(myi)+")").after(v)
		//$(".c_tr:eq("+(myi+1)+")").remove();
		$(".c_idx:eq("+(myi+1)+")").val("");
		$(".c_u_n:eq("+(myi+1)+")").val("");
		$(".c_u_c:eq("+(myi+1)+")").val("");
		$(".c_u_o:eq("+(myi+1)+")").val(myo+1);
		$(".c_tab:eq("+(myi+1)+")").val(myt+1); //탭=내탭+1
		$(".c_u_n:eq("+(myi+1)+")").css("width",(100-(myt+1)*10)+"%");

		$(".c_p_idx:eq("+(myi+1)+")").val(myk); //부모키=내키

		//새로 생긴 줄 아래 번호증가
		for(var i=(myi+2);i<=$(".c_tr").length;i++){
			$(".c_u_o:eq("+(i)+")").val(parseInt($(".c_u_o:eq("+(i)+")").val())+1);
		}
		return;
	});

	$(document).on('click', '.btnup', function(e) {
		$('[type=text], textarea').each(function(){ this.defaultValue = this.value; });
		$('[type=checkbox], [type=radio]').each(function(){ this.defaultChecked = this.checked; });
		$('select option').each(function(){ this.defaultSelected = this.selected; });

		var myi=parseInt($(".btnup").index(this)); //내순서
		if(myi==0){console.log("최상위");return;}

		var myo=$(".c_u_o:eq("+myi+")").val(); //내순서의 단원순서
		var upo=$(".c_u_o:eq("+(myi-1)+")").val(); //내순서 한칸위의 단원순서

		//두칸위에 탭이 나보다 2작으면 안감
		var myt=parseInt($(".c_tab:eq("+(myi)+")").val()); //내순서 탭
		var upt=parseInt($(".c_tab:eq("+(myi-1)+")").val()); //내순서 한칸위의 탭
		var upt2=parseInt($(".c_tab:eq("+(myi-2)+")").val()); //내순서 두칸위의 탭

		if((myt>0) && myi<=1){console.log("최상위안됨");return;}
		if( upt != (myt)){console.log("같은탭아님");return};
		if( upt >= (myt+2)){console.log("구조깨짐");return};
		if( upt2 <= (myt-2)){console.log("구조깨짐");return};

		var v=$(".c_tr:eq("+myi+")")[0].outerHTML; //내순서에 해당하는 tr

		$(".c_tr:eq("+(myi-1)+")").before(v)
		$(".c_tr:eq("+(myi+1)+")").remove();

		$(".c_u_o:eq("+(myi-1)+")").val(upo);
		$(".c_u_o:eq("+myi+")").val(myo); //내순서 단원순서 변경

	});

	$(document).on('click', '.btndn', function(e) {
		$('[type=text], textarea').each(function(){ this.defaultValue = this.value; });
		$('[type=checkbox], [type=radio]').each(function(){ this.defaultChecked = this.checked; });
		$('select option').each(function(){ this.defaultSelected = this.selected; });

		var myi=parseInt($(".btndn").index(this)); //내순서
		if(($(".btndn").length-1)==myi){console.log("최하위");return;}

		var myo=$(".c_u_o:eq("+myi+")").val(); //내순서의 단원순서
		var dno=$(".c_u_o:eq("+(myi+1)+")").val(); //내순서 한칸아래 단원순서

		//두칸아래 탭이 나보다 2작으면 안감
		var myt=parseInt($(".c_tab:eq("+(myi)+")").val()); //내순서 탭
		var dnt=parseInt($(".c_tab:eq("+(myi+1)+")").val()); //내순서 한칸아래탭
		var dnt2=parseInt($(".c_tab:eq("+(myi+2)+")").val()); //내순서 두칸아래 탭

//		if((myt>0) && myi<=1){console.log("최상위안됨");return;}
		if( dnt != myt){console.log("같은탭아님");return};
		if( dnt <= (myt-2)){console.log("구조깨짐:2단계차이");return};
		if( dnt2 >= (myt+2)){console.log("구조깨짐:아래아래깨짐");return};

		var myk=parseInt($(".c_idx:eq("+(myi)+")").val()); //내순서 키 내 탭보다 1큰 탭들의 부모키를 내키로 변경

		var v=$(".c_tr:eq("+myi+")")[0].outerHTML; //내순서에 해당하는 tr

		$(".c_tr:eq("+(myi+1)+")").after(v);
		$(".c_tr:eq("+(myi)+")").remove();

		$(".c_u_o:eq("+(myi)+")").val(myo);
		$(".c_u_o:eq("+(myi+1)+")").val(dno); //내순서 단원순서 변경


		for(var i=myi;i<($(".c_tr").length);i++){
			var yourt=parseInt($(".c_tab:eq("+(i)+")").val());
			if(yourt==(myt+1)){
				console.log(yourt);
				//var youridx=$(".c_idx:eq("+i+")").val();
				$(".c_p_idx:eq("+i+")").val(myk);
				//break;
			}
		}

	});

//한칸 안으로 넣기
	$(document).on('click', '.btabin', function(e) {
		$('[type=text], textarea').each(function(){ this.defaultValue = this.value; });
		$('[type=checkbox], [type=radio]').each(function(){ this.defaultChecked = this.checked; });
		$('select option').each(function(){ this.defaultSelected = this.selected; });

		var myi=parseInt($(".btabin").index(this)); //내순서

		var v=($(".c_tab:eq("+myi+")").val()); //내순서에 해당하는 탭 번호
		var v1=($(".c_tab:eq("+(myi-1)+")").val()); //내순서한칸위 탭
		//내순서한칸 위보다 2 차이 허용하지 않음
		if((v1-v)==-1){return;};

		var myt=parseInt($(".c_tab:eq("+myi+")").val())+1;//내 탭 1증가
		$(".c_tab:eq("+myi+")").val(myt);

		$(".c_u_n:eq("+myi+")").css("width",(100-(myt*10))+"%");

		//안으로 넣는다=상위idx 중 내 탭보다 작은 idx를 부모로 한다
		for(var i=myi;i--;i>=0){
			var yourt=parseInt($(".c_tab:eq("+(i)+")").val());
			if(yourt<myt){
				var youridx=$(".c_idx:eq("+i+")").val();
				$(".c_p_idx:eq("+myi+")").val(youridx);
				break;
			}
		}

	})

	$(document).on('click', '.btabout', function(e) {
		$('[type=text], textarea').each(function(){ this.defaultValue = this.value; });
		$('[type=checkbox], [type=radio]').each(function(){ this.defaultChecked = this.checked; });
		$('select option').each(function(){ this.defaultSelected = this.selected; });

		var myi=parseInt($(".btabout").index(this)); //내순서

		var v=($(".c_tab:eq("+myi+")").val()); //내순서에 해당하는 탭 번호
		if(v==0){return;}
		var myt=parseInt($(".c_tab:eq("+myi+")").val())-1;//내 탭 1 감소
		$(".c_tab:eq("+myi+")").val(myt);

		$(".c_u_n:eq("+myi+")").css("width",(100-(myt*10))+"%");

		//안으로 넣는다=상위idx 중 내 탭보다 작은 idx를 부모로 한다

		for(var i=myi;i--;i>=0){
			var yourt=parseInt($(".c_tab:eq("+(i)+")").val());
			if(yourt<myt){
				var youridx=$(".c_idx:eq("+i+")").val();
				$(".c_p_idx:eq("+myi+")").val(youridx);
				break;
			}
		}
		if(i==-1){$(".c_p_idx:eq("+myi+")").val(0);}

	})

	</script>

</div>
<!-- /.container-fluid -->
<?php require("_adminbottom.php");?>

<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<xxxscript src="js/demo/datatables-demo.js"></xxxscript>
