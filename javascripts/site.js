$(function() {

/* ====================== Header Functionality Start =========================*/
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
/* ====================== Header Functionality End =========================*/

/* ====================== Login Functionality Start =========================*/

$("#opaque").css('height', $(document).height());
	if (!Modernizr.inputtypes.email) {
		$("username").attr("type","text");
	}
	$("#header_login_nav ul li.limenu").hover(
		function(){
			$(this).addClass("dummy");
	 		$(this).addClass("hovered");
	 	},
	 	function(){
	 		$(this).removeClass("dummy");
			if($("#opaque").hasClass("hide")){
				$(this).removeClass("hovered");
			}
		}
	);
	
	$("#header_login_nav ul li.limenu").click(
		function(){
			if($("#opaque").hasClass("hide")){
				$("#opaque").fadeTo("fast",0.4);
				$("#opaque").removeClass("hide");
			}else{
				return true;
			}
			
			if($(this).hasClass("signin")){
				if( $("div#signin_menu").hasClass("hide")){
					$("div#signin_menu").removeClass("hide");
				}else{
					$("div#signin_menu").addClass("hide");
				}	
			}
			
			if($(this).hasClass("signout")){
				if( $("div#settings_menu").hasClass("hide") ){
					$("div#settings_menu").removeClass("hide");
				}else{
					$("div#settings_menu").addClass("hide");
				}
			}	
		}
	);

	$("#header_login_nav ul li.limenu > a").click(
		function(event){
			event.preventDefault();
		}	
	);
		
	$(document).click(
		function(){
			if(!$("#header_login_nav ul li.limenu").hasClass("dummy")){
				if($("#header_login_nav ul li.limenu").hasClass("signin")){
					if(!$("div#signin_menu").hasClass("hide")){
						$("div#signin_menu").addClass("hide");
					}
				}
				if($("#header_login_nav ul li.limenu").hasClass("signout")){
					if(!$("div#settings_menu").hasClass("hide")){
						$("div#settings_menu").addClass("hide");
					}
				}
			
				if(!$("#opaque").hasClass("hide")){
					$("#opaque").fadeOut("fast");
					$("#opaque").addClass("hide");
					$("#header_login_nav ul li.limenu").removeClass("hovered");
				}
			}
		}
	);

	$("div#settings_menu ul li a.lisignout").click(
		function(event){
			event.preventDefault();
			$.ajax({
				type: "POST",
				url: "/serverscripts/logout.php",
				data:({'uname':$("#uname").val()}),
				success: function(response){
					window.location.replace("http://www.blackbull.in");
				},
				error: function(){
					window.location.replace("http://www.blackbull.in");
				}
			});
		}
	);

	$("#signinfrm").submit(function(){
		/*$("#loginverify").show("slow");*/
		$("div#signin_menu").addClass("hide");
		$("#opaque").fadeOut("fast");
		$("#opaque").addClass("hide");
		$("#header_login_nav ul li.third").removeClass("hovered");
		$("#login_menu").addClass("invisible");
		$("#loadingdiv").fadeIn("slow");
		$.jCryption.getKeys("/serverscripts/login.php?generateKeypair=true",function(keys) {
			$.jCryption.encrypt($("#password").val(),keys,function(encrypted) {
				$("#encrypted").val(encrypted);
				$.ajax({
					type: "POST",
					url: "/serverscripts/login.php",
					data:({'username':$("#username").val(),
						'password':$("#encrypted").val()}),
					dataType: "json",
					success: function(response){
						if(response.id != '0'){
							$("#username").val('');
							$("#password").val('');
							$("#uname").html(response.id);
							$("#loadingdiv").hide();
							$("#logout_menu").removeClass("invisible");
							if(response.redirect != '0'){
								window.location.replace("http://www.blackbull.in"+ response.redirect);
							}
							// Enable editing if user has admin rights
							if(response.admin=="1"){
								$("article#news section.bbnews").attr("contenteditable","true");
								$("#lisave").show();
								$("#lipreview").show();
							}
						}else{
							$("#loadingdiv").hide();
							$("#login_menu").removeClass("invisible");
						}
						$("#username").attr("disabled",false);
						$("#password").attr("disabled",false);
					},
					error: function(){
					        $("#loadingdiv").hide();
						$("#login_menu").removeClass("invisible");
					}
				});
			});
		});
		return false;
	});
/* ====================== Login Functionality End =========================*/  	
});