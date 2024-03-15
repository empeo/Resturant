<?php
require("../../../connction.php");
session_start();
$result = $dbConnection->getData("admins",["email" => $_SESSION['email']]);
if (!isset($_SESSION["usernameRemeberMe"]) and !isset($_SESSION["username"])) {
    header("location: ../../../index.php");
    exit();
}
elseif (!empty($result) and isset($_GET["id"])) {
    $id = $_GET["id"];
    $UID = $dbConnection->getData("customer",["id"=>$id]);
    if(empty($UID)){
        require("../errorPages/error.php");
        exit();
    }
}
else{
    require("../errorPages/error.php");
    exit();
}


function test_input($data) {
    $data = strip_tags($data);
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$username="";
$email="";
$password="";
$passwordConfirm="";
$phone="";
$image="";
    if(isset($_POST["edit__btn"])){
        $imageExtensions = ["jpg","png","jpeg"];
        $Error_Data = "";
        $Error_name = "";
        $Error_email = "";
        $Error_password = "";
        $Error_confirmPassword = "";
        $Error_phone = "";
        $Error_image = "";
        $username=test_input($_POST["username__signup"]);
        $email = test_input($_POST["email_signup"]);
        $password = test_input($_POST["password_signup"]);
        $passwordConfirm = test_input($_POST["password_confirm"]);
        $phone = test_input($_POST["phone_signup"]);
        $image = $_FILES["image_signup"];
        $extensionimage = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        $regaxUsername = "/^[a-zA-Z ]{4,}$/i";
        $regaxPassword = "/^[\w+\W+\d+\D+ ]{8,}$/i";
        $regaxPhone = "/^[\d]{11,}$/i";
        if(!preg_match($regaxUsername,$username) || empty($username)){
            $Error_name="Username must be at least 4 characters.";
        }
        if(!filter_var($email,FILTER_VALIDATE_EMAIL) || empty($email)){
            $Error_email="Invalid email format.";
        }
        if(!preg_match($regaxPassword,$password) || empty($password)){
            $Error_password="password must be at least 8 characters and contain digits and special characters.";
        }
        if(!($passwordConfirm == $password) || empty($passwordConfirm)){
            $Error_confirmPassword="Username must be at least 4 characters.";
        }
        if(empty($phone)|| !preg_match($regaxPhone,$phone)){
            $Error_phone="Please enter a valid phone number.";
        }
        if(!in_array($extensionimage,$imageExtensions) || ($image["size"] > pow(10,6))){
            $Error_image="Image is required and Extesions must be (jpg,jpeg,png) and size must be less than  1MB or equal it.";
        }
        if(empty($Error_name) and empty($Error_email) and empty($Error_password) and empty($Error_confirmPassword) and empty($Error_phone) and empty($Error_image)){
            $resultValueAdmins = $dbConnection->getData("admins",["email"=>$email]);
            $resultValueCustomer = $dbConnection->getData("customer",["email"=>$email]);
            if(empty($resultValueAdmins) and empty($resultValueCustomer)){
                    if(file_exists("../../images/imagescustomer/".$UID["image"])){
                        unlink("../../images/imagescustomer/".$UID["image"]);
                    }
                    $NewNameImage = time().$image["name"];
                    $NewPathImageProfile = "../../images/imagescustomer/{$NewNameImage}";
                    move_uploaded_file($image['tmp_name'],$NewPathImageProfile);
                    $PasswordHash =  password_hash($password,PASSWORD_DEFAULT);
                    $DataEdit = $dbConnection->getUpdateData("customer",["fullname"=>$username,"email"=>$email,"password"=>$PasswordHash,"phone"=>$phone,"image"=>$NewNameImage],["id"=>$id]);
                    if($DataEdit){
                        header("location: ../adminPages/usersAdmin.php");
                        exit();
                    }
                    else{
                        $Error_Data = "Update Not Working";
                    }
                
            }
            else{
                $Error_Data = "Data is Dublicated";
            }
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../images/favicon/resturant_favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../style/style.css">
    <link rel="stylesheet" href="../../style/mediaQuery.css">
    <title>EditUsers|Admin</title>
</head>
<body class="signup_body">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$_GET["id"]?>" method="post" class="signup__form" enctype="multipart/form-data">
        <h2 class="error_message" style="color:red;text-transform:capitalize;font-weight:bolder;"><?php if(isset($Error_Data)){
            echo $Error_Data;
        } ?></h2>
        <h2 class="header_form">Edit Data</h2>
        <div class="signup_container">
        
        <div class="container__username">
        <label for="username__signup">fullname</label>
        <input type="text" id="username__signup" name="username__signup" value="<?php if(isset($UID["fullname"])){
            echo $UID["fullname"];
        } ?>">
        <p class="error_message" style="color:red;text-transform:capitalize;font-weight:bolder;">
            <?php if(isset($Error_name)){
                echo $Error_name;
            } ?>
        </p>
        </div>

        <div class="container__email">
            <label for="email_signup">email</label>
            <input type="email" id="email_signup" name="email_signup" value="<?php if(isset($UID["email"])){
                echo $UID["email"];
            } ?>">
            <p class="error_message" style="color:red;text-transform:capitalize;font-weight:bolder;"><?php if(isset($Error_email)){
                echo $Error_email;
            } ?></p>
        </div>

        <div class="container__password">
            <label for="password_login">password</label>
            <input type="password" id="password_login" name="password_signup" value="<?php if(isset($UID["password"])){
                echo $UID["password"];
            } ?>">
            <p class="error_message" style="color:red;text-transform:capitalize;font-weight:bolder;"><?php if(isset($Error_password)){
                echo $Error_password;
            } ?></p>
        </div>
        <div class="container__confirmPassword">
            <label for="password_confirm">confirm password</label>
            <input type="password" id="password_confirm" name="password_confirm" value="<?php if(isset($passwordConfirm)){
                echo $passwordConfirm;
            } ?>">
            <p class="error_message" style="color:red;text-transform:capitalize;font-weight:bolder;"><?php if(isset($Error_confirmPassword)){
                echo $Error_confirmPassword;
            } ?></p>
        </div>
        <div class="container__phone">
            <label for="phone">phone</label>
            <input type="text" id="phone" name="phone_signup" value="<?php if(isset($UID["phone"])){
                echo $UID["phone"];
            } ?>">
            <p class="error_message" style="color:red;text-transform:capitalize;font-weight:bolder;"><?php if(isset($Error_phone)){
                echo $Error_phone;
            } ?></p>
        </div>
        <div class="container__image">
            <label for="image_signup">profile image</label>
            <input type="file" accept="image/*" id="image_signup" name="image_signup" value="<?php if(isset($UID["image"])){
                echo $UID["image"];
            } ?>">
            <p class="error_message" style="color:red;text-transform:capitalize;font-weight:bolder;"><?php if(isset($Error_image)){
                echo $Error_image;
            } ?></p>
        </div>
        </div>
        <div class="container__submit"><button type="submit" name="edit__btn">edit data</button></div>
    </form>
</body>
</html>