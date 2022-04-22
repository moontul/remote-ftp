<?php include_once('./_common.php');

$code=$_GET["code"];
$list=$_GET["list"];
$page_list=$list;
$mb_id=$_GET["mb_id"];

//시험을 제한 사항검색
//if($list!=""){
  $sqltmp="select * from tb_exam where list='$list'";
  $rstmp=sql_fetch($sqltmp);

//}else if($code!=""){
//  $sqltmp="select * from tb_exam where code='$code' and list=''";
//  $rstmp=sql_fetch($sqltmp);
//}
//시험문제 개수 검색
//전체문제 쿼리 //해당문제의 정답
include_once("page.qview.detail.query.php");

$result=sql_query($sqlq);
for($i=0;$rs=sql_fetch_array($result);$i++){
  $title=$rs["title"];
}
$total_qnum=$i;

$sql="select title from tb_page where list='$list'";
$rs=sql_fetch($sql);
$page_list_title=$rs["title"];

//내가 맞은 문제 개수
//if($list!=""){
  $sqltmp="select count(*) as cnt from tb_answerlog
    where mb_id='".$member["mb_id"]."' and list='$list' and counttrue>0 and fromcbt=1";
//}else if(code!=""){
//  $sqltmp="select count(*) as cnt from tb_answerlog
//    where mb_id='".$member["mb_id"]."' and code='$code' and list='' and counttrue>0  and fromcbt=1";
//}
//echo($sqltmp);
$rstmp=sql_fetch($sqltmp);
$user_counttrue=$rstmp["cnt"];

?><!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>자격검정 CBT 웹체험 </title>
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=8">
<link rel="stylesheet" href="cbtutil/css/js_jquery_css_base_jquery-ui-1.10.2.min.css">
<link rel="stylesheet" href="cbtutil/css/app.css">
<!--style type="text/css">@charset "UTF-8";[ng\:cloak],[ng-cloak],[data-ng-cloak],[x-ng-cloak],.ng-cloak,.x-ng-cloak{display:none;}ng\:form{display:block;}</style-->
</head>

