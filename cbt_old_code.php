<?php include_once('./common.php');

//리스트가 넘어오면 해당 tb_qlist의 문제출제 tb_list > tb_qlist > tb_question
$list=$_GET["list"];
//코드만 넘어오면 tb_elist의 list를 문제로 함 tb_elist > tb_list > tb_qlist> tb_question
$code=$_GET["code"];

$total_qnum=0;
//전체문제
include_once("qview.detail.query.php");
$result=sql_query( $sqlq);
//echo($sqlq);

$arr_qlist=array(); //과목

$arr_qcode=array(); //문제코드
$arr_qtext=array(array()); //질문


$arr_list=array(); //list코드배열
$arr_listtitle=array(); //list제목
$arr_listqcnt=array(); //list 문제수
$arr_listsnum=array(); //list 시작문제수
$arr_listenum=array(); //list 종료문제수

$list_cnt=-1;
$old_list="";
for($i=0;$rs=sql_fetch_array($result);$i++){

	$arr_qtext[$i][0]=$rs["qtext"];
	$arr_qtext[$i][1]=$rs["qm1text"];
	$arr_qtext[$i][2]=$rs["qm2text"];
	$arr_qtext[$i][3]=$rs["qm3text"];
	$arr_qtext[$i][4]=$rs["qm4text"];
	$arr_qtext[$i][5]=$rs["qm5text"];

	$arr_qtext[$i][6]=$rs["qtype"];
	$arr_qtext[$i][7]=$rs["qtextsub"];
	$arr_qtext[$i][8]=$rs["qimg"];
	$arr_qtext[$i][9]=$rs["qcompilecode"];

	$arr_qcode[$i]=$rs["qcode"];


	//문제루프를 돌면서 과목정보를 입력
	if($old_list!=$rs["list"]){
		$list_cnt++;
		$arr_list[$list_cnt]=$rs["list"];
		$arr_listtitle[$list_cnt]=$rs["listtitle"];
		$arr_listqcnt[$list_cnt]=1;
		$arr_listsnum[$list_cnt]=$i+1;

		$old_list=$rs["list"];
	}else{
		$arr_listqcnt[$list_cnt]=$arr_listqcnt[$list_cnt]+1;
		$arr_listenum[$list_cnt]=$i+1;
	}

}

//전체문제수
$total_qnum=$i;

//////////////////////////////////////////////////////////////////시험제약 정보
if($list!=""){
	$sqltmp="select * from tb_exam where list='$list'";
	$rstmp=sql_fetch($sqltmp);
	$is_test=$rstmp["is_test"];
	$is_cbt=$rstmp["is_cbt"];
	$examlimit=$rstmp["examlimit"];
	$examopen=$rstmp["examopen"];
	$examclose=$rstmp["examclose"];
	$code=$rstmp["code"];
}else if($code!=""){
	$sqltmp="select * from tb_exam where code='$code'";
	$rstmp=sql_fetch($sqltmp);
	$is_test=$rstmp["is_test"];
	$is_cbt=$rstmp["is_cbt"];
	$examlimit=$rstmp["examlimit"];
	$examopen=$rstmp["examopen"];
	$examclose=$rstmp["examclose"];
}


//처음 단원별 정보
$now_listqcnt=$arr_listqcnt[0]; //현재과목문제수
$now_list=$arr_list[0];
$now_listtitle=$arr_listtitle[0];

?><!DOCTYPE html>
<html><head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<script type="text/javascript" src="/cbtutil/js/js_jquery_jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/cbtutil/js/js_jquery_jquery.corner.js"></script>
<script type="text/javascript" src="/cbtutil/js/js_jquery_jquery.ajaxfileupload.js"></script>
<script type="text/javascript" src="/cbtutil/js/js_jquery_jquery.cookie.js"></script>

