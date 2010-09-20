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
	
	$("#setnewpassform").submit(function(){
		var validEMail = /^[\_]*([a-z0-9]+(\.|\_*)?)+@([a-z][a-z0-9\-]+(\.|\-*\.))+[a-z]{2,6}$/;
		var username = $("#email").val();
		var tpassword = $("#tpassword").val();
		var upassword = $("#upassword").val();
		var rpassword = $("#repassword").val();
		if(!validEMail.test(username)){
			return false;
		}
		if(upassword != rpassword){
			$("#passresult").html("Passwords do not match.");
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