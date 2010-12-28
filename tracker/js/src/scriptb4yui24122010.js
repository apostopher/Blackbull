/* Author: Rahul Devaskar

*/
(function($){
  var requestInProcess = false;
  var cashrequestInProcess = false;
  var tradesbody = $("#porttableholder");
  var scrip_name = $("#trans_scrip");
  var result = $("#autoresults");
  var jsonRsp = null;
  var hovered = false;
  var scrip_qname = $("#trans_qscrip");
  var scrip_price = $("#trans_price");
  var portfolio_id = $("#foliosummary").attr("rel");
  var user_id = $("#container").attr("class");
  var managecasha = $("#managecasha");
  var addtransa = $("#addtransa");
  var cashform = $("#cashfrmholder");
  var transform = $("#formslide");
  var formsholder = $("#formholder");
  
  
  $(":date").dateinput({format:'yyyy-mm-dd'});
  $.getJSON("/serverscripts/portfolio/getTrades.php?portfolio="+portfolio_id+"&user="+user_id,function(jsontrades){
      trades_html="";
      scrip_symbols = "";
      invested_value = 0;
      for(count=0; count < jsontrades.total; count++){
          trades_html += "<div class=\"bodydiv clearfix\" id=\""+jsontrades.data[count].scrip_symbol.replace('.', '_')+"\">";
          trades_html += "<div class=\"first\"><a href=\"http://blackbull.in/finance/overview?user=1&symbol="+jsontrades.data[count].scrip_symbol+"\">";
          trades_html += jsontrades.data[count].scrip_name+"</a><div class=\"subrow clearfix\"><span class=\"symbolname\">"+jsontrades.data[count].scrip_symbol+"</span></div></div>";
          trades_html += "<div class=\"ltp\"><div class=\"ltpval\">"+jsontrades.data[count][0]+"</div>";
          if(jsontrades.data[count][1] < 0){
              trades_html += "<div class=\"pchange negative\">"+jsontrades.data[count][1]+"</div></div>";
          }else{
              trades_html += "<div class=\"pchange\">"+jsontrades.data[count][1]+"</div></div>";
          }
          trades_html += "<div class=\"avgbuy\">"+jsontrades.data[count].trade_avg_buy+"</div>";
          trades_html += "<div class=\"tradeqty\">"+jsontrades.data[count].trade_qty+"</div>";
          if(jsontrades.data[count][2] < 0){
              trades_html += "<div class=\"profitloss negative\">"+jsontrades.data[count][2]+"</div></div>";
          }else{
              trades_html += "<div class=\"profitloss\">"+jsontrades.data[count][2]+"</div></div>";
          }
          scrip_symbols = scrip_symbols + jsontrades.data[count].scrip_symbol + "+";
          invested_value += (jsontrades.data[count].trade_avg_buy*jsontrades.data[count].trade_qty);
      }
      $("#cashvalue").html(sprintf("%.1f", parseFloat(jsontrades.cash)));
      $("#marketvalue").html(sprintf("%.1f", invested_value));
      tradesbody.append(trades_html);
      tradesbody.attr("data-symbols", scrip_symbols);
      scripdivs = $(".bodydiv");
      scripdivs.slideDown("slow");
      getLTP(tradesbody);
      getIndices();
  });
  
  scrip_name.blur(function(){
      if(hovered == false){
          result.addClass("hidden");
          result.html("");
      }
  });
  
    scrip_name.keyup(function(event){
      if(!(event.which >= 16 && event.which<=18) && !(event.which >= 112 && event.which<=123) && event.which!=27){
          if(scrip_name.val().length >= 3) {
              if(jsonRsp){
                  jsonRsp.abort();
                  jsonRsp = null;
              }
              result.removeClass("hidden");
              result.html("loading...");
              jsonRsp = $.getJSON("/serverscripts/symbollookup.php?scrip="+scrip_name.val(),function(json){
                  result.html("");
                  html="";
                  for(i=0; i< json.ResultSet.Result.length; i++) {
                    if((json.ResultSet.Result[i].symbol.toUpperCase().indexOf(".BO") != -1 || 
                        json.ResultSet.Result[i].symbol.toUpperCase().indexOf(".NS") != -1)&& 
                       (json.ResultSet.Result[i].symbol.toUpperCase().indexOf("_A.") == -1)&&
                       (json.ResultSet.Result[i].name.toUpperCase().indexOf("FUTURE") == -1)){
                      html += '<div class="result_item clearfix">';
                      html += '<div class="scrip_name" data-name="'+json.ResultSet.Result[i].symbol+'" data-qname="'+json.ResultSet.Result[i].name+'">';
                      html += json.ResultSet.Result[i].name;
                      html += '</div>';
                      html += '<div class="scrip_symbol">';
                      html += json.ResultSet.Result[i].symbol;
                      html += '</div>'
                      html += '<div class="scrip_xchange">';
                      html += json.ResultSet.Result[i].exch;
                      html += '</div>';
                      html += '</div>';
                    }
                  }
                  if(html == ""){
                      html = "Symbol not found.";
                  }
                   result.html(html);
                   result.hover(
                       function(){hovered = true;},
                       function(){hovered = false;}
                   );
                   $(".result_item").hover(
                       function(){$(this).css("backgroundColor","#FFF9B8");},
                       function(){$(this).css("backgroundColor","#fff");
                   });
                   $(".result_item").click(function(){
                       scrip_name.val($(this).children(".scrip_name").attr("data-name"));
                       scrip_qname.val($(this).children(".scrip_name").attr("data-qname"));
                       result.addClass("hidden");
                       result.html("");
                   });
              });
          }else{
              result.addClass("hidden");
              result.html("");
          }
      }
  });
  $("#cmpa").click(function(event){
      event.preventDefault();
      
      if(scrip_name.val().length >= 3){
          scrip_price.addClass("gettingprice");
          scrip_price.val("Retrieving price...");
          $.getJSON("/serverscripts/portfolio/getPrice.php?scrip="+scrip_name.val(),function(json){
              if(json.value !=0){
                  scrip_price.val(json.value);
              }else{
                  scrip_price.val("");
              }
              scrip_price.removeClass("gettingprice");
          });
      }
  });
  addtransa.click(function(event){
    event.preventDefault();
    if(managecasha.hasClass("activetab")){
      managecasha.removeClass("activetab");
    }
    if(!managecasha.hasClass("inactivetab")){
      managecasha.addClass("inactivetab");
    }
    if(cashform.hasClass("open")){
      cashform.removeClass("open");
      cashform.hide();
      transform.addClass("open");
      transform.show();
      if($(this).hasClass("inactivetab")){
        $(this).removeClass("inactivetab");
      }
      if(!$(this).hasClass("activetab")){
        $(this).addClass("activetab");
      }
      return true;
    }
    
    if(transform.hasClass("open")){
      transform.removeClass("open");
      transform.slideUp("slow");
      formsholder.removeClass("grayed");
      if($(this).hasClass("activetab")){
        $(this).removeClass("activetab");
      }
      if($(this).hasClass("inactivetab")){
        $(this).removeClass("inactivetab");
      }
      if(managecasha.hasClass("inactivetab")){
        managecasha.removeClass("inactivetab");
      }
      return true;
    }
    if(!$(this).hasClass("activetab")){
        $(this).addClass("activetab");
    }
    transform.addClass("open");
    transform.slideDown("slow");
    formsholder.addClass("grayed");
  });
  
  
  managecasha.click(function(event){
    event.preventDefault();
    if(addtransa.hasClass("activetab")){
      addtransa.removeClass("activetab");
    }
    if(!addtransa.hasClass("inactivetab")){
      addtransa.addClass("inactivetab");
    }
    if(transform.hasClass("open")){
      transform.removeClass("open");
      transform.hide();
      cashform.addClass("open");
      cashform.show();
      
      if($(this).hasClass("inactivetab")){
        $(this).removeClass("inactivetab");
      }
      if(!$(this).hasClass("activetab")){
        $(this).addClass("activetab");
      }
      return true;
    }
    
    if(cashform.hasClass("open")){
      cashform.removeClass("open");
      cashform.slideUp("slow");
      formsholder.removeClass("grayed");
      if($(this).hasClass("activetab")){
        $(this).removeClass("activetab");
      }
      if($(this).hasClass("inactivetab")){
        $(this).removeClass("inactivetab");
      }
      if(addtransa.hasClass("inactivetab")){
        addtransa.removeClass("inactivetab");
      }
      return true;
    }
    if(!$(this).hasClass("activetab")){
        $(this).addClass("activetab");
    }
    cashform.addClass("open");
    cashform.slideDown("slow");
    formsholder.addClass("grayed");
  });
  
  
  $("#submitbtn").click(function(event){
      event.preventDefault();
      $.ajax({
          type: "POST",
          url: "/serverscripts/portfolio/addTransaction.php",
          data:({'csrf':$("#csrf").val(),
                 'portfolio_id':portfolio_id,
                 'user_id':$.trim($("#user_id").val()),
                 'trans_scrip':$.trim(scrip_name.val()),
                 'trans_qscrip':$.trim(scrip_qname.val()),
                 'trans_type':$.trim($("#trans_type").val()),
                 'includecash':$("#includecash").attr('checked')?1:0,
                 'trans_date':$.trim($("#trans_date").val()),
                 'trans_price':$.trim(scrip_price.val()),
                 'trans_qty':$.trim($("#trans_qty").val()),
                 'stoploss':$.trim($("#stoploss").val()),
                 'trans_notes':$.trim($("#trans_notes").val()) 
          }),
          dataType: "json",
          beforeSend: function(){
              if(requestInProcess){
                  return false;
              }else{
                  requestInProcess = true;
                  if(!$("#resulttxt").hasClass("hidden")){
                      $("#resulttxt").addClass("hidden");
                  }
                  $("#resulttxt").html("Please wait&hellip;");
                  if($("#resulttxt").hasClass("hidden")){
                      $("#resulttxt").removeClass("hidden");
                  }
                  return true;
              }
          },
          success: function(response){
              if($("#resulttxt").hasClass("hidden")){
                  $("#resulttxt").removeClass("hidden");
              }
              if(response.status == "1"){
                  $("#resulttxt").html("Transaction added successfully!");
                  if(response.new_trade == "1"){
                      var new_row = "<div class=\"bodydiv clearfix\" id=\""+scrip_name.val().replace('.', '_')+"\"><div class=\"first\"";
                      new_row += "<a href=\"http://blackbull.in/finance/overview?user=1&symbol=" + scrip_name.val()+ "\">";
                      new_row += response.qname + "</a><div class=\"subrow clearfix\"><span class=\"symbolname\">"+scrip_name.val()+"</span></div></div>";
                      new_row += "<div class=\"ltp\"><div class=\"ltpval\">" + response.ltp+"</div>";
                      if(response.stockchg < 0){
                          new_row += "<div class=\"pchange negative\">" + response.stockchg + "</div></div>";
                      }else{
                          new_row += "<div class=\"pchange\">" + response.stockchg + "</div></div>";
                      }
                      new_row += "<div class=\"avgbuy\">" + response.avg_buy + "</div>";
                      new_row += "<div class=\"tradeqty\">" + response.trade_qty + "</div>";
                      new_row += "<div class=\"profitloss\">loading&hellip;</div></div>";
                      scrip_symbols = tradesbody.attr("data-symbols");
                      scrip_symbols = scrip_symbols + scrip_name.val() + "+";
                      tradesbody.attr("data-symbols",scrip_symbols);
                      tradesbody.append(new_row);
                      $("#"+scrip_name.val().replace('.', '_')).slideDown("slow");
                      /* TODO: add conditional to handle BUY SELL */
                      market_value = parseFloat($("#marketvalue").html()) + parseFloat(response.avg_buy*response.trade_qty);   
                      $("#marketvalue").html(market_value);
                  }else{
                      var editrow = "#"+scrip_name.val().replace('.', '_');
                      $(editrow+" .avgbuy").html(response.avg_buy);
                      $(editrow+" .tradeqty").html(response.trade_qty);
                      $(editrow+" .profitloss").html("loading&hellip;");
                  }
              }else{
                  $("#resulttxt").html(response.error);
              }
              requestInProcess = false;
          },
          error: function(){
              requestInProcess = false;
          }
      });
  });
  
  $("#cashsubmitbtn").click(function(event){
    event.preventDefault();
    $.ajax({
      type: "POST",
      url: "/serverscripts/portfolio/managecash.php",
      data:({'csrf':$("#cashcsrf").val(),
             'portfolio_id':portfolio_id,
             'amount':$.trim($("#cashinrs").val()),
             'cash_type':$.trim($("#cash_type").val()),
             'cash_date':$.trim($("#cash_date").val()),
             'cash_notes':$.trim($("#cash_notes").val())
             }),
      beforeSend: function(){
        if(cashrequestInProcess){
          return false;
        }else{
          cashrequestInProcess = true;
          if(!$("#cashresulttxt").hasClass("hidden")){
            $("#cashresulttxt").addClass("hidden");
          }
          $("#cashresulttxt").html("Please wait&hellip;");
          if($("#cashresulttxt").hasClass("hidden")){
            $("#cashresulttxt").removeClass("hidden");
          }
          return true;
        }
      },
      success:function(response){
        cashrequestInProcess = false;
        if($("#cashresulttxt").hasClass("hidden")){
          $("#cashresulttxt").removeClass("hidden");
        }
        if(response.status == "1"){
          $("#cashresulttxt").html(response.message);
          totalcash = parseFloat($("#cashvalue").html()) + response.cash;
          $("#cashvalue").html(sprintf("%.1f", totalcash));
        }else{
          $("#cashresulttxt").html(response.error);
        }
      },
      error:function(){
        cashrequestInProcess = false;
      }
  });
  });
  
})(this.jQuery);

