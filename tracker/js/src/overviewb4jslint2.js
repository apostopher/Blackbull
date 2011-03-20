/* Author:Rahul Devaskar
*/
(function ($) { /* Get the required variables */
    var pfid = $("#main").data("pfid");
    var trid = $("#main").data("trid");
    var scrip_name = $("#trans_scrip");
    var scrip_price = $("#trans_price");
    var user_id = $("#container").attr("class");
    var transcount = 0;
    var curr_date = 0;
    var close_date = 0;
    var curr_type = 0;
    var ctrans_date = 0;
    var trans_left = 1;
    var requestInProcess = false;
    var chartdata = [];
    var closevalue = 0;
    var count = 0;
    var transhtml = "";
    var targethtml = "";
    var slhtml = "";
    var tcount = 0;
    var activevalue = 0;
    var maxValue = 0;
    var minValue = 0;
    var arrayelement;
    var count = 0;
/* Jquery tools date input plugin used at the time of this writting
   * the version of Jquery tools used is 1.2.5 */
    $(":date").dateinput({
        format: 'yyyy-mm-dd'
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
    $("#addtransa").click(function () {
        if ($(this).hasClass("activeabtn")) {
            $("#formslide").slideUp("fast", function () {
                $("#addtransa").removeClass("activeabtn");
                $("#addtransa span").removeClass("visible");
            });
        } else {
            $(this).addClass("activeabtn");
            $("#addtransa span").addClass("visible");
            $("#formslide").slideDown("fast");
        }
    }); /* Add transaction form submit code */
    $("#submitbtn").click(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "/serverscripts/portfolio/addTransaction.php",
            data: ({
                'csrf': $("#csrf").val(),
                'portfolio_id': pfid,
                'user_id': user_id,
                'trans_scrip': $.trim(scrip_name.val()),
                'trans_type': $.trim($("#trans_type").val()),
                'includecash': $("#includecash").attr('checked') ? 1 : 0,
                'trans_date': $.trim($("#trans_date").val()),
                'trans_price': $.trim(scrip_price.val()),
                'trans_qty': $.trim($("#trans_qty").val()),
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
                if (response.status === "1") {
                    $("#resulttxt").html("Transaction added successfully!<br/><span class=\"undotxt\"><a id=\"undoa\" data-trsid=\"" + response.trans_id + "\" data-trid=\"" + trid + "\" data-avgbuy=\"" + response.old_avg_buy + "\" data-qty=\"" + response.old_qty + "\" href=\"javascript:void(0);\">Click here</a> to undo.</span>");
                    $("#undoa").click(function (event) {
                        event.preventDefault(); /* Make another request to delete the newly added transaction. */
                        $.ajax({
                            type: "POST",
                            url: "/serverscripts/portfolio/undoTransaction.php",
                            data: ({
                                "trans_id": $(this).data("trsid"),
                                "trade_id": $(this).data("trid"),
                                "old_avg": $(this).data("avgbuy"),
                                "old_qty": $(this).data("qty")
                            }),
                            beforeSend: function () {
                                requestInProcess = true;
                            },
                            success: function (response) {
                                if (response.status === "1") { /* TODO */
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
                    $("#resulttxt").html("");
                }, 60000);
                return false;
            },
            error: function () {
                requestInProcess = false;
                return false;
            }
        });
        return false;
    }); /* once the page is loaded, get all the data from PHP */
    $.getJSON("/serverscripts/portfolio/getOverview.php?pfid=" + pfid + "&trid=" + trid + "&uuid=" + user_id, function (jsontrades) {
        var closei = 0;
        var transpoint;
        if (jsontrades.pagefound === "1") {
            $("#trade_name").html(jsontrades.trade_name);
            $("#trade_symbol").html(jsontrades.trade_symbol);
            scrip_name.val(jsontrades.trade_symbol);
            $("#ltpprice").html(jsontrades.last);
            $("#ltpchg").html(jsontrades.change);
            if (parseFloat(jsontrades.change) < 0) {
                if (!$("#trade_ltp").hasClass("down")) {
                    $("#trade_ltp").addClass("down");
                }
            } else {
                if ($("#trade_ltp").hasClass("down")) {
                    $("#trade_ltp").removeClass("down");
                }
            } /* start the LTP loop*/
            var user_id = $("#container").attr("class");
            getLTP(jsontrades.trade_symbol, user_id); /* declare Highcharts options */
            /* highcharts version used: 2.1.1 on 24-dec-2010 */
            var minseries = 0;
            var maxseries = 0;
            var closeoptions = {
                chart: {
                    renderTo: 'chartholder',
                    defaultSeriesType: 'spline',
                    showAxes: true
                },
                credits: {
                    enabled: false
                },
                title: {
                    text: "Trade history",
                    style: {
                        color: '#075FB2'
                    }
                },
                plotOptions: {
                    series: {
                        marker: {
                            fillColor: '#FFFFFF',
                            lineWidth: 2,
                            lineColor: null
                        }
                    }
                },
                legend: {
                    itemStyle: {
                        color: '#075FB2',
                        fontWeight: 'bold'
                    }
                },
                xAxis: {
                    labels: {
                        rotation: -45,
                        align: 'right',
                        style: {
                            color: '#aaa',
                            fontSize: '12px'
                        }
                    },
                    tickmarkPlacement: "on",
                    categories: [],
                    reversed: true,
                    lineColor: '#aaa',
                    lineWidth: 1,
                    tickColor: '#aaa'
                },
                yAxis: {
                    labels: {
                        formatter: function () {
                            return this.value;
                        },
                        style: {
                            color: '#aaa',
                            fontSize: '12px'
                        }
                    },
                    title: {
                        text: 'Price',
                        style: {
                            color: '#075FB2',
                            fontSize: '14px'
                        }
                    },
                    gridLineColor: "#F1F1F1",
                    plotLines: [],
                    lineColor: '#aaa',
                    lineWidth: 0,
                    tickColor: '#aaa',
                    tickPixelInterval: 50
                },
                series: [],
                tooltip: {
                    formatter: function () {
                        var toolcount = 0;
                        if (this.point.id) {
                            var toolarray = this.point.id.split("_");
                            var returntxt = "Close: " + this.y + " Rs.<br/><br/>";
                            for (toolcount = 0; toolcount + 4 < toolarray.length; toolcount = toolcount + 4) {
                                if (toolarray[toolcount + 3] === "1") {
                                    if (toolarray[toolcount + 2] > 1) {
                                        returntxt = returntxt + "<b>Bought</b> " + toolarray[toolcount + 2] + " shares @" + toolarray[toolcount + 1] + " Rs.<br/>";
                                    } else {
                                        returntxt = returntxt + "<b>Bought</b> " + toolarray[toolcount + 2] + " share @" + toolarray[toolcount + 1] + " Rs.<br/>";
                                    }
                                }
                                if (toolarray[toolcount + 3] === "-1") {
                                    if (toolarray[toolcount + 2] > 1) {
                                        returntxt = returntxt + "<b>Sold</b> " + toolarray[toolcount + 2] + " shares @" + toolarray[toolcount + 1] + " Rs.<br/>";
                                    } else {
                                        returntxt = returntxt + "<b>Sold</b> " + toolarray[toolcount + 2] + " share @" + toolarray[toolcount + 1] + " Rs.<br/>";
                                    }
                                }
                            }
                            return returntxt;
                        } else {
                            return "Close: " + this.y + " Rs.";
                        }
                    },
                    backgroundColor: "rgba(255, 255, 255, 1)"
                }
            }; /* define the series of close values */
            var closevals = {
                name: jsontrades.trade_symbol,
                type: 'spline',
                data: [],
                color: "#075FB2"
            }; /* populate the close series with data received from PHP */
/* set the initial values of curr_date and curr_type variables.
        * these variables are used to display BUY and SELL markers on the chart */
            if (jsontrades.transtotal > 0) { /* user has transactions. get the latest transaction details */
                curr_date = jsontrades.trans[transcount].trans_date;
                curr_type = jsontrades.trans[transcount].trans_type;
            }
            for (closei = 0; closei < jsontrades.closetotal; closei++) { /* get the close value */
                closevalue = parseFloat(jsontrades.close[closei].c);
                if (minseries === 0) {
                    minseries = closevalue;
                }
/* Need to search whether there is any transaction on this date
          * This can also be done in PHP. but it will not be simpler than this.
          * so why put load on my server? let client CPU do it. 
          * the PHP script sends the transactions in desc order.
          * I save the latest date and type in local variables. if the dates match then
          * update the local variables to next trans value.
          */
                if (jsontrades.close[closei].d === curr_date) { /* found a match. */
                    /*check whether we have processed all trans */
                    var idtxt = '';
                    if (transcount + 1 < jsontrades.transtotal) { /* there are more transactions to be processed. update the local variables.*/
                        /* I use while loop because there can be more than one transactions on a day */
                        var first_run = true;
                        while (jsontrades.close[closei].d === curr_date) {
/* If I find BUY and SELL transactions on same day then i set curr_type to 2.
              * but need to reset this to normal */
                            if (transcount > 0) {
/* if the consecutive transactions are different and if this is not a first_run then set the curr_type to 2
                first run is required because the comparison must be made between transactions that occured on same day. */
                                if ((jsontrades.trans[transcount - 1].trans_type !== jsontrades.trans[transcount].trans_type) && !first_run) {
                                    curr_type = 2;
                                }
                            }
                            idtxt = idtxt + closei + "_" + jsontrades.trans[transcount].trans_price;
                            idtxt = idtxt + "_" + jsontrades.trans[transcount].trans_qty + "_" + jsontrades.trans[transcount].trans_type + "_";
                            transcount = transcount + 1;
                            curr_date = jsontrades.trans[transcount].trans_date; /* First run is over so set the flag to false */
                            first_run = false;
                        }
                        if (curr_type !== 2) {
                            curr_type = jsontrades.trans[transcount - 1].trans_type;
                        }
                    } else { /* all transactions are done */
                        /* Update the id text */
                        idtxt = idtxt + closei + "_" + jsontrades.trans[transcount].trans_price;
                        idtxt = idtxt + "_" + jsontrades.trans[transcount].trans_qty + "_" + jsontrades.trans[transcount].trans_type + "_";
                        trans_left = 0;
                        curr_date = '';
                    }
                    if (curr_type === 1) { /* It is a BUY transaction */
                        transpoint = {
                            y: closevalue,
                            marker: {
                                symbol: "url(http://blackbull.in/tracker/images/buy.png)"
                            },
                            id: idtxt
                        };
                    } else if (curr_type === -1) { /* It is a SELL transaction */
                        transpoint = {
                            y: closevalue,
                            marker: {
                                symbol: "url(http://blackbull.in/tracker/images/sell.png)"
                            },
                            id: idtxt
                        };
                    } else { /* It is a BUY+SELL transaction */
                        transpoint = {
                            y: closevalue,
                            marker: {
                                symbol: "url(http://blackbull.in/tracker/images/buysell.png)"
                            },
                            id: idtxt
                        };
                    }
                    closevals.data.push(transpoint); /* now reset the curr_type */
                    curr_type = jsontrades.trans[transcount].trans_type;
                } else { /* no transactions match this date */
/* Check whether the CLOSE array date is smaller than trans date 
            * This means user added a transaction on a holiday. :-) so we need to fix curr_date */
                    close_date = new Date(Date.parse(jsontrades.close[closei].jd));
                    ctrans_date = new Date(Date.parse(jsontrades.trans[transcount].trans_jdate));
                    if (close_date < ctrans_date && trans_left) { /* go to next curr_date */
                        var old_curr_date = curr_date;
                        transcount = transcount + 1;
                        curr_date = jsontrades.trans[transcount].trans_date;
                        curr_type = jsontrades.trans[transcount].trans_type;
                        while (old_curr_date === curr_date) {
                            transcount = transcount + 1;
                            curr_date = jsontrades.trans[transcount].trans_date;
                            curr_type = jsontrades.trans[transcount].trans_type;
                        } /* Now curr_date is a new date. but check whether it matches the current CLOSE date */
                        if (curr_date === jsontrades.close[closei].d) { /* Need to run the loop again */
                            closei--;
                            continue;
                        }
                    }
                    closevals.data.push(closevalue);
                } /* Add X- Axis labels */
                closeoptions.xAxis.categories.push(jsontrades.close[closei].xd);
                if (minseries > jsontrades.close[closei].c) {
                    minseries = closevalue;
                }
                if (maxseries < jsontrades.close[closei].c) {
                    maxseries = closevalue;
                }
            }
            closeoptions.series.push(closevals); /* add transactions */
            transhtml = "";
            var totalqty = 0;
            var avgbuy = 0;
            var sellqty = 0;
            var rreturns = 0;
            var urreturns = 0;
            for (tcount = 0; tcount < jsontrades.transtotal; tcount++) {
                if (tcount + 1 === jsontrades.transtotal) {
                    if (tcount % 2 === 1) {
                        transhtml += "<tr class=\"bodydivlast odd clearfix\"><td class=\"srno\">" + (tcount + 1) + ".</td>";
                    } else {
                        transhtml += "<tr class=\"bodydivlast clearfix\"><td class=\"srno\">" + (tcount + 1) + ".</td>";
                    }
                } else {
                    if (tcount % 2 === 1) {
                        transhtml += "<tr class=\"bodydiv odd clearfix\"><td class=\"srno\">" + (tcount + 1) + ".</td>";
                    } else {
                        transhtml += "<tr class=\"bodydiv clearfix\"><td class=\"srno\">" + (tcount + 1) + ".</td>";
                    }
                }
                if (jsontrades.trans[tcount].trans_type === 1) {
                    transhtml += "<td class=\"ttype\">B</td>";
                    totalqty += parseInt(jsontrades.trans[tcount].trans_qty, 10);
                    urreturns += (jsontrades.trans[tcount].trans_qty * jsontrades.trans[tcount].trans_price);
                } else {
                    transhtml += "<td class=\"ttype\">S</td>";
                    sellqty += parseInt(jsontrades.trans[tcount].trans_qty, 10);
                    rreturns += (jsontrades.trans[tcount].trans_qty * jsontrades.trans[tcount].trans_price);
                }
                transhtml += "<td class=\"tdate\">" + jsontrades.trans[tcount].trans_date + "</td>";
                transhtml += "<td class=\"tprice\">" + jsontrades.trans[tcount].trans_price + "</td>";
                transhtml += "<td class=\"tqty\">" + jsontrades.trans[tcount].trans_qty + "</td>";
                transhtml += "<td class=\"notes\">" + jsontrades.trans[tcount].trans_notes + "</td>";
                transhtml += "<td class=\"trcontrol lastcell\">&nbsp;</td></tr>";
            } /*calculate average buy */
            avgbuy = jsontrades.avg_buy; /* update invested capital */
            $("#invest_cap_div").html(urreturns); /* update current value */
            $("#current_val_div").html(sprintf("%.1f", totalqty * jsontrades.last)); /*update buy quantity */
            $("#buy_qty_div").html(totalqty); /*update buy quantity */
            $("#sell_qty_div").html(sellqty); /* update realized returns */
            var rreturnsstr = sprintf("%.1f", rreturns - (sellqty * avgbuy));
            $("#r_ret_div").html(rreturnsstr);
            if (parseFloat(rreturnsstr) < 0) {
                if (!$("#r_ret_div").hasClass("down")) {
                    $("#r_ret_div").addClass("down");
                }
            } /* update unrealized returns */
            var urreturnsstr = sprintf("%.1f", (totalqty - sellqty) * (jsontrades.last - avgbuy));
            $("#unr_ret_div").html(urreturnsstr);
            if (parseFloat(urreturnsstr) < 0) {
                if (!$("#unr_ret_div").hasClass("down")) {
                    $("#unr_ret_div").addClass("down");
                }
            } else {
                if ($("#unr_ret_div").hasClass("down")) {
                    $("#unr_ret_div").removeClass("down");
                }
            } /* update average buy */
            $("#avg_price_div").html(avgbuy);
            if (parseFloat(avgbuy) < parseFloat(jsontrades.last)) {
                if ($("#avg_price_div").hasClass("down")) {
                    $("#avg_price_div").removeClass("down");
                }
            } else {
                if (!$("#avg_price_div").hasClass("down")) {
                    $("#avg_price_div").addClass("down");
                }
            } /* update market value */
            $("#marketval").html(sprintf("%.1f", totalqty * jsontrades.last)); /* Now set the transactions html */
            if (transhtml) {
                $("#transbody").html(transhtml);
            } /* add the targets if any */
            targethtml = "";
            activevalue = "activevalue";
            if (jsontrades.targetstotal > 0) {
                maxValue = 0;
                targethtml = "";
                for (count = 0; count < jsontrades.targetstotal; count++) {
                    arrayelement = [];
                    arrayelement.width = 1;
                    arrayelement.value = jsontrades.targets[count].target;
                    arrayelement.id = "tg" + jsontrades.targets[count].target;
                    arrayelement.color = "#3cb878";
                    arrayelement.zIndex = 3;
                    arrayelement.dashStyle = 'line';
                    arrayelement.label = {
                        text: "Target: " + jsontrades.targets[count].target,
                        style: {
                            color: "#3cb878",
                            fontSize: "11px"
                        }
                    };
                    closeoptions.yAxis.plotLines.push(arrayelement); /* Need to set max value on Y Axis */
                    if (parseFloat(jsontrades.targets[count].target) > maxValue) {
                        maxValue = parseFloat(jsontrades.targets[count].target);
                    } /* add the target information to target table below the chart */
                    if (count + 1 === jsontrades.targetstotal) {
                        if (count % 2 === 1) {
                            targethtml += "<tr class=\"bodydivlast odd clearfix\"><td class=\"srno\">" + (count + 1) + ".</td>";
                        } else {
                            targethtml += "<tr class=\"bodydivlast clearfix\"><td class=\"srno\">" + (count + 1) + ".</td>";
                        }
                    } else {
                        if (count % 2 === 1) {
                            targethtml += "<tr class=\"bodydiv odd clearfix\"><td class=\"srno\">" + (count + 1) + ".</td>";
                        } else {
                            targethtml += "<tr class=\"bodydiv clearfix\"><td class=\"srno\">" + (count + 1) + ".</td>";
                        }
                    }
                    targethtml = targethtml + "<td class=\"trvalue " + activevalue + "\">" + jsontrades.targets[count].target + "</td>";
                    targethtml += "<td class=\"trcontrol lastcell\">&nbsp;</td></tr>"; /* reset active value after first run */
                    activevalue = "";
                } /* The plot scale must be adjusted to fit max target */
                if (maxValue !== 0 && maxValue > maxseries && maxValue < (1.2 * maxseries)) {
                    closeoptions.yAxis.max = maxValue + parseInt(0.05 * maxValue, 10);
                }
            } else {
                targethtml = "<tr class=\"bodydivlast\"><td colspan=\"3\" class=\"loadmsg\">No data.</td></tr>";
            } /* Now update the target html */
            if (targethtml) {
                $("#targetbody").html(targethtml);
            } /* add the stop losses if any */
            slhtml = "";
            activevalue = "activevalue";
            if (jsontrades.sltotal > 0) {
                minValue = 0;
                slhtml = "";
                for (count = 0; count < jsontrades.sltotal; count++) {
                    if (count === 0) {
                        minValue = parseFloat(jsontrades.sls[count].stoploss);
                    }
                    arrayelement = [];
                    arrayelement.width = 1;
                    arrayelement.value = jsontrades.sls[count].stoploss;
                    arrayelement.id = "sl" + jsontrades.sls[count].stoploss;
                    arrayelement.color = "#D13236";
                    arrayelement.zIndex = 3;
                    arrayelement.dashStyle = 'line';
                    arrayelement.label = {
                        text: "Stoploss: " + jsontrades.sls[count].stoploss,
                        style: {
                            color: "#D13236",
                            fontSize: "11px"
                        }
                    };
                    closeoptions.yAxis.plotLines.push(arrayelement); /* Need to set min value on Y Axis */
                    if (parseFloat(jsontrades.sls[count].stoploss) < minValue) {
                        minValue = parseFloat(jsontrades.sls[count].stoploss);
                    } /* add the stop loss information to stop loss table below the chart */
                    if (count + 1 === jsontrades.sltotal) {
                        if (count % 2 === 1) {
                            slhtml += "<tr class=\"bodydivlast odd clearfix\"><td class=\"srno\">" + (count + 1) + ".</td>";
                        } else {
                            slhtml += "<tr class=\"bodydivlast clearfix\"><td class=\"srno\">" + (count + 1) + ".</td>";
                        }
                    } else {
                        if (count % 2 === 1) {
                            slhtml += "<tr class=\"bodydiv odd clearfix\"><td class=\"srno\">" + (count + 1) + ".</td>";
                        } else {
                            slhtml += "<tr class=\"bodydiv clearfix\"><td class=\"srno\">" + (count + 1) + ".</td>";
                        }
                    }
                    slhtml = slhtml + "<td class=\"slvalue " + activevalue + "\">" + jsontrades.sls[count].stoploss + "</td>";
                    slhtml += "<td class=\"trcontrol lastcell\">&nbsp;</td></tr>"; /* reset active value after first run */
                    activevalue = "";
                } /* The plot scale must be adjusted to fit min stoploss */
                if (minValue !== 0 && minValue < minseries && minValue > (0.8 * minseries)) {
                    closeoptions.yAxis.min = minValue - parseInt(0.05 * minValue, 10);
                }
            } else {
                slhtml = "<tr class=\"bodydivlast\"><td colspan=\"3\" class=\"loadmsg\">No data.</td></tr>";
            } /* Now update the SL html */
            if (slhtml) {
                $("#slbody").html(slhtml);
            }
            $("#waitscreen").hide();
            $("#chartholder").show();
            var chartfd = new Highcharts.Chart(closeoptions); /*}*/
        } else {
            $("#waitscreen").html("Page not found.");
            $("#waitscreen").addClass("red");
        }
    });
}(this.jQuery)); /* periodically get last traded price for all the scrips. hence setTimeout*/

function getLTP(scrips, user_id) {
    if (scrips.length > 0) {
        $.getJSON("/serverscripts/portfolio/getLTP.php?user=" + user_id + "&scrips=" + scrips, function (jsonLTP) {
            var avg_buy = $("#avg_price_div").html();
            var buy_qty = $("#buy_qty_div").html();
            var sell_qty = $("#sell_qty_div").html();
            var market_qty = parseInt(buy_qty, 10) - parseInt(sell_qty, 10);
            for (count = 0; count < jsonLTP.total; count++) {
                $("#ltpprice").html(jsonLTP.data[count].ltp);
                $("#ltpchg").html(jsonLTP.data[count].change);
                $("#current_val_div").html(sprintf("%.1f", market_qty * parseFloat(jsonLTP.data[count].ltp)));
                if (parseFloat(jsonLTP.data[count].change) < 0) {
                    if (!$("#trade_ltp").hasClass("down")) {
                        $("#trade_ltp").addClass("down");
                    }
                } else {
                    if ($("#trade_ltp").hasClass("down")) {
                        $("#trade_ltp").removeClass("down");
                    }
                }
                var unret = market_qty * (parseFloat(jsonLTP.data[count].ltp) - parseFloat(avg_buy));
                $("#unr_ret_div").html(sprintf("%.1f", unret));
                if (parseFloat(unret) < 0) {
                    if (!$("#unr_ret_div").hasClass("down")) {
                        $("#unr_ret_div").addClass("down");
                    }
                } else {
                    if ($("#unr_ret_div").hasClass("down")) {
                        $("#unr_ret_div").removeClass("down");
                    }
                }
            }
            setTimeout(function () {
                getLTP(scrips, user_id);
            }, 10000);
        });
    } else {
        setTimeout(function () {
            getLTP(scrips, user_id);
        }, 10000);
    }
    return false;
}