<!-- Alexander Wold (Z1817662) CSCI 467 Project 8A -->
<html>
  <head>
    <title>
      Project 8A
    </title>
  </head>

  <?php
  $cartcontents = array();

  //maintain the cart array
  if (array_key_exists('cart', $_REQUEST))
  {
    $cartcontents = unserialize(base64_decode($_REQUEST['cart']));
  }

  echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/catelog.php>";
    $arraytostring3 = base64_encode(serialize($cartcontents));
    echo "<input type=hidden name='cart'
                 value=$arraytostring3/>";
    echo "<input type=hidden name='list'
                 value='filler'/>";
    echo "<input type=submit name='button1'
                 value='View Product Catelog'/>";
    echo "<input type=submit name='button2'
                 value='Close Product Catelog'/>";
  echo "</form>";

  //create a cart button
  echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/cart.php>";
    $arraytostring6 = base64_encode(serialize($cartcontents));
    echo "<input type=hidden name='cart'
                 value=$arraytostring6/>";
    echo "<input type=submit name='button7'
                 value='Your Cart'/>";
  echo "</form>";

  //Attempt to connect to the first database
  try
  {
    $dsn1 = "mysql:host=courses;dbname=z1817662";
    include("Project8Apswrd.php");
    $pdo1 = new PDO($dsn1, $username1, $password1);
  }

  //if the first connection fails, explain why
  catch(PDOexception $e1)
  {
    //remember, . is the string concatenator
    echo "Database connection failed: " . $e1->getMessage();
  }

  //Attempt to connect to the second database
  try
  {
    $dsn2 = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
    include("Project8Apswrd.php");
    $pdo2 = new PDO($dsn2, $username2, $password2);
  }

  //if the connection to the second database fails, explain why
  catch(PDOexception $e2)
  {
    echo "Database connection failed: " . $e2->getMessage();
  }
  ?>

  <?php
  //handle the funtionality for the close catelog button
  if (isset($_POST['button2']))
  {
    unset($_REQUEST['list']);
  }

  if(array_key_exists('list', $_REQUEST))
  {
    //test a query
    echo "<h1>Product Catelog</h1>";
    $sql1 = "SELECT * FROM parts";
    $query1 = $pdo2->query($sql1);

    //get a printable array
    $rows = $query1->fetchAll(PDO::FETCH_ASSOC);

    //use a table to print the results
    echo "<table border=3>";
      echo "<tr>";
        echo "<th>Product Number</th>";
        echo "<th>Product</th>";
        echo "<th>Product Details</th>";
      echo "</tr>";
      foreach($rows as $value)
      {
        echo "<tr>";
          echo "<td>";
            echo "$value[number]";
          echo "</td>";

          echo "<td>";
            echo "$value[description]";
          echo "</td>";
        //create a button to take the customer to the details page
          echo "<td>";
            echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/details.php>";
              $arraytostring = base64_encode(serialize($value));
              echo "<input type=hidden name=pnum
                           value=$arraytostring/>";
              $arraytostring2 = base64_encode(serialize($cartcontents));
              echo "<input type=hidden name='cart'
                           value=$arraytostring2/>";
              echo "<input type=submit name='$value[number]'
                           value='See Details'/>";
            echo "</form>";
          echo "</td>";
        echo "</tr>";
      }
    echo "</table>";
  }
  ?>
</html>
