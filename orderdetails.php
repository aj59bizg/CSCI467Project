<html>
  <?php

    $sql1 = "SELECT ordersID, custid, finalprice, date, status FROM orders";
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

    $toarray = explode(" ", $sql1);

    echo "<form method=post action=http://students.cs.niu.edu/~z1817662/Project8A/orders.php>";
      $arraytostring1 = base64_encode(serialize($toarray));
      echo "<input type=hidden name='sql'
                   value=$arraytostring1/>";
      echo "<input type=hidden name='viewall'
                   value='View All Orders'/>";
      echo "<input type=hidden name='search'
                   value='R'/>";
      echo "<input type=submit name='orders'
                   value='Return to Search'/>";
    echo "</form>";
  ?>
</html>
