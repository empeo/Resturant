<?php
require("../../../connction.php");
session_start();
if (!isset($_SESSION["usernameRemeberMe"]) and !isset($_SESSION["username"])) {
    header("location: ../../../index.php");
    exit();
}
if(isset($_GET['id']) and isset($_GET["status"])) { 
    $resultStatus = $dbConnection->getUpdateData("`order`",["status"=>$_GET["status"]],["id"=>$_GET["id"]]);
    $resultStatus?header("location: ../orderUserTable.php?message=success"):header("location: ../orderUserTable.php?message=failure");
    exit();
}