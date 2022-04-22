//**************************************************************
//
// itp_item class
//
//**************************************************************
function saningong_viewer(target, $data, $param, $options) {

	var that = this;
	target = $(target);

	$options = $.extend({
		mode:'practice',
		layout:'list',
		save:'auto',
		field:{ 'response':{ 'select': { dotLabelType:"arabic-circle", dotControlUse:false, dotLabelRender:'icon' } } }
	}, $options);

	this.m_initialPageIndex = -1;
	this.m_initialLeftTime = -1;
	this.m_curSectionNo = "0";
	this.m_curPageIndex = -1;
	this.m_arrItem = null;
	this.m_arrPage = null;
	this.m_mapHistory = [];
	this.m_simulationItemIndex = 0;
	this.m_zoomStep = [
		{ dpi:'100dpi', scale:1, canvasScale:1 , canvasSize:774},
		{ dpi:'150dpi', scale:1, canvasScale:1.5 , canvasSize:1161},
		{ dpi:'200dpi', scale:1, canvasScale:2 , canvasSize:1548}
	];
	this.m_zoomStepIndex = 1;
	this.m_defaultCanvasSize = { width:100, height:1000 }; /* widthout scale */
	this.m_canvasSize = { width:100, height:1000 }; /* with scale */
	this.m_arrSection = [];
	this.m_logTimeInterval = 15;  /* 10초마다 백업 */
	this.m_testInfo = {};
	this.m_textarea_height = 80;
	this.m_delta = 16;
	this.m_sheetClass = "sheetNum";
	this.getOption = function() {
		return $options;
	}

	this.getSchema = function() {
		if(_config.isOffline){ /** external : 비상시행여부 */
			this.m_sheetClass = this.m_sheetClass + " disconnected";
		}


		/**/
		var schema = '\
			<div class="header-block">\
				<input type="text" name="implementKey" value="53b169ab40933" style="display:none;">\
				<div class="test-nm-block">\
					<label id="sheetNum" class="'+this.m_sheetClass+'">07</label>' + '\
					<label class="test-info-testNm"></label>\
				</div>\
				<div class="user-info-block">\
					<div class="user-id-block"><span class="user-info-userId-label">'+gMessage.labelA1+' : </span><input class="user-info-userId" readonly="true" onfocus="this.blur()" style="cursor:default;"> </input></div>\
					<div class="user-nm-block"><span class="user-info-userNm-label">'+gMessage.labelA2+' : </span><input class="user-info-userNm" readonly="true" onfocus="this.blur()" style="cursor:default;"> </input></div>\
				</div>\
				<div class="test-timer-block" id="timerImage">\
					<div class="max-time-block"><label class="label-max-time">'+gMessage.labelI1+' : <label class="test-max-time-control"> </label></label></div>\
					<div class="left-time-block">\
						<label class="label-left-time">'+gMessage.labelI2+' : </label>\
						<input class="test-left-time-control" readonly="true" onfocus="this.blur()" style="cursor:default;"></input>\
						<input class="left-time-hidden" style="display:none;"></input>\
					</div>\
				</div>\
			</div>\
			<div class="test-core-block">\
				<div class="section-tool-block">\
					<div class="screen-tool">\
						<div class="zoom-tool"><span class="zoom-tool-title">'+gMessage.labelB1 + gMessage.labelB2 +'</span>\
							<a button="zoom" class="zoomBtn" type="0"></a>\
							<a button="zoom" class="zoomBtn" type="1"></a>\
							<a button="zoom" class="zoomBtn" type="2"></a>\
						</div>\
						<div class="layout-tool"><span class="layout-tool-title">'+gMessage.labelD1 +  gMessage.labelD2 +'</span>\
							<a button="sheet-mode" type="list">List</a>\
							<a button="sheet-mode" type="double">Double</a>\
							<a button="sheet-mode" type="item">Item</a>\
						</div>\
					</div>\
					<div class="section-name-block">\
						<label class="section-name-label"></label>\
					</div>\
					<div class="progress-info-block">\
						<div class="total-count-block">'+gMessage.labelE +'&nbsp;&nbsp;: <span class="count-info-total">0</span></div>\
						<div class="unsolved-count-block">'+gMessage.labelF +' : <span class="count-info-unsolved">0</span></div>\
					</div>\
				</div>\
				<div class="test-page-title-block" style="display:none"><div class="test-page-title-name"></div><div class="test-page-title-qstcnt"></div></div>\
				<div class="test-page-block-holder">\
					<div class="test-page-block"></div>\
				</div>\
			</div>\
			<div class="test-result-sheet-holder">\
				<div class="sheet-title-block">'+gMessage.labelH +'</div>\
				<div class="sheet-section-block">\
					<select name="sel-section">\
					</select>\
				</div>\
				<div class="mask" style="display:none"></div>\
				<div class="test-result-sheet" id="answerSheet"></div>\
			</div>\
			<div class="footer-block">\
				<div class="footer-left-block">\
					<a button="calculator" id="btnCaculator"><img src="/cbt/images/btn_calculator.gif" class="calculator_icon"></img> <span class="unsolved_label">계산기</span></a>\
					<div id="volumeIcon" class="button_volume_on" style="display:none;"></div>\
					<div id="volumeSlider"></div>\
				</div>\
				<div class="footer-center-block">\
					<a button="prev-page">'+gMessage.labelM2 +'</a>\
					<label class="page-position-label"></label>\
					<a button="next-page">'+gMessage.labelM3 +'</a>\
				</div>\
				<div class="footer-right-block">\
					<a button="unsolved" id="btnUnsolved"><img src="/cbt/images/unsolved_icon.gif" class="unsolved_icon"></img><span class="unsolved_label">'+gMessage.labelG +'</span></a>\
					<a button="submit-test" id="btnLabel"><img src="/cbt/images/submit_icon.gif" class="submit_icon"></img><span class="submit_label">'+gMessage.labelJ1 +'</span></a>\
				</div>\
			</div>\
		';
		/*END*/

		return schema.replace(/\n/g,'');
	}

	this.init = function() {

		target.html(that.getSchema());
		that.initInnerEventHanlder();
		that.initOuterEventHanlder();

		// controller binding....
		//***************************************
		$('.test-page-block',target).controller('itp/testviewer/page',null,null,{mode:$options.mode, field:$options.field });
		$('.test-result-sheet',target).controller('itp/testviewer/resultsheet',null,null,{mode:$options.mode});
		$('.test-left-time-control',target).controller('saningong/timer');

		/**/
		setTimeout(function() {

			that._getDefaultCanvasSize();
			that._calcCanvasSize();
			that._getTestItemData();
			that.changeLayout('list');
		}, 300);
		/**/
	}

	this._getDefaultCanvasSize = function() {
		that.m_defaultCanvasSize = { width:$('.test-page-block-holder',target).width(), height:$('.test-page-block-holder',target).height() };
	}

	this._calcCanvasSize = function() {
		var canvasScale = that.m_zoomStep[that.m_zoomStepIndex].canvasScale;
		var canvasSize = that.m_zoomStep[that.m_zoomStepIndex].canvasSize;
		that.m_canvasSize = { width:canvasSize, height:that.m_defaultCanvasSize.height*1 };
		//if(that.m_zoomStep[that.m_zoomStepIndex].canvasScale == 1){
		$(".test-page-block-holder").css('height',that.m_canvasSize.height);
		$(".test-page-block").css('height', that.m_canvasSize.height);
		//}
	}

	this.initInnerEventHanlder = function() {

		// 내부 이벤트 핸들러...
		//*************************************************
		target.on('click', '[button=unsolved]', function() { that.showUnsolved(); });
		target.on('click', '[button=calculator]', function(e) { that.showCalculator(e); });
		target.on('click', '[button=prev-page]', function() { that.goPrevPage(); });
		target.on('click', '[button=next-page]', function() { that.goNextPage(); });
		target.on('click', '[button=zoom]', function() { that.doZoom($(this).attr('type')); });
		target.on('click', '[button=sheet-mode]', function() { that.changeLayout($(this).attr('type')) });
		target.on('click', '[button=submit-test]', function() { that.doCompleteSubmit(); });
		target.on('change', '[name=sel-section]', function(e) { that._goPage(that._getPageIndexOfSection($(this).val())); $('#answerSheet').scrollTop(0);  });
	}

	this.initOuterEventHanlder = function() {

		// 외부 이벤트 핸들러...
		//*************************************************

		// 시험지에서 학생이 눌렀을 때
		$('body').on('ITP:TESTVIEWER_ITEM_RESPONSE', function(e, param) {
			if(target.is(':visible') == false)
				return;

			that.m_mapHistory[param.testItemSn] = { userAnswer:param.userAnswer, submit:false };
			if($options.save == 'auto') {
				that._logItem(param.testItemSn, param.userAnswer);
			}

			saveAnswer(param.testItemSn,  param.userAnswer); /** external : 답안저장 */

			that._calcAnswerCount();
			that.logTestStatus();
		});
		// 답안표에서 문제 번호를 눌렀을 때
		$('body').on('ITP:TESTVIEWER_GET_PAGE_BY_QNO', function(e, param) {
			// get page
			var nPage = that._getPageIndexOfTestItem(param.testItemSn);
			if(nPage != -1) {
				if(that.m_curPageIndex != nPage) {
					that._goPage(nPage);
				}
				setTimeout(function() {
					var o = $('.test-item-row[testItemSn='+param.testItemSn+']', target);
					o.find('.item-no-label').hide().fadeIn();
				},30);
			}

			that._calcAnswerCount();
		});
		// 답안표에서 학생이 눌렀을 때
		$('body').on('ITP:TESTVIEWER_RESULTSHEET_RESPONSE', function(e, param) {
			that.m_mapHistory[param.testItemSn] = { userAnswer:param.userAnswer, submit:false };
			var o = $('.test-item-row[testItemSn='+param.testItemSn+']', target);
			if(o && o.is(':visible')) {
				o.controller().setTestUserResponse(param.userAnswer);
			}

			if($options.save == 'auto') {
				that._logItem(param.testItemSn, param.userAnswer);
			}

			// get page
			var nPage = that._getPageIndexOfTestItem(param.testItemSn);
			if(nPage != -1) {

				if(that.m_curPageIndex != nPage) {
					that._goPage(nPage);
				}

				setTimeout(function() {
					var o = $('.test-item-row[testItemSn='+param.testItemSn+']', target);
					o.find('.item-no-label').hide().fadeIn();
				},30);
			}

			saveAnswer(param.testItemSn,  param.userAnswer); /** external : 답안저장 */

			that._calcAnswerCount();
			that.logTestStatus();
		});

		// 시간이 종료되었을 때....
		$('body').on('TIMER:TIME_OVER', function(e) {
			//alert('시간 종료');
			showTimeout(); /** external : 시간 종료 */
		});

		// 로그기록 타이머
		$('body').on('TIMER:STATUS_LOG_TIME', function(e) {
			that.logTestStatus();
		});

	}

	this.reload = function() {
		that._getTestItemData();
	}

	//***********************************************************************
	//
	// 산인공 함수들...
	//
	//***********************************************************************
	// 산인공 데이터를 eco 데이터로 변환
	this.convertTestData = function() {

		// 모드, 레이아웃 모드

		/*
		// status setting....
		$options.mode = 'practice';
		$options.layout = 'list';

		// 지정된 페이지가 있을 때....
		that.m_initialPageIndex = 1;

		// 지정된 남은 시간이 있을 때....
		that.m_initialLeftTime = 100;

		// 지정된 확대 값이 있을 때
		that.m_zoomStepIndex = 4;

		gData.info.testNm = "1111111";
		gData.info.userNm = "22222";
		*/

		// data converting.....
	}

	// 산인공 히스토리를 eco 히스토리로 변환
	this.convertHistoryData = function() {

		// history setting....
		//gHistory = [];
	}

	// 결과를 저장함...
	this.submitResult = function(arrSave) {

		if($options.mode != 'test')
			return;

		if(arrSave == undefined || arrSave.length == 0)
			return;

		// 결과를 저장합니다.
		//console.log(arrSave);

	}

	this.logTestStatus = function() {

		that.stopLogTimer();
		if($options.mode != 'test')
			return;
		var nTimeLeft = $('.test-left-time-control',target).controller().getLeftTime();
		if(nTimeLeft < 0) {
			that.startLogTimer();
			return;
		}

		var status = {
			layout:$options.layout,
			pageIndex:that.m_curPageIndex,
			timeLeft:nTimeLeft,
			zoomIndex:that.m_zoomStepIndex
		};

		//console.log(status);

		// 상태 로그를 저장합니다....
		that.startLogTimer();
	}

	this.doCompleteSubmit = function() {
//		var resultList = [];
//		for(var i = 0; i<that.m_arrItem.length; i++){
//			if(that.m_mapHistory[that.m_arrItem[i].testItemSn] != null){
//				var answer = {};
//				answer['qNo'] = that.m_arrItem[i].testItemSn;
//				answer['value'] = that.m_mapHistory[that.m_arrItem[i].testItemSn].userAnswer;
//				resultList.push(answer);
//			}
//		}

		// 로그 타이머 종료
		that.stopLogTimer();

		// 시험결과를 알려줍니다...
		/*
		ecoUtils.doApi('/itp/implement/modifyCompleteYn', { implementKey:that.implementKey, completeYn:"Y" }, function(oData) {
			that.reload();

		});
		*/
		confirmSubmit($('.left-time-hidden').val(), that.m_testInfo.maxTime, $('.count-info-unsolved').html()); /** external : 결과 보기 화면 이동 */
	}
	//이미지 데이터
	this.getImageData = function(pid, dpi) {
		var curDpi = this.m_zoomStep[this.m_zoomStepIndex].dpi;
		var imageData = gImageMap[pid][dpi?dpi:curDpi];
		return imageData;
	}
	//동영상 데이터
	this.getVideoData = function(pid, dpi) {
		var curDpi = this.m_zoomStep[this.m_zoomStepIndex].dpi;
		var videoData = gVideoMap[pid][dpi?dpi:curDpi];
		return videoData;
	}

	//**************************************************************
	//
	// action function....
	//
	//**************************************************************
	this.goPrevPage = function() {
		that._goPage(that.m_curPageIndex-1);
	}

	this.goNextPage = function() {
		that._goPage(that.m_curPageIndex+1);
	}
	this.showCalculator = function(e){
		//window.external.showCalculator(true);
		//return;
		if($("#ifrm_draggable").is(":visible")){
			$("#ifrm_draggable").hide();
		} else {
			var url = "../viewer/calculator/calculator.html";
			$("#ifrm_draggable").show();
			if($("#ifrm_draggable").attr("src") == ''){
				$("#ifrm_draggable").attr("src", url);
			}
		}
	}
	this.showUnsolved = function(e) {
		if(that._getSolvedItemCount() == that.m_arrItem.length) {
			//alert('안 푼 문제가 없습니다');
			return;
		}
		var arrUnsolved = [];
		var unsolveBtns = "<div class='alertBxTitleWrap'><span class='alertTitle'>"+ gMessage.labelG1 +": "+ gMessage.labelG2 +"</span><button class='close' type='button' onclick='hideUnsolved();'> × </button></div>";
		unsolveBtns = unsolveBtns + "<div class='alim_cont' style='text-align:left;padding-left:15px;padding-right:15px'>";
		for(var i = 0 ; i < that.m_arrItem.length ; i++) {
			var testItemSn = that.m_arrItem[i].testItemSn;
			if(that.m_mapHistory[testItemSn] == undefined) {
				unsolveBtns = unsolveBtns + '<button class="btn_default" onclick="goUnsolvedIndex(' + testItemSn + ');"><b>'+Number(i+1)+'</b></button>';
				//that._goPage(that._getPageIndexOfTestItem(testItemSn));
			}
		}
		unsolveBtns = unsolveBtns + "</div>";
		$("#unsolved").html(unsolveBtns);
		//$("#unsolved").dialog("option", "position", [auto, auto]);
		$("#unsolved").parents(".ui-dialog").show();

		if($("#unsolved").dialog("isOpen")){
			showVideoObject(true); /** external : 동영상 플레이어 */
			$("#unsolved").dialog('close');
	    } else {
			showVideoObject(false); /** external : 동영상 플레이어 */
			cancelConfirmDialog(); /** external : 답안 제출 팝업 숨김 */
			$("#unsolved").dialog('open');
			$(".ui-dialog").removeClass("confirm");
	    }
		$("#unsolved").removeClass("ui-dialog-content");
		$("#unsolved").removeClass("ui-widget-content");

		return false;
	}

	this.changeLayout = function(type) {

		if($options.layout == type)
			return;

		$options.layout = type;

		$('[button=sheet-mode].selected',target).removeClass('selected');
		$('[button=sheet-mode][type='+type+']',target).addClass('selected');
		that._calcItemHeight();
		that._makePages();
	}

	this.doZoom = function(dir) {

		//var nIndex = this.m_zoomStepIndex + (dir == 'plus' ? 1 : -1);
		var nIndex = Number(dir);
		if(nIndex < 0 || nIndex > this.m_zoomStep.length-1)
			//that.m_zoomStepIndex = 0;
			return;

		var prevDpi = this.m_zoomStep[this.m_zoomStepIndex].dpi;
		this.m_zoomStepIndex = nIndex;
		var nZoom = this.m_zoomStep[this.m_zoomStepIndex].scale;
		target.attr('dpi',this.m_zoomStep[this.m_zoomStepIndex].dpi);

		if(prevDpi != this.m_zoomStep[this.m_zoomStepIndex].dpi) {
			that._calcCanvasSize();

			that._calcItemHeight();
			that._makePages();

			that._goPage(that.m_curPageIndex, true);
		}
		//$('.test-page-block', target).css('zoom', nZoom);

		/** textarea/video 확대 비율 복원 */
		//var ratio = 1/nZoom*(nZoom*2);
		//$('.textareaControlDiv').each(function(){
		//	$(this).css('zoom', ratio);
		//});
		//$('.videoControlDiv').each(function(){
		//	$(this).css('zoom', ratio);
		//});
		//$('.playerControlBar').each(function(){
		//	$(this).css('zoom', ratio);
		//});

		//target.attr('dpi',this.m_zoomStep[this.m_zoomStepIndex].dpi);

		//if(!$options.simulation){
			//that.logTestStatus();
		//}
	}

	/*!@#$*/
	this.showKmList = function(top, sectionNo){
		$("[name=sel-section]").css("display", "none");

		var schema = '\
			<div class="section-kmlist" style="width: 97%; margin-top: '+top+'px; background-color: #fff; font-size: 1.3em; position: absolute; z-index: 10; border: 1px solid #777;">\
		';

		var tempSection = [];
		var j=1;
		for(var i=0; i < that.m_arrItem.length; i++){
			if(tempSection[that.m_arrItem[i].sectionNo] == undefined) {
				tempSection[that.m_arrItem[i].sectionNo] = that.m_arrItem[i].sectionNm;

				if(j == sectionNo){
					schema += '\
						<p style="margin: 0px; padding:1px 2px; background-color: #0078d7; color: #fff;">'+that.m_arrItem[i].sectionNm+'</p>\
					';
				} else{
					schema += '\
						<p style="margin: 0px; padding:1px 2px;">'+that.m_arrItem[i].sectionNm+'</p>\
					';
				}
				j++;
			}
		}

		schema += '\
			</div>\
		';

		$(schema).appendTo($(".sheet-section-block", target));
	};

	this.selectKm = function(val){
		$(".section-kmlist", target).remove();
		$("[name=sel-section]").css("display", "block");
		$("[name=sel-section]").val(val).trigger("change");
	}
	/*!@#$END*/

	//**************************************************************
	//
	// private function....
	//
	//**************************************************************
	this._startTest = function() {

		// set test info
		target.addClass('mode-'+$options.mode);

		// zoom...
		that._calcCanvasSize();

		var nZoom = this.m_zoomStep[this.m_zoomStepIndex].scale;
		$('.test-page-block', target).css('zoom', nZoom);
		target.attr('dpi',this.m_zoomStep[this.m_zoomStepIndex].dpi);

		that._showTestInfo(that.m_testInfo.testNm);
		that._setTestMaxTime(that.m_testInfo.maxTime);

		if(that.m_initialLeftTime != -1) {
			that._setTestTimer(that.m_initialLeftTime);
			that.m_initialLeftTime = -1;
		} else {
			that._setTestTimer(that.m_testInfo.maxTime);
		}

		that._showUserInfo(that.m_testInfo.userNm, that.m_testInfo.userId);

		switch($options.mode) {
		case 'review' :
			$('[button=unsolved]',target).hide();
			$('[button=submit-test]',target).hide();
			break;
		case 'practice' :
			$('[button=unsolved]',target).show();
			$('[button=submit-test]',target).show();
			break;
		case 'test' :
		default:
			$('[button=unsolved]',target).show();
			$('[button=submit-test]',target).show();
			break;

		}

		that._calcItemHeight();
		that._calcAnswerCount();
		that._makePages();

		// log Time..
		if($options.mode == 'test') {
			that.startLogTimer();
		}

		// start timer...
		if($options.mode == 'test' || $options.mode == 'practice') {
			$('.test-left-time-control',target).controller('saningong/timer').startTimer();
		}

	}

	this.startLogTimer = function() {
		that.stopLogTimer();
		that.m_idLogTimer = setTimeout(that.logTestStatus, that.m_logTimeInterval*1000);
	}

	this.stopLogTimer = function() {
		clearTimeout(that.m_idLogTimer);
	}

	this._goPage = function(n, bForce) {
		if(n < 0 || n > that.m_arrPage.length-1)
			return;
		that.m_curPageIndex = n;

		$('.page-position-label',target).html((that.m_curPageIndex+1) + '/' + that.m_arrPage.length);

		$('.test-page-block',target).controller().setSheets(that.m_arrPage[that.m_curPageIndex], that.m_mapHistory, { mode:$options.mode, layout:$options.layout, canvasSize:that.m_canvasSize, canvasScale:that.m_zoomStep[that.m_zoomStepIndex].canvasScale});

		$('.test-page-block-holder',target).scrollTop(0).scrollLeft(0);

		var newSectionNo = that.m_arrPage[that.m_curPageIndex][0][0].sectionNo;

		if(that.m_curSectionNo != newSectionNo || !!bForce) {
			that.m_curSectionNo = newSectionNo;
			$('[name=sel-section]',target).val(newSectionNo);

			/*!@#$*/
			var arrSectionItem = that.m_arrItem;
			/*!@#$END*/
			var strSectionNm = that.m_arrSection.length == 0 ? '' : that.m_mapSection[that.m_curSectionNo].sectionNm;

			if(!!bForce == false)
				$('.test-result-sheet',target).controller().setItems(arrSectionItem, that.m_mapHistory, { mode:$options.mode } );

			/*!@#$*/
			var qstCnt = 0;
			if(that.m_arrSection.length > 0)
				qstCnt = that.m_mapSection[that.m_curSectionNo].listItem.length;

			$('.test-page-title-name', target).html("제"+(newSectionNo)+"과목:&nbsp;&nbsp;"+strSectionNm);
			$('.test-page-title-qstcnt', target).html( "과목 문제 수:&nbsp;<font color='yellow' ><strong>" +qstCnt+"</strong></font>");
			/*!@#$END*/
			$('.section-name-label',target).html(strSectionNm);
		}

		$('[button=prev-page]',target)[that.m_curPageIndex <= 0 ? 'addClass':'removeClass']('disabled');
		$('[button=next-page]',target)[that.m_curPageIndex >= that.m_arrPage.length-1 ? 'addClass':'removeClass']('disabled');

		//console.log(that.m_arrSection);
		if(that.m_arrSection.length == 0) {
			/*!@#$*/
			$(".test-page-title-block").remove();
			$(".test-page-block-holder").css("top", "50px");
			$(".test-page-block").css("top", "0px");
			/*!@#$END*/
			$("#answerSheet").css("top", "48px");
		} else {
			/*!@#$*/
			$(".test-page-title-block").css("display", "block");
			$(".test-page-block-holder").css("top", "50px");
			$(".test-page-block").css("top", "35px");
			/*!@#$END*/
			$("#answerSheet").css("top", "88px");
		}

		/** 동영상 플레이어 */
		$('.videoObjectScreen').each(function(){
			var width = $(this).css("width");
			var height = $(this).css("height");
			var _this = $(this);
			setTimeout(function(){
				_this.css("width", width);
				_this.css("height", height);
			}, 500 );
			//$("#openStateEventListener").attr("for", $(this).attr("id"));
			//$("#playerEventListener").attr("for", $(this).attr("id"));
		});
		/** 아이템 사이즈 보정*/
		for(var cnt=0;cnt<that.m_arrPage[that.m_curPageIndex].length;cnt++){
			var itemLength = that.m_arrPage[that.m_curPageIndex][cnt].length;
			var sheet1Height = Number($(".sheet-1").css('height').replace("px", ''))+20;
			var sheet2Height = 0;
			if(that.m_arrPage[that.m_curPageIndex].length > 1){
				sheet2Height = Number($(".sheet-2").css('height').replace("px", ''))+20;
			}
			if(itemLength == 1 && cnt == 0){
				$(".test-page-block").css('height', sheet1Height + "px");
				if(sheet1Height > that.m_defaultCanvasSize.height + 20){
					$(".test-page-block-holder").css('overflow-y', 'auto');
				}
			} else if(itemLength == 1 && cnt == 1){
				$(".test-page-block").css('height', sheet2Height + "px");
				if(sheet2Height > that.m_defaultCanvasSize.height + 20){
					$(".test-page-block-holder").css('overflow-y', 'auto');
				}
			}
		}
		if($(".sheet-2").css('height')){
			var sheet1Height = Number($(".sheet-1").css('height').replace("px", ''));
			var sheet2Height = Number($(".sheet-2").css('height').replace("px", ''));

			if(sheet1Height > sheet2Height){
				if(that.m_defaultCanvasSize.height > sheet1Height){
					sheet1Height = that.m_defaultCanvasSize.height;
				}
				$(".sheet-2").css('height', sheet1Height + "px");
				$(".test-page-block").css('height', sheet1Height + "px");
			} else {
				if(that.m_defaultCanvasSize.height > sheet2Height){
					sheet2Height = that.m_defaultCanvasSize.height;
				}
				$(".sheet-2").css('height', sheet2Height + "px");
				$(".test-page-block").css('height', sheet2Height + "px");
			}
		} else {
			$(".test-page-block").css('height', sheet1Height + "px");
		}
		if(that.m_zoomStepIndex == 0){
			/** 100dpi일 경우 overflow-x hidden 처리 */
			$(".test-page-block-holder").css('overflow-x', 'hidden');
			$(".test-page-block").css('overflow-x', 'hidden');
		}
		//that.logTestStatus();
	}


	this._setTestMaxTime = function(s) {
		var h = Math.floor(s/60/60);
		var m = Math.floor((s/60)%60);
		var s = s%60;

		var out = (h > 0 ? h + gMessage.labelX1 + ' ': '') + (m > 0 ? m + gMessage.labelX2 + ' ': '') + (s >0 ? s + gMessage.labelX3 + '' : '');
		$('.test-max-time-control',target).html(out);
	}
	this._setMaxTime = function(s){
		that.m_testInfo.maxTime = s;
	}
	this._getMaxTime = function(){
		return that.m_testInfo.maxTime;
	}
	this._setTestTimer = function(s) { $('.test-left-time-control',target).controller().setTimer(s); };
	this._getMaxSecond = function(s) { return $('.test-left-time-control',target).controller().getMaxSecond(); };
	this._showTestInfo = function(testNm) { $('.test-info-testNm', target).html(testNm); }
	this._showUserInfo = function(userNm, userId) {
		$('.user-info-userNm', target).val(userNm);
		$('.user-info-userId', target).val(userId);
	}

	this._getSolvedItemCount = function() {

		var cnt = 0;
		for(var i in that.m_mapHistory) {

			if(typeof that.m_mapHistory[i] == 'function')
				continue;

			cnt++;
		}

		return cnt;
	}

	this._calcAnswerCount = function() {

		var cntSolved = that._getSolvedItemCount();

		if(that.m_arrItem.length - cntSolved == 0) {
			$('[button=unsolved]',target).hide();
		}

		$('.count-info-unsolved', target).html(that.m_arrItem.length - cntSolved);
		$('.count-info-total', target).html(that.m_arrItem.length);

	}

	this._getPageIndexOfSection = function(sectionNo) {
		var nPage = -1;

		for(var i = 0, len = that.m_arrPage.length ; i < len ; i++) {

			for(var j = 0 ; j < that.m_arrPage[i].length ; j++) {

				for(var k = 0 ; k < that.m_arrPage[i][j].length ; k++) {

					if(that.m_arrPage[i][j][k].sectionNo == sectionNo) {
						return i;
					}
				}
			}
		}

		return nPage;
	}


	this._getFirstItemInCurPage = function() {

		var testItemSn = -1;

		try { testItemSn = that.m_arrPage[that.m_curPageIndex][0][0].testItemSn; } catch(e) {};

		return testItemSn;
	}

	this._getPageIndexOfTestItem = function(testItemSn) {

		var nPage = -1;

		for(var i = 0, len = that.m_arrPage.length ; i < len ; i++) {

			for(var j = 0 ; j < that.m_arrPage[i].length ; j++) {

				for(var k = 0 ; k < that.m_arrPage[i][j].length ; k++) {

					if(that.m_arrPage[i][j][k].testItemSn == testItemSn) {
						return i;
					}
				}
			}
		}

		return nPage;

	}

	this._calcItemHeight = function() {
		var nItemHeight = 0;
		var oItemData = null;
		var oFieldData = null;
		var oSize = null;
		var strSize = "";

		for(var i = 0 ; i < that.m_arrItem.length ; i++) {

			nItemHeight = 0;
			oItemData = typeof that.m_arrItem[i].data == 'string' ? JSON.parse(that.m_arrItem[i].data) : that.m_arrItem[i].data;

			for(var field in oItemData) {

				oFieldData = oItemData[field];

				if(field != 'question' && field != 'response' && field != 'reference')
					continue;

				if(oFieldData.value == undefined)
					continue;


				switch(field) {
				case 'response' :

					var numInRow = oFieldData.numInRow || 1;
					var maxHeightInRow = 0;
					if(oFieldData.type == 'textarea'){
						nItemHeight += maxHeightInRow;
						nItemHeight += that.m_delta; /* 10 */
					} else {
						for(var k = 0 ; k < oFieldData.value.length ; k++) {
							strSize = that.getImageData(oFieldData.value[k].pid, that.m_zoomStep[that.m_zoomStepIndex].dpi).size;
							//strSize = oFieldData.value[k].size;
							if(strSize == undefined)
								continue;

							oSize = strSize.split(',');
							maxHeightInRow = Math.max(maxHeightInRow, parseInt(oSize[1]));

							if(k%numInRow == numInRow-1 || k == oFieldData.value.length-1) {
								nItemHeight += maxHeightInRow;
								nItemHeight += that.m_delta; /* 10 */
								maxHeightInRow = 0;
							}
						}
					}

					break;
				case 'reference' :
					for(var k = 0 ; k < oFieldData.value.length ; k++) {
						strSize = that.getVideoData(oFieldData.value[k].pid, that.m_zoomStep[that.m_zoomStepIndex].dpi).size;
						//oFieldData.value[k].size;

						if(strSize == undefined)
							continue;

						oSize = strSize.split(',');
						if(oFieldData.value[k].type == 'video'){
							nItemHeight += parseInt(oSize[1])+35; /*컨트롤바 사이즈 추가*/
							nItemHeight += that.m_delta; /* 10 */
						}
					}
					break;
				case 'question' :
				default :
					for(var k = 0 ; k < oFieldData.value.length ; k++) {

						strSize = that.getImageData(oFieldData.value[k].pid, that.m_zoomStep[that.m_zoomStepIndex].dpi).size;

						if(strSize == undefined)
							continue;

						oSize = strSize.split(',');
						nItemHeight += parseInt(oSize[1]);
						nItemHeight += that.m_delta; /* 10 */
						break;
					}
					break;
				}
			}
			var canvasScale = that.m_zoomStep[that.m_zoomStepIndex].canvasScale;
			nItemHeight += (30 * canvasScale) + (10*canvasScale); /* 60 */

			//console.log(nItemHeight);
			that.m_arrItem[i].itemHeight = nItemHeight;
		}
	}

	this._makePages = function() {

		var curZoomIndex = that.m_zoomStepIndex;
		$(".zoomBtn").each(function(){
			$(this).removeClass("curZoom");
			if($(this).attr("type") == curZoomIndex){
				$(this).addClass("curZoom");
			}
		});
		that.m_zoomStepIndex = 0;
		that._calcCanvasSize();

		var lastTestItemSn = that._getFirstItemInCurPage();

		$('[button=sheet-mode].selected', target).removeClass('selected');
		$('[button=sheet-mode][type='+$options.layout+']', target).addClass('selected');

		that.m_arrPage = [];

		var arrSheet = [];
		var oSheet = null;

		switch($options.layout) {

		case 'item' :
			var pageHeight=0;
			for(var i = 0 ; i < that.m_arrItem.length ; i++) {
				oSheet = [that.m_arrItem[i]];
				pageHeight = that.m_arrItem[i].itemHeight;
				arrSheet.push(oSheet);

			}
			break;
		case 'double' :
		case 'list' :

			var oSheet = [];
			arrSheet.push(oSheet);
			var sheetHeight = 0;
			var lastSectionNo = '';
			var canvasScale = that.m_zoomStep[that.m_zoomStepIndex].canvasScale;

			var validCanvasHeight = that.m_canvasSize.height-(30+20);

			var pageHeight=0;
			for(var i = 0 ; i < that.m_arrItem.length ; i++) {

				if((lastSectionNo != '' && lastSectionNo != that.m_arrItem[i].sectionNo) || sheetHeight + that.m_arrItem[i].itemHeight > Number(validCanvasHeight)) {
					pageHeight = sheetHeight;
					if(i!=0){ /** 제일 처음 아이템은 height 사이즈가 초과하더라도 section에 적재한다.*/
						sheetHeight = 0;
						oSheet = [];
						arrSheet.push(oSheet);
					}
				}

				oSheet.push(that.m_arrItem[i]);
				sheetHeight += that.m_arrItem[i].itemHeight;
				lastSectionNo = that.m_arrItem[i].sectionNo;
			}

			break;
		}
		that.m_arrPage = [];
		var oPage = [];
		that.m_arrPage.push(oPage);

		var maxSheetInPage = $options.layout == 'double' ? 2 : 1;
		var lastSectionNo = '';

		for(var i = 0 ; i < arrSheet.length ; i++) {

			if((lastSectionNo != '' && lastSectionNo != arrSheet[i][0].sectionNo) || oPage.length >= maxSheetInPage) {
				oPage = [];
				cntSheetInPage = 0;
				that.m_arrPage.push(oPage);
			}

			oPage.push(arrSheet[i]);
			lastSectionNo = arrSheet[i][0].sectionNo;
		}

		if(that.m_curPageIndex == -1 || that.m_curPageIndex > that.m_arrPage.length-1 )
			that.m_curPageIndex = 0;

		if(lastTestItemSn != -1) {
			that.m_curPageIndex = that._getPageIndexOfTestItem(lastTestItemSn);
		}

		if(that.m_initialPageIndex != -1) {
			that.m_curPageIndex = that.m_initialPageIndex;
			that.m_initialPageIndex = -1;
		}

		that.m_zoomStepIndex= curZoomIndex;
		that._calcCanvasSize();
		that._goPage(that.m_curPageIndex);

		if(!$options.simulation){
			//that.logTestStatus();
		}
	}

	this._logItem = function(testItemSn, userAnswer) {
		that.submitResult([ { testItemSn:testItemSn, userAnswer:userAnswer } ]);
	}

	this._getTestItemData = function() {
		that.convertTestData();
		that.convertHistoryData();
		that.implementKey = $('[name=implementKey]', target).val();
		that._parseTestData(gData);
		that._parseHistoryData(gHistory);
		that._startTest();

		target.css('display','block');
	}

	this._parseHistoryData = function(arrHistory) {
		if(arrHistory) {
			for(var i = 0 ; i < arrHistory.length ; i++) {
				that.m_mapHistory[arrHistory[i].testItemSn] = { userAnswer:arrHistory[i].userAnswer, submit:true };
			}
		}
	}

	this._parseTestData = function(oData) {

		that.m_testInfo = oData.info;
		/*
		var o = JSON.parse($.cookie(that.implementKey) || "{}");

		this.m_curPageIndex = 0;

		if(o.layout)
			$options.layout = o.layout;
		if(o.pageIndex)
			that.m_curPageIndex = o.pageIndex;
		*/

		if(oData.info.completeYn == "Y")
			$options.mode = "review";

		that.m_arrItem = oData.items;


		// section data handling....
		//******************************************
		that.m_arrSection = [];
		that.m_mapSection = {};
		$('[name=sel-section]', target).html('');

		for(var i = 0 ; i < that.m_arrItem.length ; i++) {

			if(that.m_arrItem[i].sectionNo == undefined){
				continue;
			}

			if(that.m_mapSection[that.m_arrItem[i].sectionNo] == undefined) {
				that.m_mapSection[that.m_arrItem[i].sectionNo] = { sectionNm:that.m_arrItem[i].sectionNm, listItem:[] };
				that.m_arrSection.push( { sectionNo:that.m_arrItem[i].sectionNo, sectionNm:that.m_arrItem[i].sectionNm });

				$('<option value="'+that.m_arrItem[i].sectionNo+'">'+that.m_arrItem[i].sectionNm+'</option>').appendTo($('[name=sel-section]', target));
			}
			that.m_mapSection[that.m_arrItem[i].sectionNo].listItem.push(that.m_arrItem[i]);
		}


		//console.log(that.m_arrSection);
		if(that.m_arrSection.length == 0) {
			target.addClass('test-has-no-section');
		}
	}

	this.init();
};

