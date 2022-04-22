//**************************************************************
//
// itp_item class
//
//**************************************************************
function itp_item_item(target, $data, $param, $options) {

	this.target = $(target);
	this.$param = $param || {};
	this.$data = $data;
	this.$options = $.extend({
		mode:'view' // view || edit || preview || test || print
		,clone:false // 복제여부
		,load:false // 주는 데이터 처리
		,exclude:[] // 제외할 필드
	},$options);
	this.$userAnswer = this.$param.userAnswer;

	this.init();
};

$.extend(itp_item_item.prototype = new Object(), {

	init:function() {

		this.m_itemSn = null;
		this.m_revNo = null;
		this.m_itemCateSn = null;

		this.target.addClass('mode-'+this.$options.mode);

		this.m_mapField = {
			'instruction':"지시문",
			'question':"발문",
			'reference':"지문",
			'direction':"보기",
			'response':"응답",
			'hint':"힌트",
			'explanation':"설명",
			'sample':"모범답안"
		}

		var that = this;

		this.target.html('<div class="item-edit-block"/>');

		/*
		$('body').on('ITP:ITEM_CHANGED', function(e, param) {
			that.setItemSn(param.itemSn, param.data);
		});

		if(this.$options.mode == 'edit') {
			$('body').on('ITP:ITEM_TEMPLATE_FIELD_APPEND', function(e, param) {
				if(!that.target.is(':visible')) return;
				that.appendField(param.field, param.type);
			});

			$('body').on('ITP:ITEM_TEMPLATE_FIELD_REMOVE', function(e, param) {
				if(!that.target.is(':visible')) return;
				$('.item-edit-block .field-item[field='+param.field+']', that.target).remove();
			});

			$('body').on('ITP:ITEM_TEMPLATE_FIELD_VALUE_APPEND', function(e, param) {
				if(!that.target.is(':visible')) return;
				$('.item-edit-block .field-item[field='+param.field+']', that.target).controller().appendValue(param.type);
			});

			$('body').on('ITP:ITEM_TEMPLATE_FIELD_VALUE_REMOVE', function(e, param) {
				if(!that.target.is(':visible')) return;
				$('.item-edit-block .field-item[field='+param.field+']', that.target).controller().removeValue(param.index);
			});

			$('body').on('ITP:ITEM_TEMPLATE_FIELD_VALUE_CHANGE', function(e, param) {
				if(!that.target.is(':visible')) return;
				$('.item-edit-block .field-item[field='+param.field+']', that.target).controller().changeValue(param.type, param.index);
			});

			$('body').on('ITP:ITEM_TEMPLATE_FIELD_ATTR_CHANGE', function(e, param) {
				if(!that.target.is(':visible')) return;
				$('.item-edit-block .field-item[field='+param.field+']', that.target).controller().changeAttr(param.attr, param.val);
			});

			$('body').on('ITP:ITEM_TEMPLATE_FIELD_TYPE_CHANGE', function(e, param) {
				if(!that.target.is(':visible')) return;
				that.appendField(param.field, param.type);
			});

		}

		this.target.on('click','[name=btn-save-item_attr]', function() {
			that.saveItemAttribute();
		});
		*/
		if(this.$options.mode == 'edit') {

			if(this.$data) {
				this.setItemSn(this.$data);
			} else {
				//alert('유형을 먼저 정의하세요');
				$('.item-attr-form', this.target).hide();
				//$('<div class="notice-select-type-first">추가할 문항의 유형을 먼저 선택하세요.</div>').appendTo($('>.item-edit-block', this.target));

				ecoUtils.doApi('/itp/item/retrieveListItemCate', { groupSn:viewerController.getGroupSn(), domainSn:viewerController.getDomainSn() }, function(oData) {

					that.m_mapItemCate = ecoUtils.arrayToMap(oData.list, 'itemCateSn');

					var str = '<div class="notice-select-type-first" style="margin-top:80px;">';
					str += '추가할 문항의 유형을 먼저 선택하세요.';
					str += '<div style="width:70%;display:inline-block;margin-top:15px;">';
					for(var i = 0 ; i < oData.list.length ; i++) {
						str += '<li itemCateSn="'+oData.list[i].itemCateSn+'" class="item-cate-choice" style="cursor:pointer;display:inline-block;float:left;margin:10px;list-style-type:none;"><div  style="width:100px;height:100px;background:#fff url(img/itemcate_'+oData.list[i].itemCateSn+'.png) no-repeat center center;background-size:100% 100%;"></div><div style="width:100px;height:40px;">'+oData.list[i].cateNm+'</div></li>';
					}
					str += '</div>';
					str += '</div>';

					$(str).appendTo($('>.item-edit-block', that.target));

					$('.item-cate-choice', that.target).on('click', function() {
						var oInfoBlock = that.target.closest('[ctrl=itp_editor_main]').find('.info-block');

						if(oInfoBlock.length > 0) {
							oInfoBlock.find('.item-cate-row[itemCateSn='+$(this).attr('itemCateSn')+']').trigger('click');
						}
					});

				}, function(err) {
					console.log(err);
				});
			}
		} else {
			if(this.$data) {
				if(this.$options.load == true) {
					ecoUtils.doApi('/itp/item/retrieveItem', { itemSn:this.$data.itemSn }, function(oData) {
						that.setItemSn(oData);
					});
				} else {
					this.setItemSn(this.$data);
				}
			}
		}
	},

	appendField:function(field, type, template) {

		$('.item-edit-block .field-item[field='+field+']', this.target).remove();

		// get position to insert
		var prevField = null;
		for(var i in this.m_mapField) {
			if($('.item-edit-block .field-item[field='+i+']', this.target).length > 0)
				prevField = i;

			if(i == field)
				break;
		}

		var oFieldObject = null;
		var strFieldSchema = this.getFieldSchema(field, type ? { type:type } : {} );

		if(prevField == null) {
			oFieldObject = $(strFieldSchema).prependTo($('.item-edit-block', this.target));
		} else {
			oFieldObject = $(strFieldSchema).insertAfter($('.item-edit-block [field='+prevField+']', this.target));
		}
		var controllerType = 'itp/item/field/'+field + (type && type != '' ? '/'+type:'');
		oFieldObject.controller(controllerType, template, null, {mode:this.$options.mode});

	},
	getFieldSchema:function(fieldType, oFieldData) {
		var arr = [];
		arr.push('<div class="field-item" field="'+fieldType+'"');

		if(oFieldData.type) {
			arr.push(' type="'+oFieldData.type+'"');
		}
		arr.push('>');

		if($.inArray(this.$options.mode, ['edit']) > -1)
			arr.push('<label style="color:blue">'+this.m_mapField[fieldType]+'영역</label>');

		arr.push('</div>');
		return arr.join('');
	},
	getItemSchema:function(oData) {
		var schema = [];
		for(var i in oData) {
			if(typeof oData[i] == 'function') continue;
			if((this.$options.mode == 'preview' || this.$options.mode == 'print') && i == 'sample') continue;
			if(i == 'answer')
				schema.push('<div class="field-item" field="answer" style="display:none;"/>');
			else {
				if((this.$options.mode == 'test' || this.$options.mode == 'practice' || this.$options.mode == 'preview' || this.$options.mode == 'review') &&  i == 'question' && this.$data.no) {
					schema.push('<table><tr><td valign="top"><div class="item-no-label">'+this.$data.no+'.</div></td><td valign="middle">'+this.getFieldSchema(i, oData[i])+'</td></tr></table>');
				} else {
					schema.push(this.getFieldSchema(i, oData[i]));
				}
			}
		}
		schema.push('<div style="display:none;">M<input type="text" name="metadataSn" style="border:solid 1px red;width:50px;"></div>');
		return schema.join('');
	},
	setItemCateSample:function(itemCateSn) {
		var that = this;
		ecoUtils.doApi('/itp/item/retrieveItemCateSampleItem', { itemCateSn:itemCateSn }, function(oData) {
			that.$options.clone = true;
			that.setItemSn(oData);
		});
	},
	setItemCate:function(oItemCateData) {

		this.m_itemCateSn = oItemCateData.itemCateSn;

		var strTemplate = oItemCateData.template;
		if(strTemplate == undefined)
			return;
		var oTemplate = "";
		try { oTemplate = JSON.parse(strTemplate); } catch(e) {  return; };
		this.renderItem(oTemplate);

		// 채점기준표 유형에서 타고 들어오게 하기...
		$('.item-attr-form', this.target).show();
		$('[name=metadataSn]',this.target).val(oItemCateData.metadataSn||"");

		this.target.trigger('ITP:ITEM_EDITOR_ITEM_CHANGED');
	},
	flushData:function() {
		if(confirm('내용을 모두 지우시겠습니까?') == false)
			return;

		// flush attr...
		$('[name=comment]',this.target).html('');

		// flush field...
		$('.field-item',  this.target).each(function() {
			try { $(this).controller().flushData(); } catch (e) {};
		});
	},
	renderItem:function(oTemplate) {
		var that = this;
		this.mapFieldController = {};
		$('.item-edit-block', this.target).html(this.getItemSchema(oTemplate));
		$('.field-item',  this.target).each(function() {
			var fieldType = $(this).attr('field');
			if(fieldType == 'answer') return;
			/*
			if(that.$options.mode != 'test' && that.$options.mode != 'practice') {
				if(fieldType == 'answer' && oTemplate['answer']) {
					$('.field-item[field=response]', that.target).controller().setAnswerData(oTemplate['answer']);
					return;
				}
			}
			*/
			var responseType = $(this).attr('type') || "";
			var controllerType = 'itp/item/field/'+fieldType + (responseType != '' ? '/'+responseType:'');
			that.mapFieldController[fieldType] = $(this).controller(controllerType, oTemplate[fieldType], null, that.$options);
		});

		/*
		var bUpdate = this.m_itemSn != undefined && this.m_itemSn != '';
		$('[name=btn-save-item_attr]',this.target)[bUpdate?"show":"hide"]();
		*/

		if(this.$userAnswer) {
			this.mapFieldController['response'].setTestUserResponse(this.$userAnswer);
		}
	},
	getItemSn:function() {
		return this.m_itemSn;
	},
	setItemSn:function(oItemData) {

		if(oItemData == undefined)
			return;

		if(typeof oItemData.data == 'string') {
			try{ oItemData.data = JSON.parse(oItemData.data); } catch(e) { return; };
		}

		if(this.$options.clone) { // 복제 모드....
			this.m_itemSn = null;
			this.m_revNo = 1;
			this.$options.clone = false;

			// clean attributes..
			//$('[name=itemId]',this.target).val('');
		} else {
			this.m_itemSn = oItemData.itemSn;
			this.m_revNo = oItemData.revNo;
		}

		this.m_itemCateSn = oItemData.itemCateSn;


		/*
		//$('.item-attr-form', this.target).show();
		$('[name=comment]',this.target).html((oItemData.comment || "").replace(/\n/g,'<br>'));
		*/
		this.renderItem(oItemData.data);
		/*
		$('[name=metadataSn]',this.target).val(oItemData.metadataSn||"");
		this.target.trigger('ITP:ITEM_EDITOR_ITEM_CHANGED');
		*/
	},
	getTestUserResponse:function() {
		return this.mapFieldController['response'].getTestUserResponse();
	},
	setTestUserResponse:function(strUserAnswer) {
		this.mapFieldController['response'].setTestUserResponse(strUserAnswer);
	}/*,
	getItemData:function() {
		var oItemData = {};
		$('.field-item', this.target).each(function() {
			if($(this).attr('field') == "answer")
				return;
			oItemData[$(this).attr('field')] = $(this).controller().getFieldData();
		});
		oItemData.answer = this.mapFieldController['response'].getAnswerData();
		return JSON.stringify(oItemData);
	},
	saveItem:function(oMetadata) {
		var bUpdate = this.m_itemSn != undefined && this.m_itemSn != '';

		var that = this;
		var metadataSn = $('[name=metadataSn]',this.target).val() || "";
		//var itemId = $('[name=itemId]',this.target).val() || "";

		var oParam = $.extend({
			data:this.getItemData(),
			//lockYn:$('[name=lockYn]',this.target).is(":checked") ? "Y" : "N",
			//openYn:$('[name=openYn]',this.target).is(":checked") ? "Y" : "N",
			itemId:null,//itemId == "" ? null : itemId,
			itemCateSn:this.m_itemCateSn || null,
			comment:$('[name=comment]',this.target).get(0).innerText,
			autoMarkupYn:$('.field-item[field=response]', this.target).controller().getAutoMarkupYn(),
			answer:$('.field-item[field=response]', this.target).controller().getAnswer(),
			groupSn:viewerController.getGroupSn(),
			domainSn:viewerController.getDomainSn(),
			metadata:oMetadata ? JSON.stringify(oMetadata) : "",
			listMetadata:oMetadata ? oMetadata : [],
			metadataSn:metadataSn == "" ? null : metadataSn
		}, bUpdate ? { itemSn:this.m_itemSn, revNo:this.m_revNo } : {});

		ecoUtils.doApi(bUpdate ? '/itp/item/modifyItem' : '/itp/item/registerItem', oParam, function(oData) { that.onSaveItemSuccess(oData) }, function(err){
			console.log(err);
		});
	},
	onSaveItemSuccess:function(oData) {
		var bUpdate = this.m_itemSn != undefined && this.m_itemSn != '';
		this.target.trigger('ITP:'+(bUpdate?"ITEM_UPDATED":"ITEM_INSERTED"), oData);

		var itemSn = oData.itemSn;
		if(this.$param.testSn && this.$param.testSn != '' && bUpdate == false) {
			this.saveItem2Test(this.$param.testSn, itemSn);
		} else {
			alert("잘 저장되었습니다");
			try{ ecoPopupHide(); }catch(e) {}; // temp
		}
		this.m_itemSn = oData.itemSn;
	},
	saveItem2Test:function(testSn, itemSn) {
		var that = this;
		ecoUtils.doApi('/itp/test/registerListTestItem', { testSn:testSn, list:[ itemSn ]}, function(oData) {
			alert("잘 저장되었습니다");
			that.target.trigger('ITP:ITEM_INSERTED_INTO_TEST', {testSn:testSn, list:oData.list});
			try{$('body').ecoPopup('hide');}catch(e) {}; // temp
		},function(err) {
			console.log(err);
		});
	},
	saveItemAttribute:function() {
		//var itemId = $('[name=itemId]',this.target).val() || "";

		var oParam = {
			itemSn:this.m_itemSn,
			//lockYn:$('[name=lockYn]',this.target).is(":checked") ? "Y" : "N",
			//openYn:$('[name=openYn]',this.target).is(":checked") ? "Y" : "N",
			comment:$('[name=comment]',this.target).get(0).innerText,
			itemId:null//itemId == "" ? null : itemId
		};
		ecoUtils.doApi('/itp/item/modifyItemAttribute', oParam, function(oData) {
			alert("잘 저장되었습니다");
		},function(err) {
			console.log(err);
		});
	}*/
});


