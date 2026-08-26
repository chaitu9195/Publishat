<?php

$authUrl = google_login_url();

?>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <title>Publishat | Signup</title>
        <style>
            .header {
                background: #004e83;
            }

            .signupform input,
            select,
            button,
            label {
                margin: 1%;
            }

            .signupform label {
                margin-left: 20%
            }

            .signupform {
                margin-top: 2%;
            }

            .signupform .col-xs-12 {
                padding: 0%;
            }

            .google,
            .fb {
                width: 250px;
                height: 53px;
            }

            .signuplogo {
                width: 32px;
                height: 32px;
                background-image: url(https://publishat.com/graphics/postwaves-ui1.png);
                background-position: -251px -162px;
                float: left;
                margin-right: 8px;
            }
        </style>
        <script>
            $(function() {
                $("#dob").datepicker({
                    dateFormat: "yy-mm-dd",
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "1950:2016"
                });
            });

            $(document).ready(function() {
                $("#signup_btn").click('on', function() {
                    if ($("#fullname").val() == "") {
                        $("#fullname").css({
                            "border": "1px solid red"
                        });
                        $("#fullname").focus();
                        return false;
                    } else if ($("#email").val() == "") {
                        $("#email").css({
                            "border": "1px solid red"
                        });
                        $("#email").focus();
                        return false;
                    } else if ($("#conf_email").val() == "") {
                        $("#conf_email").css({
                            "border": "1px solid red"
                        });
                        $("#conf_email").focus();
                        return false;
                    } else if ($("#conf_email").val() != $("#email").val()) {
                        $("#conf_email").css({
                            "border": "1px solid red"
                        });
                        $("#conf_email").focus();
                        return false;
                    } else if ($("#password").val() == "") {
                        $("#password").css({
                            "border": "1px solid red"
                        });
                        $("#password").focus();
                        return false;
                    } else if ($("#gender").val() == "") {
                        $("#gender").css({
                            "border": "1px solid red"
                        });
                        $("#gender").focus();
                        return false;
                    } else if ($("#dob").val() == "") {
                        $("#dob").css({
                            "border": "1px solid red"
                        });
                        $("#dob").focus();
                        return false;
                    } else if ($('input[type=checkbox]:checked').length == 0) {
                        $("#terms").css({
                            "border": "1px solid red"
                        });
                        $("#terms").focus();
                        return false;
                    }

                });
            });
        </script>
    </head>

    <body>
        <div class="container-fluid">
            <div class="header row">
                <div class="logo">
                    <a href="../web/index"><img src="https://www.publishat.com/img/logo.png" class="img-responsive" /></a>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2 col-xs-12 col-xs-offset-0 signupform">
                <h3><span class="signuplogo"></span>Signup With Publishat</h3>
                <hr />
                <?php
        if($status == 'error'){
       ?>
                <div class="alert alert-danger">The email you entered has already been registered on Publishat.com...</div>
                <?  }
      ?>
                <form action="signup" method="POST">
                    <div class="form-group">
                        <div class="col-md-4 hidden-xs">
                            <label for="fullname">Full Name:</label>
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <input type="text" name="fullname" class="form-control col-md-8" id="fullname" placeholder="Enter Full Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4 hidden-xs">
                            <label for="email">Your Email:</label>
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <input type="email" name="email" class="form-control col-md-8" id="email" placeholder="Enter Email">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4 hidden-xs">
                            <label for="Re-Enter Email">Re-Enter Email:</label>
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <input type="email" name="conf_email" class="form-control col-md-8" id="conf_email" placeholder="Re-Enter Email">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4 hidden-xs">
                            <label for="password">New Password:</label>
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <input type="password" name="password" class="form-control col-md-8" id="password" placeholder="Create Password">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4 hidden-xs">
                            <label for="gender">Gender:</label>
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <select class="form-control col-md-8" name="gender" id="gender">
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 hidden-xs">
                                <label for="dob">DOB:</label>
                            </div>
                            <div class="col-md-8 col-xs-12">
                                <input type="text" name="dob" class="form-control col-md-8" id="dob" placeholder="Select Date of Birth" id="dob">
                            </div>

                            <div class="form-group">
                                <div class="col-md-4 hidden-xs">

                                </div>
                                <div class="col-md-8 col-xs-12">
                                    <input type="checkbox" style="float:left" id="terms">
                                    <p> By clicking Sign Up, you agree to our <a href="https://www.publishat.com/terms.php">Terms</a> and <a href="https://www.publishat.com/privacy.php">Privacy</a></p>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-4 hidden-xs">

                                    </div>
                                    <div class="col-md-8 col-xs-12">
                                        <button type="submit" class="btn btn-primary" id="signup_btn">Signup</button>
                                        <button type="reset" class="btn btn-default"> Reset</button>
                                    </div>

                                    <div class="col-md-8 col-md-offset-4 col-xs-12 col-xs-offset-0">
                                        <hr />
                                        <a href="<?=$authUrl;?>"><img src="https://publishat.com/images/signup-google.png" class="google"></a>
                                    </div>

                                    <!-- <div class="col-md-5 col-md-offset-1 col-xs-12 col-xs-offset-0">
             <a><img src="https://publishat.com/fb/skin/images/facebook_signup_button.png" class="fb"></a>
          </div>-->
                </form>
            </div>
        </div>
        </div>

    </body>

</html>