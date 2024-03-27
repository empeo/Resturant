<?php
require("../../connction.php");
session_start();
if (!isset($_SESSION["usernameRemeberMe"]) and !isset($_SESSION["username"])) {
    echo "<script>alert('login first!')</script>";
    header("location: ../../index.php");
    exit();
}
$categoryData = $dbConnection->getAllData("food");
$categoryNames = $dbConnection->getDataCategoryDistinct("category", "food");

$categories = [];
foreach ($categoryNames as $name) {
    $categories[] = $name["category"];
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
                    <?php if (isset($_SESSION["isAdmin"])) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./orderUserTable.php">Users Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./adminPages/admin.php">Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./adminPages/usersAdmin.php">Users</a>
                        </li>
                    <?php else : ?>
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

        <!-- Category buttons -->
        <div class="d-flex justify-content-center align-items-center gap-3 mb-4">
            <div>
                <button class="btn btn-outline-light text-bg-success w-auto fw-bolder category-btn active" data-category="category0">All</button>
            </div>
            <?php foreach ($categories as $index => $category) : ?>
                <div>
                    <button class="btn btn-outline-light text-bg-success w-auto fw-bolder category-btn" data-category="category<?php echo ($index + 1); ?>"><?php echo $category; ?></button>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Category sections -->
        <?php foreach ($categoryNames as $index => $category) : ?>
            <div id="category<?php echo ($index + 1); ?>" class="category-section <?php echo ($index == 0) ? 'active' : ''; ?>">
                <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
                    <?php foreach ($categoryData as $item) : ?>
                        <?php if ($item["category"] === $category["category"]) : ?>
                            <!-- Display items for this category -->
                            <div class="col-md-4">
                                <div class="card w-100 h-100">
                                    <!-- Card content -->
                                    <div class="container_image">
                                        <img src="../images/home/<?php echo $item["image"]; ?>" class="card-img-top" alt="Category Image">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title text-dark-emphasis">Title: <?php echo $item["category"]; ?></h5>
                                        <h5 class="card-title text-dark-emphasis">Name: <?php echo $item["name"]; ?></h5>
                                        <h5 class="card-title text-dark-emphasis">Price: <?php echo $item["price"] . "$"; ?></h5>
                                        <?php if (isset($_SESSION["isAdmin"])) : ?>
                                            <a href="./editePages/editproduct.php?id=<?php echo $item["id"] ?>" class="btn btn-primary">Edit</a>
                                            <a href="./deletePages/deleteProduct.php?name=<?php echo $item["name"] ?>" class="btn btn-danger">Delete</a>
                                        <?php else : ?>
                                            <a href="./orderUser.php?id=<?php echo $item["id"] ?>&namefood=<?php echo $item["name"] ?>&pricefood=<?php echo $item["price"] ?>" class="btn btn-primary">Add</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

        <?php endforeach; ?>

    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var categoryButtons = document.querySelectorAll(".category-btn");
            var categorySections = document.querySelectorAll(".category-section");

            categoryButtons.forEach(function(button) {
                button.addEventListener("click", function() {
                    var category = this.getAttribute("data-category");

                    // Remove 'active' class from all buttons
                    categoryButtons.forEach(function(btn) {
                        btn.classList.remove("active");
                    });

                    // Add 'active' class to the clicked button
                    this.classList.add("active");

                    // Hide all category sections
                    categorySections.forEach(function(section) {
                        section.classList.remove("active");
                    });

                    // Show the category section corresponding to the clicked button
                    if (category === "category0") {
                        // If "All" button is clicked, show all category sections
                        categorySections.forEach(function(section) {
                            section.classList.add("active");
                        });
                    } else {
                        // Show the specific category section
                        document.getElementById(category).classList.add("active");
                    }
                });
            });
        });
    </script>

    <script src="../dynamic/bootstrap.bundle.min.js"></script>
</body>

</html>
