/* Author: Rahul Devaskar

*/
(function ($, window, sprintf) { /* Variable declatations block - start */
/* Just to make sure that same request is not made again when users accidently press the submit button
   * requestInProcess and  cashrequestInProcess are used.*/
    var requestInProcess = false,
        cashrequestInProcess = false,
        jsonRsp = null,
        /* just to get hold of all the DOM elements that I am going to use I declare these variables. */
        tradesbody = $("#porttableholder"),
        scrip_name = $("#trans_scrip"),
        result = $("#autoresults"),
        scrip_qname = $("#trans_qscrip"),
        scrip_price = $("#trans_price"),
        headdiv = $("#portheadback"),
        /* PHP script fills the portfolio id from $_SESSION variable */
        portfolio_id = $("#foliosummary").attr("rel"),
/* This stores the user_id again from $_SESSION by PHP
   * I have intentionally used 'class' here, if I make user defined styles support in future. */
        user_id = $("#container").attr("class"),
        /* Add transaction and manage cash tabs DOM elements */
        managecasha = $("#managecasha"),
        addtransa = $("#addtransa"),
        cashform = $("#cashfrmholder"),
        transform = $("#formslide"),
        formsholder = $("#formholder"),
        /* Apple style lock scroll functionality */
        headerdivloc = headdiv.offset().top,
        headerdivh = headdiv.height(),
        niftyindex = $("#nifty .indexvalue"),
        niftychg = $("#nifty .indexchange"),
        sensexindex = $("#sensex .indexvalue"),
        sensexchg = $("#sensex .indexchange"),
        user_id = $("#container").attr("class"),
        ureturndiv = $("#ureturn"),
        nettvalue = $("#netvalue"),
        ureturns = 0,
        net_value = 0,
        scripavgbuy,
        scripqty,
        scripltp,
        scripchg,
        perchange,
        count,
        scripsymbol,
        hovered = false; /* Variable declatations block - end */
    /* periodically get last traded price for all the scrips. hence setTimeout*/

    function getLTP(scripnames) {
        var scrips = scripnames.attr("data-symbols");
        if (scrips.length > 0) {
            $.getJSON("/serverscripts/portfolio/getLTP.php?user=" + user_id + "&scrips=" + scrips, function (jsonLTP) {
                for (count = 0; count < jsonLTP.total; count += 1) {
                    scripsymbol = "#" + jsonLTP.data[count].symbol.replace('.', '_');
                    $(scripsymbol + " .ltpval").html(jsonLTP.data[count].ltp);
                    $(scripsymbol + " .pchange").html(jsonLTP.data[count].change);
                    if (jsonLTP.data[count].change < 0) {
                        if (!$(scripsymbol + " .pchange").hasClass("negative")) {
                            $(scripsymbol + " .pchange").addClass("negative");
                        }
                    } else {
                        if ($(scripsymbol + " .pchange").hasClass("negative")) {
                            $(scripsymbol + " .pchange").removeClass("negative");
                        }
                    }
                    scripavgbuy = $(scripsymbol + " .avgbuy").html();
                    scripqty = $(scripsymbol + " .tradeqty").html();
                    scripltp = jsonLTP.data[count].ltp;
                    scripchg = ((parseFloat(scripltp) - parseFloat(scripavgbuy)) * parseInt(scripqty, 10));
                    perchange = ((parseFloat(scripltp) - parseFloat(scripavgbuy)) * 100) / parseFloat(scripavgbuy);
                    ureturns += scripchg;
                    net_value += (jsonLTP.data[count].ltp * scripqty);
                    $(scripsymbol + " .profitloss .abs").html(sprintf("%.1f", scripchg));
                    $(scripsymbol + " .profitloss .cent").html(sprintf("%.1f", perchange) + "%");
                    if (scripchg < 0) {
                        if (!$(scripsymbol + " .profitloss").hasClass("negative")) {
                            $(scripsymbol + " .profitloss").addClass("negative");
                        }
                    } else {
                        if ($(scripsymbol + " .profitloss").hasClass("negative")) {
                            $(scripsymbol + " .profitloss").removeClass("negative");
                        }
                    }
                }
                if (ureturns < 0) {
                    if (!ureturndiv.hasClass("negative")) {
                        ureturndiv.addClass("negative");
                    }
                } else {
                    if (ureturndiv.hasClass("negative")) {
                        ureturndiv.removeClass("negative");
                    }
                }
                ureturndiv.html(sprintf("%.1f", ureturns));
                nettvalue.html(sprintf("%.1f", net_value));
                setTimeout(function () {
                    getLTP(scripnames);
                }, 10000);
            });
        } else {
            setTimeout(function () {
                getLTP(scripnames);
            }, 10000);
        }
        return false;
    } /* periodically get sensex and nifty values. hence setTimeout*/

    function getIndices() {
        $.getJSON("/serverscripts/getindices.php", function (response) {
            if (response.error === "0") {
                if (parseFloat(response.values[0].change) < 0) {
                    if (!niftyindex.hasClass("red")) {
                        niftyindex.addClass("red");
                    }
                } else {
                    if (niftyindex.hasClass("red")) {
                        niftyindex.removeClass("red");
                    }
                }
                niftyindex.html(response.values[0].price);
                niftychg.html(response.values[0].change + " / " + response.values[0].perchange);
                if (parseFloat(response.values[1].change) < 0) {
                    if (!sensexindex.hasClass("red")) {
                        sensexindex.addClass("red");
                    }
                } else {
                    if (sensexindex.hasClass("red")) {
                        sensexindex.removeClass("red");
                    }
                }
                sensexindex.html(response.values[1].price);
                sensexchg.html(response.values[1].change + " / " + response.values[1].perchange);
            }
            setTimeout(getIndices, 10000);
        });
        return false;
    }
/* Jquery tools date input plugin used at the time of this writting
   * the version of Jquery tools used is 1.2.5 */
    $(":date").dateinput({
        format: 'yyyy-mm-dd'
    });
    $(window).scroll(function () {
        if ($(window).scrollTop() >= headerdivloc) {
            headdiv.css({
                "position": "fixed",
                "top": 0
            }); /* Add for border-top + padding-top + padding-bottom + border-bottom + margin-bottom */
            tradesbody.css("paddingTop", headerdivh + 5);
        }
        if ($(window).scrollTop() < headerdivloc) {
            headdiv.css({
                "position": "static",
                "top": ""
            });
            tradesbody.css("paddingTop", 0);
        }
        return false;
    }); /* abs vs percent profit loss buttons */
    $("#inRs").click(function () {
        if (!$(this).hasClass("on")) {
            $(this).addClass("on");
            if ($("#incent").hasClass("on")) {
                $("#incent").removeClass("on");
            }
            if ($(".abs").css('marginTop') !== "0px") {
                $(".abs").animate({
                    marginTop: "0"
                }, 'fast');
            }
        }
    });
    $("#incent").click(function () {
        if (!$(this).hasClass("on")) {
            $(this).addClass("on");
            if ($("#inRs").hasClass("on")) {
                $("#inRs").removeClass("on");
            }
            if ($(".abs").css('marginTop') === "0px") {
                $(".abs").animate({
                    marginTop: "-20"
                }, 'fast');
            }
        }
    }); /* Once the document is loaded first thing that I do is get the trades for the user and corresponding portfolio */
    $.getJSON("/serverscripts/portfolio/getTrades.php?portfolio=" + portfolio_id + "&user=" + user_id, function (jsontrades) {
/*
       SAMPLE JSON returned from PHP getTrades.php
      {"status":"1",
     "total":5,
     "data":[{"trade_id":"1","scrip_symbol":"TCS.NS","scrip_name":"Tata Consultancy Services Ltd.","trade_qty":"10","trade_avg_buy":"1166.7","0":"1134.35","1":"-5.65","2":-32.35},...],
     "cash":"20580"}
    */
        /* Declare local variables */
        var trades_html = "",
            scrip_symbols = "",
            invested_value = 0,
            trade_array = [],
            count; /* Run the for loop on all the trades returned by PHP and generate HTML */
        for (count = 0; count < jsontrades.total; count += 1) {
            trades_html += "<div class=\"bodydiv clearfix\" id=\"" + jsontrades.data[count].scrip_symbol.replace('.', '_') + "\">";
            trades_html += "<div class=\"first\"><a href=\"http://blackbull.in/finance/overview?bbid=" + user_id + "&pfid=" + portfolio_id + "&trid=" + jsontrades.data[count].trade_id + "\">";
            trades_html += jsontrades.data[count].scrip_name + "</a><div class=\"subrow clearfix\"><span class=\"symbolname\">" + jsontrades.data[count].scrip_symbol + "</span></div></div>";
            trades_html += "<div class=\"ltp\"><div class=\"ltpval\">" + jsontrades.data[count][0] + "</div>";
            if (jsontrades.data[count][1] < 0) {
                trades_html += "<div class=\"pchange negative\">" + jsontrades.data[count][1] + "</div></div>";
            } else {
                trades_html += "<div class=\"pchange\">" + jsontrades.data[count][1] + "</div></div>";
            }
            trades_html += "<div class=\"avgbuy\">" + jsontrades.data[count].trade_avg_buy + "</div>";
            trades_html += "<div class=\"tradeqty\">" + jsontrades.data[count].trade_qty + "</div>";
            if (jsontrades.data[count][2] < 0) {
                trades_html += "<div class=\"profitloss negative\"><div class=\"abs\">" + jsontrades.data[count][2] + "</div>";
                trades_html += "<div class=\"cent\">" + jsontrades.data[count][3] + "%</div></div></div>";
            } else {
                trades_html += "<div class=\"profitloss\"><div class=\"abs\">" + jsontrades.data[count][2] + "</div>";
                trades_html += "<div class=\"cent\">" + jsontrades.data[count][3] + "%</div></div></div>";
            }
            scrip_symbols = scrip_symbols + jsontrades.data[count].scrip_symbol + "+";
            invested_value += (jsontrades.data[count].trade_avg_buy * jsontrades.data[count].trade_qty);
        } /* Update portfolio cash and total invested value in Rs.*/
        $("#cashvalue").html(sprintf("%.1f", parseFloat(jsontrades.cash)));
        $("#marketvalue").html(sprintf("%.1f", invested_value));
        tradesbody.append(trades_html);
/* I keep the list of all the yahoo stock symbols received from PHP in a data-symbol
     * attribute so that the LTP can be obtained periodically. */
        tradesbody.attr("data-symbols", scrip_symbols); /* do some animation. I love this effect! */
        $(".bodydiv").slideDown("slow"); /* Do some extra hover effects (optional) */
        /*$(".bodydiv").hover(function(){$(this).css("backgroundColor","#F9F9F9");},function(){$(this).css("backgroundColor","#FFF");});*/
        /* Trigger functions to update the page periodically */
        getLTP(tradesbody);
        getIndices(); /* always return */
        return false;
    }); /* hide auto suggest div is the input looses focus */
    scrip_name.blur(function () {
        if (hovered === false) {
            result.addClass("hidden");
            result.html("");
        }
        return false;
    }); /* Auto suggest feature */
    scrip_name.keyup(function (event) {
        var schtml,
            i = 0;
        if (!(event.which >= 16 && event.which <= 18) && !(event.which >= 112 && event.which <= 123) && event.which !== 27) {
            if (scrip_name.val().length >= 3) {
                if (jsonRsp) {
                    jsonRsp.abort();
                    jsonRsp = null;
                }
                result.removeClass("hidden");
                result.html("loading...");
                jsonRsp = $.getJSON("/serverscripts/symbollookup.php?scrip=" + scrip_name.val(), function (json) {
                    result.html("");
                    schtml = ""; /* create div of all the auto suggested scrips from PHP */
                    for (i = 0; i < json.ResultSet.Result.length; i += 1) { /* on 24-dec-2010 I only allow indian equity markets. thus this 'IF' condition.*/
                        if ((json.ResultSet.Result[i].symbol.toUpperCase().indexOf(".BO") !== -1 || json.ResultSet.Result[i].symbol.toUpperCase().indexOf(".NS") !== -1) && (json.ResultSet.Result[i].symbol.toUpperCase().indexOf("_A.") === -1) && (json.ResultSet.Result[i].name.toUpperCase().indexOf("FUTURE") === -1)) {
                            schtml += '<div class="result_item clearfix">';
                            schtml += '<div class="scrip_name" data-name="' + json.ResultSet.Result[i].symbol + '" data-qname="' + json.ResultSet.Result[i].name + '">';
                            schtml += json.ResultSet.Result[i].name;
                            schtml += '</div>';
                            schtml += '<div class="scrip_symbol">';
                            schtml += json.ResultSet.Result[i].symbol;
                            schtml += '</div>';
                            schtml += '<div class="scrip_xchange">';
                            schtml += json.ResultSet.Result[i].exch;
                            schtml += '</div>';
                            schtml += '</div>';
                        }
                    }
                    if (schtml === "") {
                        schtml = "Symbol not found.";
                    }
                    result.html(schtml); /* Some visual effects */
                    result.hover(function () {
                        hovered = true;
                    }, function () {
                        hovered = false;
                    });
                    $(".result_item").hover(function () {
                        $(this).css("backgroundColor", "#FFF9B8");
                    }, function () {
                        $(this).css("backgroundColor", "#fff");
                    });
                    $(".result_item").click(function () {
                        scrip_name.val($(this).children(".scrip_name").attr("data-name"));
                        scrip_qname.val($(this).children(".scrip_name").attr("data-qname"));
                        result.addClass("hidden");
                        result.html("");
                    });
                });
            } else {
                result.addClass("hidden");
                result.html("");
            }
        }
        return false;
    }); /* anchor link to get the current market price.*/
    $("#cmpa").click(function (event) {
        event.preventDefault();
        if (scrip_name.val().length >= 3) {
            scrip_price.addClass("gettingprice");
            scrip_price.val("Retrieving price...");
            $.getJSON("/serverscripts/portfolio/getPrice.php?scrip=" + scrip_name.val(), function (json) {
                if (json.value !== 0) {
                    scrip_price.val(json.value);
                } else {
                    scrip_price.val("");
                }
                scrip_price.removeClass("gettingprice");
            });
        }
        return false;
    });
/* Add transaction tab logic:
     condition 1: no tab is open
                slide down the add transaction div.
          
   condition 2: manage cash div is open and active
                switch the tab from manage cash to add transaction
          do necessory class toggle, switch, add, remove etc
          
   condition 3: add transaction tab is open and active
                slide up the add transaction div.
  */
    addtransa.click(function (event) {
        event.preventDefault();
        if (managecasha.hasClass("activetab")) {
            managecasha.removeClass("activetab");
        }
        if (!managecasha.hasClass("inactivetab")) {
            managecasha.addClass("inactivetab");
        }
        if (cashform.hasClass("open")) {
            cashform.removeClass("open");
            cashform.hide();
            transform.addClass("open");
            transform.show();
            if ($(this).hasClass("inactivetab")) {
                $(this).removeClass("inactivetab");
            }
            if (!$(this).hasClass("activetab")) {
                $(this).addClass("activetab");
            }
            return false;
        }
        if (transform.hasClass("open")) {
            transform.removeClass("open");
            transform.slideUp("slow", function () {
                $("#cancelbtn").trigger('click');
                headerdivloc = $("#portheadback").offset().top;
            });
            formsholder.removeClass("grayed");
            if ($(this).hasClass("activetab")) {
                $(this).removeClass("activetab");
            }
            if ($(this).hasClass("inactivetab")) {
                $(this).removeClass("inactivetab");
            }
            if (managecasha.hasClass("inactivetab")) {
                managecasha.removeClass("inactivetab");
            }
            return false;
        }
        if (!$(this).hasClass("activetab")) {
            $(this).addClass("activetab");
        }
        transform.addClass("open");
        transform.slideDown("slow", function () {
            headerdivloc = $("#portheadback").offset().top;
        });
        formsholder.addClass("grayed");
        return false;
    }); /* manage cash tab. funcatinality is same as add trans above.*/
    managecasha.click(function (event) {
        event.preventDefault();
        if (addtransa.hasClass("activetab")) {
            addtransa.removeClass("activetab");
        }
        if (!addtransa.hasClass("inactivetab")) {
            addtransa.addClass("inactivetab");
        }
        if (transform.hasClass("open")) {
            transform.removeClass("open");
            transform.hide();
            cashform.addClass("open");
            cashform.show();
            if ($(this).hasClass("inactivetab")) {
                $(this).removeClass("inactivetab");
            }
            if (!$(this).hasClass("activetab")) {
                $(this).addClass("activetab");
            }
            return false;
        }
        if (cashform.hasClass("open")) {
            cashform.removeClass("open");
            cashform.slideUp("slow", function () {
                $("#cashcancelbtn").trigger('click');
                headerdivloc = $("#portheadback").offset().top;
            });
            formsholder.removeClass("grayed");
            if ($(this).hasClass("activetab")) {
                $(this).removeClass("activetab");
            }
            if ($(this).hasClass("inactivetab")) {
                $(this).removeClass("inactivetab");
            }
            if (addtransa.hasClass("inactivetab")) {
                addtransa.removeClass("inactivetab");
            }
            return false;
        }
        if (!$(this).hasClass("activetab")) {
            $(this).addClass("activetab");
        }
        cashform.addClass("open");
        cashform.slideDown("slow", function () {
            headerdivloc = $("#portheadback").offset().top;
        });
        formsholder.addClass("grayed");
        return false;
    }); /* Add transaction form submit code */
    $("#submitbtn").click(function (event) {
        var scripdivid = scrip_name.val().replace('.', '_');
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "/serverscripts/portfolio/addTransaction.php",
            data: ({
                'csrf': $("#csrf").val(),
                'portfolio_id': portfolio_id,
                'user_id': $.trim($("#user_id").val()),
                'trans_scrip': $.trim(scrip_name.val()),
                'trans_qscrip': $.trim(scrip_qname.val()),
                'trans_type': $.trim($("#trans_type").val()),
                'includecash': $("#includecash").attr('checked') ? 1 : 0,
                'trans_date': $.trim($("#trans_date").val()),
                'trans_price': $.trim(scrip_price.val()),
                'trans_qty': $.trim($("#trans_qty").val()),
                'stoploss': $.trim($("#stoploss").val()),
                'trans_notes': $.trim($("#trans_notes").val())
            }),
            dataType: "json",
            beforeSend: function () {
                if (requestInProcess) {
                    return false;
                } else {
                    requestInProcess = true;
                    if (!$("#resulttxt").hasClass("hidden")) {
                        $("#resulttxt").addClass("hidden");
                    }
                    if ($("#resulttxt").hasClass("red")) {
                        $("#resulttxt").removeClass("red");
                    }
                    $("#resulttxt").html("Please wait&hellip;");
                    if ($("#resulttxt").hasClass("hidden")) {
                        $("#resulttxt").removeClass("hidden");
                    }
                    return true;
                }
            },
            success: function (response) {
                var datatrid = 0,
                    scrip_symbols,
                    market_value,
                    new_row,
                    editrow;
                if ($("#resulttxt").hasClass("hidden")) {
                    $("#resulttxt").removeClass("hidden");
                }
                if (response.status === "1") {
                    if (response.new_trade === "1") { /* This is a new trade we need to add a new div element */
                        datatrid = response.trade_id;
                        new_row = "<div class=\"bodydiv clearfix\" id=\"" + scripdivid + "\"><div class=\"first\"";
                        new_row += "<a href=\"http://blackbull.in/finance/overview?bbid=" + user_id + "&pfid=" + portfolio_id + "&trid=" + response.trade_id + "\">";
                        new_row += response.qname + "</a><div class=\"subrow clearfix\"><span class=\"symbolname\">" + scrip_name.val() + "</span></div></div>";
                        new_row += "<div class=\"ltp\"><div class=\"ltpval\">" + response.ltp + "</div>";
                        if (response.stockchg < 0) {
                            new_row += "<div class=\"pchange negative\">" + response.stockchg + "</div></div>";
                        } else {
                            new_row += "<div class=\"pchange\">" + response.stockchg + "</div></div>";
                        }
                        new_row += "<div class=\"avgbuy\">" + response.avg_buy + "</div>";
                        new_row += "<div class=\"tradeqty\">" + response.trade_qty + "</div>";
                        new_row += "<div class=\"profitloss\">loading&hellip;</div></div>";
                        scrip_symbols = tradesbody.attr("data-symbols");
                        scrip_symbols = scrip_symbols + scrip_name.val() + "+";
                        tradesbody.attr("data-symbols", scrip_symbols);
                        tradesbody.append(new_row);
                        $("#" + scripdivid).slideDown("slow"); /* TODO: add conditional to handle BUY SELL */
                        market_value = parseFloat($("#marketvalue").html()) + parseFloat(response.avg_buy * response.trade_qty);
                        $("#marketvalue").html(market_value); /*$(".bodydiv").hover(function(){$(this).css("backgroundColor","#F9F9F9");},function(){$(this).css("backgroundColor","#FFF");});*/
                    } else { /* This is an update to existing trade */
                        editrow = "#" + scripdivid;
                        $(editrow + " .avgbuy").html(response.avg_buy);
                        $(editrow + " .tradeqty").html(response.trade_qty);
                        $(editrow + " .profitloss").html("loading&hellip;"); /* update market value */
                        market_value = parseFloat($("#marketvalue").html()) + parseFloat(response.trans_buy * response.trans_qty);
                        $("#marketvalue").html(market_value);
                    }
                    $("#cancelbtn").trigger('click');
                    $("#resulttxt").html("Transaction added successfully!<br/><span class=\"undotxt\"><a id=\"undoa\" data-trsid=\"" + response.trans_id + "\" data-trid=\"" + datatrid + "\" data-avgbuy=\"" + response.old_avg_buy + "\" data-qty=\"" + response.old_qty + "\" href=\"javascript:void(0);\">Click here</a> to undo.</span>");
                    $("#undoa").click(function (event) {
                        event.preventDefault();
                        var old_qty = $(this).attr("data-qty"),
                            old_avg = $(this).attr("data-avgbuy"); /* Make another request to delete the newly added transaction. */
                        $.ajax({
                            type: "POST",
                            url: "/serverscripts/portfolio/undoTransaction.php",
                            data: ({
                                "trans_id": $(this).attr("data-trsid"),
                                "trade_id": $(this).attr("data-trid"),
                                "old_avg": old_avg,
                                "old_qty": old_qty
                            }),
                            beforeSend: function () {
                                requestInProcess = true;
                            },
                            success: function (response) {
                                var totalvalue, editrow;
                                if (response.status === "1") { /* update the market value */
                                    totalvalue = parseFloat($("#marketvalue").html()) - parseFloat(response.qty * response.price);
                                    $("#marketvalue").html(sprintf("%.1f", totalvalue));
                                    $("#resulttxt").html("Undo succeeded&hellip;"); /* update the average buy and quantity*/
                                    editrow = "#" + scripdivid;
                                    $(editrow + " .tradeqty").html(old_qty);
                                    $(editrow + " .avgbuy").html(old_avg);
                                    $(editrow + " .profitloss").html("loading&hellip;");
                                } else {
                                    $("#resulttxt").html(response.error);
                                }
                                requestInProcess = false;
                            },
                            error: function () {
                                requestInProcess = false;
                            }
                        });
                    });
                } else {
                    if (!$("#resulttxt").hasClass("red")) {
                        $("#resulttxt").addClass("red");
                    }
                    $("#resulttxt").html(response.error);
                }
                requestInProcess = false;
                setTimeout(function () {
                    if (!$("#resulttxt").hasClass("hidden")) {
                        $("#resulttxt").addClass("hidden");
                    }
                }, 60000);
                return false;
            },
            error: function () {
                requestInProcess = false;
                return false;
            }
        });
        return false;
    }); /* Manage cash form submit event */
    $("#cashsubmitbtn").click(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "/serverscripts/portfolio/managecash.php",
            data: ({
                'csrf': $("#cashcsrf").val(),
                'portfolio_id': portfolio_id,
                'amount': $.trim($("#cashinrs").val()),
                'cash_type': $.trim($("#cash_type").val()),
                'cash_date': $.trim($("#cash_date").val()),
                'cash_notes': $.trim($("#cash_notes").val())
            }),
            beforeSend: function () {
                if (cashrequestInProcess) {
                    return false;
                } else {
                    cashrequestInProcess = true;
                    if (!$("#cashresulttxt").hasClass("hidden")) {
                        $("#cashresulttxt").addClass("hidden");
                    }
                    if ($("#cashresulttxt").hasClass("red")) {
                        $("#cashresulttxt").removeClass("red");
                    }
                    $("#cashresulttxt").html("Please wait&hellip;");
                    if ($("#cashresulttxt").hasClass("hidden")) {
                        $("#cashresulttxt").removeClass("hidden");
                    }
                    return true;
                }
            },
            success: function (response) {
                var totalcash;
                cashrequestInProcess = false;
                if ($("#cashresulttxt").hasClass("hidden")) {
                    $("#cashresulttxt").removeClass("hidden");
                }
                if (response.status === "1") {
                    $("#cashresulttxt").html(response.message + "<br/><span class=\"undotxt\"><a id=\"undocasha\" data-trid=\"" + response.cash_id + "\" href=\"javascript:void(0);\">Click here</a> to undo.</span>");
                    $("#undocasha").click(function (event) {
                        event.preventDefault(); /* Make another request to delete the newly added transaction. */
                        $.ajax({
                            type: "POST",
                            url: "/serverscripts/portfolio/undocash.php",
                            data: ({
                                "cash_id": $(this).attr("data-trid")
                            }),
                            beforeSend: function () {
                                cashrequestInProcess = true;
                            },
                            success: function (response) {
                                if (response.status === "1") {
                                    totalcash = parseFloat($("#cashvalue").html()) - response.cash;
                                    $("#cashvalue").html(sprintf("%.1f", totalcash));
                                    $("#cashresulttxt").html("Undo succeeded&hellip;");
                                } else {
                                    $("#cashresulttxt").html(response.error);
                                }
                                cashrequestInProcess = false;
                            },
                            error: function () {
                                cashrequestInProcess = false;
                            }
                        });
                    });
                    totalcash = parseFloat($("#cashvalue").html()) + response.cash;
                    $("#cashvalue").html(sprintf("%.1f", totalcash));
                    $("#cashcancelbtn").trigger('click');
                } else {
                    if (!$("#cashresulttxt").hasClass("red")) {
                        $("#cashresulttxt").addClass("red");
                    }
                    $("#cashresulttxt").html(response.error);
                }
                setTimeout(function () {
                    if (!$("#cashresulttxt").hasClass("hidden")) {
                        $("#cashresulttxt").addClass("hidden");
                    }
                }, 60000);
                return false;
            },
            error: function () {
                cashrequestInProcess = false;
            }
        });
        return false;
    });
}(this.jQuery, this, this.sprintf));