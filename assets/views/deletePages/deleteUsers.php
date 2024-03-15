<?php
require("../../../connction.php");
session_start();
$result = $dbConnection->getData("admins",["email"=>$_SESSION['email']]);
if (!isset($_SESSION["usernameRemeberMe"]) and !isset($_SESSION["username"])) {
    header("location: ../../../index.php");
    exit();
}
if(!empty($result) and isset($_GET["id"])){
    $resultValue = $dbConnection->deleteData("customer",["id"=>$_GET["id"]]);
    if(isset($resultValue["image"])){
        unlink("../../images/imagescustomer/".$resultValue["image"]);
    }
    if($resultValue){
        header("location: ../adminPages/usersAdmin.php");
    }
    else{
        require("../errorPages/error.php");
        exit();
    }
}else{
    require "../errorPages/error.php";
    exit();
}