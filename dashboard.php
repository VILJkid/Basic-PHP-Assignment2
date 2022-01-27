<?php
session_start();
$uname = $_SESSION['uname'];
if (empty($uname)) {
    header("location:index.php");
}
?>
<!doctype html>
<html lang="en">

<head>
    <?php
    include("head.php");
    ?>
    <title>Login</title>
</head>

<body>
    <?php
    include("nav.php");
    ?>
    <section class="row container">
        <aside class="col-sm-4"> <?php include("sidebar.php"); ?></aside>
        <aside class="col-sm-8">
            <?php
            switch (@$_GET['con']) {
                case 'changepass':
                    include("changepass.php");
                    break;
                case 'category':
                    include("category.php");
                    break;
                case 'orders':
                    include("orders.php");
                    break;
                case 'products':
                    include("products.php");
                    break;
                case 'feedback':
                    include("feedback.php");
                    break;
                case 'changeimage':
                    include("changeimage.php");
                    break;
            }
            ?>
        </aside>
    </section>
    <?php
    include("foot.php");
    ?>
</body>

</html>