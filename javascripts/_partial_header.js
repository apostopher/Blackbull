$(document).ready(function() {
	$("li.menuitem").hover(
		function(){
			ele = $(this);
			// Hide the small arrow below menu item
			if(!ele.children("span.arrow").hasClass("invisible")){
				ele.children("span.arrow").addClass("invisible");
			}
			// Open the submenu
			ele.stop(false,true).animate({
				color:"#000",
				backgroundColor:"#FFF"}, "fast");
			ele.children(".submenu").stop(false,true).fadeIn("fast");
		},
		function(){
			ele = $(this);
			if(ele.children("span.arrow").hasClass("invisible")){
				ele.children("span.arrow").removeClass("invisible");
			}
			ele.stop(false,true).animate({
				color:"#FFF",
				backgroundColor:"#242b3b"}, "fast");
			ele.children(".submenu").stop(false,true).fadeOut("fast");
       
	});

	// Change the H6 color to orange when hovered
	$("ul.submenu li").hover(
		function(){
			ele = $(this);
			ele.css("backgroundColor", "#F3F6FA");
			ele.find("h6").css("color","#fe581a");
		},
		function(){
			ele = $(this);
			ele.stop(false,true).animate({backgroundColor:"#FFF"}, "fast");
			ele.find("h6").stop(false,true).animate({
				color:"#4575B4"}, "fast");
     	});
});