//**************************************************************
//
// itp_item_field class
//
//**************************************************************
function itp_item_field(target, $data, $param, $options) {
	this.target = $(target);
	this.m_fieldType = 'question';
	this.$data = $data;
	this.$options = $.extend({
		mode:"view"
	}, $options);

	this.init();
}

$.extend(itp_item_field.prototype = new Object(), {

	init:function() {
		this._init();
	},
	_init:function() {

		var oFieldData = this.$data || [];
		var that = this;

		var arr = [];

		var arrValue = oFieldData.value || [ { type:"html" }];

		for(var i = 0, len = arrValue.length ; i < len ; i++) {
			if(arrValue[i] == undefined)
				continue;
			arr.push('<div class="field-item-value" type="'+arrValue[i].type+'"></div>');
		}
		$(arr.join('')).appendTo(this.target);

		$('.field-item-value',this.target).each(function(index) {
			$(this).controller('itp/item/control/'+$(this).attr('type')+'',arrValue[index],null,{mode:that.$options.mode});
		});
	},
	flushData:function() {
		$('.field-item-value',this.target).each(function() {
			$(this).controller().flushData();
		});
	},
	getFieldData:function() {
		var oFieldData = { value:[] };
		$('.field-item-value',this.target).each(function() {
			oFieldData.value.push($(this).controller().getControlData());
		});
		return oFieldData;
	},
	appendValue:function(type) {
		var oFieldValue = $('<div class="field-item-value" type="'+type+'"></div>').appendTo(this.target);
		oFieldValue.controller('itp/item/control/'+type+'',null,null,{mode:this.$options.mode});
	},
	removeValue:function(nIndex) {
		$('.field-item-value:eq('+nIndex+')',this.target).remove();
	},
	changeValue:function(type, nIndex) {
		$('.field-item-value:eq('+nIndex+')',this.target).remove();
		var oFieldValue = null;
		if(nIndex == 0) {
			if($('.field-item-value', this.target).length == 0) {
				oFieldValue = $('<div class="field-item-value" type="'+type+'"></div>').appendTo(this.target);
			} else {
				oFieldValue = $('<div class="field-item-value" type="'+type+'"></div>').insertBefore($('.field-item-value:eq('+(0)+')', this.target));
			}
		} else {
			oFieldValue = $('<div class="field-item-value" type="'+type+'"></div>').insertAfter($('.field-item-value:eq('+(nIndex-1)+')', this.target));
		}
		oFieldValue.controller('itp/item/control/'+type+'',null,null,{mode:this.$options.mode});
	}

});


