$(function(){
	var chartfd;
	var chartd;
	var chartf;
	var fiidii1mx = [], fiidii3mx = [], fiidii6mx = [], fiidii1yx = [];
        var fii1mx = [], fii3mx = [], fii6mx = [], fii1yx = [];
        var dii1mx = [], dii3mx = [], dii6mx = [], dii1yx = [];
        var fiidii1m, fiidii3m, fiidii6m, fiidii1y;
        var fii1m, fii3m, fii6m, fii1y;
        var dii1m, dii3m, dii6m, dii1y;
        
	var ulholder = $("#ulholder");
	$("#charttype li").click(function(){
		var ele = $(this);
		var type = ele.attr("id");
		var activeperiod = ulholder.data("period");
		if(!ele.hasClass("active")){
			$("#fiidiili").removeClass("active hovered");
			$("#fiili").removeClass("active hovered");
			$("#diili").removeClass("active hovered");
			
			$("#fiidiili").children("span.filler").removeClass("visible");
			$("#fiili").children("span.filler").removeClass("visible");
			$("#diili").children("span.filler").removeClass("visible");
			
			ele.addClass("active");
			ele.children("span.filler").addClass("visible");
			ulholder.data("active", type);
		
			$("#fiidiiholder").hide();
			$("#fiiholder").hide();
			$("#diiholder").hide();
		
			if(type == "fiidiili"){
			  $("#fiidiiholder").show();
			  if(activeperiod == "m1"){
			    chartfd.series[0].remove(false);
			    chartfd.addSeries(fiidii1m);
			    chartfd.xAxis[0].setCategories(fiidii1mx, false);
			    chartfd.redraw();
			  }
			  if(activeperiod == "m3"){
			    chartfd.series[0].remove(false);
			    chartfd.addSeries(fiidii3m);
			    chartfd.xAxis[0].setCategories(fiidii3mx, false);
			    chartfd.redraw();
			  }
			  if(activeperiod == "m6"){
			    chartfd.series[0].remove(false);
			    chartfd.addSeries(fiidii6m);
			    chartfd.xAxis[0].setCategories(fiidii6mx, false);
			    chartfd.redraw();
			  }
			  if(activeperiod == "y1"){
			    chartfd.series[0].remove(false);
			    chartfd.addSeries(fiidii1y);
			    chartfd.xAxis[0].setCategories(fiidii1yx, false);
			    chartfd.redraw();
			  }
			}
			if(type == "fiili"){
			  $("#fiiholder").show();
			  if(activeperiod == "m1"){
			    chartf.series[0].remove(false);
			    chartf.addSeries(fii1m);
			    chartf.xAxis[0].setCategories(fii1mx, false);
			    chartf.redraw();
			  }
			  if(activeperiod == "m3"){
			    chartf.series[0].remove(false);
			    chartf.addSeries(fii3m);
			    chartf.xAxis[0].setCategories(fii3mx, false);
			    chartf.redraw();
			  }
			  if(activeperiod == "m6"){
			    chartf.series[0].remove(false);
			    chartf.addSeries(fii6m);
			    chartf.xAxis[0].setCategories(fii6mx, false);
			    chartf.redraw();
			  }
			  if(activeperiod == "y1"){
			    chartf.series[0].remove(false);
			    chartf.addSeries(fii1y);
			    chartf.xAxis[0].setCategories(fii1yx, false);
			    chartf.redraw();
			  }
			}
			if(type == "diili"){
			  $("#diiholder").show();
			  if(activeperiod == "m1"){
			    chartd.series[0].remove(false);
			    chartd.addSeries(dii1m);
			    chartd.xAxis[0].setCategories(dii1mx, false);
			    chartd.redraw();
			  }
			  if(activeperiod == "m3"){
			    chartd.series[0].remove(false);
			    chartd.addSeries(dii3m);
			    chartd.xAxis[0].setCategories(dii3mx, false);
			    chartd.redraw();
			  }
			  if(activeperiod == "m6"){
			    chartd.series[0].remove(false);
			    chartd.addSeries(dii6m);
			    chartd.xAxis[0].setCategories(dii6mx, false);
			    chartd.redraw();
			  }
			  if(activeperiod == "y1"){
			    chartd.series[0].remove(false);
			    chartd.addSeries(dii1y);
			    chartd.xAxis[0].setCategories(dii1yx, false);
			    chartd.redraw();
			  }
			}
		}
	});
	
	$("#chartperiod li").click(function(){
		var ele = $(this);
		var type = ele.attr("id");
		var activechart = ulholder.data("active");
		
		if(!ele.hasClass("active")){
			$("#m1").removeClass("active hovered");
			$("#m3").removeClass("active hovered");
			$("#m6").removeClass("active hovered");
			$("#y1").removeClass("active hovered");
			
			$("#m1").children("span.filler").removeClass("visible");
			$("#m3").children("span.filler").removeClass("visible");
			$("#m6").children("span.filler").removeClass("visible");
			$("#y1").children("span.filler").removeClass("visible");
			
			ele.addClass("active");
			ele.children("span.filler").addClass("visible");
			ulholder.data("period", type);
			if(type == "m1"){
			  if(activechart === "fiidiili"){
			    chartfd.series[0].remove(false);
			    chartfd.addSeries(fiidii1m);
			    chartfd.xAxis[0].setCategories(fiidii1mx, false);
			    chartfd.redraw();
			  }
			  if(activechart === "fiili"){
			    chartf.series[0].remove(false);
			    chartf.addSeries(fii1m);
			    chartf.xAxis[0].setCategories(fii1mx, false);
			    chartf.redraw();
			  }
			  if(activechart === "diili"){
			    chartd.series[0].remove(false);
			    chartd.addSeries(dii1m);
			    chartd.xAxis[0].setCategories(dii1mx, false);
			    chartd.redraw();
			  }
			}
			if(type == "m3"){
			  if(activechart === "fiidiili"){
			    chartfd.series[0].remove(false);
			    chartfd.addSeries(fiidii3m);
			    chartfd.xAxis[0].setCategories(fiidii3mx, false);
			    chartfd.redraw();
			  }
			  if(activechart === "fiili"){
			    chartf.series[0].remove(false);
			    chartf.addSeries(fii3m);
			    chartf.xAxis[0].setCategories(fii3mx, false);
			    chartf.redraw();
			  }
			  if(activechart === "diili"){
			    chartd.series[0].remove(false);
			    chartd.addSeries(dii3m);
			    chartd.xAxis[0].setCategories(dii3mx, false);
			    chartd.redraw();
			  }
			}
			if(type == "m6"){
			  if(activechart === "fiidiili"){
			    chartfd.series[0].remove(false);
			    chartfd.addSeries(fiidii6m);
			    chartfd.xAxis[0].setCategories(fiidii6mx, false);
			    chartfd.redraw();
			  }
			  if(activechart === "fiili"){
			    chartf.series[0].remove(false);
			    chartf.addSeries(fii6m);
			    chartf.xAxis[0].setCategories(fii6mx, false);
			    chartf.redraw();
			  }
			  if(activechart === "diili"){
			    chartd.series[0].remove(false);
			    chartd.addSeries(dii6m);
			    chartd.xAxis[0].setCategories(dii6mx, false);
			    chartd.redraw();
			  }
			}
			if(type == "y1"){
			  if(activechart === "fiidiili"){
			    chartfd.series[0].remove(false);
			    chartfd.addSeries(fiidii1y);
			    chartfd.xAxis[0].setCategories(fiidii1yx, false);
			    chartfd.redraw();
			  }
			  if(activechart === "fiili"){
			    chartf.series[0].remove(false);
			    chartf.addSeries(fii1y);
			    chartf.xAxis[0].setCategories(fii1yx, false);
			    chartf.redraw();
			  }
			  if(activechart === "diili"){
			    chartd.series[0].remove(false);
			    chartd.addSeries(dii1y);
			    chartd.xAxis[0].setCategories(dii1yx, false);
			    chartd.redraw();
			  }
			}
		}
	});
	
	$("#chartperiod li").hover(function(){
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
    		plotOptions: {series: {marker: {fillColor: '#FFFFFF', lineWidth: 2, lineColor: null}}},
    		credits: {
        		enabled: false
    		},
    		title: {
        		text: 'FII + DII Investment in India',
        		style:{
        		        color:'#2A7090'
        		      }
    		},
    		xAxis: [{
    			labels: {
    				rotation: -45,
    				align: 'right'
    			},
    			tickmarkPlacement:"on",
        		categories: []
    		}],
    		yAxis: {
    				labels: {
            				formatter: function() {
               					return this.value;
            				}
            			},
        			title: {
            				text: 'Invested capital (1000 Rs. crore)',
            				style:{
        		                         color:'#2A7090'
        		                      }
        			}
        		},
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
    		plotOptions: {series: {marker: {fillColor: '#FFFFFF', lineWidth: 2, lineColor: null}}},
    		credits: {
        		enabled: false
    		},
    		title: {
        		text: 'FII Investment in India',
        		style:{
        		        color:'#2A7090'
        		      }
    		},
    		xAxis: [{
    			labels: {
    				rotation: -45,
    				align: 'right'
    			},
    			tickmarkPlacement:"on",
        		categories: []
    		}],
    		yAxis: {
    				labels: {
            				formatter: function() {
               					return this.value;
            				}
            			},
        			title: {
            				text: 'Invested capital (1000 Rs. crore)',
            				style:{
        		                         color:'#2A7090'
        		                      }
        			}
        		},
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
    		plotOptions: {series: {marker: {fillColor: '#FFFFFF', lineWidth: 2, lineColor: null}}},
    		credits: {
        		enabled: false
    		},
    		title: {
        		text: 'DII Investment in India',
        		style:{
        		        color:'#2A7090'
        		      }
    		},
    		xAxis: [{
    			labels: {
    				rotation: -45,
    				align: 'right'
    			},
    			tickmarkPlacement:"on",
    			tickInterval: 5,
        		categories: []
    		}],
    		yAxis: {
    				labels: {
            				formatter: function() {
               					return this.value;
            				}
            			},
        			title: {
            				text: 'Invested capital (1000 Rs. crore)',
            				style:{
        		                         color:'#2A7090'
        		                      }
        			}
        		},
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
					fiidii1m = {
						name:"FII + DII Investment",
						type:'spline',
						color:"#2A7090",
						marker: {symbol: 'circle'},
                				data: []
            				};
            				fiidii3m = {
						name:"FII + DII Investment",
						type:'spline',
						color:"#2A7090",
						marker: {symbol: 'circle'},
                				data: []
            				};
            				fiidii6m = {
						name:"FII + DII Investment",
						type:'spline',
						color:"#2A7090",
						marker: {symbol: 'circle'},
                				data: []
            				};
            				fiidii1y = {
						name:"FII + DII Investment",
						type:'spline',
						color:"#2A7090",
						marker: {symbol: 'circle'},
                				data: []
            				};
            				
            				fii1m = {
						name:"FII Investment",
						type:'spline',
						color:"#2A7090",
						marker: {symbol: 'circle'},
                				data: []
            				};
            				fii3m = {
						name:"FII Investment",
						type:'spline',
						color:"#2A7090",
						marker: {symbol: 'circle'},
                				data: []
            				};
            				fii6m = {
						name:"FII Investment",
						type:'spline',
						color:"#2A7090",
						marker: {symbol: 'circle'},
                				data: []
            				};
            				fii1y = {
						name:"FII Investment",
						type:'spline',
						color:"#2A7090",
						marker: {symbol: 'circle'},
                				data: []
            				};
            				
            				dii1m = {
						name:"DII Investment",
						type:'spline',
						color:"#2A7090",
						marker: {symbol: 'circle'},
                				data: []
            				};
            				dii3m = {
						name:"DII Investment",
						type:'spline',
						color:"#2A7090",
						marker: {symbol: 'circle'},
                				data: []
            				};
            				dii6m = {
						name:"DII Investment",
						type:'spline',
						color:"#2A7090",
						marker: {symbol: 'circle'},
                				data: []
            				};
            				dii1y = {
						name:"DII Investment",
						type:'spline',
						color:"#2A7090",
						marker: {symbol: 'circle'},
                				data: []
            				};
            				
					for(var i = 0; i < response.total; i++){
					  if(i < 30){
					    fiidii1m.data.unshift(parseFloat(response.data[i].value));
					    fii1m.data.unshift(parseFloat(response.data[i].fii));
					    dii1m.data.unshift(parseFloat(response.data[i].dii));
					    fiidii1mx.unshift(response.data[i].date);
					    fii1mx.unshift(response.data[i].date);
					    dii1mx.unshift(response.data[i].date);
				          }
				          if(i < 90 && i%3 == 0){
					    fiidii3m.data.unshift(parseFloat(response.data[i].value));
					    fii3m.data.unshift(parseFloat(response.data[i].fii));
					    dii3m.data.unshift(parseFloat(response.data[i].dii));
					    fiidii3mx.unshift(response.data[i].date);
					    fii3mx.unshift(response.data[i].date);
					    dii3mx.unshift(response.data[i].date);
				          }
				          if(i < 180 && i%6 == 0){
					    fiidii6m.data.unshift(parseFloat(response.data[i].value));
					    fii6m.data.unshift(parseFloat(response.data[i].fii));
					    dii6m.data.unshift(parseFloat(response.data[i].dii));
					    fiidii6mx.unshift(response.data[i].date);
					    fii6mx.unshift(response.data[i].date);
					    dii6mx.unshift(response.data[i].date);
				          }
				          if(i%12 == 0){
				            fiidii1y.data.unshift(parseFloat(response.data[i].value));
					    fii1y.data.unshift(parseFloat(response.data[i].fii));
					    dii1y.data.unshift(parseFloat(response.data[i].dii));
					    fiidii1yx.unshift(response.data[i].date);
					    fii1yx.unshift(response.data[i].date);
					    dii1yx.unshift(response.data[i].date);
					  }				         
					}
					fdoptions.series.push(fiidii1m);
					fdoptions.xAxis[0].categories = fiidii1mx;
					foptions.series.push(fii1m);
					foptions.xAxis[0].categories = fii1mx;
					doptions.series.push(dii1m);
					doptions.xAxis[0].categories = dii1mx;
					$("#fiidiiholder").html("");
					chartfd = new Highcharts.Chart(fdoptions);
					$("#diiholder").html("");
					chartd = new Highcharts.Chart(doptions);
					$("#fiiholder").html("");
					chartf = new Highcharts.Chart(foptions);
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
	/* download data form submission */
	/*$("#dldatafrm").submit(function(){
	  var tperiod = $("#tperiod").val(),
	      ctype = $("#ctype").val();
	  $.ajax({
		type:"GET",
		url:"/serverscripts/fiidii.php",
		data:{"period" : tperiod,
		      "type" : ctype,
		      "req" : "dl"},
		dataType:"json",
		success: function(response){
		
		},
		failure: function(){}
	  });
	  return false;
	});*/
});