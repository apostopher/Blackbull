<?php
/**
* This script is the controller script for Blackbull Portfolio. This script communicates with the database. The primary functions of this script are:
*		STEP 0: Validate and Authenticate. check for sql injection.
                STEP 1: Check for existing trade in trade table.
                        STEP 1A: Existing trade is found
                                 STEP 1AA: Add new transaction using the existing trade
                                 STEP 1B: Existing trade is not found
                        STEP 1BA: Create a new trade in trades table
                        STEP 1BB: Add new transaction to newly created trade
                STEP 2: Check for any errors
                STEP 3: Check whether the trade is over
                STEP 4: Check for any errors
                STEP 5: Return json response
*
*	@package	Portfolio
*	@category	Transaction
*	@version	1.0b
*	@author		Rahul Devaskar (apostopher@gmail.com)
*	@copyright	(c) 2010 Blackbull Investment Company
*	@link		http://blackbull.in
*
*	NOTICE: THIS SCRIPT IS A PROPERTY OF BLACKBULL INVESTMENT COMPANY. COPYING, EDMTING OR DELETING THIS SCRIPT IS PROHIBITED WITHOUT THE PERMISSION FROM THE AUTHOR.
*/
    /* Start the session */
    session_start();
    /* Load required libraries */
    require_once('../dba.php');
    
    /* Initialize variables. */
    $stockfound = 0;
    $stockchg = 0;
    
    /* Authenticate the requester. */
    if(!isset($_SESSION['csrf']) || $_SESSION['csrf'] !== $_POST['csrf']){
        /* We got CSRF attack. */
        header('Content-type: application/json');
        if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
            header("Cache-Control: no-cache");
            header("Pragma: no-cache");
        }
        $response = array("status" => '0', "error" => "CSRF protection.");
        echo json_encode($response);
        mysql_close($con);
        return;
    }
    
    $portfolio_id = mysql_real_escape_string($_POST['portfolio_id']);

    /* Read the request parameters. */
    $trans_scrip = strtoupper(trim(mysql_real_escape_string($_POST['trans_scrip'])));
    $trans_qscrip = trim(mysql_real_escape_string($_POST['trans_qscrip']));
    $trans_type = mysql_real_escape_string($_POST['trans_type']);
    $trans_price = mysql_real_escape_string($_POST['trans_price']);
    $trans_qty = mysql_real_escape_string($_POST['trans_qty']);
    $trans_date = mysql_real_escape_string($_POST['trans_date']);
    $trans_notes = addslashes(trim(mysql_real_escape_string($_POST['trans_notes'])));
    /* Validation check. */
    $validation_error = 0;
    if(is_numeric($trans_price)){
        if($trans_price < 0){
           $validation_error = 1;
        }
    }else{
        $validation_error = 2;
    }
    if(is_numeric($trans_qty)){
        if($trans_qty == 0){
            $validation_error = 3;
        }
    }else{
        $validation_error = 4;
    }
    if($trans_type != -1 && $trans_type != 1){
        $validation_error = 5;
    }
      
    if($validation_error){
        /* We got validation errors. */
        header('Content-type: application/json');
        if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
            header("Cache-Control: no-cache");
            header("Pragma: no-cache");
        }
        $response = array("status" => '0', "error" => "Validation failed.");
        echo json_encode($response);
        mysql_close($con);
        return;
    }
    /* Adjust quantity for BUY/SELL */
    $trans_qty = $trans_qty*$trans_type;
    
    /* Get stops loss if present. */
    $stoploss = mysql_real_escape_string($_POST['stoploss']);
    
    /* Get target if present. */
    $target = mysql_real_escape_string($_POST['target']);
    
    /* Get scrip id from portfolio_scrip table */
    $scrip_id = 0;
    $scrip_name_query = "SELECT scrip_id, scrip_name FROM portfolio_scrips WHERE scrip_symbol='".$trans_scrip."'";
    $scrip_name_result = mysql_query($scrip_name_query);
    if($scrip_name_result){
        if(mysql_num_rows($scrip_name_result)){
            $scriprow = mysql_fetch_array($scrip_name_result);
            $scrip_id = $scriprow['scrip_id'];
            $trans_qscrip = $scriprow['scrip_name'];
        }else{
            $scrip_id = 0;
        }
        /* Free the result memory */
    	mysql_free_result($scrip_name_result);
    }else{
        $scrip_id = 0;
    }
    $trade_id = 0;
    /* initialize the new trade flag */
    $newtrade = 0;
    if($scrip_id != 0){
        /* Check whether the trade is still alive. */
        /* Search in the portfolio_trade table for a row with scrip_name as $trans_scrip and end_date is NULL and portfolio_id is $portfolio_id. */
        $trade_query = "SELECT trade_id, trade_qty, trade_avg_buy FROM portfolio_trades WHERE scrip_id='".$scrip_id."' AND portfolio_id=".$portfolio_id." AND end_date IS NULL LIMIT 1";
        $trade_result = mysql_query($trade_query);
        if($trade_result){
            if(mysql_num_rows($trade_result)){
    	        while($traderow = mysql_fetch_array($trade_result)){
    	    	    $trade_id = $traderow['trade_id'];
    	    	    $trade_qty = $traderow['trade_qty'];
    	    	    $trade_avg_buy = $traderow['trade_avg_buy'];
    	        }
    	    }else{
    	        $trade_id = 0;
    	    }
    	    /* Free the result memory */
    	    mysql_free_result($trade_result);
        }else{
            $trade_id = 0;
        }
    }
    /* Start database transaction. @ means supress any errors. */
    @mysql_query("SET autocommit=0");
    @mysql_query("BEGIN");
    
    if($trade_id == 0){
        /* The trade does not exist. We need to create a new trade. */
        /* before we create a new trade we need to check whether we have a valid scrip */
        if($scrip_id == 0){
            /* If the company name changes then this part of the code might go wrong. because we will still use the old name
               that we stored in our database. probably we will need to update this name manually in such cases */
            $yahoofile   = fopen ("http://finance.yahoo.com/d/quotes.csv?s=".$trans_scrip."&f=l1c1&ex=.csv","r");
            if($yahoofile){
                while($stock = fgetcsv($yahoofile)){
                    $stockfound = $stock[0];
                    $stockchg = $stock[1];
                    break;
                }
            }else{
                $stockfound = 0;
            }
            /* Close the file. */
            fclose($yahoofile);
            if(strlen($trans_qscrip) == 0){
                /* The qualified name for the scrip is not set. probably user entered the symbol manually
                   without using autosuggest. Thus auto suggest's click event did not fire. and hence
                   the qualified name is not set.*/
                   $callback = "YAHOO.util.ScriptNodeDataSource.callbacks";
                   $callbacklen = strlen($callback);
                   $handle   = fopen("http://d.yimg.com/autoc.finance.yahoo.com/autoc?query=$trans_scrip&region=IN&lang=en-IN&callback=$callback","r");
                   $contents = trim(stream_get_contents($handle));
                   $jsonRsp = substr($contents,$callbacklen + 1, strlen($contents) - $callbacklen - 2);
                   /* Close file */
                   fclose($handle);
                   if($jsonRsp){
                       /* Now we need to parse the JSON */
                       $qualifiedname = json_decode($jsonRsp);
                       $trans_qscrip = $qualifiedname->ResultSet->Result[0]->name;
                       error_log("qscrip ".$trans_qscrip);
                   }else{
                       /* Set an error */
                       $stockfound = 0;
                   } 
            }
            if($stockfound == 0){
                /* We did not find the stock on yahoo */
                /* Rollback transaction */
                @mysql_query("ROLLBACK");
                @mysql_query("SET autocommit=1");
                header('Content-type: application/json');
                if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
                    header("Cache-Control: no-cache");
                    header("Pragma: no-cache");
                }
                $response = array("status" => '0', "error" => "Unable to find scrip on yahoo.");
                echo json_encode($response);
                mysql_close($con);
                return;
            }
        }
        if($scrip_id == 0){
            /* We need to add this scrip to portfolio_scrips table. */
            /* If trans_scrip is NSE scrip then the corresponding NSE symbol can be found
               if the length is less than 9 e.g. UNIPHOS.NS is equivalent to UNIPHOS in NSE*/
            /* First check whether the scrip is NSE scrip  and length is less than 9 + strlen(.NS)*/
            $NSE_scrip = "";
            if(0 == strcmp(substr($trans_scrip, -3), ".NS") && strlen($trans_scrip) < 12){
              /* get the NSE symbol from trans_scrip by removing .NS */
              $NSE_scrip = substr($trans_scrip, 0, -3);
            }else{
              $NSE_scrip = NULL;
            }
            $scrip_insert_query = "INSERT INTO portfolio_scrips VALUES(null,'".$trans_scrip."','".$NSE_scrip."','".$trans_qscrip."')";
            $scrip_insert_result = mysql_query($scrip_insert_query);
            if($scrip_insert_result){
                $scrip_id = mysql_insert_id();
                if($scrip_id == 0 || $scrip_id == false){
                    /* portfolio_scrip failed to update. can't proceed */
                    /* Rollback transaction */
                    @mysql_query("ROLLBACK");
                    @mysql_query("SET autocommit=1");
                    header('Content-type: application/json');
                    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
                        header("Cache-Control: no-cache");
                        header("Pragma: no-cache");
                    }
                    $response = array("status" => '0', "error" => "Unable to update scrip.");
                    echo json_encode($response);
                    mysql_close($con);
                    return;
                }
            }else{
              /* portfolio_scrip failed to update. can't proceed */
              /* Rollback transaction */
              @mysql_query("ROLLBACK");
              @mysql_query("SET autocommit=1");
              header('Content-type: application/json');
              if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
                header("Cache-Control: no-cache");
                header("Pragma: no-cache");
              }
              $response = array("status" => '0', "error" => "Unable to update scrip.");
              echo json_encode($response);
              mysql_close($con);
              return;
            }
        }
        $new_trade_query = "INSERT INTO portfolio_trades VALUES(null,".$portfolio_id.",NOW(),null,".$scrip_id.",0,0)";
        $new_trade_result = mysql_query($new_trade_query);
        if($new_trade_result){
            $trade_id = mysql_insert_id();
            if($trade_id == 0 || $trade_id == false){
                /* New trade was not created. :-( unable to proceed. */
                /* Rollback transaction */
                @mysql_query("ROLLBACK");
                @mysql_query("SET autocommit=1");
                header('Content-type: application/json');
		if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
		    header("Cache-Control: no-cache");
		    header("Pragma: no-cache");
		}
		$response = array("status" => '0', "error" => "Unable to create new trade.");
		echo json_encode($response);
		mysql_close($con);
                return;
            }
            /* This indeed is a new trade */
            $newtrade = 1;
            $trade_qty = 0;
        }else{
            /* New trade was not created. :-( unable to proceed. */
            /* Rollback transaction */
            @mysql_query("ROLLBACK");
            @mysql_query("SET autocommit=1");
            header('Content-type: application/json');
	    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
	        header("Cache-Control: no-cache");
		header("Pragma: no-cache");
	    }
	    $response = array("status" => '0', "error" => "Unable to create new trade.");
	    echo json_encode($response);
	    mysql_close($con);
            return;
        }
    }

    /* Now we have a valid trade id. We may now add a transaction */
    $new_trans_query = "INSERT INTO portfolio_trans VALUES(null,".$trade_id.",".$trans_price.",".$trans_qty.",'".$trans_date."','".$trans_notes."')";
    $new_trans_result = mysql_query($new_trans_query);
    if($new_trans_result){
    	$trans_id = mysql_insert_id();
    	if($trans_id == 0 || $trans_id == false){
            /* New trans was not created. :-( unable to proceed. */
            /* Rollback transaction */
            @mysql_query("ROLLBACK");
            @mysql_query("SET autocommit=1");
            /* send error message */
            header('Content-type: application/json');
	    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
	        header("Cache-Control: no-cache");
		header("Pragma: no-cache");
            }
            $response = array("status" => '0', "error" => "Unable to create new transaction.");
            echo json_encode($response);
            mysql_close($con);
            return;
        }
        /* Update the trade quantity */
        $update_qty = $trade_qty + $trans_qty;
        $update_avg_buy = $trade_avg_buy;
        
        if($update_qty && $trans_qty > 0){
            /* Update the average buy price */
            $update_avg_buy = (($trade_avg_buy*$trade_qty) + ($trans_price*$trans_qty))/$update_qty;
            $update_qty_query = "UPDATE portfolio_trades SET trade_qty=".$update_qty.", trade_avg_buy=".$update_avg_buy." WHERE trade_id=".$trade_id;
        }else if($update_qty && $trans_qty <= 0){
            $update_qty_query = "UPDATE portfolio_trades SET trade_qty=".$update_qty." WHERE trade_id=".$trade_id;
        }else{
            $update_qty_query = "UPDATE portfolio_trades SET trade_qty=".$update_qty.", end_date=NOW() WHERE trade_id=".$trade_id;
        }
        $update_qty_result = mysql_query($update_qty_query);
        if(!$update_qty_result){
            /* Rollback transaction */
            @mysql_query("ROLLBACK");
            @mysql_query("SET autocommit=1");
            /* send error message */
            header('Content-type: application/json');
	    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
	        header("Cache-Control: no-cache");
                header("Pragma: no-cache");
            }
	    $response = array("status" => '0', "error" => "Unable to update trade quantity.");
	    echo json_encode($response);
	    mysql_close($con);
            return;
        }
    }else{
        /* New trans was not created. :-( unable to proceed. */
        /* Rollback transaction */
        @mysql_query("ROLLBACK");
        @mysql_query("SET autocommit=1");
        /* send error message */
        header('Content-type: application/json');
	if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
	    header("Cache-Control: no-cache");
            header("Pragma: no-cache");
        }
	$response = array("status" => '0', "error" => "Unable to create new transaction.");
	echo json_encode($response);
	mysql_close($con);
        return;
    }
    /* Everything is fine. commit the transaction */
    @mysql_query("COMMIT");
    /* Reset autocommit otherwise SL and targets wo't get updated with INSERT query - bug fix on 27-12-2010 */
    @mysql_query("SET autocommit=1");
    /* Check whether we need to update stop loss table */
    $sl_updated = false;
    if($stoploss){
        /* Check whether same stop loss exists for the trade. */
        $sl_check_query = "SELECT sl_id FROM portfolio_sl WHERE stoploss=".$stoploss." AND trade_id=".$trade_id;
        $sl_check_result = mysql_query($sl_check_query);
        if($sl_check_result){
            if(mysql_num_rows($sl_check_result) == 0){
                /* Stop loss at this level is not present. add the new stop loss. */
                $new_sl_query = "INSERT INTO portfolio_sl VALUES(null,".$trade_id.",".$stoploss.", NOW())";
                $new_sl_result = mysql_query($new_sl_query);
                if($new_sl_result){
                    $sl_id = mysql_insert_id();
                    if($sl_id == 0 || $sl_id == false){
		         /* New sl was not created. :-( unable to proceed. */
		         $sl_updated = false;
		    }else{
		        $sl_updated = true;
		    }
                }else{
                    $sl_updated = false;
                }
            }else{
                $sl_updated = false;
            }
            /* Free the result memory */
    	    mysql_free_result($sl_check_result);
        }else{
            $sl_updated = false;
        }
    }
    
    /* Check whether we need to update target table */
    $target_updated = false;
    if($target){
        /* Check whether same target exists for the trade. */
        $target_check_query = "SELECT target_id FROM portfolio_targets WHERE target=".$target." AND trade_id=".$trade_id;
        $target_check_result = mysql_query($target_check_query);
        if($target_check_result){
            if(mysql_num_rows($target_check_result) == 0){
                /* Target at this level is not present. add the new target. */
                $new_target_query = "INSERT INTO portfolio_targets VALUES(null,".$trade_id.",".$target.", NOW())";
                $new_target_result = mysql_query($new_target_query);
                if($new_target_result){
                    $target_id = mysql_insert_id();
                    if($target_id == 0 || $target_id == false){
		         /* New target was not created. :-( unable to proceed. */
		         $target_updated = false;
		    }else{
		        $target_updated = true;
		    }
                }else{
                    $target_updated = false;
                }
            }else{
                $target_updated = false;
            }
            /* Free the result memory */
    	    mysql_free_result($target_check_result);
        }else{
            $target_updated = false;
        }
    }
    
    /* Transaction has been added successfully. Return success */
    header('Content-type: application/json');
    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
    }
    /* to provide undo option, i need to send the old average buy and old quantity. This will reduce the number of queries in undo operation */
    $response = array("status" => '1', "qname"=> $trans_qscrip, "trans_id" => $trans_id, "trans_buy" =>$trans_price, "trans_qty" => $trans_qty, "new_trade" => $newtrade, "trade_id" => $trade_id, "trade_qty" => $update_qty, "avg_buy" => $update_avg_buy, 
                      "ltp" => $stockfound, "stockchg" => $stockchg, "target_updated" => $target_updated, "sl_updated" => $sl_updated, "old_avg_buy" => $trade_avg_buy, "old_qty" => $trade_qty);
    echo json_encode($response);
    mysql_close($con);
    return;
?>