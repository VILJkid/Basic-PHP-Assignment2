<?php
error_reporting(0);
session_start();

$email = $_SESSION["email"];
$uname = $_SESSION["uname"];

$fo = fopen("Users/$email/details.txt", "r");
fgets($fo);
fgets($fo);
fgets($fo);
$age = trim(fgets($fo));
$gen = trim(fgets($fo));
$image = "Users/$email/Uploads/image.jpg";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sidebar</title>
</head>

<body>
  <div class="list-group mt-4">
    <a href="?con=category" class="list-group-item list-group-item-action active">Details</a>
    <a href="#" class="list-group-item list-group-item-action text-center">
      <img src="<?php echo $image; ?>" alt="Image load error" height="150px" width="150px" style="border-radius: 50%;">
    </a>
    <a href="?con=changeimage" class="list-group-item list-group-item-action">Change Image</a>
    <a href="#" class="list-group-item list-group-item-action">Username: <?php echo $uname ?></a>
    <a href="#" class="list-group-item list-group-item-action">Age: <?php echo $age ?></a>
    <a href="#" class="list-group-item list-group-item-action">Gender: <?php echo $gen ?></a>
  </div>
</body>

</html>