//**************************************************************
//
// itp_item_field_instruction class
//
//**************************************************************
function itp_item_field_instruction(target, $data, $param, $options) {
	this.target = $(target);
	this.m_fieldType = 'instruction';
	this.$data = $data;
	this.$options = $.extend({
		mode:"view"
	}, $options);
	this.init();
}
itp_item_field_instruction.prototype = new itp_item_field();


//**************************************************************
//
// itp_item_field_question class
//
//**************************************************************
function itp_item_field_question(target, $data, $param, $options) {
	this.target = $(target);
	this.m_fieldType = 'question';
	this.$data = $data;
	this.$options = $.extend({
		mode:"view"
	}, $options);
	this.init();
}
itp_item_field_question.prototype = new itp_item_field();

//**************************************************************
//
// itp_item_field_hint class
//
//**************************************************************
function itp_item_field_hint(target, $data, $param, $options) {
	this.target = $(target);
	this.m_fieldType = 'hint';
	this.$data = $data;
	this.$options = $.extend({
		mode:"view"
	}, $options);
	this.init();
}
itp_item_field_hint.prototype = new itp_item_field();

//**************************************************************
//
// itp_item_field_direction class
//
//**************************************************************
function itp_item_field_direction(target, $data, $param, $options) {
	this.target = $(target);
	this.m_fieldType = 'direction';
	this.$data = $data;
	this.$options = $.extend({
		mode:"view"
	}, $options);
	this.init();
}
itp_item_field_direction.prototype = new itp_item_field();

