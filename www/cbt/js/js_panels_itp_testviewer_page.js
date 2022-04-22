//**************************************************************
//
// itp_testviewer_page class
//
//**************************************************************
function itp_testviewer_page(target, $data, $param, $options) {
	this.target = $(target);
	this.$options = $.extend( { mode:'test', layout:'item' }, $options);
}

$.extend(itp_testviewer_page.prototype = new Object(), {
	setSheets:function(arrSheet, mapHistory, $opt) {
		$.extend(this.$options, $opt);

		var canvasWidth = this.$options.canvasSize.width;
		var totWidth = Number($(".test-page-block-holder").css("width").replace("px", ''));
		if(this.$options.layout == 'double'){
			if(totWidth > canvasWidth){
				canvasWidth = (totWidth>1548?totWidth-20:totWidth);
			}
		} else {
			canvasWidth = (canvasWidth/2);
		}
		this.target.html('');
		this.target.css('width',canvasWidth + 'px');

		var oData = null;
		var oSheet = null;

		for(var i = 0, len = arrSheet.length ; i < len ; i++) {
			oData = arrSheet[i];
			oSheet = $('<div class="test-sheet-row"/>').appendTo(this.target).addClass('sheet-'+(i+1));
			oSheet.controller('itp/testviewer/sheet', oData, mapHistory, this.$options);
			if(this.$options.layout == 'double') {
				/** 100dpi일 경우 sheet 사이즈 조정 */
				if(this.$options.canvasScale == 1){
					oSheet.css('height', (this.$options.canvasSize.height)+'px');
				}

				oSheet.css({ 'float':"left", 'width': (canvasWidth/2-(i==0?0:2))+'px'});
			}
		}
		var waste =  totWidth - canvasWidth;
		var marginLeft = 0;
		if(waste > 0){
			marginLeft = Math.floor(waste/2)-1;
		}
		if(this.$options.layout == 'double'){
			$(".test-page-block-holder").css('overflow-x', 'auto');
			$(".test-page-block").css('overflow-x', 'auto');
		}else{
			$(".test-page-block-holder").css('overflow-x', 'hidden');
			$(".test-page-block").css('overflow-x', 'hidden');
		}
		$(".test-page-block-holder").css('overflow-y', 'hidden');
		$(".test-page-block").css('overflow-y', 'hidden');
	}
});
