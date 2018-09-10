
var slick_started = false;

function get_category(catid) {
	$.each($("#small-categories a div"),function(index,value){
		$(value).removeClass("selected");
	});
	$("#cat-"+catid).addClass("selected");
	$.ajax({
		dataType: "json",
		url: "/galleryajax?catid="+catid,
		success: function(data) {
			setimgs(data);
		}
	}).done( function(data) {
	});
}

function setimgs(data) {
	if (slick_started) {
		$("#carousel").slick("unslick");
	}
	$("#carousel").html("");
	for (var i=0; i<data.length; i++) {
		var title = data[i]["title"];
		var smallpath = data[i]["smallpath"];
		var bigpath = data[i]["bigpath"];
		var img = "<div style=\"background-image:url("+smallpath+");\" onclick=\"javascript:lightbox_single('"+bigpath+"');return false;\"><h4>"+title+"</h4></div>\n";
		$("#carousel").append(img);
	}
	$("#carousel").slick({
		adaptiveHeight: true,
		prevArrow: $("#gallery-prev"),
		nextArrow: $("#gallery-next")
	});
	slick_started = true;
}

$(document).ready(function() {
	$(".button-txt").mouseover(function() {
		$(this).animate({opacity:'0.5'})
		.promise()
		.done(function(){
			$(this).animate({opacity:'1'})
		});
	});
});

function close_lightbox() {
	$("#lightbox-scroller").remove();
	$("#lightbox-layover").remove();
}

function lightbox_single(path) {
	var HTML = "<div id='lightbox-layover' onclick='javascript:close_lightbox();return false;'></div>\n";
	HTML += "<div id='lightbox-scroller' onclick='javascript:close_lightbox();return false;'><img src='"+path+"' onclick='javascript:close_lightbox();return false;' /></div>\n";
	$(document.body).append(HTML);
}

