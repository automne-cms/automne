(function(){
	/* Add events on object*/
	if (typeof 'addEvent' != 'function') {
		function addEvent(obj, evType, fn)
		{
			if (obj.addEventListener) {
				obj.addEventListener(evType, fn, true);
				return true;
			} else if (obj.attachEvent) {
				var r = obj.attachEvent("on"+evType, fn);
				return r;
			} else {
				return false;
			}
			return true;
		}
	}
	/** 
	  * Add window.onload event
	  * launch some functions according to the current page
	  */
	addEvent(window, 'load', function(){
		//startFlash();
		if(typeof sIFR == "function"){
			// This is the preferred "named argument" syntax
			sIFR.replaceElement(named({sSelector:"#firstCol>h2", sFlashSrc:"/swf/eurostile.swf", sColor:"#6FAE03", sBgColor:"Null", nPaddingTop:0, nPaddingBottom:0, sFlashVars:"textalign=left", sWmode:"transparent"}));
			var div = document.getElementById('content');
			if(div.className != "page5"){
				sIFR.replaceElement(named({sSelector:"#content h1", sFlashSrc:"/swf/eurostile.swf", sColor:"#6FAE03", sBgColor:"Null", nPaddingTop:6, nPaddingBottom:0, sFlashVars:"textalign=left", sWmode:"transparent"}));
			}else{
				sIFR.replaceElement(named({sSelector:"#content h1", sFlashSrc:"/swf/eurostile.swf", sColor:"#EC2685", sBgColor:"Null", nPaddingTop:6, nPaddingBottom:0, sFlashVars:"textalign=left", sWmode:"transparent"}));	
			}
		}
		return true;
	});
})();