<?php
require("../../../connction.php");
session_start();
$result = $dbConnection->getData("admins", ["email" => $_SESSION['email']]);
if (!isset($_SESSION["usernameRemeberMe"]) and !isset($_SESSION["username"])) {
    header("location: ../../../index.php");
    exit();
} elseif (empty($result)) {
    require("../errorPages/error.php");
    exit();
}
if(isset($_GET["id"])){
    $resultValuesEnsures = $dbConnection->getData("food", ["id" => $_GET["id"]]);
}
else{
    require("../errorPages/error.php");
    exit();
}
function test_input($data)
{
    $data = strip_tags($data);
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$nameItem = "";
$priceItem = "";
$categoryItem = "";
$imageItem = "";
if (isset($_POST['add_submit'])) {
    $successMessage = "";
    $ErrorMessage = "";
    $error_name_item = "";
    $error_price_item = "";
    $error_category_item = "";
    $error_image_item = "";
    $imageExtensions = ["jpg", "png", "jpeg"];
    $nameItem = test_input($_POST["itemName"]);
    $priceItem = test_input($_POST["priceItem"]);
    $categoryItem = test_input($_POST["categoryItem"]);
    $imageItem = $_FILES["imageItem"];
    $extensionimage = strtolower(pathinfo($imageItem['name'], PATHINFO_EXTENSION));
    if (!preg_match("/^[a-zA-Z0-9 ]{4,}$/i", $nameItem)  || empty($nameItem)) {
        $error_name_item = "Only letters, numbers and spaces are allowed.";
    }
    if (!preg_match("/^[0-9]+$/i", $priceItem) || empty($priceItem)) {
        $error_price_item = "only numbers allowed.";
    }
    if (empty($categoryItem)) {
        $error_category_item = "select category";
    }
    if ($imageItem["size"] > pow(10, 7) || !in_array($extensionimage, $imageExtensions)) {
        $error_image_item = "select image less than 10MB";
    }
    if (empty($error_name_item) and empty($error_price_item) and empty($error_category_item) and empty($error_image_item)) {
        if(isset($resultValuesEnsures["image"])){
            unlink("../../images/home/".$resultValuesEnsures["image"]);
        }
            $newNameImage = time() . $imageItem['name'];
            $newPathImageProfile = "../../images/home/{$newNameImage}";
            move_uploaded_file($imageItem['tmp_name'], $newPathImageProfile);
            $resultInsert = $dbConnection->getUpdateData("food", ["name" => $nameItem, "price" => $priceItem, "category" => $categoryItem, "image" => $newNameImage],["id"=>$_GET["id"]]);
            $resultQeryOrder = $dbConnection->getUpdateData("`order`",["food_name"=>$nameItem,"price"=>$priceItem],["id"=>$_GET["id"]]);
            $resultInsert? header("location: ../home.php?message=Success Inserted") : header("location: ../home.php?message=Failed Inserted");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../images/favicon/resturant_favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../style/bootstrap.min.css">
    <link rel="stylesheet" href="../../style/style.css">
    <title>Admin|Dashboard</title>
    <style>
        form {
            margin: auto;
            color: #ff9151;
            font-weight: bolder;
        }

        .container__btn__submit {
            margin-top: 2rem;
        }

        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            color: #ff9151;
            background: transparent;
            font-size: 1rem;
        }

        select option {
            font-size: 1rem;
            font-weight: bolder;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="../home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../adminsPages/admin.php">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../adminPages/usersAdmin.php">Users</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$_GET["id"]?>" method="post" enctype="multipart/form-data">
        <h2 style="color:red; font-weight:bolder;"><?php if (isset($ErrorMessage)) {
                                                        echo $ErrorMessage;
                                                    } ?></h2>
        <h2 style="color:green; font-weight:bolder;"><?php if (isset($successMessage)) {
                                                            echo $successMessage;
                                                        } ?></h2>
        <h2>insert item</h2>
        <div class="container__name">
            <label for="itemName">Item Name : </label>
            <input id="itemName" type="text" name="itemName" value="<?php if (isset($resultValuesEnsures["name"])) {
                                                                        echo $resultValuesEnsures["name"];
                                                                    }?>">
            <p style="color:red; font-weight: bolder;"><?php if (isset($error_name_item)) {
                                                            echo $error_name_item;
                                                        } ?></p>
        </div>
        <div class="container__price">
            <label for="priceItem">Item Price : </label>
            <input id="priceItem" type="text" name="priceItem" value="<?php if (isset($resultValuesEnsures["price"])) {
                                                                            echo $resultValuesEnsures["price"];
                                                                        }?>">
            <p style="color:red; font-weight: bolder;"><?php if (isset($error_price_item)) {
                                                            echo $error_price_item;
                                                        } ?></p>
        </div>
        <div class="container__category__field">
            <label for="categoryItem">Choose a Category:</label>
            <select id="categoryItem" name="categoryItem">
                <option value="soft drink">Soft Drink</option>
                <option value="fried chicken">Fried Chicken</option>
                <option value="pizza">Pizza</option>
                <option value="sandwich">Sandwich</option>
            </select>
            <p style="color:red; font-weight: bolder;"><?php if (isset($error_category_item)) {
                                                            echo $error_category_item;
                                                        } ?></p>
        </div>
        <div class="container__image">
            <label for="imageItem">Item Image : </label>
            <input id="imageItem" type="file" name="imageItem">
            <p style="color:red; font-weight: bolder;"><?php if (isset($error_image_item)) {
                                                            echo $error_image_item;
                                                        } ?></p>
        </div>
        <div class="container__btn__submit">
            <button type="submit" name="add_submit">Add Item</button>
        </div>
    </form>
    <script src="../../dynamic/bootstrap.bundle.min.js"></script>
</body>

</html>