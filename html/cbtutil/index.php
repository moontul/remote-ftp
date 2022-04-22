<?php
include_once('/_common.php');

$code=$_GET["code"]; //코드로 넘어오면 해당list의 모든 문제를 풀게 됩니다 = 자격시험 문제풀이처럼
$list=$_GET["list"]; //list가 넘어오면 해당list의 문제만 풀게 됩니다.


//시험정보
$sql="select *
			from tb_list A
			where list='$list'";
$result=sql_fetch($sql);
$licensetitle=$result["listtitle"]; //.$list["licensedate"];

$total_qnum=0;
//전체문제
$sql="select *
 			,(select unitname from tb_licenseunit where lcucode=A.lcucode) as unitname
			from tb_question A
			where lccode='$code'
			order by convert(qnum, int)";

$result=mysqli_query($conn, $sql);
$row=$result->num_rows;
//전체문제수
$total_qnum=$row;

//첫번째 문제, 두번째 문제
$now1_qnum=0;
$now2_qnum=0;

$arr_qunitcode=array(); //과목

$arr_qnum=array(); //문번
$arr_qtext=array(array()); //질문

foreach($result as $key => $list){
	$arr_qunitcode[$key]=$list["lcucode"];
	$arr_qnum[$key]=$list["qnum"];

	$arr_qtext[$key][0]=$list["qtext"];
	$arr_qtext[$key][1]=$list["qm1text"];
	$arr_qtext[$key][2]=$list["qm2text"];
	$arr_qtext[$key][3]=$list["qm3text"];
	$arr_qtext[$key][4]=$list["qm4text"];
	$arr_qtext[$key][5]=$list["qm5text"];

	if($now1_qnum==0){$now1_qnum=$list["qnum"];}
	elseif($now2_qnum==0&&$now1_qnum!=0){$now2_qnum=$list["qnum"];}

}

//단원순서 및 코드, 단원별 문제수
$sql="select lcucode, unitname
			,(select count(*) from tb_question where lcucode=A.lcucode) as qcnt
			from tb_licenseunit A
			where lccode='$code'
			order by unitorder";
$result=mysqli_query($conn, $sql);
$row=$result->num_rows;

//단원별 정보 저장
$now_unitqcnt=0; //과목문제수
$now_unitcode="";
$now_unitname="";

$arr_unitcode=array();
$arr_unitname=array();
$arr_unitqcnt=array();
foreach($result as $key => $list){
	$arr_unitcode[$key]=$list["lcucode"];
	$arr_unitname[$key]=$list["unitname"];
	$arr_unitqcnt[$key]=$list["qcnt"];

	if($now_unitcode==""){$now_unitcode=$list["lcucode"];}
	if($now_unitname==""){$now_unitname=$list["unitname"];}
	if($now_unitqcnt==0){$now_unitqcnt=$list["qcnt"];}
}

