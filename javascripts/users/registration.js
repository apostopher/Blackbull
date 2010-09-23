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
	$("#captchaSubmit").hover(function(){
		if(!$(this).hasClass("hovered")){
			$(this).addClass("hovered");
		}
	},
	function(){
		if($(this).hasClass("hovered")){
			$(this).removeClass("hovered");
		}
	});
	
	$("#email").tooltip({ position: "center right", effect:"toggle"});
	$("#upassword").tooltip({ position: "center right", effect:"toggle"});
	
	$("#lastname").focus(function(){
		var lastnameresult = $("#lastnameresult");
		if(lastnameresult.hasClass("error")){
			lastnameresult.removeClass("error");
		}
		lastnameresult.html("&nbsp;");
	});
	
	$("#firstname").focus(function(){
		var firstnameresult = $("#firstnameresult");
		if(firstnameresult.hasClass("error")){
			firstnameresult.removeClass("error");
		}
		firstnameresult.html("Your screen name on blackbull.");
	});
	
	$("#email").focus(function(){
		var emailresult = $("#emailresult");
		if(emailresult.hasClass("error")){
			emailresult.removeClass("error");
		}
		emailresult.html("Your e-mail will be your <b>USERNAME</b>.");
	});
	
	$("#upassword").focus(function(){
		var passresult = $("#passresult");
		if(passresult.hasClass("error")){
			passresult.removeClass("error");
		}
		passresult.html("&nbsp;");
	});
	
	$("#repassword").focus(function(){
		$("#passresult").html("&nbsp;");
	});
	
	// Registration form submission
	$("#registrationform").submit(function(){
		// Validate all user inputs
		var fname = jQuery.trim($("#firstname").val());
		var lname = jQuery.trim($("#lastname").val());
		var email = jQuery.trim($("#email").val());
		var pwd = jQuery.trim($("#upassword").val());
		var repwd = jQuery.trim($("#repassword").val());
		var firstnameresult = $("#firstnameresult");
		var lastnameresult = $("#lastnameresult");
		var formsuccess = true;
		
		if(!fname){
			if(!firstnameresult.hasClass("error")){
				firstnameresult.addClass("error");
			}
			firstnameresult.html("First name is mandatory.");
			formsuccess = false;
		}
		if(!lname){
			if(!lastnameresult.hasClass("error")){
				lastnameresult.addClass("error");
			}
			lastnameresult.html("Last name is mandatory.");
			formsuccess = false;
		}
		if(!email){
			var emailresult = $("#emailresult");
			if(!emailresult.hasClass("error")){
				emailresult.addClass("error");
			}
			emailresult.html("E-mail is mandatory.");
			formsuccess = false;
		}
		if(!pwd){
			var passresult = $("#passresult");
			if(!passresult.hasClass("error")){
				passresult.addClass("error");
			}
			passresult.html("Password is mandatory.");
			formsuccess = false;
		}
		if(!repwd){
			formsuccess = false;
		}
		if(pwd != repwd){
			$("#passresult").html("Passwords do not match.");
			formsuccess = false;
		}
		if($("#emailverify").val() == "0"){
			formsuccess = false;
		}
		if(formsuccess == true){
			Recaptcha.create("6LdNJ70SAAAAAArTCag4zONUTF9wvyd99qj5Km0F","verifyhuman",{theme: "custom",callback: showCaptcha});
		}		
		return false;
	});
	
	$("#captchaSubmit").click(function(){
		var challenge = Recaptcha.get_challenge();
		var userinput = Recaptcha.get_response();
		$.ajax({
			type:"POST",
			url:"../serverscripts/register.php",
			data:({"challenge":challenge,
				"userinput":userinput,
				"fname":$("#firstname").val(),
				"lname":$("#lastname").val(),
				"email":$("#email").val().toLowerCase(),
				"password":$("#upassword").val()}),
			dataType:"json",
			beforeSend:function(){
				$("#captcharesult").html("Please wait&hellip;");
				return true;
			},
			success: function(response){
				var humandiv = $("div#captchaholder");
				if(!response){
					humandiv.hide();
					$("#registration").html("<h1>Registration Failed</h1><p>We are sorry. An error occured during registration. Try to register after some time. If the problem persists, contact <a href='mailto:support@blackbull.in'>support@blackbull.in</a> for further assistance.</p>");
					return false;
				}
				if(response.status == "success"){
					humandiv.hide();
					$("#registration").html("<h1>Registration successful!</h1><p>An activation mail has been sent to your email address:&nbsp;<b>"+response.email+"</b>.&nbsp;Kindly activate your account within 10 days.</p>");
				}else if(response.status == "captchafailed"){
					Recaptcha.create("6LdNJ70SAAAAAArTCag4zONUTF9wvyd99qj5Km0F","verifyhuman",{theme: "custom"});
					$("#captcharesult").html("Please try to match the 2 words shown above.");
				}else if(response.status == "idexists"){
					$("#registration").html("<h1>Registration Failed</h1><p>This e-mail address is already registered. <a href=\"/users/login.php?forgot=true\">Click here</a> if you have lost your password.</p>");
				}else if(response.status == "pending"){
					$("#registration").html("<h1>Registration Failed</h1><p>This e-mail address is already registered but not activated. The activation key was sent to this e-mail address. <a id=\"resendid\" href=\"#\">Click here</a> if you want to receive a new activation key</p><span id=\"activationResult\">&nbsp;</span>");
					var resultspan = $("#activationResult");
					$("a#resendid").bind("click",{resultspan:resultspan, emailid:response.id}, resendid);
				}else{
					humandiv.hide();
					$("#registration").html("<h1>Registration Failed</h1><p>We are sorry. An error occured during registration. Try to register after some time. If the problem persists, contact <a href='mailto:support@blackbull.in'>support@blackbull.in</a> for further assistance.</p>");
				}
			},
			failure: function(){
				Recaptcha.create("6LdNJ70SAAAAAArTCag4zONUTF9wvyd99qj5Km0F","verifyhuman",{theme: "custom"});
			}
			});
		return false;
	});
	
	// Verify the username availability before submitting
	$("input#email").blur(function(){
		var status = true;
		var message;
		var resultspan = $("#emailresult");
		var verifyinput = $("#emailverify");
		
		if(resultspan.hasClass("error")){
			resultspan.removeClass("error");
		}
		if(resultspan.hasClass("success")){
			resultspan.removeClass("success");
		}
		if($(this).val()){
			var validEMail = /^[\_]*([a-z0-9]+(\.|\_*)?)+@([a-z][a-z0-9\-]+(\.|\-*\.))+[a-z]{2,6}$/;
			if(!validEMail.test($(this).val().toLowerCase())){
				if(!resultspan.hasClass("error")){
					resultspan.addClass("error");
				}
				resultspan.html("Invalid e-mail.");
				verifyinput.val("0");
				return false;
			}
			verifyinput.val("1");
			resultspan.html("Verifying availability&hellip;");
			$.ajax({
				type:"GET",
				url:"../serverscripts/verifyid.php",
				data:({"id":$(this).val()}),
				dataType:"json",
				success: function(response){
					if(response.error == "1"){
						if(response.type == "db"){
							message = "Registration failed.";
						}else if(response.type == "idexists"){
							// duplicate entry
							message = "Username is unavailable.";
						}else if(response.type == "pendingid"){
							// Confirmation is pending
							message = "Pending confirmation. <a id=\"resendid\" href=\"#\">Resend key?</a>";
						}
						if(!resultspan.hasClass("error")){
							resultspan.addClass("error");
						}
						verifyinput.val("0");
					}else{
						if(!resultspan.hasClass("success")){
							resultspan.addClass("success");
						}
						verifyinput.val("1");
						message = "Available.";
					}
					resultspan.html(message);
					$("a#resendid").bind("click",{resultspan:resultspan, emailid:response.id}, resendid);
				},
				failure: function(){
					if(!resultspan.hasClass("error")){
						resultspan.addClass("error");
					}
					verifyinput.val("0");
					resultspan.html("Verification failed.");
				}
			});
		}else{
			verifyinput.val("0");
			resultspan.html("Your e-mail will be your <b>USERNAME</b>.");
		}
		return true;
	});
	$("#closePopup").click(function(){
		var humandiv = $("div#captchaholder");
		humandiv.hide();
		Recaptcha.destroy();
		return false;
	});
	
});

