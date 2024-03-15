<?php
require("../../connction.php");
session_start();
if (!isset($_SESSION["usernameRemeberMe"]) and !isset($_SESSION["username"])) {
    echo "<script>alert('login first!')</script>";
    header("location: ../../index.php");
    exit();
}
$CategoryAll = $dbConnection->getAllData("food");
$categoryItem = $dbConnection->getDataCategoryDistinct("category", "food");
$categoryItemPizza = $dbConnection->getDataCategory("food", ["category" => "pizza"]);
$categoryItemSoftDrink = $dbConnection->getDataCategory("food", ["category" => "soft drink"]);
$categoryItemFriedChicken = $dbConnection->getDataCategory("food", ["category" => "fried chicken"]);
$categoryItemSandwich = $dbConnection->getDataCategory("food", ["category" => "sandwich"]);
$keyCategory = [];

foreach ($categoryItem as $value) {
    foreach ($value as $values) {
        $keyCategory[] = $values;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/favicon/resturant_favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
    <title>Home | SavorCraft Bistro</title>
    <style>
        .category-section {
            display: none !important;
            width: 100%;
        }

        .active {
            display: block !important;
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
                        <a class="nav-link active" href="./home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./profile.php">Profile</a>
                    </li>
                    <?php if(isset($_SESSION["isAdmin"])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./orderUserTable.php">Users Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./adminPages/admin.php">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./adminPages/usersAdmin.php">Users</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./orderUserTable.php">MyOrders</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>



    <div class="container mt-5">
        <h2 class="text-center mb-4 fw-bolder text-secondary-emphasis">Categories</h2>

        <div class="d-flex justify-content-center align-items-center gap-3 mb-4">
            <div>
                <button class="btn btn-outline-light text-bg-success w-auto fw-bolder category-btn active" data-category="category0">All</button>
            </div>
            <?php if (!empty($keyCategory)) : foreach ($keyCategory as $key => $value) : ?>
                    <div>
                        <button class="btn btn-outline-light text-bg-success w-auto fw-bolder category-btn" data-category="category<?php echo $key + 1; ?>"><?php echo $value ?></button>
                    </div>
            <?php endforeach;
            endif; ?>
        </div>

        <div class="container__categories d-flex justify-content-center align-items-center gap-3">
            <div id="category0" class="category-section active">
                <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
                    <?php foreach ($CategoryAll as $All) : ?>
                        <div class="col-md-4">
                            <div class="card w-100 h-100 ">
                                <div class="container_image ">
                                    <img src="../images/home/<?php echo $All["image"]; ?>" class="card-img-top" alt="Category Image">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-dark-emphasis">Title: <?php echo $All["category"]; ?></h5>
                                    <h5 class="card-title text-dark-emphasis">Name: <?php echo $All["name"]; ?></h5>
                                    <h5 class="card-title text-dark-emphasis">Price: <?php echo $All["price"] . "$"; ?></h5>
                                    <?php if (isset($_SESSION["isAdmin"])) : ?>
                                        <a href="./editePages/editproduct.php?id=<?php echo $All["id"] ?>" class="btn btn-primary">Edit</a>
                                        <a href="./deletePages/deleteProduct.php?name=<?php echo $All["name"] ?>" class="btn btn-danger">Delete</a>
                                    <?php else : ?>
                                        <a href="./orderUser.php?id=<?php echo $All["id"] ?>&namefood=<?php echo $All["name"] ?>&pricefood=<?php echo $All["price"] ?>" class="btn btn-primary">Add</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

        <div class="container__categories d-flex justify-content-center align-items-center gap-3">
            <div id="category1" class="category-section ">
                <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
                    <?php foreach ($categoryItemSandwich as $All) : ?>
                        <div class="col-md-4">
                            <div class="card w-100 h-100 ">
                                <div class="container_image ">
                                    <img src="../images/home/<?php echo $All["image"]; ?>" class="card-img-top" alt="Category Image">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-dark-emphasis">Title: <?php echo $All["category"]; ?></h5>
                                    <h5 class="card-title text-dark-emphasis">Name: <?php echo $All["name"]; ?></h5>
                                    <h5 class="card-title text-dark-emphasis">Price: <?php echo $All["price"] . "$"; ?></p>
                                        <?php if (isset($_SESSION["isAdmin"])) : ?>
                                            <a href="./editePages/editproduct.php?id=<?php echo $All["id"] ?>" class="btn btn-primary">Edit</a>
                                            <a href="./deletePages/deleteProduct.php?name=<?php echo $All["name"] ?>" class="btn btn-danger">Delete</a>
                                        <?php else : ?>
                                            <a href="./orderUser.php?id=<?php echo $All["id"] ?>&namefood=<?php echo $All["name"] ?>&pricefood=<?php echo $All["price"] ?>" class="btn btn-primary">Add</a>
                                        <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

        <div class="container__categories d-flex justify-content-center align-items-center gap-3">
            <div id="category2" class="category-section ">
                <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
                    <?php foreach ($categoryItemPizza as $All) : ?>
                        <div class="col-md-4">
                            <div class="card w-100 h-100 ">
                                <div class="container_image ">
                                    <img src="../images/home/<?php echo $All["image"]; ?>" class="card-img-top" alt="Category Image">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-dark-emphasis">Title: <?php echo $All["category"]; ?></h5>
                                    <h5 class="card-title text-dark-emphasis">Name: <?php echo $All["name"]; ?></h5>
                                    <h5 class="card-title text-dark-emphasis">Price: <?php echo $All["price"] . "$"; ?></p>
                                        <?php if (isset($_SESSION["isAdmin"])) : ?>
                                            <a href="./editePages/editproduct.php?id=<?php echo $All["id"] ?>" class="btn btn-primary">Edit</a>
                                            <a href="./deletePages/deleteProduct.php?name=<?php echo $All["name"] ?>" class="btn btn-danger">Delete</a>
                                        <?php else : ?>
                                            <a href="./orderUser.php?id=<?php echo $All["id"] ?>&namefood=<?php echo $All["name"] ?>&pricefood=<?php echo $All["price"] ?>" class="btn btn-primary">Add</a>
                                        <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
        <div class="container__categories d-flex justify-content-center align-items-center gap-3">
            <div id="category3" class="category-section ">
                <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
                    <?php foreach ($categoryItemFriedChicken as $All) : ?>
                        <div class="col-md-4">
                            <div class="card w-100 h-100 ">
                                <div class="container_image ">
                                    <img src="../images/home/<?php echo $All["image"]; ?>" class="card-img-top" alt="Category Image">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-dark-emphasis">Title: <?php echo $All["category"]; ?></h5>
                                    <h5 class="card-title text-dark-emphasis">Name: <?php echo $All["name"]; ?></h5>
                                    <h5 class="card-title text-dark-emphasis">Price: <?php echo $All["price"] . "$"; ?></p>
                                        <?php if (isset($_SESSION["isAdmin"])) : ?>
                                            <a href="./editePages/editproduct.php?id=<?php echo $All["id"] ?>" class="btn btn-primary">Edit</a>
                                            <a href="./deletePages/deleteProduct.php?name=<?php echo $All["name"] ?>" class="btn btn-danger">Delete</a>
                                        <?php else : ?>
                                            <a href="./orderUser.php?id=<?php echo $All["id"] ?>&namefood=<?php echo $All["name"] ?>&pricefood=<?php echo $All["price"] ?>" class="btn btn-primary">Add</a>
                                        <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
        <div class="container__categories d-flex justify-content-center align-items-center gap-3">
            <div id="category4" class="category-section ">
                <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
                    <?php foreach ($categoryItemSandwich as $All) : ?>
                        <div class="col-md-4">
                            <div class="card w-100 h-100 ">
                                <div class="container_image ">
                                    <img src="../images/home/<?php echo $All["image"]; ?>" class="card-img-top" alt="Category Image">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-dark-emphasis">Title: <?php echo $All["category"]; ?></h5>
                                    <h5 class="card-title text-dark-emphasis">Name: <?php echo $All["name"]; ?></h5>
                                    <h5 class="card-title text-dark-emphasis">Price: <?php echo $All["price"] . "$"; ?></p>
                                        <?php if (isset($_SESSION["isAdmin"])) : ?>
                                            <a href="./editePages/editproduct.php?id=<?php echo $All["id"] ?>" class="btn btn-primary">Edit</a>
                                            <a href="./deletePages/deleteProduct.php?name=<?php echo $All["name"] ?>" class="btn btn-danger">Delete</a>
                                        <?php else : ?>
                                            <a href="./orderUser.php?id=<?php echo $All["id"] ?>&namefood=<?php echo $All["name"] ?>&pricefood=<?php echo $All["price"] ?>" class="btn btn-primary">Add</a>
                                        <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>


    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var categoryButtons = document.querySelectorAll(".category-btn");
            var categorySections = document.querySelectorAll(".category-section");

            categoryButtons.forEach(function(button) {
                button.addEventListener("click", function() {
                    var category = this.getAttribute("data-category");

                    categorySections.forEach(function(section) {
                        section.classList.remove("active");
                    });

                    document.getElementById(category).classList.add("active");
                });
            });
        });
    </script>

    <script src="../dynamic/bootstrap.bundle.min.js"></script>
</body>

</html>