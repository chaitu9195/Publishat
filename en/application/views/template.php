<?php
defined('BASEPATH') or exit('No direct script access allowed');
$rid = $rid;
$mod = $module;
if (empty($rid)) {
    $rid = '1';
}
if (empty($mod)) {
    $mod = 'academic';
}
$user_id = $this->session->user_id;
$Upgraded = $this->session->userdata('Upgraded');

$fileURL = $_GET['fileURL'];
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/images/favicon.png" />
        <title>School Records | Academics | Ntotalworld</title>
        <!-- Maps not used - Google Maps API disabled (avoids NotLoadingAPIFromGoogleMapsError)
<script src="<?php echo base_url(); ?>assets/js/mapsapi.js" type="text/javascript"></script>
<script type='text/javascript' src='<?php echo base_url(); ?>assets/js/gmaps.js'></script>
-->
        <script type='text/javascript'>
            window.google = window.google || {};
            google.maps = google.maps || {};
        </script>

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.min.css" />


        <script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>


        <!-- Bootstrap -->
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>assets/css/mab-jquery-taginput.css" />
        <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/typeahead.bundle.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/typeahead.bundle.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/mab-jquery-taginput.js"></script>


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    </head>

    <body>


        <div class="header_wrapper">

        </div>

        <!--                           Header end                       -->
        <!--                         body Start                         -->

        <div class="container" style="min-height:509px;">
            <div id="body_content">
                <div id="preloader"><i class="fa fa-spinner fa-spin fa-4x" style="color:#337AB7;"></i></div>
            </div>

        </div> <!-- container end -->


        <div class="footer">
            <section class="copyrightbottom">
                <div class="container">
                    <div class="row">
                        <div class="pull-left"> Copyright © <?= date(
                            'Y',
                        ) ?>. <a href="/"><?= $_SERVER[
    'SERVER_NAME'
] ?></a>.</div>
                        <div class="pull-right"> <a href="<?php echo base_url(); ?>web/aboutus">About Us</a> / <a href="<?php echo base_url(); ?>web/contactus">Contact</a> / <a href="<?php echo base_url(); ?>web/terms">Terms</a> / <a href="<?php echo base_url(); ?>web/privacy">Privacy</a> /
                            <a href="<?php echo base_url(); ?>web/cancellation">Cancellation Policy</a> /

                            <a href="/help.php">Help</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>


        <!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#paymentModal">Open Modal</button>-->
        <!-- Modal -->
        <div class="modal fade" id="paymentModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn btn-danger pull-right btn-sm" data-dismiss="modal">X</button>
                        <h3 class="modal-title">Ntotalworld <button class="btn btn-success">Pro</button></h3>
                    </div>
                    <div class="modal-body">
                        <?php if ($Upgraded == 'Y') { ?>
                        <h5 class="alert alert-danger">Your account already Upgraded</h5>
                        <?php } ?>
                        <h3>Features</h3>
                        <form action="../../../paytmgateway/pgRedirect.php" method="POST">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-responsive payment">
                                        <th>Description</th>
                                        <th>Free</th>
                                        <th>Pro</th>
                                        <tr>
                                            <td>File Size</td>
                                            <td>5MB</td>
                                            <td>Unlimited</td>
                                        </tr>
                                        <tr>
                                            <td>Storage</td>
                                            <td>2GB</td>
                                            <td>Unlimited</td>
                                        </tr>
                                    </table>
                                </div>
                                <?php
                                $user_id = trim(
                                    $this->session->userdata('user_id'),
                                );
                                $orderid =
                                    $user_id . '-' . date('YmdHis') . '_U';
                                setcookie(
                                    'TotalAmount',
                                    AccountUpgradeAmonut,
                                    time() + 86400 * 30,
                                    '/',
                                );
                                setcookie(
                                    'OrderID',
                                    $orderid,
                                    time() + 86400 * 30,
                                    '/',
                                );
                                ?>

                                <input type="hidden" name="CUST_ID" value="<?= $user_id .
                                    '-' .
                                    date('YmdHis') ?>">
                                <input type="hidden" name="INDUSTRY_TYPE_ID" value="Retail120">
                                <input type="hidden" name="CHANNEL_ID" value="WEB">

                                <?php if ($Upgraded == 'Y') {
                                    $disabled = 'disabled';
                                } else {
                                    $disabled = '';
                                } ?>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-danger col-md-2 pull-right" <?= $disabled ?>>Pay <i class="fa fa-inr"><?= AccountUpgradeAmonut ?></i></button>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>
        <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
        <style>
            #paymentModal .modal-dialog {
                height: 350px;
                width: 50%;
                position: absolute;
                right: 15%;
                top: 10%;
                overflow: hidden;
            }

            #paymentModal .modal-title {
                font-size: 28px;
                font-family: verdana;

            }

            #paymentModal tr td,
            #paymentModal th {
                font-size: 14px;
                font-family: inherit;
                font-weight: 500;
            }

            .close {
                color: red;
            }

            .modal-title {
                background: #466e90;
                padding: 5px;
                color: white;
            }

            .payment th {
                background: #5cb85c;
                color: white;
            }

            #paymentModal .modal-header,
            #paymentModal .modal-footer {
                padding: 0px;
                border: 0px solid #e5e5e5;
            }

            @media only screen and (max-width: 767px) {
                #paymentModal .modal-dialog {
                    width: 80%;
                    position: absolute;
                    right: 0px;
                    top: 100px;
                }
            }
        </style>

        <!--    <script src="../assets/js/jquery-3.1.1.min.js"></script> 
    <script type="text/javascript">
	/*	<?php if (isset($header, $subHeader)) { ?>
        	var header = <?php echo json_encode($header); ?>;
        	var subheader = <?php echo json_encode($subHeader); ?>;
      <?php } ?>
    $("#"+header).addClass('active');
    $("#"+subheader).addClass('active');*/
    </script>

<script src="../assets/js/jquery-3.1.1.min.js"></script> -->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/service-3.1.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                //if(history.replaceState) history.replaceState({}, "", "records?id=1&mod=academic");
                $("#academic").hover(function() {
                    $("#academic_child").toggle();
                });
                $("#professional").hover(function() {
                    $("#professional_child").toggle();
                });
                $("#personal").hover(function() {
                    $("#personal_child").toggle();
                });
                $("#health").hover(function() {
                    $("#health_child").toggle();
                });
                $("#financial").hover(function() {
                    $("#financial_child").toggle();
                });
                $("#legal").hover(function() {
                    $("#legal_child").toggle();
                });

                $('.menu li').click(function() {
                    $('.menu li a').removeClass('active');
                    $(this).find('a').addClass('active');
                });
                $('#msettings').click(function() {
                    $('.msets').slideToggle();
                });

                /* Get data while loading */

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>web/header", //"<?php echo base_url(); ?>web/schooldata",
                    cache: false,
                    async: false,
                    success: function(data) {
                        $('.header_wrapper').html(data);
                    }
                });
                var fileURL = '<?php echo $fileURL; ?>';
                if (fileURL == '' || fileURL == undefined) {
                    if ('<?= $type ?>' == "f") {
                        getFolder('<?= $rid ?>', '<?= $mod ?>');
                    } else {
                        getVal('<?= $rid ?>', '<?= $mod ?>');
                    }
                } else {
                    getNewOCR('<?= $rid ?>', '<?= $mod ?>', fileURL);
                }
            });
        </script>

    </body>

</html>