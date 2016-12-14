/**
 * html部分
 */
<!DOCTYPE html>
<html>
<head>
	<title>上传功能</title>
</head>
<body>
<input type="text" name="upload-text" id="img" />
<button id="upload">上传</button>
<div id="preview"></div>
</body>
</html>
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/jquery.upload.js"></script>
<script type="text/javascript">
 $("#upload").click(function(){
        $.upload({
            url: '{:U("Q1/Index/upload")}', 
            fileName: 'file', 
            dataType: 'text',
            onSend: function() {
                return true;
            },
            onComplate: function(data) {
            	console.log(data);
                if(data.indexOf("upload") >=0 ){
                    $("#img").val(data);
                    $("#preview").html('<img style="height:80px;" src="'+data+'" />');
                }else{
                    alert(data);
                }
            }
        });
        return false;
    })
 </script>

/**
 *jquery.upload.js 
 */
<script type="text/javascript">
(function($) {
	var noop = function(){ return true; };
	var frameCount = 0;
	
	$.uploadDefault = {
		url: '',
		fileName: 'filedata',
		dataType: 'json',
		params: {},
		onSend: noop,
		onSubmit: noop,
		onComplate: noop
	};

	$.upload = function(options) {
		var opts = $.extend(jQuery.uploadDefault, options);
		if (opts.url == '') {
			return;
		}
		
		var canSend = opts.onSend();
		if (!canSend) {
			return;
		}
		
		var frameName = 'upload_frame_' + (frameCount++);
		var iframe = $('<iframe style="position:absolute;top:-9999px" />').attr('name', frameName);
		var form = $('<form method="post" style="display:none;" enctype="multipart/form-data" />').attr('name', 'form_' + frameName);
		form.attr("target", frameName).attr('action', opts.url);
		
		// form中增加数据域
		var formHtml = '<input type="file" name="' + opts.fileName + '" onchange="onChooseFile(this)">';
		for (key in opts.params) {
			formHtml += '<input type="hidden" name="' + key + '" value="' + opts.params[key] + '">';
		}
		form.append(formHtml);

		iframe.appendTo("body");
		form.appendTo("body");
		
		form.submit(opts.onSubmit);
		
		// iframe 在提交完成之后
		iframe.load(function() {
			var contents = $(this).contents().get(0);
			var data = $(contents).find('body').text();
			if ('json' == opts.dataType) {
				data = window.eval('(' + data + ')');
			}
			opts.onComplate(data);
			setTimeout(function() {
				iframe.remove();
				form.remove();
			}, 5000);
		});
		
		// 文件框
		var fileInput = $('input[type=file][name=' + opts.fileName + ']', form);
		fileInput.click();
	};
})(jQuery);

// 选中文件, 提交表单(开始上传)
var onChooseFile = function(fileInputDOM) {
	var form = $(fileInputDOM).parent();
	form.submit();
};
</script>





/**
 * php部分
 */


<?php
namespace Q1\Controller;
use Common\BaseController;
class IndexController extends BaseController {
    public function index(){
    	$this->display();
	}
	 public function upload(){
    	$upload = new \Think\Upload();// 实例化上传类
    	$upload->maxSize = 5*1024*1024 ;// 设置附件上传大小    
    	$upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
    	$upload->rootPath = './Public/upload/'; // 设置附件上传目录    // 上传单个文件     
    	$info = $upload->uploadOne($_FILES['file']);
    	if(!$info) {// 上传错误提示错误信息        
    		echo $upload->getError();  
    	}else{// 上传成功 获取上传文件信息         
    		echo '/Public/upload/'.$info['savepath'].$info['savename'];    
    	}
    }
    public function uploadJson(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 5*1024*1024 ;// 设置附件上传大小    
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
        $upload->rootPath = './Public/upload/'; // 设置附件上传目录    // 上传单个文件     
        $info = $upload->uploadOne($_FILES['imgFile']);
        if(!$info) {// 上传错误提示错误信息
            $this->ajaxReturn(array('error' => 1, 'message' => $upload->getError()));
        }else{// 上传成功 获取上传文件信息      
            $this->ajaxReturn(array('error' => 0, 'url' => 'Public/upload/'.$info['savepath'].$info['savename']));
        }
    }
}


