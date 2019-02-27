<?php
  $payload = $_GET["payload"];
  $payload = json_decode($payload);

  $operation = $payload->operation;
  $numbers = $payload->numbers;
  $start = ($operation == "add") ? 0:1;

  $result = array_reduce($numbers, $operation, $start);

  header("Access-Control-Allow-Origin: *");
  header('Content-Type: application/json');


  echo json_encode(array(
    "success" => true,
    "result" => $result,
    "operation" => $operation,
    "numbers" => $numbers,
  ));

  function add($carry, $item)
  {
      return $carry + $item;
  }

  function multiply($carry, $item)
  {
      return $carry *  $item;
  }