<script type="text/javascript" src="/cbtutil/js/js_jquery_jquery-ui-1.10.2.min.js"></script>
<script type="text/javascript" src="/cbtutil/js/js_jquery_jquery.PrintArea.js"></script>
<script type="text/javascript" src="/cbtutil/js/js_eco_json.js"></script>
<script type="text/javascript" src="/cbtutil/js/js_eco_eco.utils.js"></script>
<script type="text/javascript" src="/cbtutil/js/js_eco_iscroll.js"></script>
<script type="text/javascript" src="/cbtutil/js/js_eco_jquery.eco.js"></script>
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

	<script type="text/javascript" src="/cbtutil/js/lang_message_WEB.js"></script>

	<script type="text/javascript" src="/cbtutil/js/js_panels_itp_item_item.js"></script>

	<script type="text/javascript" src="/cbtutil/js/js_panels_itp_testviewer_resultsheet.js"></script>
	<script type="text/javascript" src="/cbtutil/js/js_panels_itp_testviewer_sheet.js"></script>
  <script type="text/javascript" src="/cbtutil/js/js_panels_itp_testviewer_page.js"></script>
  <script type="text/javascript" src="/cbtutil/js/saningong_js_testviewer.js"></script>
	<script type="text/javascript" src="/cbtutil/js/js_external_external.js"></script>

	<link href="/cbtutil/css/js_jquery_css_base_jquery-ui-1.10.2.min.css" rel="stylesheet">
	<link href="/cbtutil/css/css_common.css" rel="stylesheet">
	<link href="/cbtutil/css/css_panels_itp_item.css" rel="stylesheet">
	<link href="/cbtutil/css/css_panels_itp_testviewer.css" rel="stylesheet">
	<link href="/cbtutil/css/saningong_css_saningong.css" rel="stylesheet">
	<link href="/cbtutil/css/css_viewer.css" rel="stylesheet">
	<link href="/cbtutil/css/css_player.css" rel="stylesheet">

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
<script src="/cbtutil/js/practice2_practiceData.js"></script>
<script src="/cbtutil/js/js_external_tutorial2.js"></script>
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
<div id="unsolved" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable" tabindex="-1" role="dialog"
		aria-describedby="unsolved" aria-labelledby="ui-id-1" style="height: auto; width: 495px; top: 298px; left: 397.5px; display: none;">
	<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
		<span id="ui-id-1" class="ui-dialog-title">&nbsp;</span>
		<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close" role="button" aria-disabled="false" title="close">
		<span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span class="ui-button-text">close</span></button>
	</div>
	<div style="width: auto; min-height: 134px; max-height: none; height: auto;" class="">
		<div class="alertBxTitleWrap">
			<span class="alertTitle">안 푼 문제 번호 보기: 번호 클릭시 해당 문제로 이동합니다.</span>
			<button class="close" type="button" onclick="hideUnsolved();"> × </button>
		</div>
		<div class="unsolved_alim_cont" style="text-align:left;padding-left:15px;padding-right:15px">
		</div>
	</div>
</div>



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
	<div id="dialog-confirm2" style="display:none;"></div>

	<div id="dialog-confirm" title="답안 제출 여부" style="display:none;">
		<p><span class="ui-icon ui-icon-alert" style="float:left;margin:0 7px 20px 0;"></span> 답안을 제출하시겠습니까?</p>
	</div>

	<form name=f method=post action="cbt_save.php">
		<input type=hidden name=code value="<?=$code?>">
		<input type=hidden name=list value="<?=$list?>">
		<input type=hidden name=is_cbt value="<?=$is_cbt?>">
		<input type=hidden name=is_test value="<?=$is_test?>">

		<input type=hidden name=mb_id value="<?=$member['mb_id']?>">

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

  <script type="text/javascript" src="/cbtutil/js/js_draggable_dragiframe.js"></script>

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
		<?=$cbt_title?>
		<span style="font-size:11px">CBT 웹 문제풀이</span>
		</label>
	</div>
	<div class="user-info-block">
		<div class="user-id-block">
			<span class="user-info-userId-label">수험번호 : </span>
			<input class="user-info-userId" readonly="true" onfocus="this.blur()" style="cursor:default;" value="0000000">
		</div>
		<div class="user-nm-block">
			<span class="user-info-userNm-label">수험자명 : </span>
			<input class="user-info-userNm" readonly="true" onfocus="this.blur()" style="cursor:default;" value="<?=$member['mb_id']?>">
		</div>
	</div>
	<div class="test-timer-block" id="timerImage" style="background-image:url(&quot;https://www.q-net.or.kr/cbtutil/viewer/images/ico_clock01.gif&quot;) !important">
			<div class="max-time-block">
				<label class="label-max-time">
					제한 시간 : <label class="test-max-time-control">
						<?php if($examlimit==0){echo "제한없음";}else{ echo $examlimit."분"; } ?>
					</label>
				</label>
			</div>
			<div class="left-time-block">
				<label class="label-left-time">남은 시간 : </label>
				<input class="test-left-time-control saningong_timer panel_saningong_timer" readonly="true" onfocus="this.blur()"
					style="cursor:default;" ctrl="saningong_timer">
				<input class="left-time-hidden" style="display:none;">
			</div>
	</div>
</div>

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
					<div class="unsolved-count-block">안 푼 문제 수 : <span class="count-info-unsolved">0</span></div>
				</div>
			</div>

	<div class="test-page-title-block" style="display: block;"><div class="test-page-title-name"><?=$now_listtitle?></div>
		<div class="test-page-title-qstcnt">과목 문제 수:&nbsp;<font color="yellow"><strong><?=$now_listqcnt?></strong></font></div>
	</div>


