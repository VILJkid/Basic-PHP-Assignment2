<?php
session_start();
error_reporting(0);

$emailErr = $unameErr = $passErr = $ageErr = $genErr = $fileErr = "";
if (isset($_POST['submit'])) {

    $email = input_field($_POST['email']);
    $uname = input_field($_POST['uname']);
    $pass = input_field($_POST['pass']);
    $age = input_field($_POST['age']);
    $gen = input_field($_POST['gen']);
    $tmp = $_FILES['file']['tmp_name'];
    // $fname = $_FILES['file']['name'];
    $fname = "image.jpg";
    $ext = pathinfo($fname, PATHINFO_EXTENSION);
    // echo $tmp;
    // echo "111111";

    //email validation
    if (empty($email)) {
        $emailErr = "Email is required.";
        changeColor("email", "red");
    } else if (!preg_match("/^[^@\s]+@[^@\s\.]+\.[^@\.\s]+$/", $email)) {
        $emailErr = "Email format incorrect.";
        changeColor("email", "red");
    } else if (is_dir("Users/$email")) {
        $emailErr = "Email already exists!";
        changeColor("email", "red");
    } else {
        changeColor("email", "green");
    }

    //uname validation 
    if (empty($uname)) {
        $unameErr = "Username is required.";
        changeColor("uname", "red");
    } else if (!preg_match("/^[a-zA-Z0-9_-]{3,15}$/", $uname)) {
        $unameErr = "Invalid username format!";
        changeColor("uname", "red");
    } else {
        changeColor("uname", "green");
    } {
        $sc = scandir("Users");
        foreach ($sc as $c) {
            if ($c != "." && $c != "..") {
                // echo "Working";
                $fo = fopen("Users/$c/details.txt", "r");
                fgets($fo);
                $fileuname = trim(fgets($fo));
                if ($uname == $fileuname) {
                    $unameErr = "Username already exists!";
                    changeColor("uname", "red");
                }
            }
        }
    }

    //pass validation 
    if (empty($pass)) {
        $passErr = "Password is required.";
        changeColor("pass", "red");
    } else if (strlen($pass) < 8) {
        $passErr = "Password should be mimimum of 8 chars.";
        changeColor("pass", "red");
    } else {
        changeColor("pass", "green");
    }

    //age validation 
    if (empty($age)) {
        $ageErr = "Age is required.";
        changeColor("age", "red");
    } else {
        changeColor("age", "green");
    }

    //file validation
    if (empty($tmp)) {
        $fileErr = "File is required.";
        changeColor("file", "red");
    } else if ($ext != "jpg") {
        $fileErr = "Only JPG file allowed!";
        changeColor("file", "red");
    } else {

        changeColor("file", "green");
    }

    //everything correct
    if ($emailErr == "" && $unameErr == "" && $passErr == "" && $ageErr == "" && $genErr == "" && $fileErr == "") {

        mkdir("Users/$email");
        mkdir("Users/$email/Uploads");

        $dest = "Users/$email/Uploads/";
        // echo "22222";
        if (!move_uploaded_file($tmp, $dest . $fname)) {
            $fileErr = "Upload failed.";
            changeColor("file", "red");

            rmdir("Users/$email");
            rmdir("Users/$email/Uploads");
        } else {
            file_put_contents("Users/$email/details.txt", "$email\n$uname\n$pass\n$age\n$gen");
            // echo "Registered successfully!";
            $_SESSION["uname"] = $uname;
            header("Location: welcome.php");
            exit;
        }
    }
}

function input_field($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function changeColor($id, $color)
{
    // echo "$id<br>$color";
?>
    <style>
        <?php echo "#" . $id; ?> {
            border: 2px solid <?php echo $color; ?>;
        }
    </style>
<?php
}
?>

<!doctype html>
<html lang="en">

<head>
    <?php
    include("head.php");
    ?>
    <title>Login</title>
    <style>
        .error {
            color: red;
        }

        .correct {
            color: green;
        }

        .center {
            margin: auto;
            width: 50%;
            padding: 10px;
        }

        textarea {
            resize: none;
        }
    </style>
</head>

<body>
    <form method="post" class="center" enctype="multipart/form-data">
        <div class="container">
            <h2 class="mt-3">Register</h2>

            <span class="error"> * are required fields </span><br />
            <br />

            <div class="form-ele form-group">
                <label for="email" class="form-label">Email<span class="error"> *</span></label>
                <input type="text" name="email" id="email" class="form-control" size="30" value="<?php echo $email; ?>" placeholder="Email" />
                <span class="error"> <?php echo $emailErr; ?></span>
                <br /><br />
            </div>

            <div class="form-ele form-group">
                <label for="uname" class="form-label">Username<span class="error"> *</span></label>
                <input type="text" name="uname" id="uname" class="form-control" value="<?php echo $uname; ?>" size="30" placeholder="Username" />
                <span class="error"> <?php echo $unameErr; ?></span>
                <br /><br />
            </div>

            <div class="form-ele form-group">
                <label for="pass" class="form-label">Password<span class="error"> *</span></label>
                <input type="password" name="pass" id="pass" class="form-control" value="<?php echo $pass; ?>" size="30" placeholder="Password" />
                <span class="error"> <?php echo $passErr; ?></span>
                <br /><br />
            </div>

            <div class="form-ele form-group">
                <label for="age" class="form-label">Age<span class="error"> *</span></label>
                <input type="number" name="age" id="age" class="form-control" value="<?php echo $age; ?>" size="30" placeholder="Age" />
                <span class="error"> <?php echo $ageErr; ?></span>
                <br /><br />
            </div>

            <div class="form-ele form-check">
                <input type="radio" class="form-check-input" name="gen" id="male" value="Male" checked />
                <label for="male" class="form-check-label">Male</label>
            </div>
            <div class="form-ele form-check">
                <input type="radio" class="form-check-input" name="gen" id="female" value="Female" />
                <label for="female" class="form-check-label">Female</label>
                <span class="error"> <?php echo $genErr; ?></span>
                <br /><br />
            </div>

            <div class="form-group mb-4">
                <label for="file" class="form-label">Upload an Image<span class="error"> *</span></label>
                <input class="form-control" type="file" id="file" name="file">
                <span class="error"> <?php echo $fileErr; ?></span>
            </div>

            <input type="submit" class="btn btn-dark" value="Submit" name="submit" />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="index.php" class="btn btn-dark">Login Page</a>

        </div>
        <br /><br />
        <span class="correct"><?php echo $correct; ?></span>
        <br /><br />
    </form>
    <?php
    include("foot.php");
    ?>

</body>

</html>