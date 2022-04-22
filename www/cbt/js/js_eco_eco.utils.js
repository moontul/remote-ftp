var gURLRoot = 'http://ks.e.gondor.kr';

var ecoUtils = {

	apiTarget:function(target) {
		window.____$$$$apiTarget = target || 'cloud';
	},

	doApi:function(url, oForm, success, error) {

		var target = window.____$$$$apiTarget || "cloud";
		var re = /^(cloud|local|http|https)\:/ig;

		var arr = re.exec(url);
		if(arr && arr.length > 1) {
			var s = arr[1];
			if(s == 'cloud' || s == 'local') {
				target = s;
				url = url.replace(re,"");
			} else {
				target = 'cloud';
			}
		}

		if(url.indexOf('.json') != -1)
			target = 'cloud';

		if(target == 'local') {
			ecoLocalApi.doApi(url,oForm,success,error);
		} else {

			if(url.indexOf('.json') == -1)
				url += '.json';

			$.ajax({

				url: (typeof cordova != "undefined" ? gURLRoot : '')+url,
				processData: false,
				contentType: 'application/json',
				dataType:"json",
				type: 'post',
				data: JSON.stringify(oForm),
				success: function(r) {
					if (r.code != "0") {
						if(error) error(r);
						return ;
					}
					if(success) success(r.data);
				},
				error:function(r) {
					alert("일시적인 통신 오류가 발생했습니다. 잠시 후, 다시 시도해 주세요.");
					if(error) error(r);
				}
			});
		}
	},
	doApiFileUpload:function(url, oForm, fileElementId, success, error) {
		$.ajaxFileUpload({
			url:(typeof cordova != "undefined" ? gURLRoot : '')+url,
			secureuri:false,
			fileElementId:fileElementId,
			forceIframeTransport:true,
			dataType: 'json',
			data:oForm,
			success: function(r) {

				if (r.code != "0") {
					alert(r.message);
					return ;
				}

				if(success) success(r.data);
			},
			error:function(r) {
				alert("일시적인 통신 오류가 발생했습니다. 잠시 후, 다시 시도해 주세요.");
				if(error) error(r);
			}
		});
	},
	getHashParams:function() {
		var hashParams = {};
		var e,
			a = /\+/g,  // Regex for replacing addition symbol with a space
			r = /([^&;=]+)=?([^&;]*)/g,
			d = function (s) { return decodeURIComponent(s.replace(a, " ")); },
			q = window.location.hash.substring(1);

		while (e = r.exec(q))
		   hashParams[d(e[1])] = d(e[2]);

		return hashParams;
	},
	guid:function() {
		function S4() {
		   return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
		}
		return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
	},
	arrayToMap:function(arr, id) {
		var map = {};
		for(var i = 0, len = arr.length ; i < len ; i++) {
			map[arr[i][id||"id"]] = arr[i];
		}
		return map;
	},
	isMobile:function() {
		var check = false;
		(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
		return check;
	},
	bindContentEditableChangeEvent:function(container) {

		container = $(container);

		$('[contenteditable]',container).unbind('focus');
		$('[contenteditable]',container).unbind('blur');
		$('[contenteditable]',container).on('focus', function() { $(this).data('beforeEdit', $(this).html()); });
		$('[contenteditable]',container).on('blur', function() {
			if($(this).html() != $(this).data('beforeEdit'))
				$(this).trigger('change');
		});
	},
	toDateString:function(oDate) {
		var y = oDate.getFullYear();
		var m = oDate.getMonth()+1;
		var d = oDate.getDate();
		return y + "-"+(m<10?"0":"")+m+"-"+(d<10?"0":"")+d;
	},
	toDateTimeString:function(oDate) {
		var h = oDate.getHours();
		var m = oDate.getMinutes();
		return this.toDateString(oDate) + " " + (h<10?"0":"")+h+"-"+(m<10?"0":"")+m;
	}
}

//*******************************************************************
//
// ecoLocalApi
//
//*******************************************************************
var ecoLocalApi = {
	database:function(dbname, version, desc, size, callback) {
		if(dbname)
			window.___$$$ecoSqlLiteDatabase = new ecoSqlite(dbname, version, desc, size, callback);
		return window.___$$$ecoSqlLiteDatabase;
	},
	doApi:function(api, param, successHandler, errorHandler) {
		if(this[api] == undefined) {
			alert('#### api not found ###\n'+api);
			console.log(api);
			return;
		}
		this[api](param,successHandler,errorHandler);
	}
}
