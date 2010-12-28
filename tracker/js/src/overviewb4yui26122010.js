/* Author:Rahul Devaskar
*/

(function($){
   /* Get the required variables */
   var pfid = $("#main").attr("data-pfid");
   var trid = $("#main").attr("data-trid");
   var user_id = $("#container").attr("class");
   var transcount = 0;
   var curr_date = 0;
   var curr_type = 0;
   /* once the page is loaded, get all the data from PHP */
   $.getJSON("/serverscripts/portfolio/getOverview.php?pfid="+pfid+"&trid="+trid+"&uuid="+user_id,function(jsontrades){
     if(jsontrades.pagefound == "1"){
       $("#trade_name").html(jsontrades.trade_name);
       $("#waitscreen").hide();
       $("#trade_name").show();
       if(jsontrades.closetotal > 10){
       /* draw the chart only if there are more than 10 points */
       /* declare Highcharts options */
       /* highcharts version used: 2.1.1 on 24-dec-2010 */
       var minseries = 0;
       var maxseries = 0;
       var closeoptions = {
           chart: {renderTo: 'chartholder', defaultSeriesType: 'spline', showAxes:true, width:850, height:400},
    	   credits: {enabled: false}, title: {text: jsontrades.trade_name},
    	   xAxis: {labels: {rotation: -45, align: 'right'}, tickmarkPlacement:"on", categories: [], reversed:true},
           yAxis: {labels: {formatter: function() {return this.value;}},title: {text: 'Price'}, gridLineColor:"#DDDDDD",
           plotLines: []}, series: [], tooltip:{formatter:function(){
           if(this.point.id){
             var toolarray =  this.point.id.split("_");
             var returntxt = "Close: " + this.y +" Rs.<br/><br/>";
             for(var toolcount = 0; toolcount + 4 < toolarray.length; toolcount = toolcount + 4){
               if(toolarray[toolcount + 3] == "1"){
                 returntxt = returntxt + "<b>Bought</b> " + toolarray[toolcount + 2]+" share @"+toolarray[toolcount + 1] + " Rs.<br/>";
               }
               if(toolarray[toolcount + 3] == "-1"){
                 returntxt = returntxt + "<b>Sold</b> " + toolarray[toolcount + 2]+" share @"+toolarray[toolcount + 1] + " Rs.<br/>";
               }
             }
             return returntxt;
           }else{
             return "Close: " + this.y + " Rs.";
           }
           },backgroundColor:"rgba(255, 255, 255, 1)"}};
       /* define the series of close values */  
       var closevals = {name:jsontrades.trade_symbol, type:'spline', data: [], color:"#06C"};
       
       /* populate the close series with data received from PHP */
       /* set the initial values of curr_date and curr_type variables.
        * these variables are used to display BUY and SELL markers on the chart */
       if(jsontrades.transtotal > 0){
       /* user has transactions. get the latest transaction details */
         curr_date = jsontrades.trans[transcount].trans_date;
         curr_type = jsontrades.trans[transcount].trans_type;
       }
       for(var closei = 0; closei<jsontrades.closetotal; closei++){
         if(minseries == 0){
           minseries = parseFloat(jsontrades.close[closei].c);
         }
         /* Need to search whether there is any transaction on this date
          * This can also be done in PHP. but it will not be simpler than this.
          * so why put load on my server? let client CPU do it. 
          * the PHP script sends the transactions in desc order.
          * I save the latest date and type in local variables. if the dates match then
          * update the local variables to next trans value.
          */
         if(jsontrades.close[closei].d == curr_date){
           /* found a match. */ 
           /*check whether we have processed all trans */
           var idtxt = '';
           if(transcount + 1 < jsontrades.transtotal){
            /* there are more transactions to be processed. update the local variables.*/
            /* I use while loop because there can be more than one transactions on a day */
            
            while(jsontrades.close[closei].d == curr_date){
             transcount = transcount + 1;
             /* If I find BUY and SELL transactions on same day then i set curr_type to 2.
              * but need to reset this to normal */
             if(curr_type != jsontrades.trans[transcount].trans_type){
               curr_type = 2;
             }
             idtxt = idtxt + closei + "_" + jsontrades.trans[transcount].trans_price;
             idtxt = idtxt + "_" + jsontrades.trans[transcount].trans_qty + "_" + jsontrades.trans[transcount].trans_type + "_";
             curr_date = jsontrades.trans[transcount].trans_date;
             /* once it is determined than this date has both BUY and SELL trans
              * i don't need to update curr_type now or i'll loose this BUY+SELL info */
             if(curr_type != 2){
               curr_type = jsontrades.trans[transcount].trans_type;
             }
            }
           }else{
             /* all transactions are done */
             /* Update the id text */
             idtxt = idtxt + closei + "_" + jsontrades.trans[transcount].trans_price;
             idtxt = idtxt + "_" + jsontrades.trans[transcount].trans_qty + "_" + jsontrades.trans[transcount].trans_type + "_";
             curr_date= '';
           }
           if(curr_type == 1){
             /* It is a BUY transaction */
             var transpoint = {y: parseFloat(jsontrades.close[closei].c),
                             marker: {symbol: "url(http://blackbull.in/tracker/images/b.png)"}, id:idtxt};
           }else if(curr_type == -1){
             /* It is a SELL transaction */
             var transpoint = {y: parseFloat(jsontrades.close[closei].c),
                             marker: {symbol: "url(http://blackbull.in/tracker/images/s.png)"}, id:idtxt};
           }else{
             /* It is a BUY+SELL transaction */
             var transpoint = {y: parseFloat(jsontrades.close[closei].c),
                             marker: {symbol: "url(http://blackbull.in/tracker/images/bs.png)"}, id:idtxt};
           }
           closevals.data.push(transpoint);
           /* now reset the curr_type */
           curr_type = jsontrades.trans[transcount].trans_type;
         }else{
           /* no transactions match this date */
           closevals.data.push(parseFloat(jsontrades.close[closei].c));
         }
         /* Add X- Axis labels */
         closeoptions.xAxis.categories.push(jsontrades.close[closei].d.substring(0,6));
         
         if(minseries > jsontrades.close[closei].c){
           minseries = parseFloat(jsontrades.close[closei].c);
         }
         
         if(maxseries < jsontrades.close[closei].c){
           maxseries = parseFloat(jsontrades.close[closei].c);
         }
       }
       closeoptions.series.push(closevals);
       
       /* add the targets if any */
       if(jsontrades.targetstotal > 0){
         maxValue = 0;
         for(var count=0; count < jsontrades.targetstotal; count++){
           arrayelement = new Array();
           arrayelement['width'] = 1;
           arrayelement['value'] = jsontrades.targets[count].target;
           arrayelement['color'] = "#3cb878";
           arrayelement['zIndex'] = 3;
           arrayelement['dashStyle'] = 'line';
           arrayelement['label'] = {
               text: "Target: "+ jsontrades.targets[count].target,
               style: { color: "#3cb878", fontSize: "11px"}
           }
           
           closeoptions.yAxis.plotLines.push(arrayelement);
           /* Need to set max value on Y Axis */
           if(parseFloat(jsontrades.targets[count].target) > maxValue){
             maxValue = parseFloat(jsontrades.targets[count].target);
           }
         }
         /* The plot scale must be adjusted to fit max target */
         if(maxValue !=0 && maxValue > maxseries && maxValue < (1.2*maxseries)){
           closeoptions.yAxis.max = maxValue + parseInt(0.05*maxValue);
         }
       }
       
       /* add the stop losses if any */
       if(jsontrades.sltotal > 0){
         minValue = 0;
         for(var count=0; count < jsontrades.sltotal; count++){
           if(count == 0){
             minValue = parseFloat(jsontrades.sls[count].stoploss);
           }
           arrayelement = new Array();
           arrayelement['width'] = 1;
           arrayelement['value'] = jsontrades.sls[count].stoploss;
           arrayelement['color'] = "#D13236";
           arrayelement['zIndex'] = 3;
           arrayelement['dashStyle'] = 'line';
           arrayelement['label'] = {
               text: "Stoploss: "+ jsontrades.sls[count].stoploss,
               style: { color: "#D13236", fontSize: "11px"}
           }
           
           closeoptions.yAxis.plotLines.push(arrayelement);
           /* Need to set min value on Y Axis */
           if(parseFloat(jsontrades.sls[count].stoploss) < minValue){
             minValue = parseFloat(jsontrades.sls[count].stoploss);
           }
         }
         /* The plot scale must be adjusted to fit min stoploss */
         if(minValue !=0 && minValue < minseries && minValue > (0.8*minseries)){
           closeoptions.yAxis.min = minValue - parseInt(0.05*minValue);
         }
       }
       $("#chartholder").show();
       var chartfd = new Highcharts.Chart(closeoptions);
       }
    }else{
      $("#waitscreen").html("Page not found.");
      $("#waitscreen").addClass("red");
    }
  });

})(this.jQuery);