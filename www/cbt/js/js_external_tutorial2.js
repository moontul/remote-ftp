var tutorialList = {

	/** practice */
	"P10":{content:{tooltip:{message:["<font color='blue'>문제풀이 연습</font>을 진행하겠습니다.<BR/><BR/>아래의 확인 버튼을 클릭해 주세요."], scope:null, confirm:null, cancel:null, args:null},
			  	    message:null,
			  	    direction:null,
					character:"normal"},
			location:null,
			delay:1,
			effectSound:false
	},
	"P20":{content:{tooltip:null,
				    message:{message:["CBT 시험 문제 화면의 기본 글자 크기는 150%입니다. 글자가 크거나 작을 경우 크기를 변경하실 수 있습니다."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
					character:"normal"},
			location:null,
			delay:1,
			effectSound:false
	},
	"P30":{content:{tooltip:null,
					message:{message:["글자 크기를 100%로 변경해 보세요."], scope:null, confirm:null, cancel:null, args:null},
					direction:null,
					character:"normal"},
			location:null,
			delay:1,
			effectSound:false
	},
	"P31":{content:{tooltip:null,
		 		    message:null,
			   		direction:[{position:function(){ return {top:"95px", left:"80px"};}, scope:function(){ return $('body > .viewer').controller();}, confirm:"doZoom", cancel:null, args:["0"]}],
					character:"none"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"P40":{content:{tooltip:{message:["잘하셨습니다. 글자 크기가 더 작아졌습니다. <BR/><BR/> 이번에는 <font color='blue'>화면 배치</font>를 변경해 보도록 하겠습니다."], scope:null, confirm:null, cancel:null, args:null},
				    message:null,
			   		direction:null,
			   		character:"normal"},
		   location:null,
		   delay:1000,
		   effectSound:false
	},
	"P50":{content:{tooltip:null,
					message:{message:["<font color='blue'>화면 배치</font>는 <font color='blue'>1단 배치</font>가 기본 설정입니다.<BR/><BR/>더 많은 문제를 볼 수 있는 <font color='blue'>2단 배치</font>와 <font color='blue'>한 문제씩 보기</font> 설정이 가능합니다."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"P60":{content:{tooltip:null,
					message:{message:["화면배치를 <font color='blue'>2단</font>으로 변경해 보세요."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"P61":{content:{tooltip:null,
				    message:null,
			   	    direction:[{position:function(){ return {top:"95px", left:"370px"};}, scope:function(){ return $('body > .viewer').controller();}, confirm:"changeLayout", cancel:null, args:["double"]}],
				    character:"none"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	/*!@#$*/
	"PX0":{content:{tooltip:{message:["잘하셨습니다. <BR/>화면이 2단으로 변경되었습니다. <BR/><BR/>이번에는 <font color='blue'>과목 선택</font> 방법을 배워보도록 하겠습니다."], scope:null, confirm:null, cancel:null, args:null},
				    message:null,
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1000,
		   effectSound:false
	},
	"PX1":{content:{tooltip:null,
				    message:{message:["시험 중 해당 시험 종목의 <font color='blue'>과목</font>을 <font color='blue'>선택</font>할 수 있습니다. <BR/><BR/><font color='blue'>단, 면제 과목은 나타나지 않습니다.</font>"], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PX2":{content:{tooltip:null,
				    message:{message:["과목을 선택하시면 해당 과목이 선택 된 것을 확인할 수 있고, <BR/><BR/>해당 <font color='blue'>과목의 문제 수</font>를 확인 할 수 있습니다."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PZ0":{content:{tooltip:null,
				    message:{message:["과목을 <font color='blue'>과목2</font>로 변경해 보세요."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PZ1":{content:{tooltip:null,
			    	message:null,
			    	direction:[{position:function(){ return {top:"137px", left:"950px"}; }, scope:function(){ return $('body > .viewer').controller(); }, confirm:"showKmList", cancel:null, args:["5", 1]}],
			    	character:"none"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PZ2":{content:{tooltip:null,
			    	message:null,
			    	direction:[{position:function(){ return {top:"164px", left:"950px"}; }, scope:function(){ return $('body > .viewer').controller(); }, confirm:"selectKm", cancel:null, args:["2"]}],
			    	character:"none"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PZ3":{content:{tooltip:null,
				    message:{message:["과목을 <font color='blue'>과목1</font>로 변경해 보세요."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PZ4":{content:{tooltip:null,
			    	message:null,
			    	direction:[{position:function(){ return {top:"137px", left:"950px"}; }, scope:function(){ return $('body > .viewer').controller(); }, confirm:"showKmList", cancel:null, args:["-21", 2]}],
			    	character:"none"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PZ5":{content:{tooltip:null,
			    	message:null,
			    	direction:[{position:function(){ return {top:"112px", left:"950px"}; }, scope:function(){ return $('body > .viewer').controller(); }, confirm:"selectKm", cancel:null, args:["1"]}],
			    	character:"none"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	/*!@#$END*/
	"P70":{content:{tooltip:{message:["잘하셨습니다. <BR/><BR/>이번에는 <font color='blue'>답안 입력 방법</font>을 배워보도록 하겠습니다."], confirm:function(){}, cancel:null},
				    message:null,
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1000,
		   effectSound:false
	},
	"P80":{content:{tooltip:null,
				    message:{message:["답안은 문제의 보기 번호를 클릭하거나 답안표기란의 번호를 클릭하여 입력하실 수 있습니다."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"P90":{content:{tooltip:null,
			  		message:{message:["1번 문제의 보기 번호를 클릭해 보세요."], scope:null, confirm:null, cancel:null, args:null},
			        direction:null,
			        character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"P91":{content:{tooltip:null,
			        message:null,
					/*!@#$*/
		   	        direction:[{position:function(){ return {top:"271px", left:"27px"};}, scope:function(){ return new tutorial();}, confirm:"setUserAnser", cancel:null, args:["1", "2"]}],
					/*!@#$END*/
			        character:"none"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PA0":{content:{tooltip:{message:["잘하셨습니다. 답안이 정상적으로 입력되었습니다. <BR/><BR/>이번에는 답안 표기란에서 입력해 보도록 하겠습니다."], scope:null, confirm:null, cancel:null, args:null},
			        message:null,
			        direction:null,
			        character:"normal"},
		   location:null,
		   delay:1000,
		   effectSound:false
	},
	"PB0":{content:{tooltip:null,
				    message:{message:["2번 문제의 답안 표기란 답안 번호를 클릭해 보세요."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PB1":{content:{tooltip:null,
				    message:null,
					/*!@#$*/
				    direction:[{position:function(){ return {top:"216px", left:"951px"};}, scope:function(){ return new tutorial();}, confirm:"setUserAnser", cancel:null, args:["2", "4"]}],
					/*!@#$END*/
			        character:"none"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PC0":{content:{tooltip:{message:["잘하셨습니다. 답안이 정상적으로 입력되었습니다. 이번에는 입력된 답안을 수정해 보도록 하겠습니다."], scope:null, confirm:null, cancel:null, args:null},
				    message:null,
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1000,
		   effectSound:false
	},
	"PD0":{content:{tooltip:null,
				    message:{message:["입력된 답안은 문제 화면 또는 답안 표기란의 보기 번호를 클릭하여 변경하실 수 있습니다."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PE0":{content:{tooltip:null,
			  	    message:{message:["2번 문제의 답안을 변경해 보세요."], scope:null, confirm:null, cancel:null, args:null},
			  	    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PE1":{content:{tooltip:null,
			    	message:null,
					/*!@#$*/
			    	direction:[{position:function(){ return {top:"216px", left:"863px"};}, scope:function(){ return new tutorial();}, confirm:"setUserAnser", cancel:null, args:["2", "1"]}],
					/*!@#$END*/
			    	character:"none"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PF0":{content:{tooltip:{message:["잘하셨습니다. 답안이 정상적으로 입력되었습니다. <BR/><BR/>이번에는 페이지 이동 방법을 배워보도록 하겠습니다."], scope:null, confirm:null, cancel:null, args:null},
				    message:null,
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1000,
		   effectSound:false
	},
	"PG0":{content:{tooltip:null,
				    message:{message:["페이지 이동은 아래의 페이지 이동 버튼 또는 답안 표기란의 문제 번호를 클릭하여 이동할 수 있습니다."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1,
		  effectSound:false
	},
	"PH0":{content:{tooltip:null,
				    message:{message:["아래의 페이지 이동 버튼을 클릭하세요."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PH1":{content:{tooltip:null,
			    	message:null,
			    	direction:[{position:function(){ var top = ($(window).height()-25)+"px"; return {top:top, left:"570px"};}, scope:function(){ return $('body > .viewer').controller(); }, confirm:"_goPage", cancel:null, args:[1]}],
			    	character:"none"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PH2":{content:{tooltip:null,
			    	message:null,
			    	direction:[{position:function(){ var top = ($(window).height()-25)+"px"; return {top:top, left:"445px"};}, scope:function(){ return $('body > .viewer').controller(); }, confirm:"_goPage", cancel:null, args:[0]}],
			    	character:"none"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PI0":{content:{tooltip:{message:["잘하셨습니다. <BR/><BR/>이번에는 계산기 기능을 사용해 보도록 하겠습니다."], scope:null, confirm:null, cancel:null, args:null},
				    message:null,
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:2000,
		   effectSound:false
	},
	"PJ0":{content:{tooltip:null,
				    message:{message:["응시종목에 계산문제가 있을 경우 좌측 하단의 계산기 기능을 <BR/>이용하실 수 있습니다."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PK0":{content:{tooltip:null,
				    message:{message:["하단의 계산기 버튼을 클릭해 주세요."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PK1":{content:{tooltip:null,
			    	message:null,
			    	direction:[{position:function(){ var top = ($(window).height()-25)+"px"; return {top:top, left:"80px"};}, scope:function(){ return $('body > .viewer').controller(); }, confirm:"showCalculator", cancel:null, args:[true]}],
			    	character:"none"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PL0":{content:{tooltip:{message:["잘하셨습니다. <BR/><BR/>이번에는 안 푼 문제 확인 기능을 사용해 보도록 하겠습니다."], scope:function(){ return $('body > .viewer').controller(); }, confirm:"showCalculator", cancel:null, args:[false]},
					message:null,
					direction:null,
					character:"normal"},
		   location:null,
		   delay:2000,
		   effectSound:false
	},
	"PM0":{content:{tooltip:null,
			        message:{message:["안 푼 문제 확인은 답안 표기란 좌측에 안 푼 문제 수를 확인하시거나 답안 표기란 하단 [안 푼 문제] 버튼을 클릭하여 확인하실 수 있습니다."], scope:null, confirm:null, cancel:null, args:null},
					direction:null,
					character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PN0":{content:{tooltip:null,
				    message:{message:["[안 푼 문제] 버튼을 클릭하세요."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
					character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PN1":{content:{tooltip:null,
			    	message:null,
			    	direction:[{position:function(){var top = ($(window).height()-25)+"px"; return {top:top, left:"790px"};}, scope:function(){ return $('body > .viewer').controller(); }, confirm:"showUnsolved", cancel:null, args:null}],
			    	character:"none"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PO0":{content:{tooltip:null,
				    message:{message:["안 푼 문제 번호 보기 팝업창에 안 푼 문제 번호가 표시됩니다. 번호를 클릭하시면 해당 문제로 이동합니다."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1500,
		   effectSound:false
	},
	"PP0":{content:{tooltip:null,
			  	    message:{message:["안 푼 문제 번호를 클릭해 보세요."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PP1":{content:{tooltip:null,
			    	message:null,
			    	direction:[{position:function(){var top = 370 - (768 - $(window).height())/2; return {top:top, left:"300px"};}, scope:function(){ return window;}, confirm:"goUnsolvedIndex", cancel:null, args:["3"]}],
			    	character:"none"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PQ0":{content:{tooltip:{message:["잘하셨습니다. <BR/><BR/>이번에는 답안 제출 방법을 배워보도록 하겠습니다."], scope:null, confirm:null, cancel:null, args:null},
				    message:null,
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1500,
		   effectSound:false
	},
	"PR0":{content:{tooltip:null,
				    message:{message:["시험 문제를 다 푸신 후 답안 제출을 하시거나 시험시간이 모두 경과 되었을 경우 시험이 종료되며 시험결과를 바로 확인하실 수 있습니다."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PS0":{content:{tooltip:null,
				    message:{message:["하단의 [답안 제출] 버튼을 클릭하세요."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PS1":{content:{tooltip:null,
			    	message:null,
			    	direction:[{position:function(){var top = ($(window).height()-25)+"px"; return {top:top, left:"940px"};}, scope:function(){ return window;}, confirm:"confirmSubmit", cancel:null, args:[1, 1, 1]}],
			    	character:"none"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PT0":{content:{tooltip:null,
				    message:{message:["[답안 제출] 버튼을 클릭하면 답안제출 승인 알림창이 나옵니다. 시험을 마치려면 [예] 버튼을 클릭하고 시험을 계속 진행하려면 [아니오] 버튼을 클릭하면 됩니다."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
				    character:"normal"},
           location:null,
	       delay:1,
	       effectSound:false
	},
	"PU0":{content:{tooltip:null,
				    message:{message:["[예] 버튼을 클릭하세요."], scope:null, confirm:null, cancel:null, args:null},
				    direction:null,
				    character:"normal"},
           location:null,
	       delay:1,
	       effectSound:false
	},
	"PU1":{content:{tooltip:null,
			    	message:null,
			    	direction:[{position:function(){var top = 570 - (768 - $(window).height())/2; return {top:top, left:"435px"};}, scope:function(){ return window;}, confirm:"confirmFinalDialog", cancel:null, args:null}],
			    	character:"none"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PV0":{content:{tooltip:null,
				    message:{message:["답안제출은 실수 방지를 위해 두 번의 확인 과정을 거칩니다. [예] 버튼을 한 번 더 클릭하세요."]},
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PV1":{content:{tooltip:null,
			    	message:null,
			    	direction:[{position:function(){var top = 595 - (768 - $(window).height())/2; return {top:top, left:"440px"};}, scope:null, confirm:null, cancel:null, args:null}],
			    	character:"none"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
	"PW0":{content:{tooltip:{message:["잘하셨습니다. 문제풀이 연습 과정이 끝났습니다. <BR/><BR/>이번에는 시험준비 완료 단계에 대하여 알아보겠습니다."], scope:function(){return window;}, confirm:"showResult", cancel:null, args:null},
				    message:null,
				    direction:null,
				    character:"normal"},
		   location:null,
		   delay:1,
		   effectSound:false
	},
};
var tutorialIndex = [
	{index:"P10"},
	{index:"P20"},
	{index:"P30"},
	{index:"P31"},
	{index:"P40"},
	{index:"P50"},
	{index:"P60"},
	{index:"P61"},
	{index:"PX0"},
	{index:"PX1"},
	{index:"PX2"},
	{index:"PZ0"},
	{index:"PZ1"},
	{index:"PZ2"},
	{index:"PZ3"},
	{index:"PZ4"},
	{index:"PZ5"},
	{index:"P70"},
	{index:"P80"},
	{index:"P90"},
	{index:"P91"},
	{index:"PA0"},
	{index:"PB0"},
	{index:"PB1"},
	{index:"PC0"},
	{index:"PD0"},
	{index:"PE0"},
	{index:"PE1"},
	{index:"PF0"},
	{index:"PG0"},
	{index:"PH0"},
	{index:"PH1"},
	{index:"PH2"},
	{index:"PI0"},
	{index:"PJ0"},
	{index:"PK0"},
	{index:"PK1"},
	{index:"PL0"},
	{index:"PM0"},
	{index:"PN0"},
	{index:"PN1"},
	{index:"PO0"},
	{index:"PP0"},
	{index:"PP1"},
	{index:"PQ0"},
	{index:"PR0"},
	{index:"PS0"},
	{index:"PS1"},
	{index:"PT0"},
	{index:"PU0"},
	{index:"PU1"},
	{index:"PV0"},
	{index:"PV1"},
	{index:"PW0"}
];
var tutorial = function(){

	var that = this;
	var curArrayIndex = 0;
	var curIndex = 0;
	var curTutorial = null;
	var curScope = null;

	/** tutorial 초기화 */
	this.initTutorial = function(){
		$(".tutorial-basic-modal").show();
		var index = tutorialIndex[0].index;
		that.setIndex(index, 1);
	};

	/** scope 설정 */
	this.setScope = function(scope){
		curScope = scope;
	};

	/** run scope function */
	this.runScopeFunction = function(func, args){
		if(curScope && curScope[func]){
			if(args){
				var length = args.length;
				if(length == 1){
					curScope[func](args[0]);
				} else if(length == 2){
					curScope[func](args[0], args[1]);
				} else if(length == 3){
					curScope[func](args[0], args[1], args[2]);
				}
			} else {
				curScope[func]();
			}
		}
	};

	/** 콘텐츠 표시 */
	this.showContent = function(showFlag){
		var content = curTutorial.content;
		var delay = curTutorial.delay;
		if(showFlag){
			setTimeout(function(){
				if(content.tooltip){
					if(content.tooltip.scope){
						var target = content.tooltip.scope();
						that.setScope(target);
					}
					that.showTooltip(content.tooltip, true);
				} else if(content.message){
					if(content.message.scope){
						var target = content.message.scope();
						that.setScope(target);
					}
					that.showMessage(content.message, true);
				} else if(content.direction){
					if(content.direction[0].scope){
						var target = content.direction[0].scope();
						that.setScope(target);
					}
					that.showDirection(content.direction, true);
				}
			}, delay);
		} else {
			that.showTooltip(null, false);
			that.showMessage(null, false);
			that.showDirection(null, false);
		}
	};

	this.showTooltip = function(tooltip, showFlag){
		if(showFlag){
			$(".tooltip-modal").show();
			$("#tooltip-operator").addClass('stop');
			$("#tooltip-operator").show();
			setTimeout(function(){
				$("#tooltip-operator").removeClass('stop');
				setTimeout(function(){
					$("#tooltip-operator").addClass('stop');
				}, 4500);
			}, 1000);

			$(".tooltip-content").html(tooltip.message);

			$("#tooltip-box").fadeIn(2000);
			$(".tooltip-btn-confirm").click(function(){
				$(".tooltip-btn-confirm").unbind("click");
				that.showContent(false);
				curArrayIndex = curArrayIndex + 1;
				if(tutorialIndex[curArrayIndex] && tutorialIndex[curArrayIndex].index){
					var index = tutorialIndex[curArrayIndex].index;
					that.setIndex(index);
				}
				if(tooltip.confirm){
					that.runScopeFunction(tooltip.confirm, tooltip.args);
				}
			});
		} else {
			$("#tooltip-box").hide();
			$("#tooltip-operator").hide();
			$(".tooltip-modal").hide();
		}
	};

	this.showMessage = function(message, showFlag){
		if(showFlag){
			$("#message-box-operator").addClass('stop');
			$("#message-box-operator").show();
			setTimeout(function(){
				$("#message-box-operator").removeClass('stop');
				setTimeout(function(){
					$("#message-box-operator").addClass('stop');
				}, 4500);
			}, 1000);
			$(".message-content").html(message.message);

			$("#message-box").fadeIn(2000);
			$(".message-btn-confirm").click(function(){
				$(".message-btn-confirm").unbind("click");
				that.showContent(false);
				curArrayIndex = curArrayIndex + 1;
				if(tutorialIndex[curArrayIndex] && tutorialIndex[curArrayIndex].index){
					var index = tutorialIndex[curArrayIndex].index;
					that.setIndex(index);
				}
				if(message.confirm){
					that.runScopeFunction(message.confirm, message.args);
				}
			});
		} else {
			$("#message-box").hide();
			$("#message-box-operator").hide();
		}
	};

	this.showDirection = function(direction, showFlag){
		if(showFlag){
			$("#arrow-circle").css("top", direction[0]["position"]()["top"]);
			$("#arrow-circle").css("left", direction[0]["position"]()["left"]);
			$("#arrow").removeClass("reverse");
			$("#arrow").css("top", direction[0]["position"]()["top"]);
			$("#arrow").css("left", direction[0]["position"]()["left"]);
			var limit = $(window).height()-50;
			if(direction[0]["position"]()["top"] > limit + "px"){
				$("#arrow").addClass("reverse");
			}

			$("#arrow").fadeIn(1000);
			$("#arrow-circle").fadeIn(2000);
			$(".arrow-btn-confirm").click(function(){
				$(".arrow-btn-confirm").unbind("click");
				that.showContent(false);
				curArrayIndex = curArrayIndex + 1;
				if(tutorialIndex[curArrayIndex] && tutorialIndex[curArrayIndex].index){
					var index = tutorialIndex[curArrayIndex].index;
					that.setIndex(index);
				}
				if(direction[0]["confirm"]){
					that.runScopeFunction(direction[0]["confirm"], direction[0]["args"]);
				}
			});
		} else {
			$("#arrow").hide();
			$("#arrow-circle").hide();
		}
	};

	/** 튜토리얼 인덱스 설정 */
	this.setIndex = function(index){
		if(tutorialList[index] != null){
			curTutorial = tutorialList[index];
			curIndex = index;
			that.showContent(true);
		} else {
			curTutorial = null;
			curIndex = 0;
			that.showContent(false);
		}
	};

	/** 튜토리얼 답안 체크 */
	this.setUserAnser = function(testItemSn, answer){

		$('body > .viewer').controller().m_mapHistory[testItemSn] = { userAnswer:answer, submit:false };
		$('.test-item-row[testItemSn=\''+testItemSn+'\']').controller().setTestUserResponse(answer);
		$('.item-response-result[testItemSn='+testItemSn+']').controller().setUserAnswer(answer);

		$('body > .viewer').controller()._calcAnswerCount();
	};
};
