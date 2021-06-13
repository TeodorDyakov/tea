<?php
    $host = "localhost";
    $username = "root";
    $password = "";
       
     $conn = new PDO("mysql:host=$host;dbname=chat", $username, $password);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
     header('Content-Type: application/json');

     $requestUrl = $_SERVER['REQUEST_URI'];
     if (strpos($requestUrl,'/lastMsg')) {

      $lastMsgId = $_GET["id"];
       
      $sql = "SELECT * FROM MESSAGES WHERE id > '".$lastMsgId."'";

      $query = $conn->query($sql) or die("failed!");
       
       $rows = $query->fetchAll(PDO::FETCH_ASSOC);

       echo json_encode($rows);

     }
      else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
       
       $sql = "SELECT * FROM MESSAGES";
       
       $query = $conn->query($sql) or die("failed!");
       
       $rows = $query->fetchAll(PDO::FETCH_ASSOC);

       echo json_encode($rows);
     }else if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $text = json_decode(file_get_contents('php://input'), true);
             
        $sql = "INSERT INTO MESSAGES (text, author) 
        VALUES ('{$text}', 'guest')";

        $query = $conn->query($sql) or die("failed!");  
     }
?>