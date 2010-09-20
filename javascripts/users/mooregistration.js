// JavaScript Document
window.addEvent('domready',function() {
	
	new Tips($$('label.tip'));
	
	$('bb_id').addEvent('blur', verifyid);
	$('bb_id').addEvent('focus', hideerr);
	$('bb_code').addEvent('blur', verifycode);
	$('bb_code').addEvent('focus', hidecodeerr);
	$('bb_psw').addEvent('blur', verifypwd);
	$('bb_psw').addEvent('focus', hidepsw);
	$('bb_rpsw').addEvent('blur', verifypwd);
	$('bb_rpsw').addEvent('focus', hidepsw);
	$('ref_cap').addEvent('click', loadCAPTCHA);
	$('bb_fname').addEvent('blur', hideemptyerr);
	$('bb_lname').addEvent('blur', hideemptyerr);
	$('reg_form').reset();
	loadCAPTCHA();
	$('reg_form').addEvent('submit', function(e) {
		e.stop();
                var resend_id = $('bb_id').value;
		if($('bb_terms').value != "on"){
			alert("You must agree to the terms and conditions");
			return;
		}
		$$('input.IsEmpty').each(function(ele){
			if(ele.value == ""){
				$('form_success').value = "0";
				if(!ele.hasClass('error')){
					ele.addClass('error');
					ele.setStyle('border','1px solid #FBC2C4');
				}
			}else if(ele.hasClass('error')){
                                $('form_success').value = "0";
                        }
		});
                verifypwd();
                verifycode();
		if($('form_success').value == "0"){
			alert("Fill all the mandatary fields and submit again.");
			return;
		}
		this.set('send', {onComplete: function(response) {		   
			//response handler
			if(response == "db" || response == "mail"){
				//show error page
				$('form_box').set('html',"<h2 class='errorText'>Registration Failed</h2><p>We are sorry. An error occured during registration. Try to register after some time. If the problem persists, contact <a href='mailto:support@blackbull.in'>support@blackbull.in</a> for further assistance</p>");
			}else if(response == "idexists"){
                                //show error page
				$('form_box').set('html',"<h2 class='errorText'>E-mail Exists</h2><p>The e-mail address that you entered has already been registered. If you have forgotten your password, visit <a href='resetpass.php'>Forgot Password</a> link</p>");
                        }else if(response == "pendingid"){
                                //show error page
				$('form_box').set('html',"<h2 class='errorText'>Pending Registration</h2><p>The e-mail that you entered has been registered but not activated. Check your inbox for the activation mail received from <b>support@blackbull.in</b></p><p>Click <a id='resend' href='#'>resend activation key</a> to get a new activation key</p><p><form><input type='hidden' id='bb_id' value='"+resend_id+"'/></form></p>");
                        $('resend').addEvent('click', resendid);
                        }else{
				//show success page
				$('form_box').set('html',"<h2 class='successText'>Registration Successful</h2><p>An activation mail has been sent to your email address:&nbsp;<b>"+response+"</b>.&nbsp;Kindly activate your account within 10 days.</p><p> This email is auto-sent from <b>support@blackbull.in</b></p>");
			}
			$('form_box').setStyle('margin-bottom','200px');
			this.reset();
		},
		onRequest: function(){
			$('form_box').set('html',"<p style='margin-bottom:100px;font-weight:bold'>Please wait...</p>");
		}});
		this.send();
	});
	$('bb_id').addEvent('onblur', verifyid);
});

function loadCAPTCHA(){
	var cap = $random(1,10);
	var captcha = getCap(cap);
	$('cap1').setStyle('background-position', '0 ' + cap*22 + 'px');
	cap = $random(1,10);
	captcha = captcha + getCap(cap);
	
	$('cap2').setStyle('background-position', '0 ' + cap*22 + 'px');
	cap = $random(1,10);
	captcha = captcha + getCap(cap);
	
	$('cap3').setStyle('background-position', '0 ' + cap*22 + 'px');
	cap = $random(1,10);
	captcha = captcha + getCap(cap);
	
	$('cap4').setStyle('background-position', '0 ' + cap*22 + 'px');
	$('bb_code_hidden').value = captcha;
	return captcha;
}

function getCap(cap){
	if(cap==1){
		return '5';
	}
	if(cap==2){
		return '3';
	}
	if(cap==3){
		return '7';
	}
	if(cap==4){
		return '9';
	}
	if(cap==5){
		return '8';
	}
	if(cap==6){
		return '6';
	}
	if(cap==7){
		return '4';
	}
	if(cap==8){
		return '1';
	}
	if(cap==9){
		return '0';
	}
	if(cap==10){
		return '2';
	}
}