function showCaptcha(){
	var humandiv = $("div#captchaholder");
	humandiv.css({"margin-left":"-"+ Math.round(humandiv.width()/2 + 6) + "px", "margin-top":"-"+ Math.round(humandiv.height()/2 + 6) + "px"});
	humandiv.show();
}

function resendid(event){
	var emailid = event.data.emailid;
	var resultspan= event.data.resultspan;
	$.ajax({
		type:"GET",
		url:"../serverscripts/resendkey.php",
		dataType:"json",
		data:({"resend":emailid}),
		beforeSend:function(){
			resultspan.html("Sending a new activation key.");
		},
		success: function(result){
			if(result){
				if(result.success == "1"){
					$("#registration").html("<p>A new activation code has been sent to " + emailid + ". Kindly activate your account within 10 days.</p>");
				}else{
					if(!resultspan.hasClass("error")){
						resultspan.addClass("error");
					}
					resultspan.html("Failed to send new key.");
				}
			}else{
				if(!resultspan.hasClass("error")){
					resultspan.addClass("error");
				}
				resultspan.html("Failed to send new key.");
			}
		},
		failure: function(){
			if(!resultspan.hasClass("error")){
				resultspan.addClass("error");
			}
			resultspan.html("Failed to send new key.");
		}
	});
	return false;
}