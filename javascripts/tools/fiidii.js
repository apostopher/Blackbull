$(function(){
	
	$("#charttype li").click(function(){
		var ele = $(this);
		var type = ele.attr("id");
		if(!ele.hasClass("active")){
			$("#fiidiili").removeClass("active hovered");
			$("#fiili").removeClass("active hovered");
			$("#diili").removeClass("active hovered");
			
			$("#fiidiili").children("span.filler").removeClass("visible");
			$("#fiili").children("span.filler").removeClass("visible");
			$("#diili").children("span.filler").removeClass("visible");
			
			ele.addClass("active");
			ele.children("span.filler").addClass("visible");
		
			$("#fiidiiholder").hide();
			$("#fiiholder").hide();
			$("#diiholder").hide();
		
			if(type == "fiidiili"){
				$("#fiidiiholder").show();
			}
			if(type == "fiili"){
				$("#fiiholder").show();
			}
			if(type == "diili"){
				$("#diiholder").show();
			}
		}
	});
	
	$("#charttype li").hover(function(){
		var ele = $(this);
		if(!ele.hasClass("active")){
			if(!ele.hasClass("hovered")){
				ele.addClass("hovered");
			}
		}
	},
	function(){
		var ele = $(this);
		if(!ele.hasClass("active")){
			if(ele.hasClass("hovered")){
				ele.removeClass("hovered");
			}
		}	
	});
	
	// Set the charts options.
	var fdoptions = {
		chart: {
        		renderTo: 'fiidiiholder',
        		defaultSeriesType: 'spline',
        		zoomType:"xy",
        		showAxes:true,
        		width:892,
        		height:400
    		},
    		credits: {
        		enabled: false
    		},
    		title: {
        		text: 'FII + DII Investment in NSE'
    		},
    		xAxis: [{
    			labels: {
    				rotation: -45,
    				align: 'right'
    			},
    			tickmarkPlacement:"on",
        		categories: []
    		}],
    		yAxis: [{
    				labels: {
            				formatter: function() {
               					return this.value;
            				}
            			},
        			title: {
            				text: 'Invested capital (1000 Rs. crore)'
        			}
        		}],
		tooltip: {
			formatter: function() {
				return 'Date: <b>'+ this.x +'</b>.<br/>'+this.series.name+': <b>'+ this.y +'</b> thousand crores.';	
			}
		},
    		series: []
	};
	var foptions = {
		chart: {
        		renderTo: 'fiiholder',
        		defaultSeriesType: 'spline',
        		zoomType:"xy",
        		showAxes:true,
        		width:892,
        		height:400
    		},
    		credits: {
        		enabled: false
    		},
    		title: {
        		text: 'FII Investment in NSE'
    		},
    		xAxis: [{
    			labels: {
    				rotation: -45,
    				align: 'right'
    			},
    			tickmarkPlacement:"on",
        		categories: []
    		}],
    		yAxis: [{
    				labels: {
            				formatter: function() {
               					return this.value;
            				}
            			},
        			title: {
            				text: 'Invested capital (1000 Rs. crore)'
        			}
        		}],
		tooltip: {
			formatter: function() {
				return 'Date: <b>'+ this.x +'</b>.<br/>'+this.series.name+': <b>'+ this.y +'</b> thousand crores.';	
			}
		},
    		series: []
	};
	var doptions = {
		chart: {
        		renderTo: 'diiholder',
        		defaultSeriesType: 'spline',
        		zoomType:"xy",
        		showAxes:true,
        		width:892,
        		height:400
    		},
    		credits: {
        		enabled: false
    		},
    		title: {
        		text: 'DII Investment in NSE'
    		},
    		xAxis: [{
    			labels: {
    				rotation: -45,
    				align: 'right'
    			},
    			tickmarkPlacement:"on",
        		categories: []
    		}],
    		yAxis: [{
    				labels: {
            				formatter: function() {
               					return this.value;
            				}
            			},
        			title: {
            				text: 'Invested capital (1000 Rs. crore)'
        			}
        		}],
		tooltip: {
			formatter: function() {
				return 'Date: <b>'+ this.x +'</b>.<br/>'+this.series.name+': <b>'+ this.y +'</b> thousand crores.';	
			}
		},
    		series: []
	};
	$.ajax({
		type:"GET",
		url:"/serverscripts/fiidii.php",
		dataType:"json",
		success: function(response){
			if(response){
				if(response.total){
					var fiidii = {
						name:"FII + DII Investment",
						type:'spline',
                				data: []
            				};
            				var fii = {
						name:"FII Investment",
						type:'spline',
                				data: []
            				};
            				var dii = {
						name:"DII Investment",
						type:'spline',
                				data: []
            				};
					for(var i = response.total -1; i>=0; i--){
						fiidii.data.push(parseFloat(response.data[i].value));
						fii.data.push(parseFloat(response.data[i].fii));
						dii.data.push(parseFloat(response.data[i].dii));
						fdoptions.xAxis[0].categories.push(response.data[i].date);
						foptions.xAxis[0].categories.push(response.data[i].date);
						doptions.xAxis[0].categories.push(response.data[i].date);
					}
					
					fdoptions.series.push(fiidii);
					foptions.series.push(fii);
					doptions.series.push(dii);
					$("#fiidiiholder").html("");
					var chartfd = new Highcharts.Chart(fdoptions);
					$("#diiholder").html("");
					var chartd = new Highcharts.Chart(doptions);
					$("#fiiholder").html("");
					var chartf = new Highcharts.Chart(foptions);
					$("#fiibuy").html(response.fiibuy);
					$("#fiisell").html(response.fiisell);
					if(response.fiibuy - response.fiisell < 0){
						$("#fiinet").addClass("red");
					}else{
						$("#fiinet").addClass("green");
					}
					$("#fiinet").html(parseFloat(response.fiibuy - response.fiisell).toFixed(2));
					$("#diibuy").html(response.diibuy);
					$("#diisell").html(response.diisell);
					if(response.diibuy - response.diisell < 0){
						$("#diinet").addClass("red");
					}else{
						$("#diinet").addClass("green");
					}
					$("#diinet").html(parseFloat(response.diibuy - response.diisell).toFixed(2));
					$("#totalbuy").html((parseFloat(response.fiibuy) + parseFloat(response.diibuy)).toFixed(2));
					$("#totalsell").html((parseFloat(response.fiisell) + parseFloat(response.diisell)).toFixed(2));
					if(parseFloat(response.fiibuy) + parseFloat(response.diibuy) - parseFloat(response.fiisell) - parseFloat(response.diisell) < 0){
						$("#totalnet").addClass("red");
					}else{
						$("#totalnet").addClass("green");
					}
					$("#totalnet").html((parseFloat(response.fiibuy) + parseFloat(response.diibuy) - parseFloat(response.fiisell) - parseFloat(response.diisell)).toFixed(2));
					$("#fiidiidate").html("Date: "+response.today);
				}else{
					$("#fiidii").html("Unable to load data. Please try again after some time.");
				}
			}else{
				$("#fiidii").html("Unable to load data. Please try again after some time.");
			}
		},
		failure: function(){	
		}
	});
});