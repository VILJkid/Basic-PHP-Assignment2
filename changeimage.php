<?php
error_reporting(0);
session_start();

$email = $_SESSION["email"];
$fileErr = "";
$toggleModal = "hide";


if (isset($_POST['submit'])) {

    echo `<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Meow
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>`;

    $tmp = $_FILES['file']['tmp_name'];
    // $fname = $_FILES['file']['name'];
    $fname = "image.jpg";
    $ext = pathinfo($fname, PATHINFO_EXTENSION);

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
    if ($fileErr == "") {

        $dest = "Users/$email/Uploads/";
        // echo "22222";
        if (!move_uploaded_file($tmp, $dest . $fname)) {
            $fileErr = "Upload failed.";
            changeColor("file", "red");
        } else {
            // header("Location: welcome.php");
            $correct = "Image changed successfully!";
            $toggleModal = "show";
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
<html>

<head>
    <?php
    include("head.php");
    ?>
    <title>Change Image</title>
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

        img {
            border-radius: 10%;
        }
    </style>

    <script>
        $(document).ready(function() {
            $("#exampleModal").modal("<?php echo $toggleModal; ?>");
        });
    </script>
</head>

<body>
    <form method="post" class="center" enctype="multipart/form-data">
        <div class="container">
            <h2 class="mt-3">Change Image</h2>

            <span class="error"> * are required fields </span><br />
            <br />

            <div class="form-ele form-group">
                <img src="<?php echo $image; ?>" alt="Image load error" class="form-label" height="400px" width="400px">
                <br /><br />
            </div>

            <div class="form-ele form-group">
                <label for="file" class="form-label">Upload an Image<span class="error"> *</span></label>
                <input class="form-control" type="file" id="file" name="file">
                <span class="error"> <?php echo $fileErr; ?></span>
                <br /><br />
            </div>

            <input type="submit" class="btn btn-dark" value="Upload" name="submit" />

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-6 col-md-3 text-center">
                                        <img src="./Images/tick-noloop.gif" alt="Error loading image" class="img-rounded center-block" width="40px">
                                    </div>
                                    <div class="col-sm-6 col-md-9 ml-auto">
                                        <div class="text-center">
                                            <h5>Image changed successfully !</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button> -->
                            <a href="dashboard.php" class="btn btn-primary">Continue</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- <br /><br />
        <span class="correct"><?php echo $correct ?></span>
        <br /><br /> -->
    </form>
    <?php
    include("foot.php");
    ?>

</body>

</html>