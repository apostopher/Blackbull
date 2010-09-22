$(function(){
	$("#submitform").hover(function(){
		if(!$(this).hasClass("hovered")){
			$(this).addClass("hovered");
		}
	},
	function(){
		if($(this).hasClass("hovered")){
			$(this).removeClass("hovered");
		}
	});
	$("email").focus(function(){
		if($("#emailresult").hasClass("error")){
			$("#emailresult").removeClass("error");
		}
		$("#emailresult").html("Your e-mail is your <b>USERNAME</b>.");
	});
	$("#upassword").focus(function(){
		$("#passresult").html("&nbsp;");
	});
	$("#upassword").tooltip({ position: "center right", effect:"toggle"});
	
	$("#setnewpassform").submit(function(){
		var validEMail = /^[\_]*([a-z0-9]+(\.|\_*)?)+@([a-z][a-z0-9\-]+(\.|\-*\.))+[a-z]{2,6}$/;
		var username = $("#email").val().toLowerCase();
		var tpassword = $("#tpassword").val();
		var upassword = $("#upassword").val();
		var rpassword = $("#repassword").val();
		if(!validEMail.test(username)){
			if(!$("#emailresult").hasClass("error")){
				$("#emailresult").addClass("error");
			}
			$("#emailresult").html("Invalid e-mail address.");
			return false;
		}
		if(upassword != rpassword){
			$("#passresult").html("Passwords do not match.");
			return false;
		}
		if(upassword.length > 16 || upassword.length < 1){
			upassword.focus();
			return false;
		}
		$.ajax({
			type:"POST",
			url:"/serverscripts/setnewpass.php",
			data:({"id":username,
				"tpassword":tpassword,
				"upassword":upassword}),
			success: function(response){
				if(response == "success"){
					$("#resetpassword").html("<p>Your password has been changed successfully. You may now login with your new password.</p>");
				}else{
					$("#resetpassword").html("<p>Change Password Failed. We are sorry. An error occured during the process. Try to change your password after some time. If the problem persists, contact <a href='mailto:support@blackbull.in'>support@blackbull.in</a> for further assistance</p>");	
				}
			},
			failure: function(){
			}
		});
		return false;
	});

});