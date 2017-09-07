/**********************************************
* PAGE & IMAGE POPUP FUNCTIONS                *
**********************************************/
/**
  * Function to open a CMS page into a pop-up
  * @param String href, location of page to open
  * @param integer id, page ID, for naming pop-up
  * @param integer width, pop-up width
  * @param integer height, pop-up height
  * @return window
  */
function CMS_openPopUpPage(href, id, width, height)
{
	if (href != "") {
		pagePopupWin = window.open(href, 'CMS_page_'+id, 'width='+width+',height='+height+',resizable=yes,menubar=no,toolbar=no,scrollbars=yes,status=no,left=0,top=0');
	}
}
/**
  * Function to open a CMS page into a pop-up
  * @param String href, location of page to open
  * @return auto-sized window
  */
function CMS_openPopUpImage(href)
{
	if (href != "") {
		pagePopupWin = window.open(href+'&popup=true', "popup", "width=20,height=20,resizable=yes,menubar=no,toolbar=no,scrollbars=yes,status=no,left=0,top=0");
	}
}

/**
  * Function to open a pop-up window
  * @param resizable (r),  location (l), directories (d), menubar (m)
  * 		status (st), toolbar (t), scrollbars (s), copyhistory (c)
  * @return void
  */
if (typeof openWindow != 'function') {
	function openWindow(url, name, w, h, r, s, m, left, top) {
		popupWin = window.open(url, name, 'width=' + w + ',height=' + h + ',resizable=' + r + s + ',menubar=' + m + ',left=' + left + ',top=' + top);
	}
}
