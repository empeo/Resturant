<?php
require("../../connction.php");
session_start();
if (!isset($_SESSION["usernameRemeberMe"]) and !isset($_SESSION["username"])) {
  echo "<script>alert('login first!')</script>";
  header("location: ../../index.php");
  exit();
}
if (isset($_GET["id"]) and isset($_GET["namefood"]) and isset($_GET["pricefood"]) and isset($_SESSION["email"])) {
  $customerUser = $dbConnection->getData("customer", ["email" => $_SESSION["email"]]);
  $customerUserfood = $dbConnection->getData("food", ["name" => $_GET["namefood"]]);
  $arrUser = [];
  $arrFood = [];
  if (!empty($customerUser) and !empty($customerUserfood))
    foreach ($customerUser as $key => $values) {
      $arrUser[$key] = $values;
    }
  foreach ($customerUserfood as $key => $values) {
    $arrFood[$key] = $values;
  }
  // $orderNameForUser = $dbConnection->getDataJoin(["customer" => "id, fullname", "food" => "name, price"],"customer","food",["customer" => "id", "food" => "id"]);
  $orderQuery = $dbConnection->getInsertDataCus("`order`", ["email" => $arrUser["email"], "customer_name" => $arrUser["fullname"], "food_name" => $arrFood["name"], "price" => $arrFood["price"], "status" => "Running"]);
  if ($orderQuery) {
    header("location: ./orderUserTable.php");
    exit();
  } else {
    echo "<script>alert('Not Correct')</script>";
    require("./errorPages/error.php");
    exit();
  }
} else {
  require("./errorPages/error.php");
  exit();
}
