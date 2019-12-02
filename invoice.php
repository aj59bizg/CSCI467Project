
<html>
  <head>
    <title>
      Project 8A
    </title>
  </head>

  <?php
    require("conn.php");

    //try adding form to select order id:
    echo '<form action="invoice.php" method="post">';
      echo 'Order ID: <input type=text name=orderid id=orderid><br>'; //input box for order id number
      echo '<br><input type="submit" name="submit" value="Submit"><br>'; //submit button
    echo '</form>';


    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $orderid = $_POST['orderid'];
        //////////////////////////////
        $stmt = $pdo1->query('select * from ordereditems where orderID = '.$orderid);
        echo '<table border="1">';
        echo '<th>Order ID</th>';
        echo '<th>description</th>';
        echo '<th>Unit Price</th>';
        echo '<th>quantity</th>';

        //displaying the information from the query in the table
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
          $productid = $row['productID'];
          $stmtgetdescription = $pdo2->query('select * from parts where number = '.$productid);
          // 'select quantity from orderedItems where orderID'

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
        // echo '</div>';

        ///////////// second table //////////////////
        $stmt2 = $pdo1->query('select * from orders where ordersID = '.$orderid);
        while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC))
        {
            echo '<table border="1">';

            echo '<tr><th>Net Price</th><td>';
            echo $row2['totalprice'];
            echo '</td></tr>';

            echo '<tr><th>Fees</th><td>';
            echo $row2['addfees'];
            echo '</td></tr>';

            echo '<tr><th>Total Price</th><td>';
            echo $row2['finalprice'];
            echo '</td></tr>';

            echo '</table>';
        }

    }
   
  ?>
</html>
