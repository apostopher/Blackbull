// Clear the local storage
localStorage.clear();
$("#previewdigest").click(function(){
	var news1 = localStorage.getItem("news1");
	var news2 = localStorage.getItem("news2");
	$.ajax({
		type:"POST",
		url: "serverscripts/dailydigest.php",
		data:({'news1':news1,'news2':news2,'preview':'1'}),
		dataType: "json",
		success: function(response){
			if(response.success == "1"){
				if(response.news1 != "null"){
					$("#news1").html(response.news1);
				}
				if(response.news2 != "null"){
					$("#news2").html(response.news2);
				}
				}else{
					alert("Preview failed...");
				}
			},
		error: function(){
			alert("Preview failed...");
		}
	});
	return false;
});

$("#savedigest").click(function(){
	var news1 = localStorage.getItem("news1");
	var news2 = localStorage.getItem("news2");
	$.ajax({
		type:"POST",
		url: "serverscripts/dailydigest.php",
		data:({'news1':news1,'news2':news2}),
		dataType: "json",
		success: function(response){
			if(response.success == "1"){
				alert("Wall Posts are saved successfully");
			}else{
				alert("Save failed...");
			}
			$(document).trigger('click');
		},
		error: function(){
			alert("Save failed...");
			$(document).trigger('click');
		}
	});
	return false;
});