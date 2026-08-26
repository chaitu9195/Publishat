<div class="row">
    <div class="left-heading col-md-6 col-xs-8">
        <span class="hidden-xs pull-left">
            <i class="fa fa-user fa-2x" aria-hidden="true"></i>
            <span class="h3">Account Summary</span>
        </span>
        <span class="visible-xs pull-left">
            <i class="fa fa-user fa-2x" aria-hidden="true"></i>
            <span class="h4">Account Summary</span>
        </span>
    </div>

</div>
<form method="post" id="user_info" enctype="multipart/form-data">

    <?php
    $data = $data['userinfo'];
    foreach ($data as $userinfo) {

        $state = $userinfo['State'];
        $bloodgroup = $userinfo['BloodGroup'];
        $height_measurement = $userinfo['HeightMeasure'];
        ?>
    <div class="row">
        <div class="col-md-3 col-md-offset-0 col-xs-8 col-xs-offset-2">

            <div class="img_pro" id="image_pro">
                <?php if (empty($userinfo['PhotoPath'])) { ?>
                <i class="fa fa-user" style="font-size: 182px;color: #b8bcca;padding: 33px;"></i>
                <?php } else { ?>
                <img src="../../../<?= $userinfo[
                    'PhotoPath'
                ] ?>" class="img img-responsive img-spacing" id="img_profile">
                <?php } ?>
            </div>
            <div id="imagePreview" class="img_pro" style="display:none"></div>
            <div class="cam" id="cam_toogle">
                <input type="file" name="UpdProfilePhoto" class="file_img" id="upd_pro_photo" title="Choose a file to upload">
                <span class="fa fa-camera" id="photo">UpdateProfilePicture</span>
            </div>

        </div>
        <div class="col-md-6 col-md-offset-1 col-xs-12">
            <div id="viewsummary">
                <button class="btn btn-primary pull-right" type="button" id="editbtn">Edit</button>
                <h3>Personal Info</h3>
                <table class="table table-responsive">
                    <tr>
                        <td><b>Name</b></td>
                        <td>: <?= $userinfo['Name'] ?></td>
                    </tr>
                    <tr>
                        <td><b>Gender</b></td>
                        <td>: <?= $userinfo['Gender'] ?></td>
                    </tr>
                    <tr>
                        <td><b>DOB</b></td>
                        <td>: <?= $userinfo['DateOfBirth'] ?></td>
                    </tr>
                    <tr>
                        <td><b>Email</b></td>
                        <td>: <?= $userinfo['Email'] ?></td>
                    </tr>
                    <tr>
                        <td><b>Mobile Number</b></td>
                        <td>: <?= $userinfo['Phone'] ?></td>
                    </tr>
                    <tr>
                        <td><b>Aadhaar (UID)</b></td>
                        <td>: <?= $userinfo['UID'] ?></td>
                    </tr>
                    <tr>
                        <td><b>Address</b></td>
                        <td>: <?= $userinfo['Address'] ?></td>
                    </tr>
                    <tr>
                        <td><b>State</b></td>
                        <td>: <?= $userinfo['State'] ?></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <h3>Health Info</h3>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Weight</b></td>
                        <td>: <?= $userinfo['Weight'] ?></td>
                    </tr>
                    <tr>
                        <td><b>Height</b></td>
                        <td>: <?= $userinfo['Height'] ?> <?= $userinfo[
     'HeightMeasure'
 ] ?></td>
                    </tr>
                    <tr>
                        <td><b>Blood Group</b></td>
                        <td>: <?= $userinfo['BloodGroup'] ?></td>
                    </tr>
                    <tr>
                        <td><b>BMI</b></td>
                        <td>: <?= $userinfo['BMI'] ?></td>
                    </tr>
                    <tr>
                        <td><b>Blood Pressure</b></td>
                        <td>: <?= $userinfo['BloodPressure'] ?></td>
                    </tr>
                </table>
            </div>

            <div class="" id="editsummary">
                <h3>Personal Info</h3>
                <hr />
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label>Name :</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="name" class="form-control" value="<?= $userinfo[
                                'Name'
                            ] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label>Email :</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="email" class="form-control" value="<?= $userinfo[
                                'Email'
                            ] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label>Aadhar(UID) :</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="uid" value="<?= $userinfo[
                                'UID'
                            ] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label>Gender :</label>
                        </div>
                        <div class="col-md-8">
                            <select name="gender" name="gender" class="form-control">
                                <option value="Male" <?= $userinfo['Gender'] ==
                                'Male'
                                    ? 'selected'
                                    : '' ?>>Male</option>
                                <option value="Female" <?= $userinfo[
                                    'Gender'
                                ] == 'Female'
                                    ? 'selected'
                                    : '' ?>>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label>DOB :</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="dob" value="<?= $userinfo[
                                'DateOfBirth'
                            ] ?>" id="dob">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label>Phone / Mobile :</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="phone" value="<?= $userinfo[
                                'Phone'
                            ] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label>Address :</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="address" value="<?= $userinfo[
                                'Address'
                            ] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label>State :</label>
                        </div>
                        <div class="col-md-8">
                            <select name="state" name="state" class="form-control">
                                <option value="">Select</option>
                                <option value="Other" <?= $state == 'Other'
                                    ? "selected='selected'"
                                    : '' ?>>Other Country / State</option>
                                <option value="Andaman And Nicobar Islands" <?= $state ==
                                'Andaman And Nicobar Islands'
                                    ? "selected='selected'"
                                    : '' ?>>Andaman And Nicobar Islands</option>
                                <option value="Andhra Pradesh" <?= $state ==
                                'Andhra Pradesh'
                                    ? "selected='selected'"
                                    : '' ?>>Andhra Pradesh</option>
                                <option value="Arunachal Pradesh" <?= $state ==
                                'Arunachal Pradesh'
                                    ? "selected='selected'"
                                    : '' ?>>Arunachal Pradesh</option>
                                <option value="Assam" <?= $state == 'Assam'
                                    ? "selected='selected'"
                                    : '' ?>>Assam</option>
                                <option value="Bihar" <?= $state == 'Bihar'
                                    ? "selected='selected'"
                                    : '' ?>>Bihar</option>
                                <option value="Chhattisgarh" <?= $state ==
                                'Chhattisgarh'
                                    ? "selected='selected'"
                                    : '' ?>>Chhattisgarh</option>
                                <option value="Daman And Diu" <?= $state ==
                                'Daman And Diu'
                                    ? "selected='selected'"
                                    : '' ?>>Daman And Diu</option>
                                <option value="Delhi" <?= $state == 'Delhi'
                                    ? "selected='selected'"
                                    : '' ?>>Delhi</option>
                                <option value="Goa" <?= $state == 'Goa'
                                    ? "selected='selected'"
                                    : '' ?>>Goa</option>
                                <option value="Gujarat" <?= $state == 'Gujarat'
                                    ? "selected='selected'"
                                    : '' ?>>Gujarat</option>
                                <option value="Haryana" <?= $state == 'Haryana'
                                    ? "selected='selected'"
                                    : '' ?>>Haryana</option>
                                <option value="Himachal Pradesh" <?= $state ==
                                'Himachal Pradesh'
                                    ? "selected='selected'"
                                    : '' ?>>Himachal Pradesh</option>
                                <option value="Jammu And Kashmir" <?= $state ==
                                'Jammu And Kashmir'
                                    ? "selected='selected'"
                                    : '' ?>>Jammu And Kashmir</option>
                                <option value="Jharkhand" <?= $state ==
                                'Jharkhand'
                                    ? "selected='selected'"
                                    : '' ?>>Jharkhand</option>
                                <option value="Karnataka" <?= $state ==
                                'Karnataka'
                                    ? "selected='selected'"
                                    : '' ?>>Karnataka</option>
                                <option value="Kerala" <?= $state == 'Kerala'
                                    ? "selected='selected'"
                                    : '' ?>>Kerala</option>
                                <option value="Madhya Pradesh" <?= $state ==
                                'Madhya Pradesh'
                                    ? "selected='selected'"
                                    : '' ?>>Madhya Pradesh</option>
                                <option value="Maharashtra" <?= $state ==
                                'Maharashtra'
                                    ? "selected='selected'"
                                    : '' ?>>Maharashtra</option>
                                <option value="Manipur" <?= $state == 'Manipur'
                                    ? "selected='selected'"
                                    : '' ?>>Manipur</option>
                                <option value="Meghalaya" <?= $state ==
                                'Meghalaya'
                                    ? "selected='selected'"
                                    : '' ?>>Meghalaya </option>
                                <option value="Mizoram" <?= $state == 'Mizoram'
                                    ? "selected='selected'"
                                    : '' ?>>Mizoram</option>
                                <option value="Nagaland" <?= $state ==
                                'Nagaland'
                                    ? "selected='selected'"
                                    : '' ?>>Nagaland</option>
                                <option value="Orissa" <?= $state == 'Orissa'
                                    ? "selected='selected'"
                                    : '' ?>>Orissa</option>
                                <option value="Pondicherry" <?= $state ==
                                'Pondicherry'
                                    ? "selected='selected'"
                                    : '' ?>>Pondicherry</option>
                                <option value="Punjab" <?= $state == 'Punjab'
                                    ? "selected='selected'"
                                    : '' ?>>Punjab</option>
                                <option value="Rajasthan" <?= $state ==
                                'Rajasthan'
                                    ? "selected='selected'"
                                    : '' ?>>Rajasthan</option>
                                <option value="Sikkim" <?= $state == 'Sikkim'
                                    ? "selected='selected'"
                                    : '' ?>>Sikkim</option>
                                <option value="Tamilnadu" <?= $state ==
                                'Tamilnadu'
                                    ? "selected='selected'"
                                    : '' ?>>Tamilnadu</option>
                                <option value="Telangana" <?= $state ==
                                'Telangana'
                                    ? "selected='selected'"
                                    : '' ?>>Telangana</option>
                                <option value="Tripura" <?= $state == 'Tripura'
                                    ? "selected='selected'"
                                    : '' ?>>Tripura</option>
                                <option value="Uttar Pradesh" <?= $state ==
                                'Uttar Pradesh'
                                    ? "selected='selected'"
                                    : '' ?>>Uttar Pradesh</option>
                                <option value="Uttaranchal" <?= $state ==
                                'Uttaranchal'
                                    ? "selected='selected'"
                                    : '' ?>>Uttaranchal</option>
                                <option value="West Bengal" <?= $state ==
                                'West Bengal'
                                    ? "selected='selected'"
                                    : '' ?>>West Bengal</option>
                            </select>
                        </div>
                    </div>
                    <h3>Health Info</h3>
                    <hr />
                    <div class="form-group">
                        <div class="col-md-4">
                            <label>Weight :</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" name="weight" class="form-control" value="<?= $userinfo[
                                'Weight'
                            ] ?>">
                        </div>
                        <span>Kgs</span>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label>Height :</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="height" class="form-control" value="<?= $userinfo[
                                'Height'
                            ] ?>">
                        </div>
                        <div class="col-md-4">
                            <select name="height_measurement" class="form-control">
                                <option value="">Select</option>
                                <option <?= $height_measurement == 'cm'
                                    ? 'selected=selected'
                                    : '' ?>>cm</option>
                                <option <?= $height_measurement == 'feets'
                                    ? 'selected=selected'
                                    : '' ?>>feets</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label>Blood Group :</label>
                        </div>
                        <div class="col-md-8">
                            <select name="blood_group" class="form-control">
                                <option value="">Select</option>
                                <option <?= $bloodgroup == 'O+'
                                    ? 'selected=selected'
                                    : '' ?>>O+</option>
                                <option <?= $bloodgroup == 'O-'
                                    ? 'selected=selected'
                                    : '' ?>>O-</option>
                                <option <?= $bloodgroup == 'A+'
                                    ? 'selected=selected'
                                    : '' ?>>A+</option>
                                <option <?= $bloodgroup == 'A-'
                                    ? 'selected=selected'
                                    : '' ?>>A-</option>
                                <option <?= $bloodgroup == 'B+'
                                    ? 'selected=selected'
                                    : '' ?>>B+</option>
                                <option <?= $bloodgroup == 'B-'
                                    ? 'selected=selected'
                                    : '' ?>>B-</option>
                                <option <?= $bloodgroup == 'AB+'
                                    ? 'selected=selected'
                                    : '' ?>>AB+</option>
                                <option <?= $bloodgroup == 'AB-'
                                    ? 'selected=selected'
                                    : '' ?>>AB-</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label>BMI :</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="bmi" class="form-control" value="<?= $userinfo[
                                'BMI'
                            ] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label>Blood Pressure :</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="bloodpressure" class="form-control" value="<?= $userinfo[
                                'BloodPressure'
                            ] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-xs-7">
                            <span class="pull-right">
                                <input class="btn btn-primary" type="submit" id="updatebutton" value="Submit">
                            </span>
                        </div>
                    </div>
                </div>
