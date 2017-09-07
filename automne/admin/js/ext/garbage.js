//This function correct an error in cache management of objects contained by IFrame.
//IE does not allow the cache of elements outside of main document and throw a Permission denied error
clearInterval(Ext.Element.collectorThreadId);
Ext.Element.garbageCollect = function(){
	if(!Ext.enableGarbageCollector){
		clearInterval(Ext.Element.collectorThreadId);
		return;
	}
	for(var eid in Ext.Element.cache){
		var el = Ext.Element.cache[eid], d = el.dom;
		try{
			if(!d || !d.parentNode || (!d.offsetParent && !document.getElementById(eid))){
				delete Ext.Element.cache[eid];
				if(d && Ext.enableListenerCollection){
					Ext.lib.Event.purgeElement(d);
				}
			}
		} catch (e) {
			delete Ext.Element.cache[eid];
		}
	}
}
Ext.Element.collectorThreadId = setInterval(Ext.Element.garbageCollect, 30000);
//This function correct an error in dom security access for IE
Ext.apply(Ext, {
	/**
	* Return the dom node for the passed string (id), dom node, or Ext.Element
	* @param {Mixed} el
	* @return HTMLElement
	*/
	getDom : function(el){
		if(!el || !document){
			return null;
		}
		try {
			return el.dom ? el.dom : (typeof el == 'string' ? document.getElementById(el) : el);
		} catch(e){
			return null;
		}
	}
});