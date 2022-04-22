var _session = {};
var _mode = 'web';
var _config = {};
var _userInfo = {};
var _status = {};
var _directions = [];
var _actionMode = {};
var _answerList = [];
var _userDataPath = '';
var _options = {};
var _examResult = {};
var _cutoff = false;
var _submit = false;
var _volumeSlider;

function showVideoObject(isShowing){
	$('.videoObjectScreen').each(function(){
		if(isShowing){
			$(this).css('visibility', '');
		} else {
			$(this).css('visibility', 'hidden');
		}
	});
}
function hideUnsolved(){
	showVideoObject(true);
	if($("#unsolved").parents(".ui-dialog").is(":visible")){
		$("#unsolved").parents(".ui-dialog").hide();
	}
}
function goUnsolvedIndex(testSn){
	viewerController._goPage(viewerController._getPageIndexOfTestItem(testSn));
	// 답안표기란도 이 문제가 보이도록 이동시킴
	$('#answerSheet').controller().updateResponse({testItemSn:testSn,userAnswer:''});
	hideUnsolved();
}
/** Confirm Dialog */
function confirmSubmit(cur, max, unsolved){
	hideCalculator();
	if(unsolved == '0'){
		confirmDialog(gNotice.examination.alert, gNotice.examination.confirmCont, gNotice.examination.confirmAlert, 'confirmFinalDialog', 'cancelConfirmDialog');
		//if(window.external.nativeConfirm('답안을 제출하시겠습니까?')){
		//	showResult();
		//}
	} else {
		confirmDialog(gNotice.examination.alert, gNotice.examination.unsolvedA + unsolved+ gNotice.examination.unsolvedB, gNotice.examination.confirmAlert, 'confirmFinalDialog', 'cancelConfirmDialog');
		//if(window.external.nativeConfirm(gNotice.examination.unsolvedA + unsolved+ gNotice.examination.unsolvedB)){
		//	showResult();
		//}
	}
}

/** 시간 종료 */
function showTimeout(){
	showDialog(gNotice.examination.timeout, gNotice.examination.timeoutCont, true, 3000);
	goResult();
}

/** 결과 화면 호출 */
function showResult(){
	cancelConfirmDialog();
	showDialog(gNotice.examination.submit, gNotice.examination.submitCont, true, 3000);
	goResult();
}
/** 채점 결과 호출 */
function goResult(){
	cancelConfirmDialog();
	hideUnsolved();
	var length = gCorrect.length;
	var cnt = 0;
	for(var i=0;i<gCorrect.length;i++){
		var correct = gCorrect[i];
		for(var j=0;j<_answerList.length;j++){
			if(correct.qNo == _answerList[j].qNo && correct.da == _answerList[j].da){
				cnt = cnt + 1;
			}
		}
	}
	var score = Math.floor((cnt/length)*100);
	var examRsltCd = '01';
	if(score < 60){
		examRsltCd = '02';
	}
	_examResult['tot'] = score;
	_examResult['examRsltCd'] = examRsltCd;

	if(!_actionMode.isPractice){
		_status.stateCd = '07'; /** 답안 제출, 시험 완료 */
		saveData();
		$("#btnLabel").hide();
		setTimeout(function(){
			window.location.href = '../html/index.html';
		}, 3000);
	} else {
		_status.currentDirection = _status.currentDirection + 1;
		_status.currentPath = _directions[_status.currentDirection].path;
		saveData();
		window.location.href = '../html/index.html';
	}
}
/** SUBMIT */
function submit(){
	var packet = { 'action':'submit',
				   'actionType':'request',
				   'params':{'answerList':_answerList} };
	window.external.sendPacket(JSON.stringify(packet));
}

/** 임시저장 데이터 LOAD */
function loadData(){
	var rtn = false;
	_session = getSession(); /** 세션 설정 */
	//try{
	var restoreStr = $.cookie('webPreviewData');

	if(restoreStr){
		var restoreData = JSON.parse(restoreStr);
		_config = JSON.parse(window.getConfig());
		if((_config.seatNo+"").length == 1){
			_config.seatNo = "0"  + _config.seatNo;
		}
		_mode = restoreData.mode;
		_userInfo = restoreData.userInfo;
		_status = restoreData.status;
		_directions = restoreData.directions;
		_actionMode = restoreData.actionMode;
		if(restoreData.answerList){
			_answerList = restoreData.answerList;
		}
		if(restoreData.options){
			_options = restoreData.options;
		}
		rtn = true;
	}
	if(rtn){

		/*!@#$*/
		var script=document.createElement("script");
		var script2=document.createElement("script");
		var script3=document.createElement("script");

		if(_userInfo.grdGbCd == '1'){

			script.src="/cbt/js/practice_practiceData.js";
			script2.src="/cbt/js/training_trainingData.js";
			script3.src="/cbt/js/js_external_tutorial.js";

		} else if(_userInfo.grdGbCd == '2'){

			script.src="/cbt/js/practice2_practiceData.js";
			script2.src="/cbt/js/training2_trainingData.js";
			script3.src="/cbt/js/js_external_tutorial2.js";
		}

		var head = document.getElementsByTagName('head')[0];
		script.async=false;
		head.appendChild(script);

		if(_actionMode.isPractice){
			script2.async=false;
			head.appendChild(script2);
			setTimeout(function(){
				gImageMap = training.imageMap;
				gVideoMap = training.videoMap;
				gAudioMap = training.audioMap;
				gHwpMap = training.hwpMap;
				gData = training.data;
			}, 100);
		}

		setTimeout(function(){
			script3.async=false;
			head.appendChild(script3);
		}, 200);
		/*!@#$END*/
	}
	//} catch(e){

	//}
	return rtn;
}

