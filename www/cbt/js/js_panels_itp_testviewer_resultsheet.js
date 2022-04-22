//**************************************************************
//
// itp_testviewer_resultsheet class
//
//**************************************************************
function itp_testviewer_resultsheet(target, $data, $param, $options) {
	this.target = $(target);
	this.$options = $.extend({ mode:'test' }, $options);
	this.init();
}

$.extend(itp_testviewer_resultsheet.prototype = new Object(), {

	init:function() {
		var that = this;
		$('body').on('ITP:TESTVIEWER_ITEM_RESPONSE', function(e, param) { that.updateResponse(param); });
	},

	updateResponse:function(param) {
		if(this.target.is(':visible') == false)
			return;

		var oResponseItem = $('.item-response-result[testItemSn='+param.testItemSn+']', this.target);
		oResponseItem.controller().setUserAnswer(param.userAnswer);

		var holderOffset = this.target.offset();
		var targetOffset = oResponseItem.offset();
    //
		if(holderOffset.top > targetOffset.top || (holderOffset.top + this.target.height() < targetOffset.top))
			this.target.scrollTo(oResponseItem, { offsetTop:this.target.offset().top, duration:0 });
	},
	setItems:function(arrItem, mapHistory, $opt) {

		this.target.html('');

		$.extend(this.$options, $opt);

		var responseType = null;
		var oItemData = null;
		var userAnswer = null;
		var that = this;

		var arrOut = [];

		for(var i = 0, len = arrItem.length ; i < len ; i++) {
			var cls = "item-response-result";
			if((i+1)%5 == 0 || i == (arrItem.length - 1)){
				cls = "item-response-result dotted";
			}
			arrOut.push('<div class="'+cls+'" testItemSn="'+arrItem[i].testItemSn+'"></div>');
		}

		$(arrOut.join('')).appendTo(this.target);

		$('.item-response-result[testItemSn]', this.target).each(function(i) {
			oItemData = typeof arrItem[i].data == 'string' ? JSON.parse(arrItem[i].data) : arrItem[i].data;
			responseType = oItemData.response.type;
			userAnswer = mapHistory[arrItem[i].testItemSn] ? mapHistory[arrItem[i].testItemSn].userAnswer || "" : "";
			$(this).controller('itp/testviewer/result/'+responseType+'', oItemData.response, { no:arrItem[i].no, userAnswer:userAnswer }, that.$options);
		});
	},
	runSimulation:function(n) {
		$('.item-response-result:eq('+n+')', this.target).controller().runSimulation();
	}
});


//**************************************************************
//
// itp_testviewer_result_item class
//
//**************************************************************
function itp_testviewer_result_item(target, $data, $param, $options) {
	//console.log($options);
}

$.extend(itp_testviewer_result_item.prototype = new Object(), {

	init:function() {
		var schema = '';
		schema += '<div>';
		schema += '<label class="item-no-block">'+this.$param.no+'</label>';
		schema += '<span class="item-response-block">'+this.getSchema()+'</span>';
		schema += '</div>';
		this.target.html(schema);

		if(this.$param.no)
			this.setQno(this.$param.no);
		if(this.$param.userAnswer)
			this.setUserAnswer(this.$param.userAnswer);

		this._init();
	},
	setUserAnswer:function(strAnswer) { },
	setQno:function(qNo){},
	getSchema:function() {},
	runSimulation:function() {},
	_init:function() {}
});


//**************************************************************
//
// itp_testviewer_result_select class
//
//**************************************************************
function itp_testviewer_result_select(target, $data, $param, $options) {
	this.target = $(target);
	this.$data = $data;
	this.$param = $param;
	this.$options = $options;
	this.init();
}

$.extend(itp_testviewer_result_select.prototype = new itp_testviewer_result_item(), {

	getSchema:function() {
		var schema = '';

		var options = root().controller().getOption();
		var dotLabelType = 'arabic-pure';
		var dotControlUse = true;
		var dotLabelRender = 'char';

		try { dotLabelType = options.field.response.select.dotLabelType; } catch(e) {};
		try { dotControlUse = options.field.response.select.dotControlUse; } catch(e) {};
		try { dotLabelRender = options.field.response.select.dotLabelRender; } catch(e) {};

		for(var i = 0 ; i < this.$data.value.length ; i++) {
			var value = this.$data.value[i].value || (i+1);
			schema += '<label class="option" value="'+value+'" index="'+i+'" dotLabelType="'+dotLabelType+'">';
			if(dotLabelRender == 'char') {
				switch(dotLabelType) {
				case 'arabic-pure' :
				default :
					schema += (i+1);
					break;
				}
			}
			 schema += '</label>';
		}
		return schema;
	},
	_init:function() {

		var that = this;

		if(this.$options.mode == 'test' || this.$options.mode == 'practice') {
			$('.option', this.target).on('click', function() {
				if($(this).hasClass('selected'))
					return;
				var n = $(this).attr('value');
				var testItemSn = $(this).closest('.item-response-result').attr('testItemSn');
				that.target.trigger('ITP:TESTVIEWER_RESULTSHEET_RESPONSE', {testItemSn:testItemSn, userAnswer:n.toString()});
				that.setUserAnswer(n.toString());
			});
		}
	},
	setUserAnswer:function(strAnswer) {
		$('.option.selected', this.target).removeClass('selected');
		var arrSelected = strAnswer.split(',');
		for(var i = 0 ; i < arrSelected.length ; i++) {
			var n = arrSelected[i];
			//$('.option[value='+n+']', this.target).addClass('selected').hide().fadeIn();
			$('.option[value='+n+']', this.target).addClass('selected');
		}
	},
	setQno:function(qNo){
		var that = this;
		$('.item-no-block', this.target).on('click', function(e) {
			var testItemSn = $(this).closest('.item-response-result').attr('testItemSn');
			that.target.trigger('ITP:TESTVIEWER_GET_PAGE_BY_QNO', {testItemSn:testItemSn});
		});
	}
});

//**************************************************************
//
// itp_testviewer_result_textarea class
//
//**************************************************************
function itp_testviewer_result_textarea(target, $data, $param, $options) {
	this.target = $(target);
	this.$data = $data;
	this.$param = $param;
	this.init();
}

$.extend(itp_testviewer_result_textarea.prototype = new itp_testviewer_result_item(), {

	getSchema:function() {
		return '<input class="userInput" type="text" readonly style="height:22px;width:58%;padding-top:8px;"> </input>';
	},
	_init:function() {
	},
	setUserAnswer:function(strAnswer) {
		$('.userInput', this.target).val(strAnswer);
	},
	setQno:function(qNo){
		var that = this;
		$('.item-no-block', this.target).on('click', function(e) {
			var testItemSn = $(this).closest('.item-response-result').attr('testItemSn');
			that.target.trigger('ITP:TESTVIEWER_GET_PAGE_BY_QNO', {testItemSn:testItemSn});
		});
	}
});
