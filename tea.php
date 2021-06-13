<?php
$host = "localhost";
$username = "root";
$password = "";

$conn = new PDO("mysql:host=$host;dbname=chat", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

header('Content-Type: application/json');
$user_id = "";
if (!isset($_COOKIE['id'])) {
  $user_id = 'guest_' . generateRandomString(7);
  setcookie('id', $user_id);
} else {
  $user_id = $_COOKIE['id'];
}

try {
  $requestUrl = $_SERVER['REQUEST_URI'];
  if (strpos($requestUrl, '/lastMsg')) {

    $lastMsgId = $_GET["id"];

    $sql = "";
   
    if (strpos($requestUrl, '/rand_match')){
      $sql = "SELECT * FROM MESSAGES WHERE id > '" . $lastMsgId . "'";      
    }else{
      $sql = "SELECT * FROM MESSAGES WHERE id > '" . $lastMsgId . "'";
    }

    $query = $conn->query($sql) or die("failed!");

    $rows = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($rows);

    $date = date('Y-m-d H:i:s');

    $sql = "INSERT INTO last_active (id_of_user, last_active) 
    VALUES ('{$user_id}', '{$date}')
    ON DUPLICATE KEY UPDATE
    last_active = '{$date}'";

    $query = $conn->query($sql) or die("failed!");

  } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $sql = "SELECT * FROM MESSAGES";

    $query = $conn->query($sql) or die("failed!");

    $rows = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($rows);
  } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = json_decode(file_get_contents('php://input'), true);

    $sql = "INSERT INTO MESSAGES (text, author) 
        VALUES ('{$text}', '{$user_id}')";

    $query = $conn->query($sql) or die("failed!");
  }
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

function generateRandomString($length = 10)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

