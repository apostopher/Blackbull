$(function(){
	getSpread('NIFTY',"jan-2011");
});

function getSpread(symbol, expiry){
	$.ajax({
		type:"GET",
		url: '/serverscripts/getOptionSpread.php',
		data:({"symbol":symbol,
			"expiry":expiry}),
		dataType:"json",
		success:function(response){
			if(response){
				var html_content = "";
				var pflg = 0;
				for(count=0; count < response.total ; count++){
					html_content = html_content + "<tr>";
					if(parseInt(response.value) < parseInt(response.positions[count].s)){
						html_content = html_content + "<td>" + response.positions[count].p +"</td>";
                                         	html_content = html_content + "<td>" + response.positions[count].c + "</td>";
                                         	html_content = html_content + "<td>" + response.positions[count].o + "</td>";
					}else{
						html_content = html_content + "<td class='green'>" + response.positions[count].p +"</td>";
                                   		html_content = html_content + "<td class='green'>" + response.positions[count].c + "</td>";
                                   		html_content = html_content + "<td class='green'>" + response.positions[count].o + "</td>";	
					}
					html_content = html_content + "<td class='stk'>" + response.positions[count].s + "</td>";
					count++;
					if(parseInt(response.value) < parseInt(response.positions[count].s)){
						html_content = html_content + "<td class='green'>" + response.positions[count].p +"</td>";
                                      		html_content = html_content + "<td class='green'>" + response.positions[count].c + "</td>";
                                      		html_content = html_content + "<td class='green'>" + response.positions[count].o + "</td></tr>";
					}else{
						html_content = html_content + "<td>" + response.positions[count].p +"</td>";
                                   		html_content = html_content + "<td>" + response.positions[count].c + "</td>";
                                   		html_content = html_content + "<td>" + response.positions[count].o + "</td></tr>";
					}
				}
				if(response.total > 1){
					var todate = new Date();
                                   	$("#spread_body").html(html_content);
                                   	$("#sec_name").html(response.name);
                                   	$("#sec_expiry").html(response.expiry);
                                   	$("#sec_val").html(response.value);
                                   	$("#updatedate").html("Last updated on "+ response.date.toLowerCase());
				}else{
				}
			}else{
			}
		},
		failure:function(){
		}
	});
}