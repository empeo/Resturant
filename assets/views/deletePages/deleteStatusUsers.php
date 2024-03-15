<?php
require("../../../connction.php");
session_start();
if (!isset($_SESSION["usernameRemeberMe"]) and !isset($_SESSION["username"])) {
    header("location: ../../../index.php");
    exit();
}
if(isset($_GET["id"])){
    $queryDeleteOrder = $dbConnection->deleteData("`order`",["id"=>$_GET["id"]]);
    $queryDeleteOrder?header("location: ../orderUserTable.php?message=Successful Delete"):header("location: ../orderUserTable?message=Failed Delete");
    exit();
}
else{
    require("../errorPages/error.php");
    exit();
}