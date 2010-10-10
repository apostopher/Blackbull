$(function() {
        // Global variables
        var totalDays = 0;
        var totalProfit = 0;
        var totalscrips = 0;
        // Select the active tab
        var activetab = $('div#content').attr("data-type");
        if(activetab){
        	$('li.menuitem[data-tab-name|='+activetab+'] span.liname').addClass("active");
        	$('li.menuitem[data-tab-name|='+activetab+'] span.arrow').removeClass("hide");
        }
	// Load the Jquery tools scroller
	$("#scrollable").scrollable({
		circular:true
	}).autoscroll({
		autoplay: true,
		interval: 5000,
		autopause: true
	});
	// Google chrome frame check
	//CFInstall.check({mode: "overlay"});
	// Set the Edit options
	$("article#news section.bbnews").blur(function(){
		if($(this).attr("contenteditable") == "true"){
			/*var rawdata = $(this).html();
			rawdata = rawdata.replace( /&lt;/g, '<' );
			rawdata = rawdata.replace( /&gt;/g, '>' );
			rawdata = rawdata.replace( '<script>', '&lt;script&gt;' );
			rawdata = rawdata.replace( '</script>', '&lt;/script&gt;' );
			$(this).html(rawdata);*/
			localStorage.setItem($(this).attr('id'), $(this).html());
		}
	});
	
	// Initial position of tabs. Trading is an active tab
	$("div#tradingcontent").show();
	$("div#investcontent").hide();
	
	// Blackbull portfolio tabs on homepage
	$("ul.portfolio li.tab").click(function(){
	        // We need to make changes to DOM only if the tab is not active
		if(!$(this).hasClass("active")){
			// Check which tab is clicked
			if($(this).attr("id") == "tradingtab"){
				// This is trading tab
				// set the visibility of content divs
				$("div#tradingcontent").show();
				$("div#investcontent").hide();
				
				// set active class on other tab
				$("#investtab").removeClass("active");
				$("#investtab span.filler").addClass("invisible");
				$(this).children("span.filler").removeClass("invisible");
			}else{
				// This is investment tab
				// set the visibility of content divs
				$("div#investcontent").show();
				$("div#tradingcontent").hide();
				
				// set active class on other tab
				$("#tradingtab").removeClass("active");
				$("#tradingtab span.filler").addClass("invisible");
				$(this).children("span.filler").removeClass("invisible");
			}
			// Add the active class to this element
			$(this).addClass("active");
		}
		return false;
	});
	if(supports_local_storage()){
		$.getScript('/javascripts/admin.js');
	}
	// Get the homepage portfolio content
	$.ajax({
		type:"GET",
		url:"serverscripts/getfoliosummary.php",
		dataType:"json",
		success: function(response){
			var portfoliotable = $("#tradingpositions");
			var count=0;
			var row;
			portfoliotable.html("");
			var listcount = Math.min(6, parseInt(response.total));
			for(count=0;count<listcount;count++){
				row = $("<tr/>");
				$("<td/>",{
					"class": "scripname",
					text: response.positions[count].name
				}).appendTo(row);
				if(response.positions[count].profit < 0){
					$("<td/>",{
						"class": "scripreturn red",
						text: response.positions[count].profit + "%"	
					}).appendTo(row);
				}else{
					$("<td/>",{
						"class": "scripreturn",
						text: response.positions[count].profit + "%"	
					}).appendTo(row);
				}
				
				$(row).appendTo(portfoliotable);
			}
			$(row).addClass("last");
			totalDays = response.days;
			totalProfit = response.profit;
			totalscrips = response.total;
			$.ajax({
				type:"GET",
				url:"serverscripts/getfoliosummary.php",
				data:({'type':'investment'}),
				dataType:"json",
				success: function(response){
					var portfoliotable = $("#investmentpositions");
					var count=0;
					var row;
					portfoliotable.html("");
					var listcount = Math.min(6, parseInt(response.total));
					for(count=0;count<listcount;count++){
						row = $("<tr/>");
						$("<td/>",{
							"class": "scripname",
							text: response.positions[count].name
						}).appendTo(row);
				
						if(response.positions[count].profit < 0){
							$("<td/>",{
								"class": "scripreturn red",
								text: response.positions[count].profit + "%"	
							}).appendTo(row);
						}else{
							$("<td/>",{
								"class": "scripreturn",
								text: response.positions[count].profit + "%"	
							}).appendTo(row);
						}
				
						$(row).appendTo(portfoliotable);
					}
					$(row).addClass("last");
					totalDays = totalDays + response.days;
					totalProfit = totalProfit + response.profit;
					totalscrips = totalscrips + response.total;
					// Calculate profit per month per 100 Rs.
					$perHundredRsProfit = totalProfit/(totalscrips);
					var returns = 100 + Math.round(($perHundredRsProfit/totalDays)*365);
					$("#returns").html(returns);
				},
				failure: function(){
				}
			});
		},
		failure: function(){
		}
	});
});

function supports_local_storage() {
  try {
    return 'localStorage' in window && window['localStorage'] !== null;
  } catch(e){
    return false;
  }
}