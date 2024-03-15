<?php
require("../../../connction.php");
session_start();
if (!isset($_SESSION["usernameRemeberMe"]) and !isset($_SESSION["username"])) {
    header("location: ../../../index.php");
    exit();
}
    $resultValueAdmins = $dbConnection->getData("admins",["email"=>$_SESSION["email"]]);
    $resultValue = $dbConnection->getData("customer",["email"=>$_SESSION["email"]]);
    if(!empty($resultValueAdmins)){
        $resultValueAdmins = $dbConnection->deleteData("admins",["email"=>$_SESSION["email"]]);
        if(isset($_SESSION["image"])){
            unlink("../../images/admin/".$_SESSION['image']);
        }
        if($resultValueAdmins){
            header("location: ../logout.php");
            exit();
        }
        else{
            header("location: ../profile.php?error=Not Deleted");
            exit();
        }
    }
    elseif(!empty($resultValue)){
        $resultValue = $dbConnection->deleteData("customer",["email"=>$_SESSION["email"]]);
        if($resultValue){
            if(isset($_SESSION["image"])){
                unlink("../../images/imagescustomer/".$_SESSION['image']);
            }
            header("location: ../logout.php");
            exit();
        }
        else{
            header("location: ../profile.php?error=Not Deleted");
            exit();
        }
    }
    else{
        header("location: ../profile.php?error=Unauthorized Access");
        exit();
    }