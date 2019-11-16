
<html>
  <head>
    <title>
      Project 8A
    </title>
  </head>

  <?php
   require("conn.php");

   $stmt = $pdo1->query('select * from orders;');
   echo '<table border="1">';
   echo '<th>ID</th>';

   //displaying the information from the query in the table
   while($row = $stmt->fetch(PDO::FETCH_ASSOC))
 {
   echo '<tr><td>';
   echo $row['ordersID'];
   echo '</td></tr>';	
 } 

   echo '</table>';
   echo '</div>';
  ?>
</html>
