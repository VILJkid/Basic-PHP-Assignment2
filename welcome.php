<?php
session_start();
$uname = $_SESSION['uname'];
?>
<!doctype html>
<html lang="en">

<head>
    <?php
    include("head.php");
    ?>
    <title>Success</title>
</head>

<body>
    <section class="container mt-3">
        <h3>Registration Successful, <?php echo $uname; ?></h3>
        <a href="index.php" class="btn btn-dark mt-2">Login</a>
    </section>
    <?php
    include("foot.php");
    ?>
</body>

</html>