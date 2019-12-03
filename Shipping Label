<html>
  <head>
    <title>
      Project 8A Shipping Label
    </title>
  </head>

  <?php
    // Connect
    require("conn.php");
	
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
		$stmt = $pdo1->query('select * from orders where ordersID = '.$orderid);
		echo '<th>Weight</th>';

        // Displaying info from query in table
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
			echo $row['totalweight'];
            echo '</td></tr>';
			
          }
        }
		
        echo '</table>';	
    }
	//echo '<br><input type="button" name="Print" value="Print"><br>'; // Print Shipping Label button
  ?>
</html>
