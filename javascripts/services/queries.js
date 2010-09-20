$(function(){
	var sending = false;
	getPosts();
	$("#tip").hover(function(){
		$("#privatetip").show();
	},
	function(){
		$("#privatetip").hide();
	});
	$("#querytext").keyup(function(){
		var length = $(this).val().length;
		charsleft = 500 - length;
		$("#charcount").html(charsleft);
	});
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
	$("#newpostform").submit(function(){
		$.ajax({
			type:"POST",
			url:"../serverscripts/addnewpost.php",
			dataType:"json",
			data:({"text": $("#querytext").val(),
				"private": $("#privatepost").checked,
				"owner" : $("#ownername").val()}),
			beforeSend: function(){
				if(sending){
					return false;
				}else{
					sending = true;
					$("#postquerybtn").val("Please wait...");
					$("#postquerybtn").attr("disabled", "1");
				}
				return true;
			},
			success: function(response){
				if(response.error == "0"){
					var html_content = "";
					html_content = html_content + "<tr id='p" + response.posts[0].id + "'>";
					html_content = html_content + "<td class='qquestion'><a class='ellipsis' href='/services/query.php?id="+ response.posts[0].id +"'><span class='posttext'>" + response.posts[count].text + "</span></a></td>";
					html_content = html_content + "<td class='qreply'>" + response.posts[0].replies + "</td>";
					if(response.posts[0].private == "0"){
						html_content = html_content + "<td class='qowner'>"+ response.posts[0].owner + "</td>";
					}else{
						html_content = html_content + "<td class='qowner'>anonymous</td>";
					}
					html_content = html_content + "<td class='qlastreply'>" + $.format.date(response.posts[0].date, "dd/MM/yyyy hh:mm a") + "</td></tr>";
					$("#queries_tbody").html(html_content + $("#queries_tbody").html());
					$(".ellipsis").ThreeDots({ max_rows:2,text_span_class: 'posttext' });
					// Hide the add post form.
					$("#postquerybtn").val("Post");
					$("formresult").html("<p>The post has been successfully submitted!. Click here to add a <a id='anotherpost' href='#'>new post</a></p>");
					$("#postquery").hide();
					$("#anotherpost").click(function(){
						$("#postquery").show();
						$("#formresult").hide();
						$("#formresult").html("");
						$("#querytext").val("");
						$("#privatepost").checked = false;
						$("#postquerybtn").val("Submit query");
						$("#postquerybtn").removeAttr("disabled");
					});
					sending = false;
                            		$("#formresult").show();
				}else{
					sending = false;
				}
			},
			failure: function(){
			}
		});
		return false;
	});
});

function getPosts(){
	$.ajax({
		type:"GET",
		url:"../serverscripts/getposts.php",
		dataType:"json",
		success: function(response){
			var html_content = "";
			for(count=0; count < response.total ; count++){
				html_content = html_content + "<tr id='p" + response.posts[count].id + "'>";
                                html_content = html_content + "<td class='qquestion'><a class='ellipsis' href='/services/query.php?id="+ response.posts[count].id +"'><span class='posttext'>" + response.posts[count].text + "</span></a></td>";
                                html_content = html_content + "<td class='qreply'>" + response.posts[count].replies + "</td>";
                                if(response.posts[count].private == "0"){
                                      html_content = html_content + "<td class='qowner'>"+ response.posts[count].owner + "</td>";
                                }else{
                                      html_content = html_content + "<td class='qowner'>anonymous</td>";
                                }
                                html_content = html_content + "<td class='qlastreply'>" + $.format.date(response.posts[count].date, "dd/MM/yyyy hh:mm a") + "</td></tr>";
			}
			$("#queries_tbody").html(html_content);
			$(".ellipsis").ThreeDots({ max_rows:2,text_span_class: 'posttext' });
			// Add hover effect to rows #FDFFCE
			$("#queries_tbody tr").hover(function(){
				$(this).css({"backgroundColor":"#FDFFCE"});
			},
			function(){
				$(this).css({"backgroundColor":"#FFF"});
			});

		},
		failure: function(){}
	});
}