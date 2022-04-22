(function ($) {
  $(document).ready(function () {

	 /** summernote start */

    //////$('.summernote').summernote('lineHeight', 1);
    var MyButtons1 = function (context) {
              var ui = $.summernote.ui;
              var list = $('#elements-list').val();
              var alist="";
              alist +="<span class='note-btn-group btn-group note-align'>";
              alist +="<a class='note-btn btn btn-light btn-sm note-icon-bold' action='bold'></a>";
              alist +="<a class='note-btn btn btn-sm note-icon-italic' action='italic'></a>";
              alist +="<a class='note-btn btn btn-sm note-icon-underline' action='underline'></a>";
              alist +="<a class='note-btn btn btn-sm note-icon-strikethrough' action='strikethrough'></a>";
              alist +="<a class='note-btn btn btn-sm note-icon-superscript' action='superscript'></a>";
              alist +="<a class='note-btn btn btn-sm note-icon-subscript' action='subscript'></a>";
              alist +="</span>";
              var button = ui.buttonGroup([
                  ui.button({
                      className: 'dropdown-toggle',
                      contents: '<a class="note-icon-bold"></a>',
                      tooltip: "Font Style",
                      data: {
                          toggle: 'dropdown'
                      }
                  }),
                  ui.dropdown({

                      className: 'drop-default summernote-list',
                      contents: alist,
                      callback: function ($dropdown) {
                          $dropdown.find('a').each(function () {
                              $(this).click(function (e) {
                                  event.preventDefault();
                                  var $button = $(event.target);
                                  if($button.attr('action')=="bold"){context.invoke("editor.bold");};
                                  if($button.attr('action')=="italic"){context.invoke("editor.italic");};
                                  if($button.attr('action')=="underline"){context.invoke("editor.underline");};
                                  if($button.attr('action')=="strikethrough"){context.invoke("editor.strikethrough");};
                                  if($button.attr('action')=="superscript"){context.invoke("editor.superscript");};
                                  if($button.attr('action')=="subscript"){context.invoke("editor.subscript");};
                                  //context.invoke("editor.insertText", "버튼1");
                                  //$('#summernote').summernote('insertText', 'hit ');
                              });
                          });
                      }
                  })
              ]);
      return button.render();   // return button as jquery object
    }
    var MyButtons2 = function (context) {
              var ui = $.summernote.ui;
              var list = $('#elements-list').val();
              var alist2="";
              alist2 +="<span class='note-btn-group btn-group note-align'>";
              alist2 +="<a class='note-btn btn btn-light btn-sm note-icon-link' action='link'></a>";
              alist2 +="<a class='note-btn btn btn-light btn-sm note-icon-picture' action='picture'></a>";
              alist2 +="<a class='note-btn btn btn-light btn-sm note-icon-video' action='video'></a>";
              alist2 +="<a class='note-btn btn btn-light btn-sm note-icon-arrows-alt' action='fullscreen'></a></span>";
              //alist2 +="<a class='note-btn btn btn-light btn-sm note-icon-code' action='codeview'></a>";

              var button = ui.buttonGroup([
                  ui.button({
                      className: 'dropdown-toggle',
                      contents: '<a class="fa fa-plus"></a>',
                      tooltip: "More",
                      data: {
                          toggle: 'dropdown'
                      }
                  }),
                  ui.dropdown({
                      className: 'drop-default summernote-list',
                      contents: alist2,
                      callback: function ($dropdown) {
                          $dropdown.find('a').each(function () {
                              $(this).click(function (e) {
                                  event.preventDefault();
                                  var $button = $(event.target);
                                  if($button.attr('action')=="link"){context.invoke('linkDialog.show');};
                                  if($button.attr('action')=="picture"){context.invoke('imageDialog.show');};
                                  if($button.attr('action')=="video"){context.invoke('videoDialog.show');};
                                  if($button.attr('action')=="fullscreen"){context.invoke('fullscreen.toggle');};
                                  //if($button.attr('action')=="codeview"){context.invoke('codeview.toggle');};

                              });
                          });
                      }
                  })
              ]);
      return button.render();   // return button as jquery object
    }

    $(".summernote").summernote({
      lang: 'ko-KR',

      height: 300,
      toolbar: [
        ['mymenu1', ['mybtns1']],
        ['highlight', ['highlight']],
        ['style', ['style']],
        ['font', ['clear']],  //'bold', 'italic', 'underline', 'strikethrough', , 'superscript', 'subscript',
      //  ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph'] ],
      //  ['height', ['height']],
        ['table', ['table']],
        ['view', ['codeview']],  //'fullscreen',
        ['mymenu2', ['mybtns2']],
      //  ['insert', ['link', 'picture', 'video']],
      //  ['help', ['help']]
      ],
      buttons: {
        mybtns1: MyButtons1,
        mybtns2: MyButtons2
      },
      callbacks : {
                    		      onImageUpload: function (files) {
                    				/** upload start */
                        				var maxSize = 1 * 1024 * 1024; // limit 1MB
                        				// TODO: implements insert image
                        				var isMaxSize = false;
                        				var maxFile = null;
                        				for (var i = 0; i < files.length; i++) {
                        				  if (files[i].size > maxSize) {
                        					isMaxSize = true;
                        					maxFile = files[i].name;
                        					break;
                        				  }
                        				  //sendFile(files[i], this);
                        				}

                        				if (isMaxSize) { // 사이즈 제한에 걸렸을 때
                        				   alert('[' + maxFile + '] 파일이 업로드 용량(1MB)을 초과하였습니다.');
                        				} else {
                        					for(var i = 0; i < files.length; i++) {
                        						sendFile(files[i], this);
                        					}
                        				}
                    			      /** upload end */
                    		  },
                          onPaste: function (e) {
                                var clipboardData = e.originalEvent.clipboardData;
                                            if (clipboardData && clipboardData.items && clipboardData.items.length) {
                                              var item = clipboardData.items[0];
                                                        if (item.kind === 'file' && item.type.indexOf('image/') !== -1) {
                                                          e.preventDefault();
                                                        }
                                            }
                          }
        }


    }); /*summernote*/

  }); /*ready*/
})(jQuery); /*jquery*/