function getConfig(){
	var config = {"seatNo":"07", "lang":"ko_KR", "mode":"local", "serverAddr":"127.0.0.1", "serverPort":"3000"};
	return JSON.stringify(config);
};


/** SESSION */
function getSession(){
	var session;
	var sessionStr = $.cookie('session');
	if(sessionStr){
		session = JSON.parse(sessionStr);
	}
	return session;
}

/** 임시저장 데이터 SAVE */
function saveData(){

	var data = {};

	data['mode'] = _mode;
	data['userInfo'] = _userInfo;
	data['status'] = _status;
	data['directions'] = _directions;
	data['actionMode'] = _actionMode;
	data['answerList'] = _answerList;
	data['options'] = _options;
	data['examResult'] = _examResult;
	$.cookie('webPreviewData', JSON.stringify(data), {path:"/"});
}

/** 학생 답안 SAVE */
function saveAnswer(qNo, da){
	if(!_actionMode.isPractice){
		var isNull = true;
		for(var i=0;i<_answerList.length;i++){
			if(_answerList[i].qNo == qNo){
				_answerList.splice(i, 1, {"qNo":qNo, "da":da});
				isNull = false;
			}
		}
		if(isNull){
			_answerList.push({"qNo":qNo, "da":da});
		}
		saveData();
	}
}
/** 볼륨 조절기 생 */
function getVolumeSlider(){
	jQuery(".button_volume_on").attr("style", "display:block");
	var initValue = window.external.getMasterVolume();
	_volumeSlider = jQuery("#volumeSlider").slider({
		orientation:"horizontal",
		range:"min",
		max:100,
		value:initValue,
		change:function(){setVolumeValue();}
	});
}
/** 볼륨 설정 */
function setVolumeValue(){

};
function cancelConfirmDialog(){
	showVideoObject(true);
	try{
		if($("#dialog-confirm").parents(".ui-dialog").is(":visible")){
			$("#dialog-confirm").parents(".ui-dialog").hide();
		}
	} catch (e){

	}
}
function confirmDialog(title, message, alertMsg, success, cancel){
	hideUnsolved();
	showVideoObject(false);
	var html = "<div class='confirmBxTitleWrap'><span class='alertTitle'>"+ title +"</span><a class='close' type='button' onclick='"+cancel+"();'> </a></div>";
	html = html + "<div class='alim_cont_2' style='text-align:left;padding-left:15px;padding-right:15px'><div>";
	html = html + "<div>" + message + "</div>";
	if(alert){
		html = html + "<div><font color='red'><b>[" + alertMsg + "]</b><font color='red'></div>";
	}
	var buttonObj = {};
	buttonObj[gMessage.labelJ3] = function(){
		$(this).dialog('destroy');
		success();
	};
	buttonObj[gMessage.labelJ4] = function(){
		$(this).dialog('destroy');
		cancel();
	};
	$("#dialog-confirm").html(html);
	$("#dialog-confirm").dialog({
		resizable:false,
		modal:false,
		height:480,
		width:865,
		buttons:buttonObj
	});
	$("#dialog-confirm").parents(".ui-dialog").show();
	$(".ui-dialog").addClass("confirm");
	$("#dialog-confirm").removeClass("ui-dialog-content");
	$("#dialog-confirm").removeClass("ui-widget-content");
	$(".ui-dialog").corner("round 13px");
	$(".confirmBxTitleWrap").corner("round top 12px");
	var cnt = 0;
	$(".ui-dialog .ui-dialog-buttonset").html('<a href="javascript:'+success+'();" ondragstart="return false;" class="btn-primary">'+gMessage.labelJ3+'</a><a href="javascript:'+cancel+'();" ondragstart="return false;" class="btn-secondary">'+gMessage.labelJ4+'</a>');
}
function confirmFinalDialog(){
	cancelConfirmDialog();
	setTimeout(function(){
		confirmDialog(gNotice.examination.alert, gNotice.examination.confirmFinalCont, gNotice.examination.confirmAlert, 'showResult', 'cancelConfirmDialog');
	}, 200);
}
/** 다이얼 로그 */
function showDialog (title, content, display, time){
	$(".alertTitle").html(title);
	$(".alim_cont > div").html(content);
	if(display){
		$("#alertBx").fadeIn(1000);
	} else {
		$("#alertBx").fadeOut(1000);
	}
	if(time > 0){
		setTimeout(function(){showDialog(title,content,false,0);}, time);
	}
}
function hideCalculator(){
	$("#ifrm_draggable").hide();
}
