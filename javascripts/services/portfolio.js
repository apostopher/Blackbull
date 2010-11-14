$(function(){
	// Get the portfolio status at page load.
	getInvestmentStatus();
	getTradingStatus();
	// Add facebox hover functionality
	$("#facebox").hover(function(){
		$("#facebox").addClass("dummy");
	},
	function(){
		$("#facebox").removeClass("dummy");
	});
	// Add document click event
	$(document).click(function(){
		if(!$("#facebox").hasClass("dummy")&& !$("#facebox").hasClass("hide")){
			$("#facebox").fadeOut("fast");
			$("#facebox_overlay").fadeOut("fast");
			$("#facebox").addClass("hide");
			$("#facebox_overlay").addClass("hide");
			$(".scripdetails").html("<h2 id=\"scripname\"></h2><div class=\"details\"><table><tbody><tr><td class=\"loading\">Loading data&hellip;</td></tr></tbody></table></div>");
		}
	});
});

// Function to get Investment positions.
function getInvestmentStatus(){
	$.ajax({
		type:"GET",
		url:"../serverscripts/getfoliosummary.php",
		data:({'type':'investment'}),
		dataType:"json",
		success: function(response){
			var portfoliotable = $("#investment_list");
			portfoliotable.html("");
			for(count=0;count<response.total;count++){
				var row = $("<tr/>");
				$("<td/>",{
					"class": "name",
					text: response.positions[count].name
				}).appendTo(row);
				if(response.positions[count].profit < 0){
					$("<td/>",{
						"class": "returns red",
						text: response.positions[count].profit + "%"	
					}).appendTo(row);
				}else{
					$("<td/>",{
						"class": "returns",
						text: response.positions[count].profit + "%"	
					}).appendTo(row);
				}
				detailsTd = $("<td/>",{
					"class": "details"
				});
				$("<a href=\"#\" data-scrip=\""+response.positions[count].scrip+"\" data-name=\""+response.positions[count].name+"\"><span>Details</span></a>").appendTo(detailsTd);
				$(detailsTd).appendTo(row);
				$(row).appendTo(portfoliotable);
			}
			// Add hover effect
			$("#investment_list td.details a").hover(function(){
				$(this).addClass("hovered");
				$(this).children("span").addClass("hovered");
			},
			function(){
				$(this).removeClass("hovered");
				$(this).children("span").removeClass("hovered");
				if($(this).hasClass("mousedown")){
					$(this).removeClass("mousedown");
					$(this).children("span").removeClass("mousedown");
				}
			});
			// Add mousedown effect
			$("#investment_list td.details a").mousedown(function(){
				if(!$(this).hasClass("mousedown")){
					$(this).addClass("mousedown");
					$(this).children("span").addClass("mousedown");
				}
			});
			// Add mouseup effect
			$("#investment_list td.details a").mouseup(function(){
				if($(this).hasClass("mousedown")){
					$(this).removeClass("mousedown");
					$(this).children("span").removeClass("mousedown");
				}
			});
			// Add click event
			$("#investment_list td.details a").click(function(){
				var scrip = $(this).attr("data-scrip");
				var scripname = $(this).attr("data-name");
				$.ajax({
					type:"GET",
					url:"../serverscripts/getInvestmentFolio.php",
					data:({'scrip':scrip}),
					dataType:"html",
					beforeSend:function(){
						$("#scripname").html(scripname);
					},
					success:function(response){
						var boxTop = $("#facebox").height();
						var windowHeight = $(window).height();
						var scrollTop = $(window).scrollTop();
						var topmargin = (windowHeight-boxTop + scrollTop)/2;
						$(".scripdetails div.details").html(response);
						$("#facebox").animate({'top':topmargin +"px"}, "slow");
					},
					failure:function(){
						$(".scripdetails div.details").html("<p class=\"error\">Error occured&hellip;</p>");
						$("#facebox").animate({'top':topmargin +"px"}, "slow");
					}
				});
				if($("#facebox").hasClass("hide")){
					$("#facebox").fadeIn("fast");
					$("#facebox_overlay").fadeIn("fast");
					$("#facebox").removeClass("hide");
					$("#facebox_overlay").removeClass("hide");
				}
				return false;
			});
			// Add hover effect to rows #FDFFCE
			$("#investment_list tr").hover(function(){
				$(this).css({"backgroundColor":"#FDFFCE"});
			},
			function(){
				$(this).css({"backgroundColor":"#FFF"});
			});
		},
		failure: function(){
		}
	});
}

