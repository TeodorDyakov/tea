<?php
    $host = "localhost";
    $username = "root";
    $password = "";
       
     $conn = new PDO("mysql:host=$host;dbname=chat", $username, $password);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
     header('Content-Type: application/json');
   
     if ($_SERVER['REQUEST_METHOD'] === 'GET') {
       
       $sql = "SELECT * FROM MESSAGES";
       
       $query = $conn->query($sql) or die("failed!");
       
       $rows = $query->fetchAll(PDO::FETCH_ASSOC);

       echo json_encode($rows);
     }else if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        
     }
?>