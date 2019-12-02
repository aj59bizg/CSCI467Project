
<html>
  <head>
    <title>
      Project 8A
    </title>
  </head>

  <?php
    require("conn.php");

    //try adding form to select order id:
    echo '<form action="workstations.php" method="post">';
      echo 'Order ID: <input type=text name=orderid id=orderid><br>'; //input box for order id number
      echo '<br><input type="submit" name="submit" value="Submit"><br>'; //submit button
    echo '</form>';


    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $orderid = $_POST['orderid'];
        //////////////////////////////
        $stmt = $pdo1->query('select * from ordereditems where orderID = '.$orderid); // add 'where orderid = 'the order we're looking for'; get order id from form the user fills out
        echo '<table border="1">';
        echo '<th>Order ID</th>';
        echo '<th>description</th>';
        echo '<th>productid</th>';
        echo '<th>quantity</th>';

        //displaying the information from the query in the table
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
          $productid = $row['productID'];
          $stmtgetdescription = $pdo2->query('select description from parts where number = '.$productid);
          // 'select quantity from orderedItems where orderID'

          while($description = $stmtgetdescription->fetch(PDO::FETCH_ASSOC))
          {
            echo '<tr><td>';
            echo $row['orderID'];
            echo '</td><td> ';
            echo $description['description'];
            echo '</td><td> ';
            echo $row['productID'];
            echo '</td><td> ';
            echo $row['quantity'];
            echo '</td></tr>';
          }

        } 

        echo '</table>';
        echo '</div>';

    }
   
  ?>
</html>
