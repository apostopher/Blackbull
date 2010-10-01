$(function(){
	
	// Set the charts options.
	var options = {
		chart: {
        		renderTo: 'chartholder',
        		defaultSeriesType: 'spline',
        		zoomType:"xy",
        		showAxes:true
    		},
    		title: {
        		text: 'Institutional Investment in NSE'
    		},
    		xAxis: [{
    			labels: {
    				rotation: -45,
    				align: 'right',
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
        		},{
        			labels: {
            				formatter: function() {
               					return this.value;
            				},
            				style: {
               					color: '#AA4643'
            				}
            			},
        			title: {
            				text: 'Nifty levels',
            				style: {
               					color: '#AA4643'
            				}
        			},
        			opposite: true
        	}],
		tooltip: {
			formatter: function() {
				if(this.series.name == "Institutional Investment"){
					return 'Date: <b>'+ this.x +'</b>.<br/>Investment: <b>'+ this.y +'</b> thousand crores.';
				}else{
					return 'Date: <b>'+ this.x +'</b>.<br/>Nifty: <b>'+ this.y +'</b>';
				}
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
					var series = {
						name:"Institutional Investment",
						type:'spline',
                				data: []
            				};
            				var nifty = {
            					name:"Nifty lavels",
            					type:'spline',
            					yAxis: 1,
            					lineWidth:1,
            					shadow:false,
            					visible: false,
            					marker: {
                					enabled: false
            					},
            					enableMouseTracking: false,
                				data: []
            				};
					for(var i = response.total -1; i>=0; i--){
						series.data.push(parseFloat(response.data[i].value));
						nifty.data.push(parseInt(response.data[i].closeval));
						options.xAxis[0].categories.push(response.data[i].date);
					}
					
					options.series.push(series);
					options.series.push(nifty);
					var chart = new Highcharts.Chart(options);
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