function getLTP(scripnames){
    scrips = scripnames.attr("data-symbols");
    var user_id = $("#container").attr("class");
    ureturns = 0;
    net_value= 0;
    if(scrips.length > 0){
    $.getJSON("/serverscripts/portfolio/getLTP.php?user="+user_id+"&scrips="+scrips,function(jsonLTP){
        for(count=0; count < jsonLTP.total; count++){
            scripsymbol = "#"+jsonLTP.data[count].symbol.replace('.', '_');
            $(scripsymbol+" .ltpval").html(jsonLTP.data[count].ltp);
            $(scripsymbol+" .pchange").html(jsonLTP.data[count].change);
            if(jsonLTP.data[count].change < 0){
               if(!$(scripsymbol+" .pchange").hasClass("negative")){
                   $(scripsymbol+" .pchange").addClass("negative");
               }
            }else{
               if($(scripsymbol+" .pchange").hasClass("negative")){
                   $(scripsymbol+" .pchange").removeClass("negative");
               }
            }
            var scripavgbuy = $(scripsymbol+" .avgbuy").html();
            var scripqty = $(scripsymbol+" .tradeqty").html();
            var scripltp = jsonLTP.data[count].ltp;
            var scripchg = ((parseFloat(scripltp) - parseFloat(scripavgbuy))*parseInt(scripqty));
            ureturns += scripchg;
            net_value += (jsonLTP.data[count].ltp*scripqty);
            $(scripsymbol+" .profitloss").html(sprintf("%.1f", scripchg));
            if(scripchg < 0){
               if(!$(scripsymbol+" .profitloss").hasClass("negative")){
                   $(scripsymbol+" .profitloss").addClass("negative");
               }
            }else{
               if($(scripsymbol+" .profitloss").hasClass("negative")){
                   $(scripsymbol+" .profitloss").removeClass("negative");
               }
            }
        }
        $("#ureturn").html(sprintf("%.1f", ureturns));
        $("#netvalue").html(sprintf("%.1f", net_value));
        setTimeout(function(){getLTP(scripnames);},10000);
    });
    }else{
        setTimeout(function(){getLTP(scripnames);},10000);
    }
}

function getIndices(){
	$.getJSON("/serverscripts/getindices.php",function(response){
		if(response.error == "0"){
		  if(parseFloat(response.values[0].change) < 0){
		    
		  }else{
		  }
		  $("#nifty .indexvalue").html(response.values[0].price);
		  $("#nifty .indexchange").html(response.values[0].change+" / "+response.values[0].perchange);
		  if(parseFloat(response.values[1].change) < 0){
		  }else{
		  }
		  $("#sensex .indexvalue").html(response.values[1].price);
		  $("#sensex .indexchange").html(response.values[1].change+" / "+response.values[1].perchange);
		}
		setTimeout(getIndices,10000);
	});
}