//**************************************************************
//
// itp_item_field_explanation class
//
//**************************************************************
function itp_item_field_explanation(target, $data, $param, $options) {
	this.target = $(target);
	this.m_fieldType = 'explanation';
	this.$data = $data;
	this.$options = $.extend({
		mode:"view"
	}, $options);
	this.init();
}
itp_item_field_explanation.prototype = new itp_item_field();

//**************************************************************
//
// itp_item_field_reference class
//
//**************************************************************
function itp_item_field_reference(target, $data, $param, $options) {
	this.target = $(target);
	this.m_fieldType = 'reference';
	this.$data = $data;
	this.$options = $.extend({
		mode:"view"
	}, $options);
	this.init();
}
itp_item_field_reference.prototype = new itp_item_field();

//**************************************************************
//
// itp_item_field_sample class
//
//**************************************************************
function itp_item_field_sample(target, $data, $param, $options) {
	this.target = $(target);
	this.m_fieldType = 'sample';
	this.$data = $data;
	this.$options = $.extend({
		mode:"view"
	}, $options);
	this.init();
}
itp_item_field_sample.prototype = new itp_item_field();


//**************************************************************
//
// itp_item_field_response class
//
//**************************************************************
function itp_item_field_response(target, $data, $param, $options) {

}

$.extend(itp_item_field_response.prototype = new itp_item_field(), {
	init:function(){},
	getFieldData:function(){},
	getAutoMarkupYn:function() {},
	getAnswerData:function() {},
	setAnswerData:function(oAnswerData) {},
	getAnswer:function(){},
	getTestUserResponse:function() {},
	setTestUserResponse:function(strUserAnswer) {},
	simulate:function() {}
});

//**************************************************************
//
// itp_item_field_response_select class
//
//**************************************************************
function itp_item_field_response_select(target, $data, $param, $options) {
	this.$data = $data;
	this.target = $(target);
	this.$options = $.extend({
		mode:"view"
	}, $options);
	this.m_cid = ecoUtils.guid();

	this.init();
}