</form>
</div>

<?php
    }
    ?>
</div>
</div>


<style>
    .img-spacing {
        margin-bottom: 5%;
    }

    #editsummary {
        display: none;
    }

    .file_img {
        position: absolute;
        opacity: 0;
        height: 43px;
        width: 100%;

    }

    .img_pro {
        width: 200px;
        height: 200px;
        background-position: center center;
        background-size: cover;
        -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
        display: inline-block;
    }

    #photo {
        margin-top: 12px;
    }

    .cam {
        background-color: rgb(185, 181, 181);
        width: 200px;
        height: 42px;
        position: absolute;
        margin-top: -47px;
        opacity: 0.9;
        color: black;
        text-align: center;
        cursor: pointer;
        display: none;
    }

    .img {
        position: relative !important;
        width: 100%;
        height: 200px;
    }
</style>
<script type="text/javascript" src="../assets/js/form.min.js"></script>
<script>
    $("#editbtn").click('on', function() {
        $("#viewsummary").hide();
        $("#editsummary").show();
        $("#cam_toogle").show();
    });
    $(document).ready(function() {
        $("#user_info").submit(function(event) {
            event.preventDefault();
            var data = new FormData($("#user_info")[0]);
            $.ajax({
                url: '../web/updateuserinfo',
                type: "POST",
                cache: false,
                data: data,
                contentType: false,
                processData: false,
                assync: false,
                success: function(result) {
                    $('#body_content').html(result);
                }
            });
        });
        $('#dob').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#dob').click(function() {
            $('#dob').datetimepicker({
                format: 'YYYY-MM-DD',
                minDate: moment()
            });
        });

    });
    $("#upd_pro_photo").on("change", function() {

        $('#image_pro').hide();
        $('#imagePreview').show();
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

        if (/^image/.test(files[0].type)) { // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file

            reader.onloadend = function() { // set image data as background of div
                $("#imagePreview").css("background-image", "url(" + this.result + ")");
            }
        }
    });
</script>