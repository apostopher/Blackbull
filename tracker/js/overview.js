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
   var trans_left = 1;
   var day_date;
   
   /* once the page is loaded, get all the data from PHP */
   $.getJSON("/serverscripts/portfolio/getOverview.php?pfid="+pfid+"&trid="+trid+"&uuid="+user_id,function(jsontrades){
     if(jsontrades.pagefound == "1"){
       $("#trade_name").html(jsontrades.trade_name);
       $("#trade_symbol").html(jsontrades.trade_symbol);
       $("#ltpprice").html(jsontrades.last);
       $("#ltpchg").html(jsontrades.change);
       if(parseFloat(jsontrades.change) < 0){
         if(!$("#trade_ltp").hasClass("down")){
           $("#trade_ltp").addClass("down");
         }
       }else{
         if($("#trade_ltp").hasClass("down")){
           $("#trade_ltp").removeClass("down");
         }
       }
       /* start the LTP loop*/
       var user_id = $("#container").attr("class");
       getLTP(jsontrades.trade_symbol, user_id);
       
       /*if(jsontrades.closetotal > 10){*/
       /* draw the chart only if there are more than 10 points */
       /* declare Highcharts options */
       /* highcharts version used: 2.1.1 on 24-dec-2010 */
       var minseries = 0;
       var maxseries = 0;
       var closeoptions = {
           chart: {renderTo: 'chartholder', defaultSeriesType: 'spline', showAxes:true},
    	   credits: {enabled: false}, title: {text: "Trade history", style:{color: '#075FB2'}},
    	   legend: {itemStyle: {color: '#075FB2', fontWeight: 'bold'}},
    	   xAxis: {labels: {rotation: -45, align: 'right', style: {color: '#aaa', fontSize: '12px'}}, tickmarkPlacement:"on", categories: [], reversed:true,lineColor: '#aaa', lineWidth: 1, tickColor:'#aaa'},
           yAxis: {labels: {formatter: function() {return this.value;}, style: {color: '#aaa', fontSize: '12px'}},title: {text: 'Price', style:{color: '#075FB2', fontSize: '14px'}}, gridLineColor:"#F1F1F1",
           plotLines: [], lineColor: '#aaa', lineWidth: 0, tickColor:'#aaa', tickPixelInterval: 50}, series: [], tooltip:{formatter:function(){
           if(this.point.id){
             var toolarray =  this.point.id.split("_");
             var returntxt = "Close: " + this.y +" Rs.<br/><br/>";
             for(var toolcount = 0; toolcount + 4 < toolarray.length; toolcount = toolcount + 4){
               if(toolarray[toolcount + 3] == "1"){
                 if(toolarray[toolcount + 2] > 1){
                   returntxt = returntxt + "<b>Bought</b> " + toolarray[toolcount + 2]+" shares @"+toolarray[toolcount + 1] + " Rs.<br/>";
                 }else{
                   returntxt = returntxt + "<b>Bought</b> " + toolarray[toolcount + 2]+" share @"+toolarray[toolcount + 1] + " Rs.<br/>";
                 }
               }
               if(toolarray[toolcount + 3] == "-1"){
                 if(toolarray[toolcount + 2] > 1){
                   returntxt = returntxt + "<b>Sold</b> " + toolarray[toolcount + 2]+" shares @"+toolarray[toolcount + 1] + " Rs.<br/>";
                 }else{
                   returntxt = returntxt + "<b>Sold</b> " + toolarray[toolcount + 2]+" share @"+toolarray[toolcount + 1] + " Rs.<br/>";
                 }
               }
             }
             return returntxt;
           }else{
             return "Close: " + this.y + " Rs.";
           }
           },backgroundColor:"rgba(255, 255, 255, 1)"}};
       /* define the series of close values */  
       var closevals = {name:jsontrades.trade_symbol, type:'spline', data: [], color:"#075FB2"};
       
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
            var first_run = true;
            while(jsontrades.close[closei].d == curr_date){
             /* If I find BUY and SELL transactions on same day then i set curr_type to 2.
              * but need to reset this to normal */
             if(transcount > 0)
             /* if the consecutive transactions are different and if this is not a first_run then set the curr_type to 2
                first run is required because the comparison must be made between transactions that occured on same day. */
             if((jsontrades.trans[transcount -1].trans_type != jsontrades.trans[transcount].trans_type) && !first_run){
               curr_type = 2;
             }
             idtxt = idtxt + closei + "_" + jsontrades.trans[transcount].trans_price;
             idtxt = idtxt + "_" + jsontrades.trans[transcount].trans_qty + "_" + jsontrades.trans[transcount].trans_type + "_";
             transcount = transcount + 1;
             curr_date = jsontrades.trans[transcount].trans_date;
             /* First run is over so set the flag to false */
             first_run = false;
            }
            if(curr_type != 2){
              curr_type = jsontrades.trans[transcount -1].trans_type;
            }
           }else{
             /* all transactions are done */
             /* Update the id text */
             idtxt = idtxt + closei + "_" + jsontrades.trans[transcount].trans_price;
             idtxt = idtxt + "_" + jsontrades.trans[transcount].trans_qty + "_" + jsontrades.trans[transcount].trans_type + "_";
             trans_left = 0;
             curr_date= '';
           }
           if(curr_type == 1){
             /* It is a BUY transaction */
             var transpoint = {y: parseFloat(jsontrades.close[closei].c),
                             marker: {symbol: "url(http://blackbull.in/tracker/images/buy.png)"}, id:idtxt};
           }else if(curr_type == -1){
             /* It is a SELL transaction */
             var transpoint = {y: parseFloat(jsontrades.close[closei].c),
                             marker: {symbol: "url(http://blackbull.in/tracker/images/sell.png)"}, id:idtxt};
           }else{
             /* It is a BUY+SELL transaction */
             var transpoint = {y: parseFloat(jsontrades.close[closei].c),
                             marker: {symbol: "url(http://blackbull.in/tracker/images/buysell.png)"}, id:idtxt};
           }
           closevals.data.push(transpoint);
           /* now reset the curr_type */
           curr_type = jsontrades.trans[transcount].trans_type;
         }else{
           /* no transactions match this date */
           /* Check whether the CLOSE array date is smaller than trans date 
            * This means user added a transaction on a holiday. :-) so we need to fix curr_date */
           close_date = new Date(Date.parse(jsontrades.close[closei].jd));
           ctrans_date = new Date(Date.parse(jsontrades.trans[transcount].trans_jdate));
           if(close_date < ctrans_date && trans_left){
             /* go to next curr_date */
             var old_curr_date = curr_date;
             transcount = transcount + 1;
             curr_date = jsontrades.trans[transcount].trans_date;
             curr_type = jsontrades.trans[transcount].trans_type;
             while(old_curr_date == curr_date){
               transcount = transcount + 1;
               curr_date = jsontrades.trans[transcount].trans_date;
               curr_type = jsontrades.trans[transcount].trans_type;
             }
             /* Now curr_date is a new date. but check whether it matches the current CLOSE date */
             if(curr_date == jsontrades.close[closei].d){
               /* Need to run the loop again */
               closei--;
               continue;
             }
           }
           closevals.data.push(parseFloat(jsontrades.close[closei].c));
         }
         /* Add X- Axis labels */
         closeoptions.xAxis.categories.push(jsontrades.close[closei].xd);
         
         if(minseries > jsontrades.close[closei].c){
           minseries = parseFloat(jsontrades.close[closei].c);
         }
         
         if(maxseries < jsontrades.close[closei].c){
           maxseries = parseFloat(jsontrades.close[closei].c);
         }
       }
       closeoptions.series.push(closevals);
       
       /* add transactions */
       transhtml = "<div id=\"transbodydiv\">";
        var totalqty = 0;
        var avgbuy  = 0;
        var sellqty = 0;
        var rreturns = 0;
        var urreturns = 0;
        for(tcount = 0; tcount < jsontrades.transtotal; tcount++){
          if(tcount+1 == jsontrades.transtotal){
            if(tcount%2 == 1){
              transhtml += "<div class=\"bodydivlast odd clearfix\"><div class=\"srno\">"+(tcount+1)+".</div>";
            }else{
              transhtml += "<div class=\"bodydivlast clearfix\"><div class=\"srno\">"+(tcount+1)+".</div>";
            }
          }else{
            if(tcount%2 == 1){
              transhtml += "<div class=\"bodydiv odd clearfix\"><div class=\"srno\">"+(tcount+1)+".</div>";
            }else{
              transhtml += "<div class=\"bodydiv clearfix\"><div class=\"srno\">"+(tcount+1)+".</div>";
            }
          }
          if(jsontrades.trans[tcount].trans_type == 1){
            transhtml += "<div class=\"ttype\"><a href=\"javascript:void(0);\">Bought</a></div>";
            totalqty += parseInt(jsontrades.trans[tcount].trans_qty);
            urreturns += (jsontrades.trans[tcount].trans_qty*jsontrades.trans[tcount].trans_price);
          }else{
            transhtml += "<div class=\"ttype\"><a href=\"javascript:void(0);\">Sold</a></div>";
            sellqty += parseInt(jsontrades.trans[tcount].trans_qty);
            rreturns += (jsontrades.trans[tcount].trans_qty*jsontrades.trans[tcount].trans_price);
          }
          transhtml += "<div class=\"tdate\">"+jsontrades.trans[tcount].trans_date+"</div>";
          transhtml += "<div class=\"tprice\">"+jsontrades.trans[tcount].trans_price+"</div>";
          transhtml += "<div class=\"tqty\">"+jsontrades.trans[tcount].trans_qty+"</div>";
          transhtml += "<div class=\"trcontrol lastcell\">&nbsp;</div></div>";
        }
        transhtml += "</div>";
        /*calculate average buy */
        avgbuy = jsontrades.avg_buy;
        
        /* update invested capital */
        $("#invest_cap_div").html(urreturns);
        
        /* update current value */
        $("#current_val_div").html(sprintf("%.1f",totalqty*jsontrades.last));
        
        /*update buy quantity */
        $("#buy_qty_div").html(totalqty);
        
        /*update buy quantity */
        $("#sell_qty_div").html(sellqty);
        
        /* update realized returns */
        var rreturnsstr = sprintf("%.1f",rreturns - (sellqty*avgbuy));
        $("#r_ret_div").html(rreturnsstr);
        if(parseFloat(rreturnsstr) < 0){
          if(!$("#r_ret_div").hasClass("down")){
            $("#r_ret_div").addClass("down");
          }
        }
        
        /* update unrealized returns */
        var urreturnsstr = sprintf("%.1f", (totalqty - sellqty)*(jsontrades.last-avgbuy));
        $("#unr_ret_div").html(urreturnsstr);
        if(parseFloat(urreturnsstr) < 0){
          if(!$("#unr_ret_div").hasClass("down")){
            $("#unr_ret_div").addClass("down");
          }
        }else{
          if($("#unr_ret_div").hasClass("down")){
            $("#unr_ret_div").removeClass("down");
          }
        }
        
        /* update average buy */
        $("#avg_price_div").html(avgbuy);
        if(parseFloat(avgbuy) < parseFloat(jsontrades.last)){
          if($("#avg_price_div").hasClass("down")){
           $("#avg_price_div").removeClass("down");
         }
        }else{
          if(!$("#avg_price_div").hasClass("down")){
           $("#avg_price_div").addClass("down");
         }
        }
        
        /* update market value */
        $("#marketval").html(sprintf("%.1f", totalqty*jsontrades.last));
        
        /* Now set the transactions html */
       if(transhtml){
         $("#transbody").html(transhtml);
       }
       
       /* add the targets if any */
       targethtml = "";
       activevalue ="activevalue";
       if(jsontrades.targetstotal > 0){
         maxValue = 0;
         targethtml = "";
         for(var count=0; count < jsontrades.targetstotal; count++){
           arrayelement = new Array();
           arrayelement['width'] = 1;
           arrayelement['value'] = jsontrades.targets[count].target;
           arrayelement['id'] = "tg" + jsontrades.targets[count].target;
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
           /* add the target information to target table below the chart */
           if(count+1 == jsontrades.targetstotal){
            if(count%2 == 1){
              targethtml += "<div class=\"bodydivlast odd clearfix\"><div class=\"srno\">"+(count+1)+".</div>";
            }else{
              targethtml += "<div class=\"bodydivlast clearfix\"><div class=\"srno\">"+(count+1)+".</div>";
            }
          }else{
            if(count%2 == 1){
              targethtml += "<div class=\"bodydiv odd clearfix\"><div class=\"srno\">"+(count+1)+".</div>";
            }else{
              targethtml += "<div class=\"bodydiv clearfix\"><div class=\"srno\">"+(count+1)+".</div>";
            }
          }
           targethtml = targethtml + "<div class=\"trvalue "+ activevalue +"\">"+jsontrades.targets[count].target+"</div>";
           targethtml += "<div class=\"trcontrol lastcell\">&nbsp;</div></div>";
           /* reset active value after first run */
           activevalue ="";
         }
         /* The plot scale must be adjusted to fit max target */
         if(maxValue !=0 && maxValue > maxseries && maxValue < (1.2*maxseries)){
           closeoptions.yAxis.max = maxValue + parseInt(0.05*maxValue);
         }
       }else{
         targethtml = "<div class=\"bodydivlast\"><div class=\"loadmsg\">No data.</div></div>";
       }
       /* Now update the target html */
       if(targethtml){
         $("#targetbody").html(targethtml);
       }
       /* add the stop losses if any */
       slhtml = "";
       activevalue ="activevalue";
       if(jsontrades.sltotal > 0){
         minValue = 0;
         slhtml = "";
         for(var count=0; count < jsontrades.sltotal; count++){
           if(count == 0){
             minValue = parseFloat(jsontrades.sls[count].stoploss);
           }
           arrayelement = new Array();
           arrayelement['width'] = 1;
           arrayelement['value'] = jsontrades.sls[count].stoploss;
           arrayelement['id'] = "sl" + jsontrades.sls[count].stoploss;
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
           /* add the stop loss information to stop loss table below the chart */
           if(count+1 == jsontrades.sltotal){
            if(count%2 == 1){
              slhtml += "<div class=\"bodydivlast odd clearfix\"><div class=\"srno\">"+(count+1)+".</div>";
            }else{
              slhtml += "<div class=\"bodydivlast clearfix\"><div class=\"srno\">"+(count+1)+".</div>";
            }
          }else{
            if(count%2 == 1){
              slhtml += "<div class=\"bodydiv odd clearfix\"><div class=\"srno\">"+(count+1)+".</div>";
            }else{
              slhtml += "<div class=\"bodydiv clearfix\"><div class=\"srno\">"+(count+1)+".</div>";
            }
          }
           slhtml = slhtml + "<div class=\"slvalue "+ activevalue +"\">"+jsontrades.sls[count].stoploss+"</div>";
           slhtml += "<div class=\"trcontrol lastcell\">&nbsp;</div></div>";
           /* reset active value after first run */
           activevalue ="";
         }
         /* The plot scale must be adjusted to fit min stoploss */
         if(minValue !=0 && minValue < minseries && minValue > (0.8*minseries)){
           closeoptions.yAxis.min = minValue - parseInt(0.05*minValue);
         } 
       }else{
         slhtml = "<div class=\"bodydivlast\"><div class=\"loadmsg\">No data.</div></div>";
       }
       /* Now update the SL html */
       if(slhtml){
         $("#slbody").html(slhtml);
       }
       $("#waitscreen").hide();
       $("#chartholder").show();
       var chartfd = new Highcharts.Chart(closeoptions);
       /*}*/
    }else{
      $("#waitscreen").html("Page not found.");
      $("#waitscreen").addClass("red");
    }
  });

})(this.jQuery);