//**************************************************************
//
// timer class
//
//**************************************************************
function saningong_timer(target) {

	var that = this;
	target = $(target);

	this.m_maxSecond = 10000;
	this.m_startTimestamp = 0;
	this.m_running = false;
	this.m_idTimer = 0;
	this.m_initLeftTime = 0;
	this.m_half = false;
	this.m_alert = false;
	this.init = function() {

	}
	this.getMaxSecond = function(){
		return that.m_maxSecond;
	}
	this.setTimer = function(s) {
		that.m_maxSecond = s;

		that.m_half = false;
		that.m_half = false;
		var img = $("#timerImage").css("background-image");
		img = img.replace("ico_clock01.gif", "clock_icon.gif");
		img = img.replace("ico_clock02.gif", "clock_icon.gif");
		$("#timerImage").attr('style', "background-image:"+img + " !important"); /** 타이머 이미지 초기화 */
	}

	this.getLeftTime = function() {

		var nElapsed = (new Date()).getTime()-that.m_startTimestamp;
		var nLeftTime = that.m_maxSecond-Math.floor(nElapsed/1000) - that.m_initLeftTime;

		return nLeftTime;
	}

	this.startTimer = function() {

		if(that.m_running)
			return;

		that.m_startTimestamp = (new Date()).getTime();
		that.m_running = true;
		that.m_idTimer = setInterval(that.timerTic,100);
	}

	this.stopTimer = function() {
		if(that.m_running == false)
			return;

		clearInterval(that.m_idTimer);
	}

	this.timerTic = function() {

		if(that.m_running == false)
			return;

		var nElapsed = (new Date()).getTime()-that.m_startTimestamp;
		var nLeftTime = that.m_maxSecond-Math.floor(nElapsed/1000) - that.m_initLeftTime;

		if(nLeftTime < 0) {
			target.trigger('TIMER:TIME_OVER');
			that.stopTimer();
			target.val('0' + gMessage.labelX3);
			return;
		}
		$('.left-time-hidden').val(nLeftTime);
		var m = Math.floor(nLeftTime/60);
		var s = nLeftTime%60;
		var out = (m > 0 ? m+ gMessage.labelX2 +' ' : '') + s + gMessage.labelX3 +'';
		target.val(out);

		/** 타이머 이미지 변경 */
		var img = $("#timerImage").css("background-image");
		if(Math.floor(Number(that.m_maxSecond) / Number(nLeftTime)) > 1 && !that.m_half){ /** 남은 시간이 1/2미만인 경우 */
			that.m_half = true;
			img = img.replace("clock_icon.gif", "ico_clock01.gif");
			$("#timerImage").attr('style', "background-image:"+img + " !important");
		} else if(Math.floor(Number(that.m_maxSecond) / Number(nLeftTime)) > 4 && !that.m_alert) { /** 남은 시간이 1/5미만인 경우 */
			that.m_alert = true;
			img = img.replace("ico_clock01.gif", "ico_clock02.gif");
			$("#timerImage").attr('style', "background-image:"+img + " !important");
		}
	}

	this.init();
}
