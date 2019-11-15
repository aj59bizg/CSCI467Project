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

    echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/orders.php>";
      echo "<input type=submit name='goorder'
                   value='Return to Orders'/>";
    echo "</form>";

    echo "<h1>Modify the Weight Brackets</h1>";

    if (array_key_exists('add', $_REQUEST))
    {
      $weightnum = $_REQUEST['addnum'];
      $floatnum1 = round(floatval($weightnum), 2);

      if ($floatnum1 < 0)
      {
        $floatnum1 = 0;
      }

      $chargenum = $_REQUEST['addcharge'];
      $floatnum2 = round(floatval($chargenum), 2);

      if ($floatnum2 < 0)
      {
        $floatnum2 = 0;
      }

      //reset the first element
      $sqlfnd = "SELECT * FROM admin WHERE bracket = $floatnum1";
      $queryfnd = $pdo1->query($sqlfnd);
      $fndarray = $queryfnd->fetchAll(PDO::FETCH_ASSOC);

      if (count($fndarray) != 0)
      {
        $sqlfo = "UPDATE admin SET charge = $floatnum2 WHERE bracket = $floatnum1";
        $queryfo = $pdo1->query($sqlfo);
      }

      else
      {
        //insert the elemnt into the list
        $sqladd = "INSERT INTO admin (bracket, charge)
                  VALUES ($floatnum1, $floatnum2)";
        $queryadd = $pdo1->query($sqladd);
     }
   }

    if (array_key_exists('delete', $_REQUEST))
    {
      $number = round(floatval($_REQUEST['weightdel']), 2);
      $sqldel = "DELETE FROM admin WHERE bracket = $number";
      $querydel = $pdo1->query($sqldel);
    }

    $sql1 = "SELECT * FROM admin ORDER BY bracket";
    $query1 = $pdo1->query($sql1);
    $brackets = $query1->fetchAll(PDO::FETCH_ASSOC);

    echo "<table border=3>";
      echo "<tr>";
        echo "<th>Weights</th>";
        echo "<th>Charges</th>";
        echo "<th>Delete</th>";
      echo "</tr>";

      foreach($brackets as $bracket)
      {
        echo "<tr>";
          echo "<td>";
            echo "$bracket[bracket]";
          echo "</td>";

          echo "<td>";
            echo "$bracket[charge]";
          echo "</td>";

          echo "<td>";
            echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/weights.php>";
              echo "<input type=hidden name='weightdel'
                           value=$bracket[bracket]/>";
              echo "<input type=submit name='delete'
                           value='Remove'/>";
            echo "</form>";
          echo "</td>";

        echo "</tr>";
      }
    echo "</table>";

    echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/weights.php>";
      echo "<input type=submit name='add'
                   value='Add Bracket'/>";
      echo "<input type=text name='addnum'
                   placeholder='Weight' required/>";
      echo "<input type=text name='addcharge'
                   placeholder='Charge' required/>";
    echo "</form>";
  ?>
</html>
