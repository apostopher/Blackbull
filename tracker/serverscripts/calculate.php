<?php
// Load the database script
require_once('../../serverscripts/dba.php');

$user_id = 1; /* populated from session */
$curr_mkt_price = Array("tcs.bo"=>150, "wipro.bo"=>100);

/* this array will contain the final values to be displayed to user. it will be populated by fetching different data from db using different query */
$portfolio_array = Array();

/* fetch the quantity, invested amt and average price of each share === step 1*/
$qt_invAmt_avgPrice = mysql_query("SELECT symbol, sum(quantity) as quantity, sum(quantity * price) as invested_amt, ROUND(sum(quantity * price) / sum(quantity), 2) as average_price  FROM `portfolio_transactions` where type='BUY' and id = ".$user_id." group by symbol");

/* this will hold the total invested amount in market === step 2 */
$total_inv_amt = 0;

/*
	computimg values required for step 1 and 2
*/
while($row = mysql_fetch_assoc($qt_invAmt_avgPrice)){
	$portfolio_array[$row['symbol']] = Array("avg_buy_price" => $row['average_price']);
	$total_inv_amt += $row['invested_amt'];
//	print_r($row);
}


$sql = "select symbol, sum(qt) as net_qt from  (
		SELECT symbol, sum(quantity) as qt  FROM `portfolio_transactions` where type='BUY' and id = ".$user_id." group by symbol
		UNION
		SELECT symbol, - sum(quantity) FROM `portfolio_transactions` where type='SELL'  and id = ".$user_id."  group by symbol
		) as result group by symbol";

$total_stock_qt = mysql_query($sql);
$money_value_in_market = 0; /* (BUY qt - SELL qt) * CMP === step 3 */
while($row = mysql_fetch_assoc($total_stock_qt)){
	$portfolio_array[$row['symbol']] = array_merge($portfolio_array[$row['symbol']], Array("current_qt" => $row['net_qt']));
	$money_value_in_market += ($row['net_qt'] * $curr_mkt_price[$row['symbol']]);
}



$sql = "SELECT symbol, sum(quantity * price) as cash FROM `portfolio_transactions` where type='SELL' and id = ".$user_id." group by symbol";

$money_in_cash = mysql_query($sql);
$total_money_in_cash = 0; /* (SELL qt) * SELL price === step 4 */
while($row = mysql_fetch_assoc($money_in_cash)){
	$total_money_in_cash += $row['cash'];
}


print_r($portfolio_array );
echo "<br>";
echo "(A) Total Invested Amount:".$total_inv_amt ;
echo "<br>";
echo "(B) Money Value in market:".$money_value_in_market ;
echo "<br>";
echo "(C) Total Money in cash:".$total_money_in_cash ;
echo "<br>";
echo "Absolute profit (B) + (C) - (A):".($money_value_in_market + $total_money_in_cash - $total_inv_amt);




/*
To get total quantity, invested amount and average price per share
	SELECT symbol, sum(quantity) as quantity, sum(quantity * price) as invested_amt, ROUND(sum(quantity * price) / sum(quantity), 2) as average_price  FROM `portfolio_transactions` where type='BUY' and id = 1 group by symbol

To get the total stock quantity in market...
	select symbol, sum(qt) from  (
		SELECT symbol, sum(quantity) as qt  FROM `portfolio_transactions` where type='BUY' and id = 1 group by symbol
		UNION
		SELECT symbol, - sum(quantity) FROM `portfolio_transactions` where type='SELL'  and id = 1  group by symbol
	) as result group by symbol

Money in cash
	SELECT symbol, sum(quantity * price) as cash FROM `portfolio_transactions` where type='SELL' and id = 1 group by symbol
*/

?>