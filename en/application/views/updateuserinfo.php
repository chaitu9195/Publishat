<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function() {
        $("#dob").datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            yearRange: "1950:2016"
        });
    });
</script>
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
</style>

<body>
    <div class="container-fluid">
        <div class="header row">
            <div class="logo">
                <a href="../web/index"><img src="https://www.publishat.com/img/logo.png" class="img-responsive" /></a>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-2 col-xs-12 col-xs-offset-0 signupform">
            <h3><span class="signuplogo"></span>Update User Info</h3>
            <hr />
            <form action="updateuserinfo" method="POST">
                <div class="form-group">
                    <div class="col-md-4 hidden-xs">
                        <label for="fullname">DOB:</label>
                    </div>
                    <div class="col-md-8 col-xs-12">
                        <input name="dob" id="dob" type="text" class="form-control" placeholder="Select Date of Birth" style="cursor: pointer;" required />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 hidden-xs">
                        <label for="fullname">Fb Id (If Any):</label>
                    </div>
                    <div class="col-md-8 col-xs-12">
                        <input name="fbid" type="text" class="form-control" maxlength="50" placeholder="Fb Id (If Any)" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 hidden-xs">
                        <label for="fullname">Country Code:</label>
                    </div>
                    <div class="col-md-8 col-xs-12">
                        <select name="country_code" class="form-control" required>
                            <option value="+91">+91</option>
                            <option value="+1">+1</option>
                            <option value="+61">+61</option>
                            <option value="+44">+44</option>
                            <option value="+971">+971</option>
                            <option value="+86">+86</option>
                            <option value="+81">+81</option>
                            <option value="+65">+65</option>
                            <option value="+94">+94</option>
                            <option value="+92">+92</option>
                            <option value="+880">+880</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 hidden-xs">
                        <label for="fullname">Mobile Number:</label>
                    </div>
                    <div class="col-md-8 col-xs-12">

                        <input name="phone" type="text" class="form-control" maxlength="10" onkeypress="return onlyNumbers(event)" placeholder="Enter Mobile No" required />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 hidden-xs">

                    </div>
                    <div class="col-md-8 col-xs-12">
                        <button type="submit" class="btn btn-primary" id="signup_btn">Update</button>
                        <button type="reset" class="btn btn-default"> Reset</button>
                    </div>
            </form>