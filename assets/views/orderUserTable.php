<?php
require("../../connction.php");
session_start();
if (!isset($_SESSION["usernameRemeberMe"]) and !isset($_SESSION["username"])) {
    echo "<script>alert('login first!')</script>";
    header("location: ../../index.php");
    exit();
}
if (isset($_SESSION["isAdmin"])) {
    $queryAllCustomerOrders = $dbConnection->getAllData("`order`");
    if ($queryAllCustomerOrders) {
        $queryAllCustomerOrdersKey = array_keys($queryAllCustomerOrders[0]);
    }
} else {
    $queryAllCustomerOrdersUsers = $dbConnection->getDataCategory("`order`", ["email" => $_SESSION["email"]]);
    if ($queryAllCustomerOrdersUsers) {
        $queryAllCustomerOrdersUsersKey = array_keys($queryAllCustomerOrdersUsers[0]);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../images/favicon/resturant_favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
    <title>Order User | SavorCraft Bistro</title>
    <style>
        .table {
            text-align: center;
            vertical-align: middle;
        }

        .table td,
        .table th {
            font-size: 1.2rem;
            font-weight: bolder;
        }

        button {
            width: auto;
        }

        button a {
            text-decoration: none;
            color: #fff !important;
            border-radius: 10px;
            display: block;
        }
        
        .alert {
            display: flex;
            align-items: center;
            padding: 0.55rem 0.65rem 0.55rem 0.75rem;
            border-radius: 1rem;
            min-width: 400px;
            justify-content: space-between;
            margin-bottom: 2rem;
            box-shadow:
                0px 3.2px 13.8px rgba(0, 0, 0, 0.02),
                0px 7.6px 33.3px rgba(0, 0, 0, 0.028),
                0px 14.4px 62.6px rgba(0, 0, 0, 0.035),
                0px 25.7px 111.7px rgba(0, 0, 0, 0.042),
                0px 48px 208.9px rgba(0, 0, 0, 0.05),
                0px 115px 500px rgba(0, 0, 0, 0.07)
        }

        button a {
            text-decoration: none;
            color: #fff !important;
            border-radius: 10px;
            display: block;
        }

        .content {
            display: flex;
            align-items: center;
        }

        .icon {
            padding: 0.5rem;
            margin-right: 1rem;
            border-radius: 39% 61% 42% 58% / 50% 51% 49% 50%;
            box-shadow:
                0px 3.2px 13.8px rgba(0, 0, 0, 0.02),
                0px 7.6px 33.3px rgba(0, 0, 0, 0.028),
                0px 14.4px 62.6px rgba(0, 0, 0, 0.035),
                0px 25.7px 111.7px rgba(0, 0, 0, 0.042),
                0px 48px 208.9px rgba(0, 0, 0, 0.05),
                0px 115px 500px rgba(0, 0, 0, 0.07)
        }

        .info {
            background-color: rgba(0, 108, 227, 0.2);
            border: 2px solid #ff4500;
        }

        .content p {
            font-size: 1.5rem;
            font-weight: bolder;
        }

        .info .icon {
            background-color: #006CE3;
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

    <table class="table">
        <?php if (!empty($queryAllCustomerOrders) || !empty($queryAllCustomerOrdersUsers)) : ?>
        <thead>
            <tr>
                <?php if (!empty($queryAllCustomerOrdersKey)) : foreach ($queryAllCustomerOrdersKey as $value) : ?>
                        <th scope="col"><?= $value ?></th>
                    <?php endforeach; ?>
                    <th>Actions</th>
                    <?php else : foreach ($queryAllCustomerOrdersUsersKey as $value) : ?>
                        <th scope="col"><?= $value ?></th>
                <?php endforeach;?>
                <th scope="col">Actions</th>
                <?php  endif;?>
            </tr>

        </thead>
        <tbody>
                <?php if (isset($_SESSION["isAdmin"])) : foreach ($queryAllCustomerOrders as $values) : ?>
                        <tr>
                            <?php if ($values["status"] == "Running") : ?>
                            <?php foreach ($values as $value) : ?>
                                <td><?= $value ?></td>
                                <?php endforeach; ?>
                            <td><button class="btn btn-success"><a href="./editePages/editStatusAccept.php?id=<?=$values["id"]?>&status=accept">Accept</a></button></td>
                            <td><button class="btn btn-danger"><a href="./editePages/editStatusAccept.php?id=<?=$values["id"]?>&status=refused">Refused</a></button></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; else : foreach ($queryAllCustomerOrdersUsers as $values) : ?>
                        <tr>
                            <?php foreach ($values as $value) : ?>
                                <td><?= $value ?></td>
                                <?php endforeach; ?>
                                <td><button><a href="./deletePages/deleteStatusUsers.php?id=<?php echo $values["id"] ?>">Delete</a></button></td>
                            </tr>
                <?php endforeach; endif; ?>
            <?php else : ?>
                <div class="info alert">
                    <div class="content">
                        <div class="icon">
                            <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="50" height="50" rx="25" fill="white" />
                                <path d="M27 22H23V40H27V22Z" fill="#006CE3" />
                                <path d="M25 18C24.2089 18 23.4355 17.7654 22.7777 17.3259C22.1199 16.8864 21.6072 16.2616 21.3045 15.5307C21.0017 14.7998 20.9225 13.9956 21.0769 13.2196C21.2312 12.4437 21.6122 11.731 22.1716 11.1716C22.731 10.6122 23.4437 10.2312 24.2196 10.0769C24.9956 9.92252 25.7998 10.0017 26.5307 10.3045C27.2616 10.6072 27.8864 11.1199 28.3259 11.7777C28.7654 12.4355 29 13.2089 29 14C29 15.0609 28.5786 16.0783 27.8284 16.8284C27.0783 17.5786 26.0609 18 25 18V18Z" fill="#006CE3" />
                            </svg>
                        </div>
                        <p>You Have A Nothing Items Request It</p>
                    </div>
                </div>
            </tbody>
            <?php endif; ?>
    </table>
    <script src="../dynamic/bootstrap.bundle.min.js"></script>
</body>

</html>