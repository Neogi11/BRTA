<?php
include_once "connection.php";

if (isset($_POST["submit_btn"])) {
    $name = htmlspecialchars($_POST["name"]);
    $nid = htmlspecialchars($_POST["nid"]);
    $email = htmlspecialchars($_POST["email"]);
    $vehicleNo = htmlspecialchars($_POST["vehicleNo"]);
    $chassisNo = htmlspecialchars($_POST["chassisNo"]);
    $presentAddress = htmlspecialchars($_POST["presentAddress"]);
    $permanentAddress = htmlspecialchars($_POST["permanentAddress"]);

    $profile_pic = $_FILES["profile_pic"];
    $nidSoftCopy = $_FILES["nidSoftCopy"];

    $sql = "SELECT `email` FROM `applicants` WHERE `email` = '$email';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        ?>
        <script>
            window.location.href = "form.php?msg=This email is already exists"
        </script>
        <?php 
        exit();
    }

    if ($_FILES["profile_pic"]["error"] == UPLOAD_ERR_OK && $_FILES["nidSoftCopy"]["error"] == UPLOAD_ERR_OK) {
        // Specify the target directory to save the uploaded files
        $targetDir = "./uploads/";

        // Create the target directory if it doesn't exist
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Get the file name with path
        $target_file = $_FILES["profile_pic"]["name"];
        $image_tmp_name = $_FILES["profile_pic"]["tmp_name"];
        $imageFileExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $profile_pic = "./uploads/" . $email . "." . $imageFileExt;

        // Get the file name with path
        $target_file = $_FILES["nidSoftCopy"]["name"];
        $file_tmp_name = $_FILES["nidSoftCopy"]["tmp_name"];
        $FileExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $nidSoftCopy = "./uploads/" . $email . "." . $FileExt;


        if ($imageFileExt != "jpg" && $imageFileExt != "png" && $imageFileExt != "jpeg" && $imageFileExt != "gif" ) {
            header("Location: form.php?msg=Sorry, only JPG, JPEG, PNG and GIF files are allowed");
            exit();
        } else if($FileExt != "pdf"){
            header("Location: form.php?msg=Sorry, only PDF allowed");
            exit();
        } else{
            move_uploaded_file($image_tmp_name, $profile_pic) && move_uploaded_file($file_tmp_name, $nidSoftCopy);

            $sql = "INSERT INTO `applicants` (`name`, `nid_no`, `vehicle_no`, `vehicle_chassis_no`, `present_addr`, `permanent_addr`, `profile_pic`, `nid_softcopy`, `id`, `email`) VALUES ('$name', '$nid', '$vehicleNo', '$chassisNo', '$presentAddress', '$permanentAddress', '$profile_pic', '$nidSoftCopy', NULL, '$email')";
            if(mysqli_query($conn, $sql)){
                header("Location: form.php?success_msg=Submition Success");
                exit();
            } else{
                header("Location: form.php?msg=Submition Failed");
                exit();
            }
        }

        // Move the uploaded files to the target directory
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        footer {
            background-color: lightblue;
            padding: 40px 0;
        }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="form.php">Form Page</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="form.php">Form</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <div style="text-align: center;">
            <h2>Registration Form</h2>
        </div>

        <form method="post" , enctype="multipart/form-data">
            <?php
            if (isset($_GET["msg"])) {
                echo "<div class='alert alert-danger' role='alert'>" . $_GET["msg"] . "</div>";
            } else if (isset($_GET["success_msg"])) {
                echo "<div class='alert alert-success' role='alert'>" . $_GET["success_msg"] . "</div>";
            }
            ?>
            <div class="mb-3"><label class="form-label" for="name">Your Name</label><input class="form-control item" type="text" id="name" name="name" required></div>
            <div class="mb-3"><label class="form-label" for="subject">NID No</label><input class="form-control item" type="text" id="nid" name="nid" required></div>
            <div class="mb-3"><label class="form-label" for="email">Email</label><input class="form-control item" type="email" id="email" name="email" required></div>
            <div class="mb-3"><label class="form-label" for="name">Vehicle No</label><input class="form-control item" type="text" id="vehicleNo" name="vehicleNo" required></div>
            <div class="mb-3"><label class="form-label" for="name">Vehicle Chassis No</label><input class="form-control item" type="text" id="chassisNo" name="chassisNo" required></div>
            <div class="mb-3"><label class="form-label" for="name">Present Address</label><input class="form-control item" type="text" id="presentAddress" name="presentAddress" required></div>
            <div class="mb-3"><label class="form-label" for="name">Permanent Address</label><input class="form-control item" type="text" id="permanentAddress" name="permanentAddress" required></div>
            <div class="mb-3"><label class="form-label" for="name">Your Photo</label><input class="form-control" type="file" accept="image/*" id="profile_pic" name="profile_pic" required></div>
            <div class="mb-3"><label class="form-label" for="name">NID Soft Copy (PDF)</label><input class="form-control" accept="application/pdf" id="nidSoftCopy" name="nidSoftCopy" type="file" required></div>
            <div class="mb-3 mt-4"><button onclick="validateFormPHP()" class="btn btn-primary " name="submit_btn" type="submit">Submit Form</button></div>
            <div id="form_submit" name="error_success_status" style="text-align: center;"></div>
        </form>

    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <p>Address: Rajuk,Mohakhali,East 51-52, Dhaka-1212 </p>
                    <p>Email: brtaofficebd@gmail.com</p>
                    <p>Phone:09610-990998</p>
                </div>
                <div class="col-md-4">
                   
                </div>
                <div class="col-md-4">
                    <h5>Subscribe BRTA Website</h5>
                    <form action="subscribe.php" method="post">
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function validateFormPHP() {
            // Get form inputs
            var name = document.getElementById('name').value;
            var nid = document.getElementById('nid').value;
            var email = document.getElementById('email').value;
            var vehicleNo = document.getElementById('vehicleNo').value;
            var chassisNo = document.getElementById('chassisNo').value;
            var presentAddress = document.getElementById('presentAddress').value;
            var permanentAddress = document.getElementById('permanentAddress').value;
            var photo = document.getElementById('profile_pic').value;
            var nidSoftCopy = document.getElementById('nidSoftCopy').value;

            // Simple validation example (you can add more complex validation)
            if (name === '' || nid === '' || email === '' || vehicleNo === '' || chassisNo === '' || presentAddress === '' || permanentAddress === '' || photo === '' || nidSoftCopy === '') {
                alert("Please fill up the full form");
            }
        }
    </script>
</body>

</html>