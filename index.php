<?php
error_reporting(0);

$emailErr = $passErr = "";
if (isset($_POST['submit'])) {

    $email = input_field($_POST['email']);
    $pass = input_field($_POST['pass']);

    //email validation
    if (empty($email)) {
        $emailErr = "Email is required.";
        changeColor("email", "red");
    } else if (!preg_match("/^[^@\s]+@[^@\s\.]+\.[^@\.\s]+$/", $email)) {
        $emailErr = "Email format incorrect.";
        changeColor("email", "red");
    } else {
        changeColor("email", "green");
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

    //everything correct
    if ($emailErr == "" && $passErr == "") {
        if (is_dir("Users/$email")) {
            $fo = fopen("Users/$email/details.txt", "r");
            fgets($fo);
            $uname = trim(fgets($fo));
            $filepass = trim(fgets($fo));
            if ($pass == $filepass) {
                session_start();
                $_SESSION["uname"] = $uname;
                $_SESSION["email"] = $email;
                // echo "Authentication successful!";
                header("Location: dashboard.php");
                exit;
            } else {
                $passErr = "Please enter the correct password.";
                changeColor("pass", "red");
            }
        } else {
            $emailErr = "Please register with this email first!";
            changeColor("email", "red");
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
    <form method="post" class="center">
        <div class="container">
            <h2 class="mt-3">Login</h2>

            <span class="error"> * are required fields </span><br />
            <br />

            <div class="form-ele form-group">
                <label for="email" class="form-label">Email<span class="error"> *</span></label>
                <input type="text" name="email" id="email" class="form-control" size="30" value="<?php echo $email; ?>" placeholder="Email" />
                <span class="error"> <?php echo $emailErr; ?></span>
                <br /><br />
            </div>

            <div class="form-ele form-group">
                <label for="pass" class="form-label">Password<span class="error"> *</span></label>
                <input type="password" name="pass" id="pass" class="form-control" value="<?php echo $pass; ?>" size="30" placeholder="Password" />
                <span class="error"> <?php echo $passErr; ?></span>
                <br /><br />
            </div>

            <div class="form-ele form-check">

                <input type="checkbox" class="form-check-input" id="flexCheckChecked" checked />
                <label for="flexCheckChecked" class="form-check-label">Remember Me</label>
                <!-- <span class="error"> <?php echo $passErr; ?></span> -->
                <br /><br />
            </div>

            <input type="submit" class="btn btn-dark" value="Login" name="submit" />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="reg.php" class="btn btn-dark">Register</a>
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