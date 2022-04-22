<?php include_once('./_common.php');
include_once("./page.head.php");
include_once(G5_THEME_PATH.'/head.php');
?>

<?php include_once("page.wraptop.php");?>
<?php include_once("page.nav.php");?>
<div class="col-lg-9 col-md-9 col-sm-12 pp-mainpage">
<?php include_once("page.adm.btns.php");?>


  <section class="pp-title">
        <div class="h4"><?=$total_code_title?> <sub>목록편집</sub></div>
  </selction>
  <hr class="pp-hr">

        <form name=f method="post" action="page_lsave.php">
        <input type=hidden name=mode>
        <input type=hidden name=edit_list value="<?=$list?>">
        <input type=hidden name=edit_idx id="edit_idx" value="<?=$page_idx?>">

              <table class="table table-sm pptable">
              <thead class="table-light">
              <tr>
                <th nowrap width=3%></th>
                <th nowrap>목록이름 <sub>* 같은 레벨의 목록 순서는 순서정렬+목록이름에 따라 정렬됩니다</sub></th>
                <th nowrap style="text-align:center;">순서용</th>
                <th nowrap style="text-align:center;">목록추가 &nbsp; 위치조정</th>
              </tr>
              </thead>
              <tfoot>
                <tr>
                <th>
                  새목록
                </th>
                <th nowrap colspan=2><textarea name="new_title" rows=10 class="form-control form-control-sm" autocomplete="off"></textarea></th>
                <th nowrap>
                    Tip!<br>
                    * 여러줄 입력할 수 있어요<br>
                    * 탭으로 하위목록을 정할 수 있어요<br> &nbsp; (2단계까지 지원)<br>
                    * 기존 목록을 체크하면<br> &nbsp; 그 목록의 하위목록으로 저장됩니다<br>
                </th>
                </tr>
              </tfoot>
              <tbody>


        <?php
        for($i=0;$i<count($a_idx);$i++){
        ?>
              <tr class="c_tr" onmouseover="this.style.backgroundColor='#efefef'" onmouseout="this.style.backgroundColor='#fff'">
              <td  style="width:60px;" nowrap>
                <div class="form-check">
                  <input type="checkbox" class="chk_idx form-check-input" name="chk_idx[]" value="<?=$a_idx[$i]?>" tabindex="-1">
                </div>
                <span class="d-none">
                  <input type=text size=1 class="c_idx" name="idx[]" value="<?=$a_idx[$i]?>" style="font-size:9px;">
                  <input type=text size=1 class="c_u_c" name="list[]"  value="<?=$a_list[$i]?>" style="font-size:9px;">
                  <input type=text size=1 class="c_u_o" name="unitorder_a[]" value="<?=$i?>" style="font-size:9px;">
                  <input type=text size=4 class="c_p_idx" name="pidx[]" value="<?=$a_pidx[$i]?>" style="font-size:9px;">
                  <input type=text size=1 class="c_tab" name="u_tab_a[]" value="<?=$a_lvl[$i]-1?>" style="font-size:9px;">
                </span>
              </td>
              <!--
              <td style="width:60px" nowrap>
                <input type=text size=1 class="c_listorder" name="listorder[]" value="<?=$a_listorder[$i]?>" style="font-size:9px;">
              </td>
              -->
              <td style="text-align:right;padding:0;width:100%;" nowrap>
                              <? $myw=(100-(($a_lvl[$i]-1)*7)) ?>
                <input type=text name="title[]" class="c_u_n underline"
                  style="width:<?=$myw?>%;font-size:13px;" value="<?=$a_title[$i]?>" autocomplete=off>
              </td>
              <td nowrap class="text-center">
                <input type=text name="titleorder[]" size=5 class="c_u_to underline" value="<?=$a_titleorder[$i]?>" style="font-size:13px;" autocomplete=off>
              </td>
              <td style="width:200px;" nowrap>

                <span class="td-buttons-del" style="display:none">
                  <a class="badge text-dark btn btn-sm u-btndel"> - </a>
                </span>

                <span class="td-buttons-1">
                  &nbsp; &nbsp;
                  <input type=text size=1 class="c_plus" value="3" style="font-size:13px;"  tabindex="-1">칸
                  <a class="badge text-dark btn btn-sm u-btnnew" title="같은 단계 목록 추가"  tabindex="-1"><i class="fas fa-caret-right"></i></a>
                  <a value="└" class="badge text-dark btn btn-sm u-btnadd" title="하위 목록 추가" tabindex="-1"><i class="fas fa-caret-down"></i></a>
                </span>

                <span class="td-buttons-2">
                  <!--input type=button value="↑" class="btn btn-pp-sx u-btnup"><input type=button value="↓" class="btn btn-pp-sx u-btndn"-->
                    <a type=button class="badge text-dark btn btn-sm u-btabin" title="하위 목록으로 이동"  tabindex="-1"><i class="fas fa-arrow-right"></i></a>
                    <a type=button class="badge text-dark btn btn-sm u-btabout" title="상위 목록으로 이동"  tabindex="-1"><i class="fas fa-arrow-left"></i></a>
                </span>

              </td>
              </tr>
        <?php } ?>
              </tbody>
              </table>



            <div class="mt-3 mb-3 text-center">
                <input type="submit" value=" 저장 " class="btn btn-sm bg-gradient-primary shadow-sm" accesskey="s">
                <a href="page?<?=$total_code?>" class="btn btn-sm btn-light shadow-sm">목록</a>

                <input type=button class="btn btn-sm btn-secondary shadow-sm" value="선택 목록 삭제" onclick="preDel()">
            </div>

           </form>

           <script>
           	function preDel(){
           		if(confirm("선택된 목록을 삭제할까요?")){
           				document.f.mode.value="d";
           				document.f.submit();
           		}
           	}


           $(document).on('click', '.u-btndel', function(e) {
             var myi=parseInt($(".u-btndel").index(this)); //내순서
             $(".c_tr:eq("+myi+")")[0].remove(); //내순서에 해당하는 tr
             //삭제 후 번호재정렬
             var pi=parseInt($(".c_u_o:eq("+(myi-1)+")").val());
             var addi=1
             for(var i=(myi);i<=$(".c_tr").length;i++){
               $(".c_u_o:eq("+(i)+")").val( pi+addi);
               addi++;
             }

           });

             //아래에 같은 레벨 한칸 추가
           	$(document).on('click', '.u-btnnew', function(e) {
           		 var myi=parseInt($(".u-btnnew").index(this)); //내순서
           		 var myo=parseInt($(".c_u_o:eq("+myi+")").val()); //내순서의 단원순서
               var myt=parseInt($(".c_tab:eq("+myi+")").val()); //내순서의 탭
               var myk=$(".c_idx:eq("+myi+")").val(); //내키
               var myp=$(".c_p_idx:eq("+myi+")").val(); //내키
               var myplus=parseInt($(".c_plus:eq("+myi+")").val()); //몇칸추가
                   if(myplus==""||myplus=="0"){myplus=1;}

           		var v=$(".c_tr:eq("+myi+")")[0].outerHTML; //내순서에 해당하는 tr
                   for(var x=0;x<myplus;x++){
                   		$(".c_tr:eq("+(myi+x)+")").after(v);
                      console.log(myi+1+x);
                   		$(".c_idx:eq("+(myi+1+x)+")").val("");
                   		$(".c_u_n:eq("+(myi+1+x)+")").val("");
                   		$(".c_u_c:eq("+(myi+1+x)+")").val("");
                      $(".c_u_o:eq("+(myi+1+x)+")").val(myo+1+x);
                      $(".c_tab:eq("+(myi+1+x)+")").val(myt); //탭=내탭
                   		$(".c_u_n:eq("+(myi+1+x)+")").css("width",(100-(myt)*7)+"%");
                   		$(".c_p_idx:eq("+(myi+1+x)+")").val(myp); //부모키=내부모키

                       $(".td-buttons-1:eq("+(myi+1+x)+")").hide();
                       $(".td-buttons-2:eq("+(myi+1+x)+")").hide();
                       $(".td-buttons-del:eq("+(myi+1+x)+")").show();
                   }

                   //새로 생긴 줄 아래 번호증가
                   for(var i=(myi+1+myplus);i<=$(".c_tr").length;i++){
                     $(".c_u_o:eq("+(i)+")").val($(".c_tr:eq("+i+")").index());
                   }

           		return;
           	});

             //아래에 낮은 레벨 한칸 추가
           	$(document).on('click', '.u-btnadd', function(e) {
           		var myi=parseInt($(".u-btnadd").index(this)); //내순서
           		var myo=parseInt($(".c_u_o:eq("+myi+")").val()); //내순서의 단원순서
           		var myt=parseInt($(".c_tab:eq("+myi+")").val()); //내순서의 탭
               var myplus=parseInt($(".c_plus:eq("+myi+")").val()); //몇칸추가
                   if(myplus==""||myplus=="0"){myplus=1;}
           		var myk=$(".c_idx:eq("+myi+")").val(); //내키
           		if(myk==""){console.log("키없음");return;}
           		myk=parseInt(myk);

           		var v=$(".c_tr:eq("+myi+")")[0].outerHTML; //내순서에 해당하는 tr

               for(var x=0;x<myplus;x++){
               		$(".c_tr:eq("+(myi+0+x)+")").after(v)
                   //$(".c_idx:eq("+(myi+1+x)+")").val("");
                   $(".chk_idx:eq("+(myi+1+x)+")").val("");
               		$(".c_u_n:eq("+(myi+1+x)+")").val("");
               		$(".c_u_c:eq("+(myi+1+x)+")").val("");
               		$(".c_u_o:eq("+(myi+1+x)+")").val(myo+1+x);
               		$(".c_tab:eq("+(myi+1+x)+")").val(myt+1); //탭=내탭+1
               		$(".c_u_n:eq("+(myi+1+x)+")").css("width",(100-(myt+1)*7)+"%");
               		$(".c_p_idx:eq("+(myi+1+x)+")").val(myk); //부모키=내키

                  $(".td-buttons-1:eq("+(myi+1+x)+")").hide();
                  $(".td-buttons-2:eq("+(myi+1+x)+")").hide();
                  $(".td-buttons-del:eq("+(myi+1+x)+")").show();
               }

           		//새로 생긴 줄 아래 번호증가
           		for(var i=(myi+1+myplus);i<=$(".c_tr").length;i++){
           			$(".c_u_o:eq("+(i)+")").val(parseInt($(".c_u_o:eq("+(i)+")").val())+myplus); //n개 추가시 +n
           		}

           		return;
           	});

             //한칸 위로 이동
           	$(document).on('click', '.u-btnup', function(e) {
           		$('[type=text], textarea').each(function(){ this.defaultValue = this.value; });
           		$('[type=checkbox], [type=radio]').each(function(){ this.defaultChecked = this.checked; });
           		$('select option').each(function(){ this.defaultSelected = this.selected; });

           		var myi=parseInt($(".u-btnup").index(this)); //내순서
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

             //한칸 아래로 이동
           	$(document).on('click', '.u-btndn', function(e) {
           		$('[type=text], textarea').each(function(){ this.defaultValue = this.value; });
           		$('[type=checkbox], [type=radio]').each(function(){ this.defaultChecked = this.checked; });
           		$('select option').each(function(){ this.defaultSelected = this.selected; });

           		var myi=parseInt($(".u-btndn").index(this)); //내순서
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
           	$(document).on('click', '.u-btabin', function(e) {
           		$('[type=text], textarea').each(function(){ this.defaultValue = this.value; });
           		$('[type=checkbox], [type=radio]').each(function(){ this.defaultChecked = this.checked; });
           		$('select option').each(function(){ this.defaultSelected = this.selected; });

           		var myi=parseInt($(".u-btabin").index(this)); //내순서

               if(myi==0){console.log('최상위');return false;};

           		var v=($(".c_tab:eq("+myi+")").val()); //내순서에 해당하는 탭 번호
                 if(v==""){v=0;}
           		var v1=($(".c_tab:eq("+(myi-1)+")").val()); //내순서한칸위 탭
                 if(v1==""){v1=0;}
           		//내순서한칸 위보다 2 차이 허용하지 않음
           		if((v1-v)==-1){return;};

           		var myt=parseInt(v)+1;//내 탭 1증가
           		$(".c_tab:eq("+myi+")").val(myt);
           		$(".c_u_n:eq("+myi+")").css("width",(100-(myt*7))+"%");

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

           	$(document).on('click', '.u-btabout', function(e) {
           		$('[type=text], textarea').each(function(){ this.defaultValue = this.value; });
           		$('[type=checkbox], [type=radio]').each(function(){ this.defaultChecked = this.checked; });
           		$('select option').each(function(){ this.defaultSelected = this.selected; });

           		var myi=parseInt($(".u-btabout").index(this)); //내순서

           		var v=($(".c_tab:eq("+myi+")").val()); //내순서에 해당하는 탭 번호
           		if(v==0){return;}
           		var myt=parseInt($(".c_tab:eq("+myi+")").val())-1;//내 탭 1 감소
           		$(".c_tab:eq("+myi+")").val(myt);

           		$(".c_u_n:eq("+myi+")").css("width",(100-(myt*7))+"%");

           		//안으로 넣는다=상위idx 중 내 탭보다 작은 idx를 부모로 한다

           		for(var i=myi;i--;i>=0){
           			var yourt=parseInt($(".c_tab:eq("+(i)+")").val());
           			if(yourt<myt){
           				var youridx=$(".c_idx:eq("+i+")").val();
           				$(".c_p_idx:eq("+myi+")").val(youridx);
           				break;
           			}
           		}

           		if(i==-1){
                if(myt==0){ //최상위탭의 pidx값을 가져옴
                    $(".c_p_idx:eq("+myi+")").val($("#edit_idx").val());
                }
              }
           	})

           </script>



           <script>
           $(function(){

             $("textarea").keydown(function(e) {

                 if(e.keyCode === 9) { // tab was pressed

             	     // get caret position/selection
             	     var start = this.selectionStart;
             	     var end = this.selectionEnd;

             	     var $this = $(this);
             	     var value = $this.val();

             	     // set textarea value to: text before caret + tab + text after caret
             	     $this.val(value.substring(0, start)
             	                    + "\t"
             	                    + value.substring(end));

             	     // put caret at right position again (add one for the tab)
             	     this.selectionStart = this.selectionEnd = start + 1;

             	     // prevent the focus lose
             	     e.preventDefault();
             	 }
             });

           });
           </script>








</div>
<?php include_once("page.wrapbottom.php");?>



<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
