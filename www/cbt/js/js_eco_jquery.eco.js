(function($) {
	if(Array.prototype.indexOf == undefined) {
		Array.prototype.indexOf = function(a) {
			for(var i = 0 ; i < this.length ; i++) {
				if(this[i] == a) {
					return i;
				}
			}
			return -1;
		}
	}

	if(String.prototype.ltrim == undefined) {
		String.prototype.ltrim = function() {
			return this.replace(/\s*((\S+\s*)*)/, "$1");
		}
	}

	if(String.prototype.rtrim == undefined) {
		String.prototype.rtrim = function() {
			return this.replace(/((\s*\S+)*)\s*/, "$1");
		}
	}

	if(String.prototype.trim == undefined) {
		String.prototype.trim = function() {
			return this.ltrim().rtrim();
		}
	}

	$.fn.scrollTo = function( target, options, callback ){
	  if(typeof options == 'function' && arguments.length == 2){ callback = options; options = target; }
	  var settings = $.extend({
		scrollTarget  : target,
		offsetTop     : 50,
		duration      : 500,
		easing        : 'swing'
	  }, options);
	  return this.each(function(){
		var scrollPane = $(this);
		var scrollTarget = (typeof settings.scrollTarget == "number") ? settings.scrollTarget : $(settings.scrollTarget);
		var scrollY = (typeof scrollTarget == "number") ? scrollTarget : scrollTarget.offset().top + scrollPane.scrollTop() - parseInt(settings.offsetTop);
		scrollPane.animate({scrollTop : scrollY }, parseInt(settings.duration), settings.easing, function(){
		  if (typeof callback == 'function') { callback.call(this); }
		});
	  });
	}

	$.fn.centerToWindow = function()
	{
	  var obj           = $(this);
	  var obj_width     = $(this).outerWidth(true);
	  var obj_height    = $(this).outerHeight(true);
	  var window_width  = window.innerWidth ? window.innerWidth : $(window).width();
	  var window_height = window.innerHeight ? window.innerHeight : $(window).height();

	  obj.css({
		"position" : "fixed",
		"top"      : ((window_height / 2) - (obj_height / 2))+"px",
		"left"     : ((window_width / 2) - (obj_width / 2))+"px"
	  });

	  return this;
	}

	window.____$$$ecoConfig = {
		dynimicScriptRoot:null,
		dynimicCssRoot:null
	};

	window.ecoConfig = function(options) {
		if(options) {
			$.extend(window.____$$$ecoConfig, options);
		}
		return window.____$$$ecoConfig;
	}

	$.fn.controller = function(fn, param1, param2, param3) {

		var that = this;
		var path = fn;

		if(fn){fn = fn.replace(/\//g,'_');}
		else {return this.data('controllerBinded');}

			this.bindController = function() {
				if(window[fn] == undefined) {
					alert("##### controller not found ####\ncontroller="+fn+"\npath="+path);
					return;
				}
				oController = new window[fn](that.get(0), param1, param2, param3);
				$(that).addClass(fn);
				if(fn.indexOf('panel_') != 0)
					$(that).addClass('panel_'+fn);

				$(that).attr('ctrl',fn);
				that.data('controllerBinded', oController);

				return oController;
			}

		var oController = this.data('controllerBinded');
		console.log("oController:" + that.data('controllerBinded')); //saningong_viewer saningong_viewer

		if(oController == null){

			if(ecoConfig().dynimicCssRoot && $('link[name='+fn+']').length == 0) {

				var css = document.createElement('link');
				css.rel = "stylesheet";
				css.onload = function() {

				}
				css.name = fn;
				path = window.ecoCssDynamicMap ? window.ecoCssDynamicMap[path] || path : path;
				css.href = ecoConfig().dynimicCssRoot+'/'+path+".css";
				document.getElementsByTagName('head')[0].appendChild(css);
			}

			if(ecoConfig().dynimicScriptRoot && window[fn] == undefined) {
				var src = ecoConfig().dynimicScriptRoot+"/"+path+'.js';
				$.getScript(src, function(){
					return that.bindController();
				});
			} else {
				return that.bindController();
			}
		}

		return oController;
	};



	$( "<style>\
		.eco-panel  { position:relative;left:0px;right:0px;top:0px;bottom:0px; }\
		.eco-panel > .eco-panel-header { position:absolute;top:0px;left:0px;right:0px;height:0px; }\
		.eco-panel > .eco-panel-footer { position:absolute;bottom:0px;left:0px;right:0px;height:0px; }\
		.eco-panel > .eco-panel-body { position:absolute;top:0px;bottom:0px;left:0px;right:0px;background:#fff; } \
		.eco-panel.scroll > .eco-panel-body { overflow:hidden; }\
		.eco-panel.eco-container > .eco-panel-body > * { position:absolute;left:0px;right:0px;top:0px;bottom:0px; }\
		.eco-popup { position:absolute;left:0px;top:0px;z-index:9999;border-radius:10px;box-shadow:0px 0px 10px rgba(0,0,0,0.3); }\
		.eco-popup.full-size { bottom:0px;right:0px; }\
		.eco-popup > .eco-popup-header [button=close] { float:right; }\
		.eco-popup > .eco-popup-header { position:absolute;left:0px;right:0px;top:0px;height:0px; }\
		.eco-popup.has-header > .eco-popup-header { background:#eaeaea;border-radius:10px 10px 0px 0px;height:35px; }\
		.eco-popup > .eco-popup-body { background:#fff;border-radius:0px 0px 10px 0px;position:absolute;top:0px;bottom:0px;left:0px;right:0px;overflow-y:auto; }\
		.eco-popup.has-header > .eco-popup-body { top:35px; }\
		.eco-popup-screen { position:absolute;left:0px;right:0px;top:0px;bottom:0px;background:rgba(0,0,0,0.3);z-index:9998; }\
	</style>" ).appendTo( "head" );


	function eco(target, options) {

		var that = this;
		target = $(target);

		this.init = function(target, options) {

			that.options = $.extend({
				header:false,
				footer:false,
				type:"plain"
			}, options);

			target.addClass(['eco-panel', that.options.type, ['cascade','slide','carousel','browser'].indexOf(that.options.type) != -1 ? 'eco-container' : '', that.options.scroll ? 'scroll' : ''].join(" "));

			if(that.options.header && that.header().length == 0) $('<div/>', { 'class':'eco-panel-header' } ).appendTo(target);
			if(that.body().length == 0) $('<div/>', { 'class':'eco-panel-body'}).appendTo(target);
			if(that.options.footer && that.footer().length == 0) $('<div/>', { 'class':'eco-panel-footer'}).appendTo(target);

			if(that.options.scroll) {
				$('<div/>', { 'class':"eco-panel-content" }).appendTo(that.body());
				that.m_scroller = new IScroll(that.body().get(0),{ scrollbars:true, mouseWheel:true });
			}

		}

		this.header = function() { return $('> .eco-panel-header',target); }
		this.footer = function() { return $('> .eco-panel-footer',target); }
		this.body = function() { return $('> .eco-panel-body',target); }
		this.content = function() { return that.options.scroll ? $('> .eco-panel-body > .eco-panel-content',target) : that.body(); }
		this.update = function() { setTimeout(function() { that.m_scroller.refresh(); },0); }
		this.container = function() { return $(target.closest('.eco-panel.eco-container')); }
		this.empty = function() { that.body().empty(); }

		this.focus = function(nIndex) {
			if(that.options.type == 'cascade') {
				for(var i = that.body().children().length-1 ; i > nIndex ; i--) {
					that.body().children(':eq('+(i)+')').remove();
				}
			}
			that._focusPanel(that.body().children(':eq('+(nIndex)+')'), that.body().children(':visible'));
		}

		this.prev = function() {
			var oHide = that.body().children(':visible');
			var nIndex = oHide.index();
			if(that.options.type == 'slide' && oHide.is(':first-child'))
				return;
			var oShow = that.options.type == 'carousel' && oHide.is(':first-child') ? that.body().children(':last-child').prependTo(that.body()) : that.body().children(':eq('+(nIndex-1)+')');
			that._focusPanel(oShow, oHide, 'prev');
		}

		this.next = function() {
			var oHide = that.body().children(':visible');
			var nIndex = oHide.index();
			if(that.options.type == 'slide' && oHide.is(':last-child'))
				return;
			var oShow = that.options.type == 'carousel' && oHide.is(':last-child') ? that.body().children(':first-child').appendTo(that.body()) : that.body().children(':eq('+(nIndex+1)+')');
			that._focusPanel(oShow, oHide, 'next');
		}

		this.append = function(schema, controller, $data, $param) {
			var oHide = that.body().children(':visible');

			if(that.options.type == 'browser') {
				that.body().empty();
			}

			var oShow = $(schema == undefined || schema == "" ? '<div></div>' : schema).appendTo(that.body());
			if(controller)
				oShow.controller(controller, $data, $param);
			switch(that.options.type) {
			case 'cascade' :
				that._focusPanel(oShow, oHide, that.body().children().length == 1 ? null : 'next');
				break;
			default:
				if(that.body().children().length > 1) oShow.hide();
				else that._focusPanel(oShow, oHide);
				break;
			}
			return oShow;
		}

		this.back = this.pop = function() {
			if(that.body().children().length <= 1)
				return;
			that._focusPanel(this.body().children(':eq('+(that.body().children().length-2)+')'), that.body().children(':visible'), 'pop');
		}

		this._focusPanel = function(oShow, oHide, type) {

			switch(type) {
			case 'pop' :
			case 'prev' :
				oHide.animate({ left:'100%' },300, function() { $(this)[type=="pop"?"remove":"hide"]() });
				oShow.css('left','-100%').show().animate({ left:'0%' },300);
				break;
			case 'next' :
				oHide.animate({ left:'-100%' },300, function() { $(this).hide() });
				oShow.css('left','100%').show().animate({ left:'0%' },300);
				break;
			default :
				oHide.hide();
				oShow.css('left','0%').show();
				break;
			}
			target.trigger('ECO_PANEL_FOCUSED',{ panel:oShow, container:target });
		}


		this.init(target, options);
	}


	$.fn.eco = function(method) {

		var that = this;
		var ecox = that.data('ecoController');

		this.init = function(options) {
			if(ecox) return that;
			that.data('ecoController', ecox = new eco(this, options));
			return that;
		}

		if(typeof method != "string") {
			return that.init.apply(that, Array.prototype.slice.call(arguments,0));
		}

		if(ecox == undefined)
			that.init();
		return ecox[method].apply(ecox, Array.prototype.slice.call(arguments,1));
	}


	var ecoPopupManager = {
		'append':function(popupAnchorId, oPopup, oScreen) {
			if(window._____popupManager == undefined)
				window._____popupManager = {};

			if(window._____popupManager[popupAnchorId] == undefined) {
				window._____popupManager[popupAnchorId] = [];
			}

			window._____popupManager[popupAnchorId].push( { panel:oPopup, screen:oScreen });
		},
		'remove':function(popupAnchorId) {
			return window._____popupManager[popupAnchorId].pop()
		}

	};

	$.fn.ecoPopup = function(method) {

		var that = this;

		if($(this).data('popupAnchorId') == undefined) {
			$(this).data('popupAnchorId', ecoUtils.guid());
		}
		var popupAnchorId = $(this).data('popupAnchorId');

		this.init = function(options, schema, controller, $data, $param, $options) {

			schema = schema && schema != '' ? schema : '<div/>';
			options = $.extend({ header:true, screen:true, fullSize:true }, options);

			var schemaPopup = '<div style="display:none;">';
			if(options.header) {
				schemaPopup += '<div class="eco-popup-header">';

				if(options.title)
				schemaPopup += '<label class="title">'+options.title+'</label>';
				schemaPopup += '<a button="close">X</a>';
				schemaPopup += '</div>';
			};
			schemaPopup += '<div class="eco-popup-body"></div></div>';

			var oScreen = options.screen ? $('<div class="eco-popup-screen"></div>').appendTo($(this)) : null;
			var oShow = $(schemaPopup).appendTo($(this)).addClass('eco-popup');

			if(options.header) { oShow.addClass('has-header'); }
			if(options.fullSize) { oShow.addClass('full-size'); }

			$('[button=close]', $('> .eco-popup-header',oShow)).on(window['EVENT_CLICK']||'click', that.hide);

			var oPanel = $(schema).appendTo($('> .eco-popup-body', oShow)).css({'position':'absolute', left:'0px', right:'0px', top:'0px', bottom:'0px' });

			if(controller && controller != '') {
				oPanel.controller(controller, $data, $param, $options);
			}

			ecoPopupManager.append(popupAnchorId, oShow, oScreen);
			setTimeout(function() { oShow.centerToWindow().show(); }, 0);

			return oShow;
		}

		this.hide = function(param) {

			var o = ecoPopupManager.remove(popupAnchorId);
			if(o.screen)
				o.screen.remove();

			//o.panel.css('border','solid 10px red');
			o.panel.remove();
		}

		return this[typeof method == "string" ? method : "init"].apply(this, Array.prototype.slice.call(arguments,typeof options == "string" ? 1 : 0));
	}

	window.ecoPopupShow = function(options, scheam, controller, $data, $param, $options) {
		return $('body').ecoPopup(options,scheam, controller, $data, $param, $options);
	}

	window.ecoPopupHide = function() {
		return $('body').ecoPopup('hide');
	}


	$( "<style>\
		.eco-paging .btn-page, .eco-paging .btn-action { cursor:pointer;margin-top:5px;display:inline-block;width:20px;height:20px;border:solid 1px #ccc;margin-right:5px;line-height:20px;text-align:center;color:#000;}\
		.eco-paging .btn-page.selected { background:navy;color:#fff; }\
		</style>" ).appendTo( "head" );


	$.fn.ecoPaging = function(options) {

		var that = this;

		this.init = function(options, fn) {
			$(this).addClass('eco-paging');
			$(this).data('eco-paging-options',$.extend({},options));
			$(this).data('eco-paging-handler',fn);
		}

		this.data = function(nPageIndex, nPageUnit, nPageTotal) {

			var target = $(this);
			var that = this;

			var s = nPageIndex%10 == 0 ? nPageIndex-(10-1) : Math.floor(nPageIndex/10)*10+1;
			var e = s+10;

			target.empty();

			target.append('<span class="count-total">Total '+nPageTotal+'</span>');

			var cntMaxPage = Math.floor(nPageTotal/nPageUnit)+1+(nPageTotal%nPageUnit != 0 ? 1 : 0);
			e = Math.min(e, cntMaxPage);

			var a = $('<span/>').appendTo(target);

			if(s > 10*2) {
				$('<li class="btn-action btn-go-next"><<</li>').appendTo(a).click(function() {
					var fn = target.data('eco-paging-handler');
					if(fn) fn(1);
				});
			}
			if(s > 10*1) {
				$('<li class="btn-action btn-go-last"><</li>').appendTo(a).click(function() {
					var fn = target.data('eco-paging-handler');
					if(fn) fn(s-10);
				});
			}

			for(var i = s ; i < e ; i++) {
				var o = $('<li class="btn-page" pageIndex="'+i+'">'+i+'</li>').appendTo(a);
				if(i == nPageIndex)
					o.addClass('selected');

				o.click(function(e) {
					var fn = target.data('eco-paging-handler');
					if(fn) fn($(this).attr('pageIndex'));
				});
			}

			if(e < cntMaxPage) {
				$('<li class="btn-action btn-go-next">></li>').appendTo(a).click(function() {
					var fn = target.data('eco-paging-handler');
					if(fn) fn(s+10);
				});
			}
			if(e+10 < cntMaxPage) {
				$('<li class="btn-action btn-go-last">>></li>').appendTo(a).click(function() {
					var fn = target.data('eco-paging-handler');
					if(fn) fn(cntMaxPage);

				});
			}

		}

		return this[typeof options == "string" ? options : "init"].apply(this, Array.prototype.slice.call(arguments,typeof options == "string" ? 1 : 0));
	}

})(jQuery);