// Function to get Trading positions.
function getTradingStatus(){
	$.ajax({
		type:"GET",
		url:"../serverscripts/getfoliosummary.php",
		dataType:"json",
		success: function(response){
			var portfoliotable = $("#trading_list");
			portfoliotable.html("");
			for(count=0;count<response.total;count++){
				row = $("<tr/>");
				$("<td/>",{
					"class": "name",
					text: response.positions[count].name
				}).appendTo(row);
				if(response.positions[count].profit < 0){
					$("<td/>",{
						"class": "returns red",
						text: response.positions[count].profit + "%"	
					}).appendTo(row);
				}else{
					$("<td/>",{
						"class": "returns",
						text: response.positions[count].profit + "%"	
					}).appendTo(row);
				}
				detailsTd = $("<td/>",{
					"class": "details"
				});
				$("<a href=\"#\" data-scrip=\""+response.positions[count].scrip+"\" data-name=\""+response.positions[count].name+"\"><span>Details</span></a>").appendTo(detailsTd);
				$(detailsTd).appendTo(row);
				$(row).appendTo(portfoliotable);
			}
			// Add hover effect
			$("#trading_list td.details a").hover(function(){
				$(this).addClass("hovered");
				$(this).children("span").addClass("hovered");
			},
			function(){
				$(this).removeClass("hovered");
				$(this).children("span").removeClass("hovered");
				if($(this).hasClass("mousedown")){
					$(this).removeClass("mousedown");
					$(this).children("span").removeClass("mousedown");
				}
			});
			// Add mousedown effect
			$("#trading_list td.details a").mousedown(function(){
				if(!$(this).hasClass("mousedown")){
					$(this).addClass("mousedown");
					$(this).children("span").addClass("mousedown");
				}
			});
			// Add mouseup effect
			$("#trading_list td.details a").mouseup(function(){
				if($(this).hasClass("mousedown")){
					$(this).removeClass("mousedown");
					$(this).children("span").removeClass("mousedown");
				}
			});
			// Add click event
			$("#trading_list td.details a").click(function(){
				var scrip = $(this).attr("data-scrip");
				var scripname = $(this).attr("data-name");
				$.ajax({
					type:"GET",
					url:"../serverscripts/getTradingFolio.php",
					data:({'scrip':scrip}),
					dataType:"html",
					beforeSend:function(){
						$("#scripname").html(scripname);
					},
					success:function(response){
						var boxTop = $("#facebox").height();
						var windowHeight = $(window).height();
						var scrollTop = $(window).scrollTop();
						var topmargin = (windowHeight-boxTop + scrollTop)/2;
						$(".scripdetails div.details").html(response);
						$("#facebox").animate({'top':topmargin + "px"}, "slow");
					},
					failure:function(){
						$(".scripdetails div.details").html("<p class=\"error\">Error occured&hellip;</p>");
						$("#facebox").animate({'top':topmargin + "px"}, "slow");
					}
				});
				if($("#facebox").hasClass("hide")){
					$("#facebox").fadeIn("fast");
					$("#facebox_overlay").fadeIn("fast");
					$("#facebox").removeClass("hide");
					$("#facebox_overlay").removeClass("hide");
				}
				return false;
			});
			// Add hover effect to rows #FDFFCE
			$("#trading_list tr").hover(function(){
				$(this).css({"backgroundColor":"#FDFFCE"});
			},
			function(){
				$(this).css({"backgroundColor":"#FFF"});
			});	
		},
		failure: function(){
			}
	});
}