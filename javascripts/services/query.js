$(function(){
        var sending = false;
	var postid = jQuery.url.param("id");
	
	$("#postquerybtn").hover(function(){
		if(!$(this).hasClass("hovered")){
			$(this).addClass("hovered");
		}
	},
	function(){
		if($(this).hasClass("hovered")){
			$(this).removeClass("hovered");
		}
	});
	
	$.ajax({
		type:"GET",
		url:"../serverscripts/getQA.php",
		dataType:"json",
		data:({"id": postid}),
		success:function(response){
			if(response.error != "0"){
				// Error handling
				return false;
			}
			var isopen = response.isopen;
			var total = response.total;
			var html_content = "<div id='qn_id' rel='"+ response.qid +"' class='qn_holder'>";
			if(response.private == "0"){
				html_content = html_content + "<div class='qn_head'><span class='res_type'>q :</span><span class='qn_owner'>"+ response.qowner +" says:</span><span class='qn_date'>on ";
			}else{
				html_content = html_content + "<div class='qn_head'><span class='res_type'>q :</span><span class='qn_owner'>Anonymous says:</span><span class='qn_date'>on ";
			}
			html_content = html_content + $.format.date(response.qdate, "dd/MM/yyyy hh:mm a") + "</span></div>";
			html_content = html_content + "<div class='qn_body'><p>"+ response.question + "</p></div></div>";
			$("#question").html(html_content);
			var answers_content = "";
			var answers=0;
			for(answers=0; answers < total; answers++){
				answers_content = answers_content + "<div id='a"+ response.answers[answers].a_id +"' class='ans_holder'>";
				if(response.answers[answers].private == "0"){
					answers_content = answers_content + "<div class='ans_head'><span class='res_type'>a :</span><span class='ans_owner'>"+ response.answers[answers].owner +" says:</span><span class='ans_date'>on ";
				}else{
					answers_content = answers_content + "<div class='ans_head'><span class='res_type'>a :</span><span class='ans_owner'>Anonymous says:</span><span class='ans_date'>on ";
				}
				answers_content = answers_content + $.format.date(response.answers[answers].date, "dd/MM/yyyy hh:mm a") + "</span></div>";
				answers_content = answers_content + "<div class='ans_body'><p>"+ response.answers[answers].text + "</p></div></div>";
			}
			if( total == 0 && isopen == "1"){
				$("#answers").html("<p class='noanswer'>There are no answers to this question. Be the first one to answer.</p>");
				$("#answers").attr('rel',"0");
			}else{
				$("#answers").html(answers_content);
				$("#answers").attr('rel',"1");
			}
		},
		failure:function(){
			$("#question").html("<p>Unable to get details&hellip;</p>");
		}
	});
	$("#newpostform").submit(function(){
		var querytext = $("#querytext").val();
		var ownername =  $("#ownername").val();
		var qid = $("#qn_id").attr('rel');
		var isprivate = $("#privatepost").attr('checked')?1:0;
		$.ajax({
			type:"POST",
			url:"../serverscripts/addnewans.php",
			dataType:"json",
			data:({"text" : querytext,
                               "private" : isprivate,
                               "open" : "1",
                               "owner" : ownername,
                               "id" : qid}),
                        beforeSend: function(){
				if(sending || querytext.length < 5){
					return false;
				}else{
					sending = true;
					$("#postquerybtn").val("Please wait...");
					$("#postquerybtn").attr("disabled", "1");
				}
				return true;
			},
			success: function(response){
				if(response.error !="0"){
					return false;
				}
				var answers_content = "";
				answers_content = answers_content + "<div id='a"+ response.answer.a_id +"' class='ans_holder'>";
				if(response.answer.private == "0"){
					answers_content = answers_content + "<div class='ans_head'><span class='res_type'>a :</span><span class='ans_owner'>"+ response.answer.owner +" says:</span><span class='ans_date'>on ";
				}else{
					answers_content = answers_content + "<div class='ans_head'><span class='res_type'>a :</span><span class='ans_owner'>Anonymous says:</span><span class='ans_date'>on ";
				}
				answers_content = answers_content + $.format.date(response.answer.date, "dd/MM/yyyy hh:mm a") + "</span></div>";
				answers_content = answers_content + "<div class='ans_body'><p>"+ response.answer.text + "</p></div></div>";
				if($("#answers").attr('rel') == "0"){
					$("#answers").html(answers_content);
					$("#answers").attr('rel',"1");
				}else{
					$("#answers").html(answers_content + $("#answers").html());
				}
				$('#formresult').html("<p><b>The post has been successfully submitted!. Click here to add a <a id='anotherpost' href='#'>new post</a></b></p>");
				$("#anotherpost").click(function(){
					$("#formresult").hide();
					$("#formresult").html("");
					$("#querytext").val("");
					$("#privatepost").checked = false;
					$("#postquerybtn").val("Submit query");
					$("#postquerybtn").removeAttr("disabled");
					$("#postquery").show();
				});
				$("#postquery").hide();
				$('#formresult').show();
			},
			failure: function(){
				$('#formresult').html("<p class='failure'><b>There was an error in posting your query.</b></p>");
			}
		});
		return false;
	});
});