(function(window, undefined)
{
	var jCore = jCore || {};
	
	jCore.uuid=function() 
	{
		    var d = new Date().getTime();
		    var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
		        var r = (d + Math.random()*16)%16 | 0;
		        d = Math.floor(d/16);
		        return (c=='x' ? r : (r&0x3|0x8)).toString(16);
		    });
		    return uuid;
	};
	
	jCore.encrypt=function(dat)
	{
		return jCore.stringToHex($.base64.btoa($.toJSON(dat),true));
	}

	jCore.uploadMultiFile=function(params)
	{
		
		$.blueimp.fileupload.prototype.processActions.duplicateImage = function (data, options) {
		    if (data.canvas) {
		        data.files.push(data.files[data.index]);
		    }
		    return data;
		};
		
		
		  'use strict';
		    // Change this to the location of your server-side upload handler:
		   // var url ="/file/image/upload?root=photo&w=10&h=10";


		    
		    $(params.file).fileupload({
		        url: params.url,
		        dataType: 'json',

		        /*

		        disableImageResize: /Android(?!.*Chrome)|Opera/
		            .test(window.navigator && navigator.userAgent),
		        imageMaxWidth: 800,
		        imageMaxHeight: 800,
		        imageCrop: true ,// Force cropped images
		        */

		
		        disableImagePreview: true,
		        disableImageResize: false,
		        disableImageMetaDataSave: true,
		        
		        done: function (e, data) {
		        	
		            $.each(data.result.files, function (index, file) {

		            	params.done(file);
		            
		            });
		        },
		        progressall: function (e, data)
		        {
		            var p = parseInt(data.loaded / data.total * 100, 10);

		        	params.progress(p);

		        },

		        processQueue: params.queue

		        
		    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

		
	}

	
	jCore.validObejct=function(dat)
	{
		var ok=true
		for(var key in dat)
		{
			if(dat[key]=='')ok=false;
		}
		return ok;
	}
	

	
	jCore.addTab=function(args)
	{
		var con='#divTab';
		if (!$(con).tabs('exists', args.name))
		{
			var html = '<iframe frameborder="0" scrolling="yes" src="' + args.url + '" style="width:100%;height:100%;"></iframe>';

        	$(con).tabs('add', { title: args.name, content: html, closable: true });
    	}
    	else{$(con).tabs('select', args.name);}
    	
    }
	jCore.uploadfile=function(args)
	{
		
		
		jCore.ajaxfileupload(args);
		
		return;
		
		var ok=jCore.validfile(args);
		alert(ok);

		
		if (!jCore.validfile(args))
		{
			ele=$('#msg_info');
			ele.html(args.msg)
			$(ele).fadeIn(2000,function(){
				
				$(ele).fadeOut(2000);
				
			});
			var ext = $(args.file).val();
			
		
	    }
		else
		{
			jCore.ajaxfileupload(args);
		}
		
	}
	jCore.ajaxfileupload=function(args)
	{
		$.ajaxFileUpload
		(
			{
				url:args.url,
				secureuri:false,
				fileElementId: args.widget,
				dataType: 'json',
				beforeSend:function()
				{
					//$("#loading").show();
				},
				complete:function()
				{
					//$("#loading").hide();
				},				
				success: function (data, status)
				{
					if(typeof(data.err) != 'undefined')
					{
						if(data.err != '')
						{
							alert(data.err);
			
						}else
						{

							args.callback(data,args);
						}
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
	}
	jCore.validfile=function(args)
	{
    		var ok = false;

    		var ext = $(args.file).val();

    		ext = ext.substring(ext.lastIndexOf(".") + 1);
    		ext=ext.toLowerCase();
    		var format = args.format.split(',');
    		
    		for (var i = 0; i < format.length; i++)
    		{
        		if (format[i].toLowerCase() == ext)
        		{
           			ok = true; break;
        		}
    		}
   
    		return ok;
	}
	
	
	jCore.validRegex=function(args)
	{
		var has=args.regex.test(args.text);
		if(args.check)
		{
			if(has)
				jCore.showOk(args);
			else
				jCore.showError(args);
		}
		return has;
	}

	jCore.hexToString=function(text)
	{
		
		/*
		var val='';
		var arr = str.split(",");
		for(arr i = 0; i < arr.length; i++){
		val += arr[i].fromCharCode(i);
		}
		return val;
		*/
		
	}

	jCore.stringToHex=function(text)
	{
		var hex='';
		for(var i = 0; i < text.length; i++)
		{
			if(hex=='')
				hex = text.charCodeAt(i).toString(16);
			else
				hex +=text.charCodeAt(i).toString(16);//The separator you cant set ',';
		}
		return hex;
	}
	
	jCore.showError=function(args)
	{
		$(args.ele).html(args.error);
		$(args.ele).removeClass('ok');
		$(args.ele).addClass('error');	
		$(args.ele).fadeIn();
		
	}
	jCore.showOk=function(args)
	{
		$(args.ele).addClass('ok');	
		$(args.ele).html(args.msg);
		$(args.ele).removeClass('error');
		$(args.ele).fadeOut(function(){});

	}

	jCore.obtkey=function(con)
	{
	   		var object=$(con).datagrid('getChecked');	

	   		var has=[];		

			$.each(object,function(i,item)
			{
				has.push(item.id);
			});

			return has.join(',');
	}
	jCore.remove=function(param,url)
	{
		
		jCore.httpRequest({type:'post',data:param,url:url,dataType:'json',
			success:function(data)
			{
				
				param.callback(data);

			},
			beforeSend:function()
			{
				
			},
			error:function()
			{
				
			}
			});
		
	}
	jCore.getHtml=function(args)
	{
		$.getJSON(args.url, args.para, function(data)
		{
			args.callBack(data);
		});
	}
	jCore.httpRequest=function(args)
	{
		args.data._t=new Date().getTime();
		jQuery.ajax({type:args.type,data:args.data,url:args.url,dataType:args.dataType,
			success:function(data)
			{
				args.success(data);
			},
			beforeSend:function()
			{

			},
			error:function()
			{
				
			}
			
		});
	}
	
	window.jCore = jCore;
})(window);

$.format = function (source, params) {
    if (arguments.length == 1)
        return function () {
            var args = $.makeArray(arguments);
            args.unshift(source);
            return $.format.apply(this, args);
        };
    if (arguments.length > 2 && params.constructor != Array) {
        params = $.makeArray(arguments).slice(1);
    }
    if (params.constructor != Array) {
        params = [params];
    }
    $.each(params, function (i, n) {
        source = source.replace(new RegExp("\\{" + i + "\\}", "g"), n);
    });
    return source;
};
/*
var text = "a{0}b{0}c{1}d\nqq{0}"; 
var text2 = $.format(text, 1, 2); 
alert(text2); 
*/