?><!DOCTYPE html>
<html><head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<script type="text/javascript" src="/cbt/js/js_jquery_jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/cbt/js/js_jquery_jquery.corner.js"></script>
<script type="text/javascript" src="/cbt/js/js_jquery_jquery.ajaxfileupload.js"></script>
<script type="text/javascript" src="/cbt/js/js_jquery_jquery.cookie.js"></script>
<script type="text/javascript" src="/cbt/js/js_jquery_jquery-ui-1.10.2.min.js"></script>
<script type="text/javascript" src="/cbt/js/js_jquery_jquery.PrintArea.js"></script>
<script type="text/javascript" src="/cbt/js/js_eco_json.js"></script>
<script type="text/javascript" src="/cbt/js/js_eco_eco.utils.js"></script>
<script type="text/javascript" src="/cbt/js/js_eco_iscroll.js"></script>
<script type="text/javascript" src="/cbt/js/js_eco_jquery.eco.js"></script>
<style>
.eco-panel  { position:relative;left:0px;right:0px;top:0px;bottom:0px; }
.eco-panel > .eco-panel-header { position:absolute;top:0px;left:0px;right:0px;height:0px; }
.eco-panel > .eco-panel-footer { position:absolute;bottom:0px;left:0px;right:0px;height:0px; }
.eco-panel > .eco-panel-body { position:absolute;top:0px;bottom:0px;left:0px;right:0px;background:#fff; }
.eco-panel.scroll > .eco-panel-body { overflow:hidden; }		.eco-panel.eco-container > .eco-panel-body > * { position:absolute;left:0px;right:0px;top:0px;bottom:0px; }
.eco-popup { position:absolute;left:0px;top:0px;z-index:9999;border-radius:10px;box-shadow:0px 0px 10px rgba(0,0,0,0.3); }
.eco-popup.full-size { bottom:0px;right:0px; }		.eco-popup > .eco-popup-header [button=close] { float:right; }
.eco-popup > .eco-popup-header { position:absolute;left:0px;right:0px;top:0px;height:0px; }		.eco-popup.has-header > .eco-popup-header { background:#eaeaea;border-radius:10px 10px 0px 0px;height:35px; }
.eco-popup > .eco-popup-body { background:#fff;border-radius:0px 0px 10px 0px;position:absolute;top:0px;bottom:0px;left:0px;right:0px;overflow-y:auto; }
.eco-popup.has-header > .eco-popup-body { top:35px; }		.eco-popup-screen { position:absolute;left:0px;right:0px;top:0px;bottom:0px;background:rgba(0,0,0,0.3);z-index:9998; }
</style>
<style>
.eco-paging .btn-page, .eco-paging .btn-action { cursor:pointer;margin-top:5px;display:inline-block;width:20px;height:20px;border:solid 1px #ccc;margin-right:5px;line-height:20px;text-align:center;color:#000;}
.eco-paging .btn-page.selected { background:navy;color:#fff; }
</style>

	<script type="text/javascript" src="/cbt/js/lang_message_WEB.js"></script>

	<script type="text/javascript" src="/cbt/js/js_panels_itp_item_item.js"></script>

	<script type="text/javascript" src="/cbt/js/js_panels_itp_testviewer_resultsheet.js"></script>
	<script type="text/javascript" src="/cbt/js/js_panels_itp_testviewer_sheet.js"></script>
  <script type="text/javascript" src="/cbt/js/js_panels_itp_testviewer_page.js"></script>
  <script type="text/javascript" src="/cbt/js/saningong_js_testviewer.js"></script>
	<script type="text/javascript" src="/cbt/js/js_external_external.js"></script>

	<link href="/cbt/css/js_jquery_css_base_jquery-ui-1.10.2.min.css" rel="stylesheet">
	<link href="/cbt/css/css_common.css" rel="stylesheet">
	<link href="/cbt/css/css_panels_itp_item.css" rel="stylesheet">
	<link href="/cbt/css/css_panels_itp_testviewer.css" rel="stylesheet">
	<link href="/cbt/css/saningong_css_saningong.css" rel="stylesheet">
	<link href="/cbt/css/css_viewer.css" rel="stylesheet">
	<link href="/cbt/css/css_player.css" rel="stylesheet">

  <script>
		/** localmode */
		//var gMessage;
		//var gNotice;
		//var viewerController;
		//$(document).ready(function() {
		//	loadData(); /** external : 시험지 데이터 로드 */
		//	jQuery.getJSON("lang/message_"+_userInfo.examLangCcd+".json", function(data){ /** 언어 설정 */
		//		gMessage = data['examination'];
		//		gNotice =  data['notice'];
		//		viewerController = $('<div class="viewer"/>').appendTo('body').controller('saningong/viewer');
		//	});
		//});
		var gMessage = lang['examination'];
    var gNotice =  lang['notice'];

		var viewerController;

		$(document).ready(function() {

    	$("#ifrm_draggable").draggable({iframeFix:true});
			$("#ifrm_draggable").css("top", (($(window).height()/2)-111)+"px");
			$("#ifrm_draggable").css("left", (($(window).width()/2)-176)+"px");
			loadData();

			//xxxxx jQuery("#unsolved").dialog({ autoOpen: false, modal:false, resizable:false, width:495});

			//xxxxx viewerController = $('<div class="viewer"/>').appendTo('body').controller('saningong/viewer');

			/** 튜토리얼 */
      /*****
			setTimeout(function(){
				var tutorialService = new tutorial();
				if(_actionMode.isTutorial){
					tutorialService.initTutorial();
				}
			}, 500);
      *****/
			/*END*/
		});

		document.onselectstart = function() { return false; };

		function root() {
      return $('body > .viewer');
    }

	</script>
	<script language="JScript" id="playerEventListener" for="none" event="playStateChange(NewState)">
		switch(NewState){
			case 0:
					break;
			case 1:
					modePause();
					break;
			case 2:
					modePlay();
					break;
			case 3:
					modePlay();
					break;
		}
		function modePause(){
			try{
				$(".playBtn").each(function(){
					$(this).hide();
				});
				$(".pauseBtn").each(function(){
					$(this).show();
				});
				$(".playerLoadingDiv").progressbar({
					value:false
				});
			}catch(e){

			}
		}
		function modePlay(){
			try{
				$(".playBtn").each(function(){
					$(this).show();
				});
				$(".pauseBtn").each(function(){
					$(this).hide();
				});
				$(".playerLoadingDiv").progressbar("value", 100);
			}catch(e){

			}
		}
	</script>
<script src="/cbt/js/practice2_practiceData.js"></script>
<script src="/cbt/js/js_external_tutorial2.js"></script>
</head>
<!--
수험자 정보확인
1374X720

(시험장 감독위원이 컴퓨터에 나온 수험자 정보와 신분증이 일치하는지를 확인하는 단계입니다.)

신분확인이 끝난 후 시험 시작 전 CBT 시험 안내가 진행됩니다
<hr>
-->
<body scroll="no" style="overflow: hidden !important;">
	<iframe id="ifrm_draggable" style="width: 352px; height: 223px; z-index: 10000; display: none; position: relative; top: 429.5px; left: 643px;"
  class="ui-widget-content ui-draggable" src="" border="0" frameborder="0" scrolling="no"></iframe>
	<!-- Unsolved 시작 -->

	<!-- Alert 시작 -->
	<div id="alertBx" style="display:none;">
		<div class="alertBxTitleWrap"><span class="alertTitle"></span>
			<!--<button class="closeAlert" type="button">×</button>-->
		</div>
		<div class="alim_cont">
			<div></div>
			<!--<p><img src="./img/ajax-loader-20.gif" alt="" /></p>-->
		</div>
	</div>
	<!-- Confirm 시작 -->
	<div id="dialog-confirm" style="display:none;"></div>
	<!--
	<div id="dialog-confirm" title="답안 제출 여부" style="display:none;">
		<p><span class="ui-icon ui-icon-alert" style="float:left;margin:0 7px 20px 0;"></span> 답안을 제출하시겠습니까?</p>
	</div>
	-->
	<!-- ToolTip 시작 -->
	<div id="tooltip-box" style="display:none;">
		<div class="tooltip-header">자격검정 CBT 튜토리얼</div>
		<div class="tooltip-content">
		</div>
		<div class="tooltip-footer">
			<!-- 콘텐츠 영역 -->
			<a><span class="tooltip-btn-confirm">
			확 인
			</span></a>
		</div>
	</div>
	<div id="tooltip-operator" style="display:none;"></div>
	<div class="tooltip-modal" style="display:none;"></div>
	<!-- MessageBox 시작 -->
	<div id="message-box" style="display:none;">
		<div class="message-content">
		<!--  콘텐츠 영역 -->
		</div>
		<div class="message-btn-confirm"></div>
	</div>
	<div id="message-box-operator" style="display:none;"></div>
	<!-- ArrowCircle 시작 -->
	<div id="arrow-circle" style="display:none;">
		<div class="arrow-wrap">
			<div class="arrow-btn-confirm"></div>
		</div>
	</div>
	<div id="arrow" style="display:none;"></div>
	<div class="tutorial-basic-modal" style="display:none;"></div>

  <script type="text/javascript" src="/cbt/js/js_draggable_dragiframe.js"></script>

<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable" tabindex="-1" role="dialog" aria-describedby="unsolved" aria-labelledby="ui-id-1" style="display: none;">
	<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
  <span id="ui-id-1" class="ui-dialog-title">&nbsp;</span>
  <button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close" role="button" aria-disabled="false" title="close">
    <span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span>
    <span class="ui-button-text">close</span></button></div>

	<div id="unsolved" style="" class="ui-dialog-content ui-widget-content"></div>
</div>

<?php ?>
<div class="viewer saningong_viewer panel_saningong_viewer mode-practice" ctrl="saningong_viewer" dpi="150dpi" style="display: block;">
<div class="header-block">
  <input type="text" name="implementKey" value="53b169ab40933" style="display:none;">
<div class="test-nm-block">
  <label id="sheetNum" class="sheetNum">07</label>
  <label class="test-info-testNm">
	<?=$licensetitle?>

	<span style="font-size:11px">자격검정 CBT 웹체험 문제풀이</span>

	</label>
</div>
<div class="user-info-block">
<div class="user-id-block"><span class="user-info-userId-label">수험번호 : </span><input class="user-info-userId" readonly="true" onfocus="this.blur()" style="cursor:default;"> </div>
<div class="user-nm-block"><span class="user-info-userNm-label">수험자명 : </span><input class="user-info-userNm" readonly="true" onfocus="this.blur()" style="cursor:default;"> </div>				</div>
<div class="test-timer-block" id="timerImage" style="background-image:url(&quot;https://www.q-net.or.kr/cbt/viewer/images/ico_clock01.gif&quot;) !important">
<div class="max-time-block"><label class="label-max-time">제한 시간 : <label class="test-max-time-control">10분 </label></label></div>
<div class="left-time-block">
<label class="label-left-time">남은 시간 : </label>
<input class="test-left-time-control saningong_timer panel_saningong_timer" readonly="true" onfocus="this.blur()" style="cursor:default;" ctrl="saningong_timer">
<input class="left-time-hidden" style="display:none;">					</div>				</div>			</div>

<div class="test-core-block">

	<div class="section-tool-block">
						<div class="screen-tool">
						  <div class="zoom-tool">
						    <span class="zoom-tool-title">글자크기</span>
						    <a button="zoom" id="zoom100" class="zoomBtn" type="0"></a>
						    <a button="zoom" id="zoom150" class="zoomBtn curZoom" type="1"></a>
						    <a button="zoom" id="zoom200" class="zoomBtn" type="2"></a>
						  </div>
						  <div class="layout-tool">
						    <span class="layout-tool-title">화면배치</span>
						    <a button="sheet-mode" type="list" class="selected">List</a>
						    <a button="sheet-mode" type="double" class="">Double</a>
						    <a button="sheet-mode" type="item" class="">Item</a>
						  </div>
						</div>
				<div class="section-name-block">
				  <label class="section-name-label">제1과목???</label>
				</div>
				<div class="progress-info-block">
				  <div class="total-count-block">전체 문제 수&nbsp;&nbsp;: <span class="count-info-total"><?=$total_qnum?></span>
					</div>
					<div class="unsolved-count-block">안 푼 문제 수 : <span class="count-info-unsolved">5</span></div>
				</div>
			</div>

	<div class="test-page-title-block" style="display: block;"><div class="test-page-title-name"><?=$now_unitname?></div>
		<div class="test-page-title-qstcnt">과목 문제 수:&nbsp;<font color="yellow"><strong><?=$now_unitqcnt?></strong></font></div>
	</div>


<div class="test-page-block-holder" style="height: 913px; overflow: hidden; top: 50px;">
<div class="test-page-block itp_testviewer_page panel_itp_testviewer_page" ctrl="itp_testviewer_page" style="height: 573px; zoom: 1; width: 580.5px; overflow: hidden; top: 35px;">
<div class="test-sheet-row sheet-1 itp_testviewer_sheet panel_itp_testviewer_sheet" ctrl="itp_testviewer_sheet" >



<?php //화면 첫번째 문제 ?>
<?php for($x=1;$x<=$total_qnum;$x++){ ?>
<div class="qbox ucode_<?=$arr_qunitcode[$x]?>" id="qbox<?=$x?>" style="font-size:16px;">

<div class="test-item-row mode-practice itp_item_item panel_itp_item_item" testitemsn="<?=$x?>" ctrl="itp_item_item">
  <div class="item-edit-block">

			    <table>
			    <tbody>
			    <tr>
			    <td valign="top" style="padding-top:5px;"><div class="item-no-label"><?=$x?>.</div></td>
			    <td valign="middle">
			      <div class="field-item itp_item_field_question panel_itp_item_field_question" field="question" ctrl="itp_item_field_question">
								<?=$arr_qtext[$x-1][0]?>
			      </div>
			    </td>
			    </tr>
			    </tbody>
			    </table>

					<div class="field-item itp_item_field_response_select panel_itp_item_field_response_select" field="response" type="select" ctrl="itp_item_field_response_select">
						<table cellspacing="0" cellpadding="0">
						<tbody>

						<?php for($y=0;$y<4;$y++){ ?>
						<tr class="response-option-row" idx="<?=$y?>">
						<td class="seldot-block" valign="top" align="center">
							<div id="qsel<?=$x?>_<?=$y+1?>" qnum="<?=$x?>" class="qsel seldot-label option<?=$x?>" value="<?=$y+1?>" index="<?=$y?>" dotlabeltype="arabic-circle"></div>
						</td>
						<td style="width:100%;">
							<?=$arr_qtext[$x-1][$y+1]?>
						</td>
						</tr>
						<?php } ?>

							</tbody>
							</table>
						</div>

			<div style="display:none;">M<input type="text" name="metadataSn" style="border:solid 1px red;width:50px;"></div>
		</div>
	</div>
</div><!--qbox-->
<?php } ?>
<?php //화면 첫번째 문제끝 ?>





	</div>
</div>
</div>
</div>

<?php //답안표기란 시작 ?>
<div class="test-result-sheet-holder">

	<div class="sheet-title-block">답안 표기란</div>
	<div class="sheet-section-block">
		<select name="sel-section" id="sel-section">
			<?php
		  for($x=0;$x<count($arr_unitcode);$x++){?>
			<option value="<?=$arr_unitcode[$x]?>"><?=$arr_unitname[$x]?></option>
			<?}?>
		</select>
	</div>

	<div class="mask" style="display:none"></div>

	<?php //오엠알 시작 ?>
	<div class="test-result-sheet itp_testviewer_resultsheet panel_itp_testviewer_resultsheet" id="answerSheet" ctrl="itp_testviewer_resultsheet" style="top: 88px;">

		<?php for($x=1;$x<=20;$x++){ ?>

			<div class="item-response-result itp_testviewer_result_select panel_itp_testviewer_result_select" testitemsn="<?=$x?>" ctrl="itp_testviewer_result_select">
				<div>
					<label class="item-no-block" qnum="<?=$x?>"><?=$x?></label>
					<span class="item-response-block">
						<label class="option option<?=$x?>" qnum="<?=$x?>" value="1" index="0" dotlabeltype="arabic-circle" id="omr<?=$x?>_1"></label>
						<label class="option option<?=$x?>" qnum="<?=$x?>" value="2" index="1" dotlabeltype="arabic-circle" id="omr<?=$x?>_2"></label>
						<label class="option option<?=$x?>" qnum="<?=$x?>" value="3" index="2" dotlabeltype="arabic-circle" id="omr<?=$x?>_3"></label>
						<label class="option option<?=$x?>" qnum="<?=$x?>" value="4" index="3" dotlabeltype="arabic-circle" id="omr<?=$x?>_4"></label>
					</span>
				</div>
			</div>

		<?php } ?>
		<!--
			<div class="item-response-result itp_testviewer_result_select panel_itp_testviewer_result_select" testitemsn="2" ctrl="itp_testviewer_result_select">
				<div>
					<label class="item-no-block">2</label>
					<span class="item-response-block">
						<label class="option" value="1" index="0" dotlabeltype="arabic-circle"></label>
						<label class="option" value="2" index="1" dotlabeltype="arabic-circle"></label>
						<label class="option" value="3" index="2" dotlabeltype="arabic-circle"></label>
						<label class="option" value="4" index="3" dotlabeltype="arabic-circle"></label>
					</span>
				</div>
			</div>
		-->
<!--
<div class="item-response-result itp_testviewer_result_select panel_itp_testviewer_result_select" testitemsn="3" ctrl="itp_testviewer_result_select"><div><label class="item-no-block">3</label>
<span class="item-response-block"><label class="option" value="1" index="0" dotlabeltype="arabic-circle"></label>
  <label class="option" value="2" index="1" dotlabeltype="arabic-circle"></label>
  <label class="option" value="3" index="2" dotlabeltype="arabic-circle"></label>
  <label class="option" value="4" index="3" dotlabeltype="arabic-circle"></label></span></div>
</div>
-->
<!--
<div class="item-response-result itp_testviewer_result_select panel_itp_testviewer_result_select" testitemsn="4" ctrl="itp_testviewer_result_select"><div>
  <label class="item-no-block">4</label><span class="item-response-block"><label class="option" value="1" index="0" dotlabeltype="arabic-circle"></label>
    <label class="option" value="2" index="1" dotlabeltype="arabic-circle"></label>
    <label class="option" value="3" index="2" dotlabeltype="arabic-circle"></label>
    <label class="option" value="4" index="3" dotlabeltype="arabic-circle"></label></span></div>
</div>
-->
<!--
<div class="item-response-result dotted itp_testviewer_result_select panel_itp_testviewer_result_select" testitemsn="5" ctrl="itp_testviewer_result_select"><div><label class="item-no-block">5</label>
<span class="item-response-block"><label class="option" value="1" index="0" dotlabeltype="arabic-circle"></label>
    <label class="option" value="2" index="1" dotlabeltype="arabic-circle"></label>
    <label class="option" value="3" index="2" dotlabeltype="arabic-circle"></label>
    <label class="option" value="4" index="3" dotlabeltype="arabic-circle"></label></span></div>
</div>
-->

	</div>
	<?php //오엠알 끝 ?>

</div>
<?php //답안표기란 끝?>

	<div class="footer-block">
	    <div class="footer-left-block">
	    		<a button="calculator" id="btnCaculator"><img src="/cbt/images/btn_calculator.gif" class="calculator_icon"> <span class="unsolved_label">계산기</span></a>

					<input type=button value="문제토글" onclick="qboxToggle()">
	        <div id="volumeIcon" class="button_volume_on" style="display:none;"></div>
	        <div id="volumeSlider"></div>
	    </div>
	    <div class="footer-center-block">
	        <a button="prev-page" id="btn_prevpage" class="xxxxxdisabled">◀ 이전</a>
	        <label class="page-position-label"><span class="c_this_page">1</span>/<?=$total_qnum/2?></label>
	        <a button="next-page" id="btn_nextpage">다음 ▶</a>
	    </div>
	    <div class="footer-right-block">
	      <a button="unsolved" id="btnUnsolved"><img src="/cbt/images/unsolved_icon.gif" class="unsolved_icon"><span class="unsolved_label">안 푼 문제</span></a>
	      <a button="submit-test" id="btnLabel"><img src="/cbt/images/submit_icon.gif" class="submit_icon"><span class="submit_label">답안 제출</span></a>
	    </div>
	</div>

</div>
</body>
</html>
<script>

var this_page=1;
function qboxToggle(){
	$(".qbox").toggle();
}

function showQbox(){
	var s=this_page*2-1;
	var e=this_page*2;
	$(".qbox").hide();
	$("#qbox"+s).show();
	$("#qbox"+e).show();

	$(".c_this_page").text(this_page);
	if(this_page<=1){$("#btn_prevpage").hide()}else{$("#btn_prevpage").show()}

}

$("#btn_prevpage").click(function(){
		if(this_page==1){return;}
		this_page--;
		showQbox();


})

$("#btn_nextpage").click(function(){
		this_page++;
		if(this_page>1){$("#btn_prevpage").show();}
		showQbox();
})

$(function(){
	showQbox();
})


$(".qsel").click(function(){

		var a=$(this).attr("id");
		var qnum=$(this).attr("qnum");
		var b=a.replace("qsel","omr");
		$(".option"+qnum).removeClass("selected");

		$("#"+a).addClass("selected");
		$("#"+b).addClass("selected");

})
$(".option").click(function(){

		var a=$(this).attr("id");
		var qnum=$(this).attr("qnum");
		var b=a.replace("omr","qsel");
		$(".option"+qnum).removeClass("selected");

		$("#"+a).addClass("selected");
		$("#"+b).addClass("selected");
})


$(".zoomBtn").click(function(){
	$(".zoomBtn").removeClass("curZoom");
	$(this).addClass("curZoom");
	var t=parseInt($(this).attr("type"));
	$(".qbox").css("font-size", 18+(t*4)+"px");
})
//과목변경
$("#sel-section").change(function(){
	var a=$("#sel-section option:selected").val();
})
//omr문번선택
$(".item-no-block").click(function(){

	var a = parseFloat(parseInt($(this).attr("qnum"))/2)+0.1;
	this_page = Math.round(a);
	showQbox();

})
</script>
