<?php
//connect to the databases
try
{
  $dsn1 = "mysql:host=courses;dbname=z1813641";
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
?>