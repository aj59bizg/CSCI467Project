<html>
	<head>
		<title>
		Project 8A Shipping Label
		</title>
	</head>
	<?php
    	// Connect
    	require("conn.php");
    	require("Project8Apswrd.php");

    	// try adding form to select order id:
    	echo '<form action="shippinglabel.php" method="post">';
    	echo 'Order ID: <input type=text name=orderid id=orderid><br>'; // input box for order id number
    	echo '<br><input type="submit" name="Print Label" value="Print Label"><br>'; // Print label button
    	echo '</form>';
    	if($_SERVER['REQUEST_METHOD'] == 'POST')
    		{
        	$orderid = $_POST['orderid'];

        	// Shipping Label Table
        	$stmt = $pdo1->query('select * from ordereditems where orderID = '.$orderid);
        	echo '<table border="1">';
        	echo '<th>Order ID</th>';
        	echo '<th>Description</th>';
        	echo '<th>Unit Price</th>';
        	echo '<th>Quantity</th>';

			// Dislaying info from query in table
        	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        		{
          		$productid = $row['productID'];
          		$stmtgetdescription = $pdo2->query('select * from parts where number = '.$productid);

			// Shipping label Info
          		while($description = $stmtgetdescription->fetch(PDO::FETCH_ASSOC))
          			{
            		echo '<tr><td>';
            		echo $row['orderID'];
            		echo '</td><td> ';
            		echo $description['description'];
            		echo '</td><td> ';
            		echo $description['price'];
            		echo '</td><td> ';
            		echo $row['quantity'];
            		echo '</td></tr>';
					}
        		}

        	echo '</table>';

        	// Weight & Status Info
        	$stmt2 = $pdo1->query('select * from orders where ordersID = '.$orderid);
				while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC))
					{
					echo '<table border="1">';
					echo '<tr><th>Weight</th><td>';
					echo $row2['totalweight'];
					echo '<tr><th>Status</th><td>';
					echo $row2['status'];
					echo '</table>';
					}
            // Customer Info
            $stmt3 = $pdo1->query('select * from customer where customerID = '.$orderid);
				while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC))
					{
					echo '<table border="1">';
					echo '<tr><th>Name</th><td>';
					echo $row3['name'];
					echo '<tr><th>Address</th><td>';
					echo $row3['address'];
					echo '<tr><th>Email</th><td>';
					echo $row3['email'];
					echo '</table>';
					}
			}
        // echo 'Status: <input type=text name=status id=status><br>'; // input box for status
        // echo '<br><input type="submit" name="Update Status" value="Update Status"><br>'; // Update Order Status button

 	?>
</html>