<div class="test-page-block-holder" style="height: 913px; overflow: hidden; top: 50px;">
<div class="test-page-block itp_testviewer_page panel_itp_testviewer_page" ctrl="itp_testviewer_page" style="height: 573px; zoom: 1; width: 580.5px; overflow: hidden; top: 35px;">
<div class="test-sheet-row sheet-1 itp_testviewer_sheet panel_itp_testviewer_sheet" ctrl="itp_testviewer_sheet" >



<?php //화면 첫번째 문제 ?>
<?php for($x=1;$x<=$total_qnum;$x++){ ?>
<div class="qbox ucode_<?=$arr_list[$x]?>" id="qbox<?=$x?>" style="font-size:16px;">

<input type=hidden name="qcode_a[]" value="<?=$arr_qcode[$x-1]?>">
<input type=hidden name="qnum_a[]" size=2 value="<?=$x?>">
<input type=hidden name="sel_a[]" class="sel_all" id="sel<?=$x?>" size=2 value="">
<input type=hidden name="answer_a[]" class="answer_all" id="answer<?=$x?>" size=12 value="">

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

						<?=$arr_qtext[$x-1][7]?>
						<?=$arr_qtext[$x-1][8]?>
						<?=$arr_qtext[$x-1][9]?>

			    </td>
			    </tr>
			    </tbody>
			    </table>

					<div class="field-item itp_item_field_response_select panel_itp_item_field_response_select" field="response" type="select" ctrl="itp_item_field_response_select">
						<table cellspacing="0" cellpadding="0">
						<tbody>

							<?if($arr_qtext[$x-1][6]=="객관식"){?>

									<?php for($y=0;$y<5;$y++){ ////////////////////////////////////////5번까지 보면서  보기가 있으면 보여줌?>
										<?php if($arr_qtext[$x-1][$y+1]!=""){ ?>
												<tr class="response-option-row" idx="<?=$y?>">
												<td class="seldot-block" valign="top" align="center">
													<div id="qsel<?=$x?>_<?=$y+1?>" qnum="<?=$x?>" class="qsel seldot-label option<?=$x?>" value="<?=$y+1?>" index="<?=$y?>" dotlabeltype="arabic-circle"></div>
												</td>
												<td style="width:100%;">
													<?=$arr_qtext[$x-1][$y+1]?>
												</td>
												</tr>
									<?php }
								 	} ?>
								<?php }else{ ////////////////// 주관식, 서술식은??>

									<input type="text" onkeyup="$('#answer<?=$x?>').val($(this).val())">

								<?php }?>

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
			<?php /////////////////////////////////////과목
		  for($x=0;$x<count($arr_list);$x++){?>
			<option value="<?=$arr_listsnum[$x]?>"><?=$arr_listtitle[$x]?>(<?=$arr_listqcnt[$x]?>문제 <?=$arr_listsnum[$x]?>~<?=$arr_listenum[$x]?>)</option>
			<?}?>
		</select>
	</div>

	<div class="mask" style="display:none"></div>

	<?php //오엠알 시작 ?>
	<div class="test-result-sheet itp_testviewer_resultsheet panel_itp_testviewer_resultsheet" id="answerSheet" ctrl="itp_testviewer_resultsheet" style="top: 88px;">

		<?php for($x=1;$x<=$total_qnum;$x++){ ?>

			<div class="item-response-result itp_testviewer_result_select panel_itp_testviewer_result_select" testitemsn="<?=$x?>" ctrl="itp_testviewer_result_select">
				<div>
					<label class="item-no-block" qnum="<?=$x?>"><?=$x?></label>
					<span class="item-response-block" qcode="<?=$arr_qcode[$x]?>">
						<?php for($y=0;$y<5;$y++){ ////////////////////////////////////////5번까지 보면서  보기가 있으면 보여줌?>
							<?php if($arr_qtext[$x-1][$y+1]!=""){ ?>
								<label class="option option<?=$x?>" qnum="<?=$x?>" value="<?=$y+1?>" index="<?=$y?>" dotlabeltype="arabic-circle" id="omr<?=$x?>_<?=$y+1?>"></label>
							<?php } } ?>
					</span>
				</div>
			</div>

		<?php } ?>

	</div>
	<?php //오엠알 끝 ?>

</div>
<?php //답안표기란 끝?>




	<div class="footer-block">
	    <div class="footer-left-block">
	    		<a button="calculator" id="btnCaculator"><img src="/cbtutil/images/btn_calculator.gif" class="calculator_icon"> <span class="unsolved_label">계산기</span></a>

					<input type=button value="문제토글" onclick="qboxToggle()">
	        <div id="volumeIcon" class="button_volume_on" style="display:none;"></div>
	        <div id="volumeSlider"></div>
	    </div>
	    <div class="footer-center-block">
	        <a button="prev-page" id="btn_prevpage" class="xxxxxdisabled">◀ 이전</a>
	        <label class="page-position-label"><span class="c_this_page">1</span>/<?=round($total_qnum/2)?></label>
	        <a button="next-page" id="btn_nextpage">다음 ▶</a>
	    </div>
	    <div class="footer-right-block">
	      <a button="unsolved" id="btnUnsolved"><img src="/cbtutil/images/unsolved_icon.gif" class="unsolved_icon"><span class="unsolved_label">안 푼 문제</span></a>
	      <a button="submit-test" id="btnLabel"><img src="/cbtutil/images/submit_icon.gif" class="submit_icon"><span class="submit_label">답안 제출</span></a>
	    </div>
	</div>

</div>


</form>

</body>
</html>
<script>

var this_qnum=1;
var this_page=1;
var total_page=<?=round($total_qnum/2)?>;
function qboxToggle(){
	$(".qbox").toggle();
}

function showQnum(q){
		this_qnum=q;
		var q1 = parseFloat(parseInt(q)/2)+0.1;
		this_page = Math.round(q1);
		showQbox();
}
function showQbox(){
	var s=this_page*2-1;
	var e=this_page*2;
	$(".qbox").hide();
	$("#qbox"+s).show();
	$("#qbox"+e).show();

	$(".c_this_page").text(this_page);
	if(this_page<=1){$("#btn_prevpage").hide()}else{$("#btn_prevpage").show()}
	this_qnum=s;

	//현재 문제를 기준으로 과목 선택박스를 변경
	var options = $('#sel-section').find('option').map(function() {
	      return $(this).val();
	}).get();
	var this_list=0;
	for(var i=0;i<options.length;i++){
		//console.log('option' + i, this_qnum,  options[i]);
		if(options[i]<=this_qnum){
			this_list=i;
		}
	}
	//console.log(this_list);
	$("#sel-section option:eq("+this_list+")").prop("selected", true); //option 선택

}

$("#btn_prevpage").click(function(){
		if(this_page==1){return;}
		this_page--;
		showQbox();
})

$("#btn_nextpage").click(function(){
		this_page++;
		if(this_page>total_page){
			this_page=total_page;
		}
		if(this_page>1){$("#btn_prevpage").show();}
		showQbox();
})

$(function(){
	showQbox();
})


$(".qsel").click(function(){

		var a=$(this).attr("id");
		var qnum=$(this).attr("qnum");
		this_qnum=qnum;
		var b=a.replace("qsel","omr");
		var c=a.replace("qsel"+qnum+"_","");

					var q1 = parseFloat(parseInt(qnum)/2)+0.1;
					this_page = Math.round(q1);
					showQbox();

		$(".option"+qnum).removeClass("selected");
		$("#"+a).addClass("selected");
		$("#"+b).addClass("selected");
		$("#sel"+qnum).val(c);

})
$(".option").click(function(){

		var a=$(this).attr("id");
		var qnum=$(this).attr("qnum");
		this_qnum=qnum;
		var b=a.replace("omr","qsel");
		var c=a.replace("omr"+qnum+"_","");

					var q1 = parseFloat(parseInt(qnum)/2)+0.1;
					this_page = Math.round(q1);
					showQbox();

		$(".option"+qnum).removeClass("selected");

		$("#"+a).addClass("selected");
		$("#"+b).addClass("selected");

		$("#sel"+qnum).val(c);
})

//안푼문제
$("#btnUnsolved").click(function(){

	$(".unsolved_alim_cont").html("");

	$(".sel_all").each(function(index, item){
			if( $(item).val()==""){
				//console.log("안품", index);
				$(".unsolved_alim_cont").append("<input type=button style='cursor:pointer' onclick='showQnum("+(index+1)+")' value='"+(index+1)+"'>");
			}
	})
	//<button class="btn_default" onclick="goUnsolvedIndex(1);"><b>1</b></button>

	$("#unsolved").show();
})
function hideUnsolved(){
	$("#unsolved").hide();

}


$(".zoomBtn").click(function(){
	$(".zoomBtn").removeClass("curZoom");
	$(this).addClass("curZoom");
	var t=parseInt($(this).attr("type"));
	$(".qbox").css("font-size", 18+(t*4)+"px");
})
//과목변경
$("#sel-section").change(function(){
	var qnum=$("#sel-section option:selected").val();
	this_qnum=qnum;
	var a = parseFloat(parseInt(qnum)/2)+0.1;
	this_page = Math.round(a);
	showQbox();
})
//omr문번선택
$(".item-no-block").click(function(){
	this_qnum=$(this).attr("qnum");
	var a = parseFloat(parseInt(this_qnum)/2)+0.1;
	this_page = Math.round(a);
	showQbox();
});

//답안제출
$("#btnLabel").click(function(){

	if(confirm("제출?")){

		document.f.submit();

	}
	//$("#dialog-confirm").show();

});



</script>