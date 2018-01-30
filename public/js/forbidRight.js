function forbidRight(){
	if (window.Event) 
    document.captureEvents(Event.MOUSEUP); 
	function nocontextmenu() {
	    event.cancelBubble = true;
	    event.returnValue = false;
	    return false;
	}
	function norightclick(e) {
	    if (window.Event) {
	          if (e.which == 2 || e.which == 3)
	           return false;
	    }else if (event.button == 2 || event.button == 3){
	           event.cancelBubble = true;
	           event.returnValue = false;
	           return false;
	    }
	}
	document.oncontextmenu = nocontextmenu;  // for IE5+
	document.onmousedown = norightclick;  // for all others

	document.onselectstart = function(){//禁用网页上选取的内容
	    event.returnValue = false;
	};
	document.oncopy = function(){//禁用复制
	    event.returnValue = false;
	};
}
forbidRight();