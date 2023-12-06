<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Slider</title>
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
        <a class="navbar-brand" href="index.php">Home Page</a>
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
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- navbar end -->

    <div class="container mt-4">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner">
               
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <br> <br>
    <section class="portfolio-block website gradient" style="background: var(--bs-body-bg);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-14 col-lg-5 offset-lg-1 text">
                    <p style="color: rgb(0,0,0);text-align: justify;"><span style="color: rgb(32, 33, 34);">A driver's licence is one of the most important documents to consider when identifying a person during various national and international activities. 
                    It is the primary identification document for granting permits to adult citizens to drive various types of motor vehicles. 
                    No one may drive on a public road without a driving licence, according to Section 3 of the Bangladesh Motor Vehicles Ordinance 1983. 
                    As a result, there is no substitute for a valid driver's licence to drive anywhere in the country.
                    </p>
                </div>
               
        </div>
    </section>

    <br> <br>
    <!-- Start: footer -->

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <p>Address: Rajuk,Mohakhali,East 51-52, Dhaka-1212 </p>
                    <p>Email: brtaofficebd@gmail.com</p>
                    <p>Phone:09610-990998 </p>
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
        var email;
        $("#subscription_submit_btn").click(function() {
            email = $('#subscription_email').val();
            if (email.length < 1) {
                $('#err').empty();
                $('#err').html('<br>This field is required');
            } else {
                var regEx = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                // var validEmail = regEx.test(email);
                if (regEx.test(email)) {
                    $('#err').empty();
                    console.log(111);
                    $.ajax({
                        url: './external/footer_email.php',
                        type: 'POST',
                        data: {
                            email: email
                        },
                        success: function(data) {
                            $('#err').empty();
                            $('#err').html('<br>' + data);
                        }
                        // complete: function () {
                        //     // Schedule the next data fetch after a delay (e.g., every 5 seconds)
                        // setTimeout(fetchUserListData, 5000);
                        // }
                    });
                } else {
                    $('#err').empty();
                    $('#err').html('<br>Enter a valid email');
                }

            }

        });
    </script>
</body>

</html>