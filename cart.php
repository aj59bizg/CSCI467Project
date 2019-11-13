<html>
  <head>
    <title>
      Your Cart
    </title>
  </head>

  <?php
  //Attempt to connect to the database
  try
  {
    $dsn1 = "mysql:host=courses;dbname=z1817662";
    include("Project8Apswrd.php");
    $pdo1 = new PDO($dsn1, $username1, $password1);
  }

  //handle connection falure
  catch (PDOexception $e1)
  {
    echo "Database connection failure: " . $e1->getMessage();
  }

  //Attempt to connect to the second database
  try
  {
    $dsn2 = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
    include("Project8Apswrd.php");
    $pdo2 = new PDO($dsn2, $username2, $password2);
  }

  //handle connection failure
  catch (PDOexception $e2)
  {
    echo "Database connection failure: " . $e2->getMessage();
  }

  $cartcontents = array();

  if (array_key_exists('cart', $_REQUEST))
  {
    $cartcontents = unserialize(base64_decode($_REQUEST['cart']));
  }

  if (isset($_POST['changequantity']))
  {
    $ind = intval($_POST['index']);
    $quan = intval($_POST['quantity']);
    $cartcontents[$ind]['qntty'] = $quan;
  }

  echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/catelog.php>";
    $arraytostring4 = base64_encode(serialize($cartcontents));
    echo "<input type=hidden name='cart'
                 value=$arraytostring4/>";
    echo "<input type=submit name='button5'
                 value='Return to Catelog'/>";
  echo "</form>";

  echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/cart.php>";
    echo "<input type=submit name='button8'
                 value='Clear Cart'/>";
  echo "</form>";

  if (array_key_exists('pnum', $_REQUEST))
  {
    echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/details.php>";
      echo "<input type=hidden name='pnum'
                   value=$_REQUEST[pnum]/>";
      $arraytostring5 = base64_encode(serialize($cartcontents));
      echo "<input type=hidden name='cart'
                   value=$arraytostring5/>";
      echo "<input type=submit name='button6'
                   value='Return to Item'/>";
    echo "</form>";
  }

  if (!empty($cartcontents))
  {
    $plist = array();
    $calclist = array();
    $calcentry = array();
    foreach($cartcontents as $citem)
    {
      $sql1 = "SELECT * FROM parts WHERE number = $citem[prdctnum]";
      $query1 = $pdo2->query($sql1);
      $rows = $query1->fetchAll(PDO::FETCH_ASSOC);
      array_push($plist, $rows[0]);
    }

    $count = 0;
    $itemprices = 0;
    $totalweight = 0;
    $addfees = 0;
    $finalprice = 0;
    foreach($cartcontents as $centry)
    {
      $sql2 = "SELECT quantity FROM inventory WHERE productID = $centry[prdctnum]";
      $query2 = $pdo1->query($sql2);
      $rows2 = $query2->fetchAll(PDO::FETCH_ASSOC);
      $itemquant = $rows2[0]['quantity'];

      $pentry = $plist[$count];
      $calcentry = array("pid"=>($centry["prdctnum"]),
                   "des"=>($pentry["description"]),
                   "qty"=>($centry["qntty"]),
                   "tpr"=>($centry["qntty"] * $pentry["price"]),
                   "twe"=>($centry["qntty"] * $pentry["weight"]),
                   "mqy"=>($itemquant));
      array_push($calclist, $calcentry);

      //increment the summary variables
      $itemprices += ($centry["qntty"] * $pentry["price"]);
      $totalweight += ($centry["qntty"] * $pentry["weight"]);

      $count++;
    }

    //set the additional fees
    $sqladd = "SELECT * FROM admin ORDER BY bracket ASC";
    $queryadd = $pdo1->query($sqladd);

    //set default charge
    if ($queryadd == FALSE)
    {
      $addfees = 1.00;
    }

    else
    {
      $weightarray = $queryadd->fetchAll(PDO::FETCH_ASSOC);

      //set the additional fees
      foreach($weightarray as $weightbracket)
      {
        //we are dealing with the first
        if ($weightbracket['flag'] == 'F')
        {
          if ($totalweight <= $weightbracket['bracket'] && $totalweight >= 0)
          {
            $addfees = $weightbracket['charge'];
            break;
          }
        }

        elseif ($weightbracket['flag'] == 'N')
        {
          if ($totalweight <= $weightbracket['bracket'])
          {
            $addfees = $weightbracket['charge'];
            break;
          }
        }

        //we are dealing with the last bracket
        elseif ($weightbracket['flag'] == 'L')
        {
          if ($totalweight >= $weightbracket['bracket'])
          {
            $addfees = $weightbracket['charge'];
            break;
          }
        }
      }
    }

    $itemprices = round($itemprices, 2);
    $totalweight = round($totalweight, 2);
    $addfees = round($addfees, 2);
    $finalprice = round(($itemprices + $addfees), 2);

    echo "<h1>Review Your Items</h1>";

    echo "<table border=3>";
      echo "<tr>";
        echo "<th>Product ID</th>";
        echo "<th>Product Description</th>";
        echo "<th>Quantity</th>";
        echo "<th>Added Price</th>";
        echo "<th>Added Weight</th>";
        echo "<th>Change Quantity</th>";
        echo "<th>Edit</th>";
        echo "<th>Revisit</th>";
      echo "</tr>";

      $countcount = 0;
      foreach($calclist as $cinfo)
      {
        echo "<tr>";
        foreach($cinfo as $label=>$data)
        {
          if ($label != "mqy")
          {
            echo "<td>$data</td>";
          }
        }

          echo "<td>";
            echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/cart.php>";
              if (array_key_exists('pnum', $_REQUEST))
              {
                echo "<input type=hidden name='pnum'
                             value=$_REQUEST[pnum]/>";
              }

              $arraytostring9 = base64_encode(serialize($cartcontents));
              echo "<input type=hidden name='cart'
                           value=$arraytostring9/>";
              echo "<input type=hidden name='index'
                           value=$countcount/>";
              echo "<input type=number name='quantity'
                           min=1 max='$cinfo[mqy]'/>";
              echo "<input type=submit name='changequantity'
                           value='Change'/>";
            echo "</form>";
          echo "</td>";

          echo "<td>";
            echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/cart.php>";
              if (array_key_exists('pnum', $_REQUEST))
              {
                echo "<input type=hidden name='pnum'
                             value=$_REQUEST[pnum]/>";
              }

              $cartarray = array();
              foreach($cartcontents as $cartitem)
              {
               if ($cartitem['prdctnum'] != $cinfo['pid'])
               {
                 array_push($cartarray, $cartitem);
               }
              }
              $arraytostring8 = base64_encode(serialize($cartarray));
              echo "<input type=hidden name='cart'
                           value=$arraytostring8/>";
              echo "<input type=submit name=$cinfo[pid]
                           value='Delete'/>";
            echo "</form>";
          echo "</td>";
          echo "<td>";
            echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/details.php>";
              $arraytostring11 = base64_encode(serialize($plist[$countcount]));
              echo "<input type=hidden name='pnum'
                           value=$arraytostring11/>";
              $arraytostring10 = base64_encode(serialize($cartcontents));
              echo "<input type=hidden name='cart'
                          value=$arraytostring10/>";
              echo "<input type=submit name='revisit'
                           value='View Item'/>";
            echo "</form>";
          echo "</td>";
        echo "</tr>";
        $countcount++;
      }
    echo "</table>";

    echo "<h4>Order Totals</h4>";
    echo "<table border=3>";
      echo "<tr>";
        echo "<th>Total Price</th>";
        echo "<th>Total Weight</th>";
        echo "<th>Additional Fees</th>";
        echo "<th>Final Price</th>";
      echo "</tr>";
      echo "<tr>";
        echo "<td>$itemprices</td>";
        echo "<td>$totalweight</td>";
        echo "<td>$addfees</td>";
        echo "<td>$finalprice</td>";
      echo "</tr>";
    echo "</table>";

    echo "<h4>Ready to Order?</h4>";

    echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/checkout.php>";
      $arraytostring12 = base64_encode(serialize($cartcontents));
      echo "<input type=hidden name='cart'
                   value=$arraytostring12/>";
      echo "<input type=hidden name='itemprices'
                   value=$itemprices/>";
      echo "<input type=hidden name='totalweight'
                   value=$totalweight/>";
      echo "<input type=hidden name='addfees'
                   value=$addfees/>";
      echo "<input type=hidden name='finalprice'
                   value=$finalprice/>";
      echo "<input type=submit name='gotocheckout'
                   value='Proceed to Checkout'/>";
    echo "</form>";
  }

  else
  {
    echo "Your Cart is empty";
  }
  ?>
</html>