<body scroll="no" class="contentView ng-scope" ng-controller="CommonController" ng-init="initRoot()" onselectstart="return false;" style="">
	<!-- CBT 수험자 프로그램 CONTENT VIEW -->
	<div ng-view="" id="view"><div class="bzPage page full ng-scope" ng-init="init();" ng-style="displayResult();" style="display: block;">
	<div class="header_block">
		<p class="sheetNum ng-binding">07</p>
		<h1 class="introTestTitle blueColor ng-binding">자격검정 CBT 웹체험 채점결과</h1>
	</div>
	<div class="pageIntro" ng_style="displayResult();" style="display: block;">
      <div class="sectionIntroWrap" style="margin-top: 50px;">
			<div id="modal_border_helper" style="padding: 3px; border-radius: 13px;">
				<div class="modal_contWrap" round-border-corner="" style="border-radius: 12px;">
					<!-- ngIf: _examResult.examRsltCd == '01' -->
					<!-- ngIf: _examResult.examRsltCd == '01' -->
					<!-- ngIf: _examResult.examRsltCd != '01' --><div class="mobileWrapper ng-scope" ng-if="_examResult.examRsltCd != '01'"><span class="examinationTitle"></span>
						<span class="introSubTitle ng-binding">수고 하셨습니다 <!--다음 기회에 꼭 합격하시길 기원합니다.--></span>
					</div>
					<!-- ngIf: _examResult.examRsltCd != '01' --><div class="mobileWrapper sub ng-scope" ng-if="_examResult.examRsltCd != '01'">
						<span class="introSubTitle_3 ng-binding">

              ※ 시험 결과는 오답노트 > cbt 시험결과에서 다시 확인해 볼 수 있습니다.
              <!--※ 지역별, 종목별로 상이하므로 큐넷(http://www.q-net.or.kr) 시험일정 안내를 참고하시기 바랍니다.-->
						</span>
					</div>
					<table class="testInfoTable">
						<caption class="blind ng-binding">수험자 합격여부안내</caption>
						<colgroup>
							<col style="width: 25%;">
							<col style="width: 30%;">
							<col style="width: 20%;">
							<col style="width: ">
						</colgroup>
						<tbody><tr>
							<th class="ng-binding">수험자 이름</th>
							<th class="ng-binding">응시 종목</th>
							<th class="ng-binding">득점</th>
							<!--th class="ng-binding">합격여부</th-->
						</tr>
						<tr>
							<td class="bold ng-binding">수험자<br><?=$member["mb_id"]?></td>
							<td class="bold ng-binding">시험명<br><?=$page_list_title?></td>
							<td ng-class="_textColor" style="font-size:25px;" class="ng-binding txtRed">
                <?=$total_qnum?>문제 중 <?=$user_counttrue?>문제 맞음
              </td>
							<!--td ng-class="_textColor" style="font-size:25px;" class="ng-binding txtRed">
                ...
              </td-->
						</tr>
					</tbody></table>
					<!-- ngIf: _examResult.kmResult.length -->
					<ul class="article emphasize" style="list-style:none;">
						<span style="font-size:1.7em;list-style:none;text-align:center;color:#CE6F6F;" class="ng-binding">"득점 및 합격여부를 확인하셨습니까?"</span>
					</ul>
				</div>
			</div>
      </div>
      <p class="cenAlign">
		  <button type="button" class="exitExamButton ng-binding" name="btnStartExam" onclick="location.href='/mycbt?list=<?=$list?>'">확인 완료</button>
	  </p>
      <br>
   </div>
</div></div>
	<!--div class="exitTutorial" ng-click="exitTutorial();" ng-show="showExitTutorial();" style="display: none;">&nbsp;튜토리얼 나가기 </div-->
	<div class="loading-modal" ng-style="_modal" style="display: none;"></div>
	<div class="loading-mark" ng-style="_loading" style="display: none;"></div>
	<!-- Alert 시작 -->
	<div id="alertBx" style="display:none;">
		<div class="alertBxTitleWrap"><span class="alertTitle ng-binding"></span>
			<!--<button class="close" type="button">×</button>-->
		</div>
		<div class="alim_cont">
			<div class="ng-binding"></div>
			<!--<p><img src="./img/ajax-loader-20.gif" alt="" /></p>-->
		</div>
	</div>

	<!-- ToolTip 시작 -->
	<div id="tooltip-box" style="display:none;">
		<div class="tooltip-header">자격검정 CBT 튜토리얼</div>
		<div class="tooltip-content">
		</div>
		<div class="tooltip-footer">
			<!-- 콘텐츠 영역 -->
			<span class="tooltip-btn-confirm">
			확 인
			</span>
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
	<!--
	<object id="audioObject" classid="clsid:22d6f312-b0f6-11d0-94ab-0080c74c7e95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#version=5,1,52,701" standby="loading..." type="application/x-oleobject" width="1px" height="1px">
		<param name="animationstart" value="true">
		<param name="transparentastart" value="true">
		<param name="filename" value="">
		<param name="autostart" value="true">
		<param name="autoSize" value="false">
		<param name="ShowControls" value="false">
		<param name="clickToPlay" value="true">
		<param name="windowLessvideo" value="false">
	</object>
	-->
	<!-- CBT 수험자 프로그램 Javascript Library -->
	<xxxxxscript src="libs/eoneo/angular/angular.min.js"></script>
	<xxxxxscript src="libs/jquery/jquery-1.11.0.min.js"></script>
	<xxxxxscript src="libs/jquery/jquery-ui-1.10.2.min.js"></script>
	<xxxxxscript src="libs/jquery/jquery.cookie.js"></script>
	<xxxxxscript src="libs/jquery/jquery.corner.js"></script>
	<xxxxxscript src="libs/json3.min.js"></script>

	<!-- CBT 수험자 프로그램 APP -->
	<xxxxxscript src="js/app.js"></script>
	<xxxxxscript src="js/webPreview.js"></script>
	<xxxxxscript src="js/properties.js"></script>
	<xxxxxscript src="js/tutorial.js"></script>

	<!-- CBT 수험자 프로그램 Services -->
	<xxxxxscript src="js/services/commonService.js"></script>
	<xxxxxscript src="js/services/mediaService.js"></script>
	<xxxxxscript src="js/services/connectionService.js"></script>
	<xxxxxscript src="js/services/identificationService.js"></script>
	<xxxxxscript src="js/services/directionService.js"></script>
	<xxxxxscript src="js/services/examinationService.js"></script>
	<xxxxxscript src="js/services/tutorialService.js"></script>

	<!-- CBT 수험자 프로그램 Filter -->
	<xxxxxscript src="js/filters/commonFilter.js"></script>

	<!-- CBT 수험자 프로그램 Directives -->
	<xxxxxscript src="js/directives/commonDirective.js"></script>

	<!-- CBT 수험자 프로그램 Controllers -->
	<xxxxxscript src="js/controllers/commonController.js"></script>
	<xxxxxscript src="js/controllers/connectionController.js"></script>
	<xxxxxscript src="js/controllers/identificationController.js"></script>
	<xxxxxscript src="js/controllers/directionController.js"></script>
	<xxxxxscript src="js/controllers/examinationController.js"></script>


<xxxxxscript type="module" charset="UTF-8" src="chrome-extension://aefibgbaijilanbphdomgjlogkldhlpm/framework/bootstrap/content/content-loader.js"></script>
<xxxxxscript type="text/javascript" charset="UTF-8" src="chrome-extension://aefibgbaijilanbphdomgjlogkldhlpm/vendor/crypto/aes.js"></script>
<xxxxxscript type="text/javascript" charset="UTF-8" src="chrome-extension://aefibgbaijilanbphdomgjlogkldhlpm/vendor/crypto/pad-zeropadding-min.js"></script>
</body>
</html>
