<?php
require("../../../connction.php");
session_start();
$result = $dbConnection->getData("admins",["email"=>$_SESSION['email']]);
if (!isset($_SESSION["usernameRemeberMe"]) and !isset($_SESSION["username"])) {
    header("location: ../../../index.php");
    exit();
}
if(!empty($result) and isset($_GET["name"])){
    $resultValue = $dbConnection->deleteData("food",["name"=>$_GET["name"]]);
    if ($resultValue){
        if(isset($resultValue["image"])){
            unlink("../../images/home/".$resultValue['image']);
        }
        echo "<script>alert('Delete Successfully')</script>";
        header("location: ../home.php");
        exit();
    }
    else{
        echo "<script>alert('Delete Failed')</script>";
        header("location: ../home.php");
        exit();
    }
}else{
    require "../errorPages/error.php";
    exit();
}
