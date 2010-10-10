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
	$("#resetform").hover(function(){
		if(!$(this).hasClass("hovered")){
			$(this).addClass("hovered");
		}
	},
	function(){
		if($(this).hasClass("hovered")){
			$(this).removeClass("hovered");
		}
	});
	$("#sendpassbtn").hover(function(){
		if(!$(this).hasClass("hovered")){
			$(this).addClass("hovered");
		}
	},
	function(){
		if($(this).hasClass("hovered")){
			$(this).removeClass("hovered");
		}
	});
	$("a.registeruser").hover(function(){
		if(!$(this).hasClass("over")){
			$(this).addClass("over");
		} 
	},
	function(){
		if($(this).hasClass("over")){
			$(this).removeClass("over");
		}
	});
	$("#showresetpass").click(function(){
		$("#resendpass").show();
		return false;
	});
	//Submit login
	$("#loginform").submit(function(){
		var username = $("#pageusername").val().toLowerCase();
		var upassword = $("#pagepassword").val();
		var validEMail = /^[\_]*([a-z0-9]+(\.|\_*)?)+@([a-z][a-z0-9\-]+(\.|\-*\.))+[a-z]{2,6}$/;
		$("#loginerror").hide();
		$("#submitform").addClass("disabled");
		$("#submitform").val("Verifying...");
		$("#submitform").attr("disabled", true);
		if(!validEMail.test(username)){
			$("#submitform").removeClass("disabled");
			$("#submitform").val("Sign in");
			$("#submitform").attr("disabled", false);
			$("#loginerror").show();
			return false;
		}
		if(!upassword){
			$("#submitform").removeClass("disabled");
			$("#submitform").val("Sign in");
			$("#submitform").attr("disabled", false);
			$("#newpass").val(username);
			$("#loginerror").show();
			return false;
		}
		$.jCryption.getKeys("/serverscripts/login.php?generateKeypair=true",function(keys) {
			$.jCryption.encrypt(upassword,keys,function(encrypted) {
				$("#pageencrypted").val(encrypted);
				$.ajax({
					type: "POST",
					url: "/serverscripts/login.php",
					data:({'username':username,
						'password':encrypted,
						'remember':$("#pageremember").attr('checked')?1:0}),
					dataType: "json",
					success: function(response){
						$("#submitform").attr("disabled", false);
						if(response){
							if(response.id != '0'){
								$("#submitform").val("Redirecting");
								if(response.redirect != '0'){
									window.location.replace("http://www.blackbull.in"+ response.redirect);
								}else{
									window.location.replace("http://www.blackbull.in");
								}
							}else{
								$("#submitform").removeClass("disabled");
					        		$("#submitform").val("Sign in");
					        		$("#submitform").attr("disabled", false);
					        		$("#newpass").val(username);
								$("#loginerror").show();
							}
						}else{
							$("#submitform").removeClass("disabled");
					        	$("#submitform").val("Sign in");
					        	$("#submitform").attr("disabled", false);
					        	$("#newpass").val(username);
							$("#loginerror").show();
						}
					},
					error: function(){
					        $("#submitform").removeClass("disabled");
					        $("#submitform").val("Sign in");
					        $("#submitform").attr("disabled", false);
					        $("#newpass").val(username);
						$("#loginerror").show();
					}
				});
			});
		});
		return false;
	});
	$("#resendpass").submit(function(){
		var username = $("#newpass").val().toLowerCase();
		var validEMail = /^[\_]*([a-z0-9]+(\.|\_*)?)+@([a-z][a-z0-9\-]+(\.|\-*\.))+[a-z]{2,6}$/;
		if(!validEMail.test(username)){
			return false;
		}
		$.ajax({
			type:"POST",
			url: "/serverscripts/resetpass.php",
			data:({"id":username}),
			dataType:"json",
			success:function(response){
				if(response){
					if(response.success == "1"){
						$("#login").html("<p>A temporary password is sent to <b>"+response.message+"</b>. Please follow the instructions in e-mail to reset your account password.</p>");
					}else{
						if(response.message == "iderror"){
							$("#login").html("<p>The username is not registered. <a href=\"/users/registration.php\">Sign up</a> if you are a new user.</p>");
						}else{
							$("#login").html("<p>Unable to send temporary password. Please try again after some time.</p>");
						}
					}
				}else{
					$("#login").html("<p>Unable to send temporary password. Please try again after some time.</p>");
				}
			},
			failure:function(){
				$("#login").html("<p>Unable to send temporary password. Please try again after some time.</p>");
			}
		});
		return false;
	});
	
});