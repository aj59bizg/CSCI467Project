<html>
  <?php
    try
    {
      $dsn1 = "mysql:host=courses;dbname=z1817662";
      include("Project8Apswrd.php");
      $pdo1 = new PDO($dsn1, $username1, $password1);
    }

    catch(PDOexception $e1)
    {
      echo "Database connection failed: " . $e1->getMessage();
    }

    try
    {
      $dsn2 = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
      include("Project8Apswrd.php");
      $pdo2 = new PDO($dsn2, $username2, $password2);
    }

    catch(PDOexception $e2)
    {
      echo "Database connection failed: " . $e2->getMessage();
    }

    //handle a search for date
    if (array_key_exists('searchdate', $_REQUEST))
    {
      $lowval = date('Y-m-d', strtotime($_REQUEST['lowerdate']));
      $highval = date('Y-m-d', strtotime($_REQUEST['higherdate']));

      $statement = "SELECT ordersID, custid, finalprice, date, status FROM orders
                    WHERE date BETWEEN \"$lowval\" AND \"$highval\"";
      $_POST['sql'] = $statement;
    }

    //handle search for status
    else if (array_key_exists('searchstatus', $_REQUEST))
    {
      $statusval = $_REQUEST['status'];
      $statement = "SELECT ordersID, custid, finalprice, date, status FROM orders
                    WHERE status = \"$statusval\"";
      $_POST['sql'] = $statement;
    }

    //handle a search for price
    else if (array_key_exists('searchprice', $_REQUEST))
    {
      $lownum = round(floatval($_REQUEST['lowerprice']), 2);
      $highnum = round(floatval($_REQUEST['higherprice']), 2);

      $statement = "SELECT ordersID, custid, finalprice, date, status FROM orders
                    WHERE finalprice BETWEEN $lownum AND $highnum";
      $_POST['sql'] = $statement;
    }


    if (!array_key_exists('viewall', $_REQUEST) && !array_key_exists('search', $_REQUEST))
    {
      echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/orders.php>";
        echo "<input type=submit name='viewall'
                     value='View All Orders'/>";
      echo "</form>";

      echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/weights.php>";
        echo "<input type=submit name='goweights'
                     value='Adjust Charges'/>";
      echo "</form>";
    }

    else
    {
      echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/orders.php>";
        echo "<input type=submit name='closeall'
                     value='Close Orders'/>";
      echo "</form>";

      echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/orders.php>";
        echo "<input type=submit name='searchdate'
                     value='Search Dates Between'/>";
        echo "<input type=text name='lowerdate'
                     placeholder='Lower Bound' required/>";
        echo "<input type=text name='higherdate'
                     placeholder='Upper Bound' required/>";
        echo "<input type=hidden name='search' value='D'/>";
      echo "</form>";

      echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/orders.php>";
        echo "<input type=submit name='searchstatus'
                     value='Search by Status of      '/>";
        echo "<input type=text name='status'
                     placeholder='Status' required/>";
        echo "<input type=hidden name='search' value='S'/>";
      echo "</form>";

      echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/orders.php>";
        echo "<input type=submit name='searchprice'
                    value='Search Prices Between'/>";
        echo "<input type=text name='lowerprice'
                     placeholder='Lower Bound' required/>";
        echo "<input type=text name='higherprice'
                     placeholder='Upper Bound' required/>";
        echo "<input type=hidden name='search' value='P'/>";
      echo "</form>";

      $sql1 = "SELECT ordersID, custid, finalprice, date, status FROM orders";
      if (array_key_exists('sql', $_POST) && array_key_exists('sql', $_POST))
      {
        $sql1 = $_POST['sql'];
      }

      if (array_key_exists('sql', $_REQUEST))
      {
        $sql1 = "";
        $asarray = unserialize(base64_decode($_REQUEST['sql']));

        foreach($asarray as $word)
        {
          $sql1 = ($sql1 . $word . " ");
        }

        $sql1 = substr($sql1, 0, -1);
      }

      $query1 = $pdo1->query($sql1);
      $allorders = $query1->fetchAll(PDO::FETCH_ASSOC);

      $toarray = explode(" ", $sql1);

      echo "<table border=3>";
        echo "<tr>";
          echo "<th>Order ID</th>";
          echo "<th>Customer ID</th>";
          echo "<th>Price</th>";
          echo "<th>Date</th>";
          echo "<th>Status</th>";
        echo "</tr>";

        foreach($allorders as $order)
        {
          echo "<tr>";
            echo "<td>";
              echo "$order[ordersID]";
            echo "</td>";

            echo "<td>";
              echo "$order[custid]";
            echo "</td>";

            echo "<td>";
              echo "$order[finalprice]";
            echo "</td>";

            echo "<td>";
              echo "$order[date]";
            echo "</td>";

            echo "<td>";
              echo "$order[status]";
            echo "</td>";

            echo "<td>";
              echo "<form method=post action =http://students.cs.niu.edu/~z1817662/Project8A/orderdetails.php>";
                echo "<input type=hidden name='oid'
                             value=$order[ordersID]/>";
                $arraytostring1 = base64_encode(serialize($toarray));
                echo "<input type=hidden name='sql'
                             value=$arraytostring1/>";
                echo "<input type=submit name=$order[ordersID]
                             value='See Details'/>";
              echo "</form>";
            echo "</td>";
          echo "</tr>";
        }
      echo "</table>";
    }
  ?>
</html>
