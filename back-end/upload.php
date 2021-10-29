<?php
  header('Access-Control-Allow-Origin: *');
  header("Content-Type:application/json");

  $acceptFormats = ["image/jpg","image/png","image/jpeg","image/webp"];
  
  if($_SERVER["REQUEST_METHOD"] != "POST"){
    $response = array(
      "status" => 400,
      "msg" => "failed"
    );
    http_response_code(400);
    echo json_encode($response);
    die;
  }
  $file = $_FILES["upload"];

  if(!in_array($file["type"],$acceptFormats)){
    $response = array(
      "status" => 415,
      "msg" => "please upload image file"
    );
    http_response_code(415);
    echo json_encode($response);
    die;
  }

  // upload file in server
  $random = rand(1000,999999);
  if(!move_uploaded_file($file["tmp_name"],"storage/".strval($random).$file["name"])){
    $response = array(
      "status" => 500,
      "msg" => "failed to upload"
    );
    http_response_code(500);
    echo json_encode($response);
    die;
  }

  $response = array(
    "msg" => "image upload success"
  );
  echo json_encode($response);

?>