function verifyid(){

        var log = $('id_error');
	var showerr = new Fx.Tween(log);
	if($('bb_id').value == ""){
		return;
	}
        if(!$('bb_id').value.test("^[\_]*([a-z0-9]+(\.|\_*)?)+@([a-z][a-z0-9\-]+(\.|\-*\.))+[a-z]{2,6}$")){
            $('id_error').set('html',"&nbsp;E-mail address is invalid");
            $('bb_id').addClass("error");
	    $('bb_id').setStyle('border','1px solid #FBC2C4');
            if($('id_error').hasClass('successText')){
		$('id_error').removeClass('successText');
	    }
	    if(!$('id_error').hasClass('errorText')){
		$('id_error').addClass('errorText');
	    }
            $('form_success').value = "0";
	    showerr.start('opacity', 1);
            return;
        }
	var idRequest = new Request({url: '/serverscripts/verifyid.php', method: 'post', onSuccess: function(responseText, responseXML) {																									 
		if(responseText == "0"){
			$('form_success').value = "1";
			$('id_error').set('html',"&nbsp;E-mail validation is successful");
			if($('id_error').hasClass('errorText')){
				$('id_error').removeClass('errorText');
			}
			if(!$('id_error').hasClass('successText')){
				$('id_error').addClass('successText');
			}
		}
		if(responseText == "1"){
			//email already exisits
			$('form_success').value = "0";
			log.set('html', "&nbsp;This email is already registered.&nbsp;<a href='resetpass.php'>reset password?</a>");
			$('bb_id').addClass("error");
			$('bb_id').setStyle('border','1px solid #FBC2C4');
			if($('id_error').hasClass('successText')){
				$('id_error').removeClass('successText');
			}
			if(!$('id_error').hasClass('errorText')){
				$('id_error').addClass('errorText');
			}
			showerr.start('opacity', 1);
		}
		if(responseText == "2"){
			//internal server error
			log.set('html', "Unable to verify e-mail");		
		}
		if(responseText == "3"){
			//email pending activation
			$('form_success').value = "0";
			log.set('html', "&nbsp;Email activation is pending.&nbsp;<a id='resend' href='#'>resend activation key?</a>");
                        $('resend').addEvent('click', resendid);
			$('bb_id').addClass("error");
			$('bb_id').setStyle('border','1px solid #FBC2C4');
			if($('id_error').hasClass('successText')){
				$('id_error').removeClass('successText');
			}
			if(!$('id_error').hasClass('errorText')){
				$('id_error').addClass('errorText');
			}
			showerr.start('opacity', 1);		
		}
		
}});
	$('id_error').set('html',"&nbsp;Verifying e-mail...");
	showerr.start('opacity', 1);
	idRequest.send('id='+ $('bb_id').value);
}

function resendid(e) {
     if(e) e.stop();
     if($('bb_id').value == ""){
		return;
     }
     var req = new Request({
			method: 'get',
			url: 'serverscripts/resendkey.php',
			data: { 'resend' : $('bb_id').value},
			onRequest: function() {return false;},
			onComplete: function(response) {
				if(response != 'resendid'){
                                      $('form_box').set('html',"<p>An activation mail has been sent to your email address:&nbsp;<b>"+response+"</b>.&nbsp;Kindly activate your account within 10 days.</p><p> This email is auto-sent from <b>support@blackbull.in</b>");
                                $('form_box').setStyle('margin-bottom','200px');  
				}else{
                                   $('form_box').set('html',"<p>We are sorry. An Error occurred while sending the new activation key. Contact <b><a href='mailto:support@blackbull.in'>support@blackbull.in</a></b> for assistance.");
                                $('form_box').setStyle('margin-bottom','200px');     
                                }
			}
		}).send();   
}

function hideerr(){
	var showerr = new Fx.Tween($('id_error'));
	$('form_success').value = "1";
	$('bb_id').removeClass("error");
	$('bb_id').setStyle('border','1px solid #DDDDDD');
	$('id_error').set('html', "");
	showerr.start('opacity', 0);
	
}

function hidecodeerr(){
	var showerr = new Fx.Tween($('code_error'));
	$('form_success').value = "1";
	$('code_error').set('html', "");
	$('bb_code').removeClass("error");
	$('bb_code').setStyle('border','1px solid #DDDDDD');
	showerr.start('opacity', 0);
}

function verifycode(){
	if($('bb_code').value == ""){
		return;
	}
	if($('bb_code').value != $('bb_code_hidden').value){
		var showerr = new Fx.Tween($('code_error'));
		$('form_success').value = "0";
		$('code_error').set('html', "&nbsp;Incorrect code");
		$('bb_code').addClass("error");
		$('bb_code').setStyle('border','1px solid #FBC2C4');
		showerr.start('opacity', 1);
	}
}

function verifypwd(){
	if($('bb_psw').value == ""){
		return;
	}
	if($('bb_rpsw').value == ""){
		return;
	}
	if($('bb_rpsw').value != $('bb_psw').value){
		var showerr = new Fx.Tween($('rpsw_error'));
		$('form_success').value = "0";
		$('rpsw_error').set('html', "&nbsp;Passwords do not match");
		$('bb_rpsw').addClass("error");
		$('bb_rpsw').setStyle('border','1px solid #FBC2C4');
		showerr.start('opacity', 1);
	}else{
		if($('bb_psw').value.length <6 || $('bb_psw').value.length > 16){
			var showerr = new Fx.Tween($('psw_error'));
			$('form_success').value = "0";
			$('psw_error').set('html', "&nbsp;Password must be between 6 and 16 characters");
			$('bb_psw').addClass("error");
			$('bb_psw').setStyle('border','1px solid #FBC2C4');
			showerr.start('opacity', 1);
		}
	}
}

function hidepsw(){
	var showerr = new Fx.Tween($('psw_error'));
	$('form_success').value = "1";
	$('psw_error').set('html', "");
	$('rpsw_error').set('html', "");
	$('bb_rpsw').removeClass("error");
	$('bb_rpsw').setStyle('border','1px solid #DDDDDD');
	$('bb_psw').removeClass("error");
	$('bb_psw').setStyle('border','1px solid #DDDDDD');
	showerr.start('opacity', 0);
}

function hideemptyerr(){
	if(this.value.length > 0){
		$('form_success').value = "1";
		if(this.hasClass('error')){
			this.removeClass('error');
			this.setStyle('border','1px solid #DDDDDD');
		}
	}
}