$.extend(itp_item_field_response_select.prototype = new itp_item_field_response(), {

	init:function() {

		var that = this;

		var oFieldData = this.$data || [];
		var cid = ecoUtils.guid();
		var arr = [];
		var maxOptionInRow = parseInt(this.$data.numInRow || 1);
		arr.push('<table cellspacing="0" cellpadding="0">');
		var arrValue = oFieldData.value == undefined  || oFieldData.value.length == 0 ? [ { type:"html" },  { type:"html" },  { type:"html" },  { type:"html" } ] : oFieldData.value;
		for(var i = 0 ; i < arrValue.length ; i++) {
			if(i%maxOptionInRow == 0)
				arr.push('<tr class="response-option-row" idx="'+i+'">');
			arr.push(this._getOptionSchema(i, arrValue[i].value, arrValue[i].type, maxOptionInRow));
			if(i%maxOptionInRow == maxOptionInRow-1 || i == arrValue.length-1)
			arr.push('</tr>');
		}
		arr.push('</table>');
		this.target.append(arr.join(''));

		if(this.$options.mode == 'edit' || this.$options.mode == 'test' || this.$options.mode == 'practice') {
			this.target.on('click', '.response-option-row .seldot-label', function() {
				that.target.find('.response-option-row .seldot-label.selected').removeClass('selected');
				$(this).addClass('selected');

				if(that.$options.mode == 'test' || that.$options.mode == 'practice') {
					var testItemSn = $(this).closest('[ctrl=itp_item_item]').attr('testItemSn');
					that.target.trigger('ITP:TESTVIEWER_ITEM_RESPONSE', { testItemSn:testItemSn, userAnswer:that.getTestUserResponse() });
				}
			});

			this.target.on('click', '.response-option-row .field-response-value .text-altenative-image', function() {
				var n = $(this).closest('.field-response-value').attr('value');
				$('.response-option-row .seldot-label[value='+n+']', that.target).trigger('click');
			});
		}

		$('.field-response-value',this.target).each(function(index) {
			$(this).controller('itp/item/control/'+$(this).attr('type'), arrValue[index], null, { mode:that.$options.mode });
		});
	},

	flushData:function() {
		$('.field-response-value',this.target).each(function() {
			$(this).controller().flushData();
		});
	},
	getFieldData:function() {
		var oFieldData = { type:'select', value:[] };
		$('.field-response-value',this.target).each(function() {
			oFieldData.value.push($(this).controller().getControlData());
		});
		return oFieldData;
	},

	getAutoMarkupYn:function() {
		return "Y";
	},

	getAnswer:function() {
		var n = $('.response-option-row ..seldot-label.selected',this.target).attr('value') || "";
		return n;
	},

	getAnswerData:function() {
		var oAnswer = [];
		$('.response-option-row .seldot-label.selected',this.target).each(function(index) {
			oAnswer.push($(this).attr('value'));
		});
		return oAnswer;
	},

	getTestUserResponse:function() {
		var n = $('.response-option-row .seldot-label.selected', this.target).attr('value') || "";
		return n;
	},
	setTestUserResponse:function(strUserAnswer) {
		var arr = strUserAnswer.split(',');
		this.target.find('.response-option-row .seldot-label.selected').removeClass('selected');
		for(var i = 0 ; i < arr.length ; i++) {
			var n = arr[i];
			$('.response-option-row .seldot-label[value='+(n)+']', this.target).addClass('selected');
			$('.response-option-row .seldot-label[value='+(n)+'] .seldot-label input', this.target).prop('checked', true);
		}

	},
	setAnswerData:function(oAnswerData) {
		for(var i = 0 ; i < oAnswerData.length ; i++) {
			$('.response-option-row .seldot-label[value='+oAnswerData[i]+']', this.target).addClass('answer');
			$('.response-option-row .seldot-label[value='+oAnswerData[i]+'] input', this.target).prop('checked', true);
		}
	},
	changeAttr:function(attr, val) {

		var that = this;

		switch(attr) {
		case 'cntOption' :
			var n = $('.response-option-row', this.target).length;
			var cntOption = parseInt(val);
			var optionType = $('.field-response-value:eq(0)', this.target).attr('type');

			if(n == val)
				return;

			if(n < val) {
				for(var i = n ; i < val ; i++) {

					// TODO : 2x2등에 대한 처리 필요
					var arrOptionSchema = [];
					arrOptionSchema.push('<tr class="response-option-row" idx="'+i+'">');
					arrOptionSchema.push(that._getOptionSchema(i, null, optionType,maxOptionInRow));
					arrOptionSchema.push('</tr>');
					var oOption = $(arrOptionSchema.join('')).appendTo($('table', this.target));
					$('.field-response-value', oOption).controller('itp/item/control/'+optionType, "", null, { mode:this.$options.mode });
				}
			} else {
				for(var i = n-1 ; i >= val ; i--) {
					$('.response-option-row:eq('+i+')', this.target).remove();
				}
			}
			break;
		case 'optionType' :
			var cntOption = $('.response-option-row', this.target).length;
			var optionType = val;

			$('table', this.target).html('');
			var maxOptionInRow = parseInt(this.$data.numInRow || 1);

			for(var i = 0 ; i < cntOption ; i++) {
				var arrOptionSchema = [];

				// TODO : 2x2등에 대한 처리 필요
				arrOptionSchema.push('<tr class="response-option-row" idx="'+i+'">');
				arrOptionSchema.push(that._getOptionSchema(i, null, optionType, maxOptionInRow));
				arrOptionSchema.push('</tr>');
				var oOption = $(arrOptionSchema.join('')).appendTo($('table', this.target));
				$('.field-response-value', oOption).controller('itp/item/control/'+optionType, "", null, { mode:this.$options.mode });
			}

			break;
		}
	},
	_getOptionSchema:function(i, value, optionType, maxOptionInRow) {
		value = value || (i+1);
		maxOptionInRow = maxOptionInRow || 1;

		var dotLabelType = 'arabic-pure';
		var dotControlUse = true;
		var dotLabelRender = 'char';

		try { dotLabelType = this.$options.field.response.select.dotLabelType; } catch(e) {};
		try { dotControlUse = this.$options.field.response.select.dotControlUse; } catch(e) {};
		try { dotLabelRender = this.$options.field.response.select.dotLabelRender; } catch(e) {};

		var optionSchema = [];

		optionSchema.push('<td class="seldot-block" valign="top" align="center">');
		optionSchema.push('<div class="seldot-label" value="',value,'" index="',i,'" dotLabelType="',dotLabelType,'">');
		if((this.$options.mode == 'edit' || this.$options.mode == 'test' || this.$options.mode == 'practice') && dotControlUse)
			optionSchema.push('<input type="radio" name="',this.m_cid,'-response-sel-check"></input>');
		if(dotLabelRender == 'char') {
			switch(dotLabelType) {
			case 'arabic-pure' :
			default:
				optionSchema.push(i+1);
				break;
			}
		}
		optionSchema.push('</div></td><td style="width:',(Math.floor(100/maxOptionInRow)),'%;"><div class="field-response-value" type="',optionType,'" value="',value,'" index="',i,'"></div></td>');

		return optionSchema.join('');
	},
	simulate:function() {
		var nOption = $('.response-option-row .seldot-label', this.target).length;
		var n = Math.round(Math.random()*1000)%nOption;
		$('.response-option-row .seldot-label:eq('+n+')', this.target).trigger('click');
	}
});

