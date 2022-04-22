//**************************************************************
//
// itp_testviewer_sheet class
//
//**************************************************************
function itp_testviewer_sheet(target, $data, $param, $options) {
	this.target = $(target);
	this.$options = $.extend( { mode:'test' }, $options);
	this.$data = $data;
	this.$param = $param;
	this.init();
}

$.extend(itp_testviewer_sheet.prototype = new Object(), {
	init:function() {
		if(this.$data)
			this.setItems(this.$data, this.$param);
	},
	setItems:function(arrItem, mapHistory, $opt) {
		$.extend(this.$options, $opt);
		this.target.html('');

		for(var i = 0, len = arrItem.length, oData, userAnswer, oHistory ; i < len  ; i++) {
			oData = arrItem[i];
			userAnswer = ((oHistory = mapHistory[oData.testItemSn]) ? oHistory.userAnswer : "") || "";
			$('<div class="test-item-row" testItemSn="'+oData.testItemSn+'"/>').appendTo(this.target).controller('itp/item/item', oData, { userAnswer:userAnswer }, { mode:this.$options.mode == "edit" ? "view" : this.$options.mode, field:this.$options.field });
		}
	}
});
