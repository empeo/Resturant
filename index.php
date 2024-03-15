<?php 
require("./connction.php");
session_start();
if(isset($_SESSION["usernameRemeberMe"]) and isset($_SESSION["username"])){
    header("location: ./assets/views/home.php");
    exit();
}
function test_input($data) {
    $data = strip_tags($data);
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$email_login = "";
$password_login = "";
if(isset($_POST['submit_login'])){
    $error_Data_login = "";
    $error_email = "";
    $error_password = "";
    $email_login = test_input($_POST["email_login"]);
    $password_login = test_input($_POST["password_login"]);
    if (!filter_var($email_login, FILTER_VALIDATE_EMAIL) || empty($email_login)) {
        $error_email = "Email is not valid";
    }
    if(empty($password_login)){
        $error_password = "password is not valid";
    }
    if(empty($error_email) and empty($error_password)){
            $resultValueAdmins = $dbConnection->getData("admins",["email"=>$email_login]);
            $resultValue = $dbConnection->getData("customer",["email"=>$email_login]);
            if(!empty($resultValueAdmins)){
                if($password_login == $resultValueAdmins["password"]){
                    if(isset($_POST["remeberMe"])){
                        $_SESSION["usernameRemeberMe"] = $resultValueAdmins["name"];
                    }
                        $_SESSION["isAdmin"]=true;
                        $_SESSION["username"] = $resultValueAdmins["name"];
                        $_SESSION["email"] = $resultValueAdmins["email"];
                        $_SESSION["password"] = $password_login;
                        $_SESSION["phone"] = $resultValueAdmins["phone"];
                        $_SESSION["image"] = $resultValueAdmins["image"];
                        header("location: ./assets/views/profile.php");
                    }
                    else{
                        echo "<script>alert('Password incorrect!')</script>";
                    }
            }
            elseif(!empty($resultValue)){
                if(password_verify($password_login,$resultValue["password"])){
                    if(isset($_POST["remeberMe"])){
                        $_SESSION["usernameRemeberMe"] = $resultValue["fullname"];
                    }
                        $_SESSION["username"] = $resultValue["fullname"];
                        $_SESSION["email"] = $resultValue["email"];
                        $_SESSION["password"] = $password_login;
                        $_SESSION["phone"] = $resultValue["phone"];
                        $_SESSION["image"] = $resultValue["image"];
                        header("location: ./assets/views/profile.php");
                    }
                else{
                    echo "<script>alert('Password incorrect!')</script>";
                }
            }
            else{
                $error_Data_login = "Data is not Correct";
            }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon/resturant_favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/style/style.css">
    <link rel="stylesheet" href="assets/style/mediaQuery.css">
    <title>Login|SavorCraft Bistro</title>
</head>
<body class="login_body">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <h2 class="header_form error_message" style="color:red"><?php if(isset($error_Data_login)){
            echo $error_Data_login;
        } ?></h2>
        <h2 class="header_form">sign in</h2>
        <div class="login_container">
        <div class="container_email" style="width:100%;">
            <label for="email_login">email</label>
            <input type="email" id="email_login" name="email_login" value="<?php if(isset($email_login)){
                echo $email_login;
            } ?>">
            <p class="error_message" style="color:red;font-weight:bolder"><?php if(isset($error_email)){
                echo $error_email;
            } ?></p>
        </div>
        <div class="container_pass" style="width:100%;">
            <label for="password_login">password</label>
            <input type="password" id="password_login" name="password_login" value="<?php if(isset($password_login)){
                echo $password_login;
            } ?>">
            <p class="error_message" style="color:red;font-weight:bolder"><?php if(isset($error_password)){
                echo $error_password;
            } ?></p>
        </div>
        </div>
        <div class="checkbox-wrapper-24">
        <input type="checkbox" id="remeberMe1" name="remeberMe"  />
        <label for="remeberMe1">
            <span></span>remeber me
        </label>
        </div>


        <div class="container__submit"><button type="submit" name="submit_login">login</button></div>
        <div class="link_newAccount">
            <a href="./assets/views/signup.php">if you don't have one click here</a>
        </div>
    </form>
</body>
</html>