//**************************************************************
//
// itp_item_field_response_textarea class
//
//**************************************************************
function itp_item_field_response_textarea(target, $data, $param, $options) {
	this.$data = $data;
	this.target = $(target);
	this.$options = $.extend({
		mode:"view"
	}, $options);
	this.init();
}

$.extend(itp_item_field_response_textarea.prototype = new itp_item_field_response(), {

	init:function() {

		var that = this;

		this.target.addClass('mode-'+this.$options.mode);

		if(this.$options.mode == 'print')
			return;

		var oFieldData = this.$data || {};
		var arr = [];

		if(oFieldData.pre) {
			arr.push('<div class="pre-field" placeholder="윗머리 글을 입력하세요"></div>');
		}

		if(this.$options.mode == 'edit') {
			// 임시로 제거합니다...
			//arr.push('<div><select name="limitUnit"><option value="">입력수 제한 없음</option><option value="word">단어수 제한</option><option value="letter">글자수 제한</option></select><input type="text" name="maxLimitCount" value="0" size="4" maxlength="4" style="display:none;"></input></div>');
		} else {
			arr.push('<div class="field-info"></div>');
		}

		if(this.$options.mode == 'test' || this.$options.mode == 'practice') {
			arr.push('<input contentEditable="true" class="textareaControlDiv" style="height:26px;width:40%;"></input>');
		} else {
			arr.push('<div contentEditable="false"><label class="description">'+"사용자 문단 입력"+'</label></div>');
		}

		if(oFieldData.post) {
			arr.push('<div class="post-field"  placeholder="아랫글을 입력하세요"></div>');
		}

		this.target.append(arr.join(''));

		if(oFieldData.pre) {
			$('.pre-field',this.target).addClass('pre-field');
			$('.pre-field',this.target).controller('itp/item/control/html',oFieldData.pre,null,{mode:this.$options.mode});
		}

		if(oFieldData.post)
			$('.post-field',this.target).addClass('post-field');
			$('.post-field',this.target).controller('itp/item/control/html',oFieldData.post,null,{mode:this.$options.mode});


		var limitUnit = this.$data ? this.$data.limitUnit || "" : "";
		var maxLimitCount = this.$data ? this.$data.maxLimitCount || 30 : 30;

		if(this.$options.mode == 'edit') {

			$('[name=limitUnit]',this.target).val(limitUnit).on('change', function() {
				$('[name=maxLimitCount]',that.target)[$(this).val() == '' ? 'hide' : 'show']();
			});
			$('[name=maxLimitCount]',this.target).val(maxLimitCount);

			if(limitUnit != '') {
				$('[name=maxLimitCount]',this.target).show();
			}
		} else {
			var strLabel = "";
			switch(limitUnit) {
			case 'word' :
				strLabel += maxLimitCount+'단어 제한';
				break;
			case 'letter' :
				strLabel += maxLimitCount+'글자 제한';
				break;
			default :
				strLabel += '';
				break;
			}
			$('.field-info', this.target).html(strLabel);
		}

		if(that.$options.mode == 'test' || this.$options.mode == 'practice') {
			this.target.on('blur','[contenteditable=true]', function(e) {
				var testItemSn = $(this).closest('[ctrl=itp_item_item]').attr('testItemSn');
				that.target.trigger('ITP:TESTVIEWER_ITEM_RESPONSE', { testItemSn:testItemSn, userAnswer:that.getTestUserResponse() });
			});
		}

	},
	flushData:function() {
		if($('.pre-field',this.target).length > 0)
			$('.pre-field',this.target).controller().flushData();
		if($('.post-field',this.target).length > 0)
			$('.post-field',this.target).controller().flushData();
		$('[name=limitUnit]',this.target).val('');
		$('[name=maxLimitCount]',this.target).val('').hide();
	},
	getFieldData:function() {
		var oFieldData = { type:'textarea', value:[] };

		var limitUnit = $('[name=limitUnit]',this.target).val() || "";
		var maxLimitCount = $('[name=maxLimitCount]',this.target).val() || "";

		oFieldData.limitUnit = limitUnit;
		oFieldData.maxLimitCount = limitUnit != '' ? maxLimitCount : '';

		if($('.pre-field',this.target).length > 0) {
			oFieldData.pre = $('.pre-field',this.target).controller().getControlData();
		}
		if($('.post-field',this.target).length > 0) {
			oFieldData.post = $('.post-field',this.target).controller().getControlData();
		}

		return oFieldData;
	},
	getAutoMarkupYn:function() {
		return "N";
	},
	getAnswer:function() {
		return "";
	},
	getAnswerData:function() {
		return [];
	},
	getTestUserResponse:function() {
		return $('[contentEditable]',this.target).val();
	},
	setTestUserResponse:function(strUserAnswer) {
		$('[contentEditable]',this.target).val(strUserAnswer);
	},
	simulate:function() {
		$('[contenteditable=true]', this.target).val('test simulation text inserted automatically').trigger('blur');
	}
});

