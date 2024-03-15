<?php
session_start();
if(!isset($_SESSION["usernameRemeberMe"]) and !isset($_SESSION["username"])){
    header("location: ../index.php");
    exit();
}
if(isset($_POST["btn__logout"])){
    header("location: ./logout.php");
    exit();
}
if(isset($_POST["btn__delete"])){
    header("location: ./deletePages/deleteDataProfile.php");
    exit();
}
if(isset($_POST["btn__edit"])){
    header("location: ./editePages/updatedata.php");
    exit();
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
    <title>Profile|SavorCraft Bistro</title>
    <style>
        form{
            margin: auto !important;
            
        }
        form button{
            width: auto;
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


<section>
        <div class="container bootstrap snippets bootdey">
            <div class="panel-body inf-content">
                <div class="row flex-column text-center">
                    <div class="col-md-12">
                        <img alt="" style="width:250px; border-radius:50%;" title="" class="img-circle img-thumbnail isTooltip" src="<?php if(isset($_SESSION["isAdmin"])){
                            echo "../images/admin/".$_SESSION["image"];
                        }
                        else{
                            echo "../images/imagescustomer/".$_SESSION["image"];
                        } ?>" data-original-title="Usuario">
                        <ul title="Ratings" class="list-inline ratings text-center">
                            <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                            <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                            <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                            <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                            <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <h2 class="info__userpage">Information</h2><br>
                        <div class="table-responsive">
                                <table class="table table-user-information">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <strong>
                                                    <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                                    phone
                                                </strong>
                                            </td>
                                            <td class="text-primary">
                                            <?=$_SESSION["phone"]?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>
                                                    <span class="glyphicon glyphicon-bookmark text-primary"></span>
                                                    Username
                                                </strong>
                                            </td>
                                            <td class="text-primary">
                                            <?=$_SESSION["username"]?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>
                                                    <span class="glyphicon glyphicon-envelope text-primary"></span>
                                                    email
                                                </strong>
                                            </td>
                                            <td class="text-primary">
                                            <?=$_SESSION["email"]?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>
                                                    <span class="glyphicon glyphicon-envelope text-primary"></span>
                                                    password
                                                </strong>
                                            </td>
                                            <td class="text-primary">
                                            <?=$_SESSION["password"]?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <article>
            <div class="container bootstrap snippets bootdey my-5">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="row flex-row text-center">
                    <div class="btn__delete1 col-md-6 my-4">
                        <button class="btn btn-danger" name="btn__delete">delete account</button>
                    </div>
                    <div class="btn__logout col-md-6 my-4">
                        <button class="btn btn-danger" name="btn__logout">logout</button>
                    </div>
                    <div class="btn__logout col-md-12 my-4">
                        <button class="btn btn-primary" name="btn__edit">Edit</button>
                    </div>
                </form>
            </div>
        </article>
    </section>
    <script src="../dynamic/bootstrap.bundle.min.js"></script>
</body>
</html>
