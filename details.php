<html>
  <?php
  //Attempt to connect to the first database
  try
  {
    $dsn1 = "mysql:host=courses;dbname=z1817662";
    include("Project8Apswrd.php");
    $pdo1 = new PDO($dsn1, $username1, $password1);
  }

  catch (PDOexeption $e1)
  {
    echo "Database connection failed: " . $e1->getMessage();
  }

  try
  {
    $dsn2 = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
    include("Project8Apswrd.php");
    $pdo2 = new PDO($dsn2, $username2, $password2);
  }

  catch (PDOexception $e2)
  {
    echo "Database connection failed: " . $e2->getMessage();
  }

  //initialzize the cart
  $cartcontents = array();

  //check for the existence of a cart
  if (array_key_exists('cart', $_REQUEST))
  {
    $cartcontents = unserialize(base64_decode($_REQUEST['cart']));
  }

  //check for the existence of an item
  if (array_key_exists('pnum', $_REQUEST))
  {
    $chosenitem = unserialize(base64_decode($_REQUEST['pnum']));
  }

  else
  {
    $chosenitem = array("number"=>"-1", "description"=>"NO ITEM CHOSEN", "price"=>"-1", "weight"=>"-1", "https://www.google.com/url?sa=i&source=images&cd=&ved=2ahUKEwiE0Pb2ht7lAhVHLKwKHcwBA-MQjRx6BAgBEAQ&url=https%3A%2F%2Fwww.vectorstock.com%2Froyalty-free-vector%2Fnot-available-flat-icon-vector-12770007&psig=AOvVaw3CzGK2ABM54vY1_P-FI8gw&ust=1573420670639053"=>"pictureURL");
  }

  if (isset($_POST['addcart']))
  {
    $citem = array("prdctnum"=>$chosenitem['number'], "qntty"=>$_POST['quantity']);
    array_push($cartcontents, $citem);
  }
  ?>

  <head>
    <title>
      Product Details
    </title>
  <head>

  <?php
  echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/catelog.php>";
    $arraytostring1 = base64_encode(serialize($cartcontents));
    echo "<input type=hidden name='cart'
                 value=$arraytostring1/>";
    echo "<input type=submit name='button3'
                 value='Return to Catelog'/>";
  echo "</form>";

  echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/cart.php>";
    echo "<input type=hidden name='pnum'
                 value=$_REQUEST[pnum]/>";
    $arraytostring1 = base64_encode(serialize($cartcontents));
    echo "<input type=hidden name='cart'
                 value=$arraytostring1/>";
    echo "<input type=submit name='button4'
                 value='Your Cart'/>";
  echo "</form>";
  ?>

  <h1>Product Details</h1>
  <?php
    //get the quantity for the item
    $sql1 = "SELECT quantity FROM inventory WHERE productID = $chosenitem[number]";
    $query1 = $pdo1->query($sql1);
    $rows = $query1->fetchAll(PDO::FETCH_ASSOC);
    $itemquant = $rows[0]['quantity'];

    //create a table with the appropriate information
    echo "<img src=$chosenitem[pictureURL]
           style=width:200px;height=200px>";
    echo "<table border=3>";
      echo "<tr>";
        echo "<th>Product Number</th>";
        echo "<th>Product Description</th>";
        echo "<th>Product Price</th>";
        echo "<th>Product Weight</th>";
        echo "<th>In Stock</th>";
      echo "</tr>";

      echo "<tr>";
        echo "<td>$chosenitem[number]</td>";
        echo "<td>$chosenitem[description]</td>";
        echo "<td>$chosenitem[price]</td>";
        echo "<td>$chosenitem[weight]</td>";
        echo "<td>$itemquant</td>";
      echo "</tr>";
    echo "</table>";
  ?>

  <?php
  echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/details.php>";
    echo "<input type=hidden name='pnum'
                 value=$_REQUEST[pnum]/>";
    echo "<input type=hidden name='cart'
                 value=$_REQUEST[cart]/>";

    $found = False;
    foreach($cartcontents as $cartcheck)
    {
      if ($cartcheck['prdctnum'] == $chosenitem['number'])
      {
        $found = True;
      }
    }

    if ($found == False)
    {
      echo "<h5>Qnty:</h5>";
      echo "<input type=number name='quantity'
                 min=1 max='$itemquant'/>";
      echo "<input type=submit name='addcart'
                 value='Add to Cart'/>";
    }

    else
    {
      echo "You added this item to your cart. Please edit your decision there.";
    }
    echo "</form>";
  ?>

</html>