//**************************************************************
//
// itp_item_control class
//
//**************************************************************
function itp_item_control(target, $data, $param, $options) {
	this.target = $(target);
	this.$data = $data;
	this.$options = $.extend({
		mode:"view"
	}, $options);
	this.init();
}

$.extend(itp_item_control.prototype = new Object(), {
	init:function() {},
	getControlData:function() {},
	flushData:function() {}
});


//**************************************************************
//
// itp_item_control_html class
//
//**************************************************************
function itp_item_control_html(target, $data, $param, $options) {
	this.target = $(target);
	this.$data = $data;
	this.$options = $.extend({
		mode:"view"
	}, $options);
	this.init();
}

$.extend(itp_item_control_html.prototype = new itp_item_control(), {
	init:function() {
		var data = (this.$data ? this.$data.value : null) || "";
		$('<div contenteditable="'+(this.$options.mode=="edit")+'">'+data+'</div>').appendTo(this.target);
	},
	getControlData:function() {
		var strHtml = $('[contentEditable]',this.target).html();
		return { type:"html", value:strHtml };
	},
	flushData:function() {
		$('[contentEditable]',this.target).html('');
	}
});


//**************************************************************
//
// itp_item_control_image class
//
//**************************************************************
function itp_item_control_image(target, $data, $param, $options) {
	this.target = $(target);
	this.$data = $data;
	this.$options = $.extend({
		mode:"view"
	}, $options);
	this.init();
}

$.extend(itp_item_control_image.prototype = new itp_item_control(), {
	init:function() {
		var that = this;

		this.m_uploadKey = this.$data && this.$data.uploadKey ? this.$data.uploadKey : null;
		this.m_mid = this.$data && this.$data.mid ? this.$data.mid : null;
		if(this.m_mid)
			this.m_uploadKey = null;

		var url = "";

		if(this.m_mid) {
			url = '/itp/item/downloadStorageAsset.json?mid='+this.m_mid;
		} else if(this.m_uploadKey) {
			url = '/itp/item/downloadFileAsset.json?uploadKey='+this.m_uploadKey;
		} else if(this.$data.url) {
			url = '';//this.$data.url;
		}

		var schema = '';

		// 산업인력공단 뷰어 (canvas 스케일)
		if(this.$data.pid) {

			var oImageData = viewerController.getImageData(this.$data.pid);

			schema = '<div class="text-altenative-image"';
			var t = oImageData.size.split(',');
			schema += 'style="display:inline-block;width:'+t[0]+'px;height:'+t[1]+'px;';
			schema += 'background:url(\''+_userDataPath + oImageData.url+'\') no-repeat;"';
			schema += '/>';

		} else {
			 schema = '<img src="'+url+'" />';
		}

		$(schema).appendTo(this.target);
		if(this.$options.mode == "edit") {
			$('<div style="position:relative;height:30px;"><input type="file" name="filedata" multiple="" style="position:absolute;left:0px;top:0px;opacity:0;filter: \progid:DXImageTransform.Microsoft.Alpha(Opacity=0)\;width:100px;z-index:100;width:100px;cursor:pointer"><button name="btn-upload" style="position:absolute;left:0px;top:0px;width:100px;">그림 업로드</button></div>').appendTo(this.target);
		}

		$('[name=btn-upload]',this.target).on('click', function() {
			$('[name=filedata]',that.target).trigger('click');
		});

		this.target.on('change', '[name=filedata]', function(e) {
			e.stopPropagation();

			var uploadKey = ecoUtils.guid();
			$(this).attr('id',uploadKey);

			var strFileName = $('[name=filedata]',that.target).val();
			ecoUtils.doApiFileUpload('/itp/item/uploadFileAsset.json',{ uploadKey:uploadKey },uploadKey,function(oData) {
				that.m_uploadKey = oData.uploadKey;
				that.m_mid = null;
				$('img',that.target).attr('src','/itp/item/downloadFileAsset.json?uploadKey='+oData.uploadKey+'');
				$('[name=filedata]',that.target);
			}, function(err) {
				alert(JSON.stringify(err));
			});
		});
	},
	flushData:function() {
		$('img',this.target).attr('src','');
		this.m_mid = null;
		this.m_uploadKey = null;
	},
	getControlData:function() {
		var url = $('img',this.target).attr("src");

		var oData = {
			type:"image"
		}
		if(this.m_uploadKey) {
			oData.uploadKey = this.m_uploadKey;
		}
		if(this.m_mid) {
			oData.mid = this.m_mid;
		}
		return oData;
	}
});
//**************************************************************
//
// itp_item_control_video class
//
//**************************************************************
function itp_item_control_video(target, $data, $param, $options) {
	this.target = $(target);
	this.$data = $data;
	this.$options = $.extend({
		mode:"view"
	}, $options);
	this.init();
}

