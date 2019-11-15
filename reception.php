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

    catch (PDOexception $e2)
    {
      echo "Database connection failed: " . $e2->getMessage();
    }

    if (array_key_exists('change', $_REQUEST))
    {
      $changenum = intval($_REQUEST['qntty']);
      $prdctnum = intval($_REQUEST['pnmbr']);
      $sqlchange = "UPDATE inventory SET quantity = $changenum WHERE productID = $prdctnum";
      $qchange = $pdo1->query($sqlchange);
    }



    echo "<h1>Inventory</h1>";

    $sql3 = "SELECT number FROM parts";
    $q3 = $pdo2->query($sql3);
    $array3 = $q3->fetchAll(PDO::FETCH_ASSOC);

    $arraymast = array();
    foreach($array3 as $pnumb)
    {
      $sql1 = "SELECT productID, quantity FROM inventory WHERE productID = $pnumb[number]";
      $q1 = $pdo1->query($sql1);
      $array1 = $q1->fetchAll(PDO::FETCH_ASSOC);
      array_push($arraymast, $array1[0]);
    }

    echo "<table border=3>";
      echo "<tr>";
        echo "<th>Product Number</th>";
        echo "<th>Product Description</th>";
        echo "<th>Quantity on Hand</th>";
        echo "<th>Change Amounts on Hand</th>";
      echo "</tr>";

      foreach($arraymast as $num)
      {
        echo "<tr>";
          $sql2 = "SELECT description FROM parts WHERE number = $num[productID]";
          $q2 = $pdo2->query($sql2);
          $array2 = $q2->fetchAll(PDO::FETCH_ASSOC);
          $description = $array2[0]['description'];

          echo "<td>";
            echo "$num[productID]";
          echo "</td>";

          echo "<td>";
            echo "$description";
          echo "</td>";

          echo "<td>";
            echo "$num[quantity]";
          echo "</td>";

          echo "<td>";
            echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/reception.php>";
              echo "<input type=number name='qntty'
                           min=1 required/>";
              echo "<input type=hidden name='pnmbr'
                           value=$num[productID]/>";
              echo "<input type=submit name='change'
                           value='Modify'/>";
            echo "</form>";
          echo "</td>";

        echo "</tr>";
      }
  ?>
</html>
