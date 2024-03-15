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
$resUsers = $dbConnection->getAllData("customer");
$userKey = [];
if (!empty($resUsers)) {
    $userKey = array_keys($resUsers[0]);
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
    <title>Users|Admin Panel</title>
    <style>
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #3498db;
            color: #fff;
            text-transform: capitalize
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
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
                        <a class="nav-link active" href="../home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../profile.php">Profile</a>
                    </li>
                    <?php if(isset($_SESSION["isAdmin"])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../orderUserTable.php">Users Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./admin.php">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./usersAdmin.php">Users</a>
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

    <table>
    <thead>
        <tr>
            <?php if (!empty($userKey)): ?>
                <?php foreach ($userKey as $key): ?>
                    <th><?php echo $key; ?></th>
                <?php endforeach; ?>
                <th>Actions</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($resUsers)): ?>
            <?php foreach ($resUsers as $valuesArray): ?>
                <tr>
                    <?php foreach ($valuesArray as $key => $value): ?>
                        <td>
                            <?php if (in_array(substr($value, -4), ['jpeg', '.jpg', '.png'])): ?>
                                <div style="width: 10rem; border-radius: 50%; overflow: hidden;">
                                    <img src="../../images/imagescustomer/<?php echo $value; ?>" alt="Item Image" style="width: 100%;">
                                </div>
                            <?php else: ?>
                                <?php echo $value; ?>
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                    <?php $id = $valuesArray["id"] ?? ''; ?>
                    <td>
                        <button><a href="../editePages/editDataUser.php?id=<?php echo $id; ?>">Edit</a></button>
                        <button><a href="../deletePages/deleteUsers.php?id=<?php echo $id; ?>">Delete</a></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="<?php echo count($userKey) + 1; ?>">
                    <div class="info alert">
                        <div class="content">
                            <div class="icon">
                                <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="50" height="50" rx="25" fill="white"/>
                                    <path d="M27 22H23V40H27V22Z" fill="#006CE3"/>
                                    <path d="M25 18C24.2089 18 23.4355 17.7654 22.7777 17.3259C22.1199 16.8864 21.6072 16.2616 21.3045 15.5307C21.0017 14.7998 20.9225 13.9956 21.0769 13.2196C21.2312 12.4437 21.6122 11.731 22.1716 11.1716C22.731 10.6122 23.4437 10.2312 24.2196 10.0769C24.9956 9.92252 25.7998 10.0017 26.5307 10.3045C27.2616 10.6072 27.8864 11.1199 28.3259 11.7777C28.7654 12.4355 29 13.2089 29 14C29 15.0609 28.5786 16.0783 27.8284 16.8284C27.0783 17.5786 26.0609 18 25 18V18Z" fill="#006CE3"/>
                                </svg>
                            </div>
                            <p>No Users</p>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

    <script src="../../dynamic/bootstrap.bundle.min.js"></script>
</body>

</html>