$.extend(itp_item_control_video.prototype = new itp_item_control(), {
	init:function() {
		var that = this;
		var schema = '';
		var videoObject = '';
		var script = '';

		// 산업인력공단 뷰어 (canvas 스케일)
		if(this.$data.pid) {
			var oVideoData = viewerController.getVideoData(this.$data.pid);
			schema = '<div class="media-altenative-video"';
			var t = oVideoData.size.split(',');
			schema += 'style="display:inline-block;width:'+t[0]+'px;height:'+(Number(t[1]) + 20)+'px;background:black;margin-bottom:15px;"';
			schema += '> ';
			videoObject += '<object class="videoObjectScreen" id="videoObject" classid="clsid:22d6f312-b0f6-11d0-94ab-0080c74c7e95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#version=5,1,52,701" standby="loading..." type="application/x-oleobject" width="'+t[0]+'px" height="'+t[1]+'px">';
			videoObject += '	<param name="animationstart" value="true">';
			videoObject += '	<param name="transparentastart" value="true">';
			videoObject += '	<param name="filename" value="'+_userDataPath + oVideoData.url+'">';
			videoObject += '	<param name="autostart" value="false">';
			videoObject += '	<param name="autoSize" value="true">';
			videoObject += '	<param name="ShowControls" value="false">';
			videoObject += '	<param name="clickToPlay" value="true">';
			videoObject += '	<param name="windowLessvideo" value="false">';
			videoObject += '</object><div class="playerControlBar" style="width:'+t[0]+'px;">';
			videoObject += '	<div class="playerBtnDiv">';
			videoObject += '		<span class="playBtn" id="'+this.$data.pid+'"></span>';
			videoObject += '		<span class="pauseBtn" id="'+this.$data.pid+'" style="display:none;"></span>';
			videoObject += '	</div>';
			videoObject += '	<div class="playerLoadingDiv" id="progressBar_'+this.$data.pid+'" style="width:'+(Number(t[0]) - 42)+'px"></div>';
			videoObject += '	<div class="playerBtnDiv">';
			videoObject += '		<span type="button" class="fullscreen" id="'+this.$data.pid+'"></span>';
			videoObject += '	</div>';
			videoObject += '</div>';
			schema += videoObject;
			schema += '</div>';

//			script += '<script language="JScript" for="videoObject_"'+ this.$data.pid +'" event="playStateChange(NewState)">';
//			script += '		switch(NewState){';
//			script += '			case 0:';
//			script += '					alert("0");';
//			script += '					break;';
//			script += '			case 1:';
//			script += '					alert("1");';
//			script += '					break;';
//			script += '			case 2:';
//			script += '					alert("2");';
//			script += '					break;';
//			script += '			case 3:';
//			script += '					alert("3");';
//			script += '					break;';
//			script += '		}';
//			script += '</script>';
//			schema += script;
		}
		$(schema).appendTo(this.target);
		var _pid = this.$data.pid;
		$("#progressBar"+ this.$data.pid).progressbar({
			value:false
		});
		$(".playBtn").on('click', function(){
			var pid = $(this).attr('id');
			//$("#openStateEventListener").attr("for", "videoObject_" + pid);
			//$("#playerEventListener").attr("for", "videoObject_" + pid);
			$("#progressBar_" + pid).progressbar({
				value:false
			});
			$(".pauseBtn").show();
			$(".playBtn").hide();
			$("#videoObject")[0].play();
		});
		$(".pauseBtn").on('click', function(){
			var pid = $(this).attr('id');
			$("#progressBar_" + pid).progressbar("value", 100);

			$(".pauseBtn").hide();
			$(".playBtn").show();
			$("#videoObject")[0].pause();
		});
		$(".fullscreen").on('click', function(){
			var pid = $(this).attr('id');
			$("#videoObject")[0].DisplaySize = 3;
		});
	}
});
