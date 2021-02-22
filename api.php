<?php

$conn = new mysqli("localhost","root","","vue-crud");
if ($conn->connect_errno){
    die("Database connect error!");
}
$response = ["error" =>false];

$action = "read";

if (isset($_GET["action"])){
    $action = $_GET["action"];
}
if ($action === "read"){
    $users = array();
    $result = $conn->query("SELECT * FROM `users`");
  while ($row = $result->fetch_assoc()){
      array_push($users, $row);
  }
    $response["users"] = $users;
}elseif ($action === "create"){
    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];

    $result = $conn->query("INSERT INTO `users`(`name`, `username`, `email`) VALUES ('$name','$username','$email')");
    if ($result){
        $response["message"] = "Data saved successfully.";
    }else{
        $response["message"] = "Data saved failed.";
    }
}elseif ($action === "update"){
    $id = $_POST["id"];
    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];

    $result = $conn->query("UPDATE `users` SET `name`= '$name',`username`= '$username',`email`= '$email' WHERE id = '$id'");
    if ($result){
        $response["message"] = "Data updated successfully.";
    }else{
        $response["message"] = "Data updated failed.";
    }
}elseif ($action === "delete"){
    $id = $_POST["id"];

    $result = $conn->query("DELETE FROM `users` WHERE id = '$id'");
    if ($result){
        $response["message"] = "Data deleted successfully.";
    }else{
        $response["message"] = "Data deleted failed.";
    }
}else{
    $response["error"] = true;
    die("Invalid action");
}
header("content-type:application/json");
echo json_encode($response);