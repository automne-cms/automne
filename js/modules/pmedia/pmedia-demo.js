$(document).ready(function(){
	var search = function  () {
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
		//set form values if needed
		if (this.url.indexOf('cat=') !== -1) {
			var cat = parseInt(this.url.substr(this.url.indexOf('cat=') + 4));
			if (!isNaN(cat) && $('#cat').val() != cat) {
				$('#cat').val(cat);
				$('#keyword').val('');
			}
		}
		if (xmlcontent.getElementsByTagName('data').length > 0) {
			$('#searchresult').html(xmlcontent.getElementsByTagName('data').item(0).firstChild.nodeValue);
			catchResults();
		}
		return true;
	}
	var catchResults = function() {
		//hide all content except first one
		$("#searchresult div.mediaContent").hide();
		$("#searchresult div.mediaContent").eq(0).slideToggle("slow");
		if ($('#pages')) {
			$('#pages a').click(getPage);
		}
		$("#searchresult a[rel='search']").click(getPage);
		$("#searchresult h2").click(function(e){
			$(e.target).nextAll('.mediaContent').slideToggle("slow");
		});
		$("#content .searchresult h2").click(function(e){
			$(e.target).nextAll('.mediaContent').slideToggle("slow");
		});
		
	}
	$("#loadingSearch").ajaxStart(function(){
		$(this).show();
	});
	$("#loadingSearch").ajaxStop(function(){
		$(this).hide();
	});
	$('#submitSearch').hide();
	$('#keyword').keyup(search);
	$('#cat').change(search);
	catchResults();
});