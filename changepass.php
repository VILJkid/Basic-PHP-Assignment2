<?php
error_reporting(0);
session_start();

$passErr = $npassErr = $cpassErr = $successMessage = "";
if (isset($_POST['submit'])) {

    $pass = input_field($_POST['pass']);
    $npass = input_field($_POST['npass']);
    $cpass = input_field($_POST['cpass']);

    //current pass validation
    if (empty($pass)) {
        $passErr = "Current password is required.";
        changeColor("pass", "red");
    } else {
        $fo = fopen("Users/" . $_SESSION["email"] . "/details.txt", "r");
        fgets($fo);
        fgets($fo);
        $origpass = trim(fgets($fo));
        if ($pass != $origpass) {
            $passErr = "Incorrect current password!";
            changeColor("pass", "red");
        } else {
            changeColor("pass", "green");
        }
        fclose($fo);
    }

    //npass validation 
    if (empty($npass)) {
        $npassErr = "New Password is required.";
        changeColor("npass", "red");
    } else if (strlen($npass) < 8) {
        $npassErr = "Password should be mimimum of 8 chars.";
        changeColor("npass", "red");
    } else {
        changeColor("npass", "green");
    }

    //cpass validation 
    if (empty($cpass)) {
        $cpassErr = "Confirm the new password.";
        changeColor("cpass", "red");
    } else if ($npass != $cpass) {
        $cpassErr = "Passwords not matching.";
        changeColor("cpass", "red");
    } else {
        changeColor("cpass", "green");
    }

    //everything correct
    if ($passErr == "" && $npassErr == "" && $cpassErr == "") {

        $fo = fopen("Users/" . $_SESSION["email"] . "/details.txt", "r");
        $email = trim(fgets($fo));
        $uname = trim(fgets($fo));
        fgets($fo);
        $age = trim(fgets($fo));
        $gen = trim(fgets($fo));
        file_put_contents("Users/$email/details.txt", "$email\n$uname\n$npass\n$age\n$gen");
        fclose($fo);
        $correct = "Password successfully changed!";
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
<html>

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
            <h2 class="mt-3">Change Password</h2>

            <span class="error"> * are required fields </span><br />
            <br />

            <div class="form-ele form-group">
                <label for="pass" class="form-label">Current Password<span class="error"> *</span></label>
                <input type="password" name="pass" id="pass" class="form-control" value="<?php echo $pass; ?>" size="30" placeholder="Current Password" />
                <span class="error"> <?php echo $passErr; ?></span>
                <br /><br />
            </div>

            <div class="form-ele form-group">
                <label for="npass" class="form-label">New Password<span class="error"> *</span></label>
                <input type="password" name="npass" id="npass" class="form-control" value="<?php echo $npass; ?>" size="30" placeholder="New Password" />
                <span class="error"> <?php echo $npassErr; ?></span>
                <br /><br />
            </div>

            <div class="form-ele form-group">
                <label for="cpass" class="form-label">Confirm Password<span class="error"> *</span></label>
                <input type="password" name="cpass" id="cpass" class="form-control" value="<?php echo $cpass; ?>" size="30" placeholder="Confirm Password" />
                <span class="error"> <?php echo $cpassErr; ?></span>
                <br /><br />
            </div>

            <input type="submit" class="btn btn-dark" value="Submit" name="submit" />

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