/* periodically get last traded price for all the scrips. hence setTimeout*/
function getLTP(scrips, user_id){
    if(scrips.length > 0){
    $.getJSON("/serverscripts/portfolio/getLTP.php?user="+user_id+"&scrips="+scrips,function(jsonLTP){
        var avg_buy = $("#avg_price_div").html();
        var buy_qty = $("#buy_qty_div").html();
        var sell_qty = $("#sell_qty_div").html();
        var market_qty = parseInt(buy_qty) - parseInt(sell_qty);
        for(count=0; count < jsonLTP.total; count++){
            $("#ltpprice").html(jsonLTP.data[count].ltp);
            $("#ltpchg").html(jsonLTP.data[count].change);
            $("#current_val_div").html(sprintf("%.1f", market_qty*parseFloat(jsonLTP.data[count].ltp)));
            if(parseFloat(jsonLTP.data[count].change) < 0){
              if(!$("#trade_ltp").hasClass("down")){
                $("#trade_ltp").addClass("down");
              }
            }else{
              if($("#trade_ltp").hasClass("down")){
                $("#trade_ltp").removeClass("down");
              }
            }
            var unret = market_qty*(parseFloat(jsonLTP.data[count].ltp) - parseFloat(avg_buy));
            $("#unr_ret_div").html(sprintf("%.1f", unret));
            if(parseFloat(unret) < 0){
              if(!$("#unr_ret_div").hasClass("down")){
                $("#unr_ret_div").addClass("down");
              }
            }else{
              if($("#unr_ret_div").hasClass("down")){
                $("#unr_ret_div").removeClass("down");
              }
            }
        }
        setTimeout(function(){getLTP(scrips, user_id);},10000);
    });
    }else{
        setTimeout(function(){getLTP(scrips, user_id);},10000);
    }
    return false;
}