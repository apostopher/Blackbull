<?php
// Load the database script
require_once('dba.php');

$result = mysql_query("SELECT * FROM portfolio_transactions order by timestamp desc");

if(isset($_POST['btn']) && $_POST['btn']!=null && $_POST['btn']=="Add"){
	$sql = "insert into portfolio_transactions(id, type, quantity, symbol, name, price, date, timestamp)";
	$sql .= " values (".$_POST['user_id'].", '".$_POST['type']."', '".$_POST['quantity']."', '".$_POST['symbol']."', '".$_POST['name']."', '".$_POST['price']."', '".$_POST['date']."', CURRENT_TIMESTAMP)";
	$insert = mysql_query($sql);
	if($insert == 1)
		echo "Insert successful";
	else
		echo "Error in inserting";
}

?>

<html>
<head>
</head>
<body>
<form action="http://blackbull.in/serverscripts/populate.php" method="post">
	<table border="0" cellspacing="0" cellpadding="1">
		<tr>
			<th>User ID</th>
			<th>Type</th>
			<th>Quantity</th>
			<th>Symbol</th>
			<th>Name</th>
			<th>Price</th>
			<th>Date (yyyy/mm/dd)</th>
			<th>Action</th>
		</tr>
		<tr>
			<td><input type="text" name="user_id" id="user_id" size="3"></td>
			<td>
				<select name="type">
					<option value="BUY">Buy</option>
					<option value="SELL">Sell</option>
				</select>
			</td>
			<td><input type="text" name="quantity" id="quantity" size="5"></td>
			<td><input type="text" name="symbol" id="symbol" ></td>
			<td><input type="text" name="name" id="name" ></td>
			<td><input type="text" name="price" id="price" ></td>
			<td><input type="text" name="date" id="date" ></td>
			<td><input type="submit" name="btn" id="btn" value="Add" ></td>
		</tr>
		<?php
			while($row = mysql_fetch_array($result)){
				echo '<tr>
						<td>'.$row['id'].'</td>
						<td>'.$row['type'].'</td>
						<td>'.$row['quantity'].'</td>
						<td>'.$row['symbol'].'</td>
						<td>'.$row['name'].'</td>
						<td>'.$row['price'].'</td>
						<td>'.$row['date'].'</td>
						<td><a onclick="edit('.$row['transaction_id'].')">Edit</a></td>
					<tr>';
			}
		?>
	</table>
</form>
</body>
</html>

<?php
	mysql_close($con);
?>