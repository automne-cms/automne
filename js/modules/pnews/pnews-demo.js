$(document).ready(function(){
	var getSearch = function  () {
		if ($('#keyword').val() && $('#keyword').val().length < 3) {
			return false;
		}
		$.ajax({
			type: 		"GET",
			url: 		pageURL,
			data: 		'out=xml&cat=' + $('#cat').val() + '&keyword=' + $('#keyword').val(),
			success: 	displaySearch
		});
		return true;
	}
	var getPage = function  (e) {
		var href = $(e.target).is('a') ? $(e.target).attr("href") : $(e.target).parent('a').attr("href");
		if (href) {
			e.preventDefault();
			$.ajax({
				type: 		"GET",
				url: 		href,
				data: 		'out=xml',
				success: 	displaySearch
			});
			return false;
		}
		return true;
	}
	var displaySearch = function  (xmlcontent) {
		if (xmlcontent.getElementsByTagName('data').length > 0) {
			$('#searchresult').html(xmlcontent.getElementsByTagName('data').item(0).firstChild.nodeValue);
			if ($('#pages')) {
				$('#pages a').click(getPage);
			}
		}
		return true;
	}
	$("#loadingSearch").ajaxStart(function(){
		$(this).show();
	});
	$("#loadingSearch").ajaxStop(function(){
		$(this).hide();
	});
	
	$('#submitSearch').hide();
	$('#keyword').keyup(getSearch);
	$('#cat').change(getSearch);
	if ($('#pages')) {
		$('#pages a').click(getPage);
	}
});