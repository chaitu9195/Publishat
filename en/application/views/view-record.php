<?php
if (strtolower($moduleName) == 'medical') {
    $modName = 'health';
} else {
    $modName = strtolower($moduleName);
}

$record_type_id = $recTypeId;
if ($record_type_id == 19) {
    $sub_type_id = 23;
}
if ($record_type_id == 20) {
    $sub_type_id = 24;
}
if ($record_type_id == 21) {
    $sub_type_id = 26;
}
if ($record_type_id == 22) {
    $sub_type_id = 27;
}
if ($record_type_id == 32) {
    $sub_type_id = 41;
}
if ($record_type_id == 35) {
    $sub_type_id = 39;
}
if ($record_type_id == 16) {
    $sub_type_id = 45;
}
?>
<div class="center_wrapper">

    <div class="row">
        <div class="left-heading col-md-8 col-xs-6">
            <span class="hidden-xs pull-left">
                <i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i>
                <span class="h3">View Record</span>
            </span>
            <span class="visible-xs pull-left">
                <i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i>
                <span class="h4">View Record</span>
            </span>
        </div>

        <div class="right-icons col-md-offset-0 col-md-3 col-xs-4 " id="right_icons" ">
	   <!-- <i class=" fa fa-lock fa-2x" aria-hidden="true"></i> -->

            <!-- <i class="fa fa-file-o fa-2x" aria-hidden="true"></i> -->
            <?php if ($recTypeId == 16) { ?>
            <a href='#' id="collaboration_rec"> <i class="fa fa-users fa-2x" aria-hidden="true"></i></a>
            <?php } ?>
            <a href='#' id="addKart"> <i class="fa fa-cart-plus fa-2x" aria-hidden="true"></i> </a>
            <a href="#/" onclick="getedit('<?= $data[
                'RecordId'
            ] ?>','<?= $recTypeId ?>','<?= strtolower(
    $moduleName,
) ?>')"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
            <a href="#/" id='share_button'><i class="fa fa-share-alt fa-2x" aria-hidden="true"></i></a>
            <a href="#/" id='delete_button'><i class="fa fa-trash fa-2x" aria-hidden="true"></i> </a>
        </div>
        <div class="right-icons col-xs-offset-0 col-xs-2 col-md-1 col-md-offset-0 pull-left " id="right_icons" style="display:block;">
            <button class="btn btn-primary" href="#/school" title="Add new record" onclick="getVal('<?= $recTypeId ?>','<?= $moduleName ?>')"> back </button>
        </div>
    </div>

    <div class="row" id="cart_error"> </div>

    <!-- code to display delete form element -->
    <div class="row delete_rec" id="delete_rec">
        <div class="top_text">
            <span>Enter the Captcha to delete the selected record(s) & related documents. </span>
            <button type="button" id='del_close' class="pull-right btn btn-danger btn-xs"><i class="fa fa-remove" aria-hidden="true"></i>
            </button>
        </div>
        <div class="delete_body">
            <?php
            $code = rand(100000, 999999);
            $this->session->set_userdata('captcha', $code);
            ?>
            <div class="alert alert-danger" id="error" style="display:none">
                <div id="msg"> </div>
            </div>
            <form class="form-horizontal col-sm-8 col-sm-offset-1 pad" name="deleteForm" id='deleteForm'>
                <div class="form-group">
                    <input type="hidden" name="record_type_id" value="<?= $recTypeId ?>">
                    <input type="hidden" name="RecordId" value="<?= $data[
                        'RecordId'
                    ] ?>">
                    <input type="hidden" name='module' value="<?= strtolower(
                        $moduleName,
                    ) ?>">
                    <label class="control-label col-sm-6 hidden-xs" for="Captcha">Captcha <span style="float:right"> : </span></label>
                    <div class="col-sm-6 col-xs-12">
                        <span class="captcha"><?= $code ?> </span>

                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-6 hidden-xs" for="Captcha">Enter Captcha <span style="float:right"> : </span></label>
                    <div class="col-sm-6 col-xs-12">
                        <input type="text" class="form-control" name='captcha' id="captcha" placeholder="Enter Captcha">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-6 col-sm-6">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-default" id="reset">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div> <!-- end of delete_rec div -->
    <!--start of collaboration div -->
    <div class="row colaborate_rec" id="colaborate_record">
        <div class="top_text">
            <span> Share the information of selected records with document links. </span>
            <button type="button" id='colaborate_close' class="pull-right btn btn-danger btn-xs"><i class="fa fa-remove" aria-hidden="true"></i></button>
        </div>
        <div class="delete_body">
            <div class="alert alert-danger" id="error_collaboration" style="display:none">
                <div id="share_collaboration"> </div>
            </div>
            <form class="form-horizontal col-sm-12 pad" name="coloborateForm" id='coloborateForm'>
                <input type="hidden" name="record_type_id" value="<?= $recTypeId ?>">
                <input type="hidden" name="record_id" value="<?= $data[
                    'RecordId'
                ] ?>">
                <div class="form-group">
                    <span class='attchdocuments files' style="width:98%">
                        Please enter the emails separated by a comma (,)
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3 hidden-xs" for="colaborate">Edit privileges:</label>
                    <div class="col-sm-9 col-xs-12">
                        <span class="col-sm-1">
                            <input type="radio" name="privileges" value="Y">
                        </span>
                        <span class="col-sm-2 privileges" style="">
                            YES
                        </span>
                        <span class="col-sm-1">
                            <input type="radio" name="privileges" value="N">
                        </span>
                        <span class="col-sm-3 privileges">
                            NO
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3 hidden-xs" for="colaborate">Enter Emails:</label>
                    <div class="col-sm-9 col-xs-12">
                        <textarea class="form-control tag-input" name='coloborate_list' id="coloborate_list" placeholder="Enter Emails"></textarea>
                    </div>
                </div>
                <!--<div class="form-group">
              <label class="control-label col-sm-3 hidden-xs" for="message">Enter Message:</label>
              <div class="col-sm-9 col-xs-12">          
                <textarea  class="form-control" name ='addtext'  id="emailBody" placeholder="Enter Email Body"></textarea>
              </div>
          </div>-->
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <button type="submit" class="btn btn-primary">Send</button>
                        <button type="reset" class="btn btn-default" id="reset">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- end of collaboration div -->
    <!-- code for Email form Element --->
    <div class="row share_rec" id="share_rec">
        <div class="top_text">
            <span>Selected Records Email with attachment links.</span>
            <button type="button" id='share_close' class="pull-right btn btn-danger btn-xs"><i class="fa fa-remove" aria-hidden="true"></i>
            </button>
        </div>
        <div class="delete_body">
            <div class="alert alert-danger" id="error_mail" style="display:none">
                <div id="msg_mail"> </div>
            </div>
            <form class="form-horizontal col-sm-12 pad" name="emailForm" id='emailForm'>
                <div class="form-group">
                    <?php if (count($files ?? [])) {
                        for ($i = 0; $i <= count($files ?? []) - 1; $i++) {

                            $label = $files[$i]['Notes'];
                            $doc_id = $files[$i]['DocumentId'];
                            $path = $files[$i]['DocumentPath'];
                            $filename = $files[$i]['filename'];
                            if (empty($filename)) {
                                $filename = pathinfo($path, PATHINFO_FILENAME);
                                $filename = substr(
                                    strstr($filename, '-'),
                                    1,
                                    15,
                                );
                            }
                            $filename = substr($filename, 0, 11);
                            $ext = $files[$i]['FileType'];
                            ?>
                    <div class="attchdocuments">
                        <input type="checkbox" name="document_id[]" class='' id="document_id_arr" value="<?= $doc_id ?>">
                        <a href="./docviewer?fid=<?= $doc_id ?>" target="_blank" title='View / Download File'><span class="files"> <?= !empty(
    $label
)
    ? $label
    : ucfirst($filename) ?> </span></a>
                    </div>
                </div>
                <div class="form-group">
                    <?php
                        }
                    } ?>
                    <?php foreach ($sub_rec as $sub_rec_idr) {

                        $constants = get_defined_constants();
                        $headers = json_decode($constants[$tableName], true);
                        $key1 = $headers['subheaders']['key1'];
                        $key2 = $headers['subheaders']['key2'];
                        $key3 = $headers['subheaders']['key3'];
                        $key_value1 = $sub_rec_idr[$key1];
                        $key_value2 = $sub_rec_idr[$key2];
                        $key_value3 = $sub_rec_idr[$key3];
                        $sub_rec_id = $sub_rec_idr['RecordId'];
                        ?>

                    <div class="col-md-11 col-xs-12 subrec">
                        <input type="checkbox" name="sub_record_id[]" class="rec_id_arr" value="<?= $sub_rec_id ?>">
                        <label><?= $key_value1 ?> | <?= $key_value2 ?> | <?= $key_value3 ?></label>
                    </div>
                    <div class="col-md-11 col-md-offset-1 col-xs-12">
                        <?php if (count($sub_files ?? [])) {
                            for (
                                $i = 0;
                                $i <= count($sub_files ?? []) - 1;
                                $i++
                            ) {
                                if ($sub_files[$i]['RecordId'] == $sub_rec_id) {

                                    $label = $sub_files[$i]['Notes'];
                                    $doc_id = $sub_files[$i]['DocumentId'];
                                    $path = $sub_files[$i]['DocumentPath'];
                                    $filename = $sub_files[$i]['filename'];
                                    if (empty($filename)) {
                                        $filename = explode('-', $path);
                                        $filename = $filename[1];
                                    }
                                    ?>
                        <div class="attchdocuments">
                            <input type="checkbox" name="document_id[]" class='' id="document_id_arr" value="<?= $doc_id ?>">
                            <a href="./docviewer?fid=<?= $doc_id ?>" target="_blank" title='View / Download File'><span class="files"> <?= !empty(
    $label
)
    ? $label
    : $filename ?> </span></a>
                        </div>
                        <?php
                                }
                            }
                        } ?>
                    </div><?php
                    } ?>
                </div>
                <div class="form-group">
                    <span class='attchdocuments files' style="width:98%">
                        Please enter the emails separated with space
                    </span>
                </div>
                <div class="form-group">
                    <input type="hidden" name="selective_attach" value="1">
                    <input type="hidden" name="record_type_id" value="<?= $recTypeId ?>">
                    <input type="hidden" name="ids" value="<?= $data[
                        'RecordId'
                    ] ?>">
                    <input type="hidden" name='module' value="<?= $modName ?>">
                    <label class="control-label col-sm-3 hidden-xs" for="email">Enter Emails:</label>
                    <div class="col-sm-9 col-xs-12">
                        <textarea class="form-control tag-input" name='email_list' id="email_list" placeholder="Enter Emails"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3 hidden-xs" for="message">Enter Message:</label>
                    <div class="col-sm-9 col-xs-12">
                        <textarea class="form-control" name='addtext' id="emailBody" placeholder="Enter Email Body"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <button type="submit" class="btn btn-primary">Send</button>
                        <button type="reset" class="btn btn-default" id="reset">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class='row content'>
        <div class="col-sm-8 col-xs-12 left_wrapper">
            <?php
            $record_id = $data['RecordId'];
            unset($data['_id']);
            unset($data['UserId']);
            unset($data['RecordId']);
            unset($data['RecordId1']);
            unset($data['filename']);
            foreach ($data as $label => $fieldDetails) {
                $na = 'NA'; ?>
            <div class="col-sm-12 col-xs-12 metadata">
                <span class="col-sm-5 col-xs-5"> <strong><?= $label ?> </strong> <span style="float:right"> : </span> </span>
                <span class="col-sm-7 col-xs-7"> <?= !empty($fieldDetails)
                    ? $fieldDetails
                    : $na ?></span>
            </div>

            <?php
            }
            ?>
            <?php if ($relatedRecTypeId) { ?>
            <div class="sub_records">
                <div class="h4">
                    <span class="pull-left"><?= ucfirst(
                        $tabName,
                    ) ?> Records</span>
                    <span class="pull-right">
                        <button class="btn btn-primary btn-sm" href="#" title="Add new record" onclick="addrelated('<?= $record_id ?>','<?= $recTypeId ?>','<?= strtolower(
    $moduleName,
) ?>')"> Add <i class="fa fa-plus-square" aria-hidden="true"></i> </button>
                    </span>
                </div>
                <?php if ($sub_data != 'failed' && count($sub_data ?? []) > 0) {
                    $constants = get_defined_constants();
                    $headers = json_decode($constants[$tableName], true);
                    $key1 = $headers['subheaders']['key1'];
                    $key2 = $headers['subheaders']['key2'];
                    $key3 = $headers['subheaders']['key3'];
                    for ($i = 0; $i <= count($sub_data ?? []) - 1; $i++) {
                        $rec_id = $sub_data[$i]['RecordId']; ?>
                <div class='sub_rec_wrapper'>
                    <div class="" onclick="sub_view('<?= $recTypeId ?>','<?= $relatedRecTypeId ?>','<?= $rec_id ?>','<?= $record_id ?>','<?= $moduleName ?>')">
                        <div class="sub_rec_title"><?= $sub_data[$i][
                            $key1
                        ] ?></div>
                        <div class="sub_rec_title"><?= $sub_data[$i][
                            $key2
                        ] ?></div>
                        <span> <?= $sub_data[$i][$key3] ?> - (<?= $file_count[
     $i
 ] ?>)</span>
                    </div>
                    <div class="">
                        <a class="pull-right" onclick="subRecDelete('<?= $relatedRecTypeId ?>','<?= $rec_id ?>','<?= $record_id ?>','<?= $moduleName ?>')">
                            <i class="fa fa-trash"></i></a>
                    </div>
                </div>


                <?php
                    }
                } else {
                     ?><div class=''> Related <?= ucfirst(
    $tabName,
) ?> Records not available </div> <?php
                } ?>
            </div>
            <?php } ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <h3> Attachments </h3>
            <?php if (count($files ?? [])) {
                for ($i = 0; $i <= count($files ?? []) - 1; $i++) {

                    $doc_id = $files[$i]['DocumentId'];
                    $label = $files[$i]['Notes'];

                    $path = $files[$i]['DocumentPath'];
                    $filename = $files[$i]['filename'];
                    if (empty($filename)) {
                        $filename = basename($path);

                        $filename = end(explode('-', $filename));
                    }
                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    $file_name = basename($filename, $ext);
                    $file_name = substr($file_name, 0, 15);
                    ?>
            <div class="col-sm-8 col-xs-12 file_wrapper_view">

                <div class="col-sm-4 col-xs-4 ext_type">
                    <?php
                    $images = ['jpg', 'png', 'jpeg', 'gif', ''];
                    if (in_array($ext, $images ?? [])) {
                        $url = base_url() . "web/viewfile?fid=$doc_id&type=png";
                        echo "<img src='$url' alt='$filename;' width='50px' height='50px' style='padding: 2px'>";
                    } else {
                         ?>
                    <?= get_icon($ext) ?>
                    <?php
                    }
                    ?>
                </div>
                <div class='col-sm-8 col-xs-8 filename'>
                    <input type="hidden" name="fileids[]" id="fname" value="<?= !empty(
                        $label
                    )
                        ? $label
                        : ucfirst($filename) ?>">
                    <span>
                        <?= !empty($label)
                            ? $label
                            : ucfirst($file_name . '.' . $ext) ?>
                    </span>
                </div>
                <a href="./docviewer?fid=<?= $doc_id ?>&type=<?= strtolower(
    $ext,
) ?>" target="_blank" class="downloadpop1"><i class="fa fa-download"></i>
                    <?= $ext == 'jpeg' ||
                    $ext == 'png' ||
                    ($ext = 'jpg' || $ext == 'pdf' || $ext == 'gif')
                        ? 'View'
                        : 'Download' ?> </a>
            </div>
            <?php
                }
            } else {
                echo 'Files not found';
            } ?>

        </div>
    </div>
</div><!-- row end -->


<script type="text/javascript">
    function getedit(id, refer_id, module) {
        $.ajax({
            type: "POST",
            url: "../web/editrecord",
            data: {
                rid: id,
                page_refer_id: refer_id,
                module: module
            },
            cache: false,
            async: false,
            success: function(data) {
                $('#body_content').html(data);
                //alert("file downloded successfully "+data);
            }
        });

    }
    $('.fa-download,.filename, .file_wrapper_view').hover(function() {
        var filename = $(this).closest('div').find('input[type=hidden]').attr("value");
        $(this).closest('div').attr("title", filename);
    });
    /* Get add cart page */
    $("#addKart").click(function() {
        var file_count = "<?= count($files ?? []) ?>";
        var sub_file_count = "<?= count($sub_files ?? []) ?>";
        if (file_count > 0 || sub_file_count > 0) {
            getkart('<?= $record_id ?>', '<?= $recTypeId ?>', '<?= strtolower(
    $moduleName,
) ?>', '<?= $sub_type_id ?>');
        } else {
            $("#cart_error").html('<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong style="text-align:center">Oops!</strong> No attachments found.</div>');
        }
    });

    $("#delete_button").click(function() {
        $(".delete_rec").show();
        $('.content').show();
        $(".share_rec").hide();
        $(".colaborate_rec").hide();
        data_reset();
    });
    $("#collaboration_rec").click(function() {
        $('.content').hide();
        $(".share_rec").hide();
        $(".delete_rec").hide();
        $(".colaborate_rec").show();
        data_reset();
    });
    $("#share_button").click(function() {
        $('.content').hide();
        $(".share_rec").show();
        $(".delete_rec").hide();
        $(".colaborate_rec").hide();
        data_reset();
    });
    $("#deleteForm").submit(function(e) {
        e.preventDefault();
        if ($('#captcha').val() == "") {
            validate('captcha', 'Enter Cpatcha');
        } else {
            var data = new FormData(this);
            $.ajax({
                type: "POST",
                url: "../web/deleteRecord",
                data: data,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data == 'failed') {
                        $('#msg').html('Invalid Captcha!. Enter Valid Captcha.');
                        $('#error').show();
                    } else if (data == 'success') {
                        $('#error').removeClass('alert-danger');
                        $('#error').addClass('alert-success');
                        $('#msg').html('<i class="fa fa-thumbs-up-o"></i> Record successfully deleted. Redirecting <i class="fa fa-spinner fa-spin"></i>');
                        $('#error').show();
                        $('.content').hide();
                        setTimeout(function() {
                            rec_count();
                            getVal('<?= $recTypeId ?>', '<?= $moduleName ?>');
                        }, 4000);
                    }
                }
            });
        }
    });
    /* collaborate form submit */

    $("#coloborateForm").submit(function(e) { //console.log($('#coloborate_list').val());
        e.preventDefault();
        var coloborate_list = $('#coloborate_list').val();
        if (coloborate_list == '') {
            validate("coloborate_list", "");
            $("#share_collaboration").html('Email filed should not be empty');
            $("#error_collaboration").show();
        } else if (checkemail(coloborate_list) == 'failed') {
            console.log('Please enter valid email');
            validate("coloborate_list", "");
            $("#share_collaboration").html('Please enter valid email');
            $("#error_collaboration").show();
        } else {
            $("#error_collaboration").hide();
            var data = new FormData(this);
            $.ajax({
                type: "POST",
                url: "../web/collaboraterecord",
                data: data,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data != 'success') {
                        $('#share_collaboration').html(data);
                        $('#error_collaboration').show();
                    } else if (data == 'success') {
                        $('#error_collaboration').removeClass('alert-danger');
                        $('#error_collaboration').addClass('alert-success');
                        $('#share_collaboration').html('<i class="fa fa-thumbs-up"></i> Record shared successfully... <i class="fa fa-spinner fa-spin"></i>');
                        $('.form-horizontal').hide();
                        $('#error_collaboration').show();
                        setTimeout(function() {
                            displayView("<?= $recTypeId ?>", "<?= $record_id ?>", "<?= $moduleName ?>", "<?= $sub_type_id ?>")
                        }, 3000);
                    }
                    //resetform();
                }
            });
        }
    });
    /*collaboration form end*/
    /* Email form submit */

    $("#emailForm").submit(function(e) { //console.log($('#email_list').val());
        e.preventDefault();
        var emaillist = $('#email_list').val();
        if (emaillist == '') {
            validate("email_list", "");
            $("#msg_mail").html('Email filed should not be empty');
            $("#error_mail").show();
        } else if (checkemail(emaillist) == 'failed') {
            console.log('Please enter valid email');
            validate("email_list", "");
            $("#msg_mail").html('Please enter valid email');
            $("#error_mail").show();
        } else {
            $("#error_mail").hide();
            var data = new FormData(this);
            $.ajax({
                type: "POST",
                url: "../web/mailRecord",
                data: data,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data != 'success') {
                        $('#msg_mail').html(data);
                        $('#error_mail').show();
                    } else if (data == 'success') {
                        $('#error_mail').removeClass('alert-danger');
                        $('#error_mail').addClass('alert-success');
                        $('#msg_mail').html('<i class="fa fa-thumbs-up"></i> Mails sent successfully... <i class="fa fa-spinner fa-spin"></i>');
                        $('.form-horizontal').hide();
                        $('#error_mail').show();
                        setTimeout(function() {
                            displayView("<?= $recTypeId ?>", "<?= $record_id ?>", "<?= $moduleName ?>", "<?= $sub_type_id ?>")
                        }, 3000);

                    }

                }
            });

        }

    });

    $('#academic').removeClass('active');
    $('#professional').removeClass('active');
    $('#personal').removeClass('active');
    $('#health').removeClass('active');
    $('#financial').removeClass('active');
    $('#legal').removeClass('active');
    $('#<?= $modName ?>').addClass('active');
    $('#err_close').click(function() {
        $('#error').css({
            "display": "none"
        });
    });
    $("#del_close, #share_close").click(function() {
        $(".content").show();
        $("#share_rec").hide();
        $("#delete_rec").hide();
        data_reset();
    });

    function data_reset() {
        $("#error").hide();
        $("#error_mail").hide();
        $('input[type="text"], textarea').val("");
        $('input[type="checkbox"]').prop('checked', false);
        $("input,textarea").css({
            "border": "1px solid #ccc",
            "background": "#f9f9f9",
            "box-shadow": "inset 0 1px 1px rgba(0,0,0,.075)",
            "transition": "border-color ease-in-out .15s,box-shadow ease-in-out .15s"
        });
    }

    function sub_view(mainmod_id, related_type_id, recId, parent_recId, module) {
        $.ajax({
            type: 'POST',
            url: '../web/relatedview',
            data: {
                module: module,
                modid: related_type_id,
                main_modid: mainmod_id,
                rid: recId,
                ParentId: parent_recId
            },
            cache: false,
            async: false,
            success: function(data) {
                $('#body_content').html(data);
            }

        });
    }

    function addrelated(recId, modid, mod) {
        $.ajax({
            type: 'POST',
            url: '../web/addrelated',
            data: {
                module: mod,
                mod_id: modid,
                r_id: recId
            },
            cache: false,
            async: false,
            success: function(data) {
                $('#body_content').html(data);
            }

        });
    }

    function subRecDelete(related_type_id, sub_recId, parent_recId, mod) {
        $.ajax({
            type: "POST",
            url: "../web/deleteSubRecord",
            data: {
                rec_id: sub_recId,
                module: mod,
                rel_type_id: related_type_id,
                p_rid: parent_recId
            },
            cache: false,
            async: false,
            success: function(data) {
                if (data == 'success') {
                    displayView('<?= $recTypeId ?>', '<?= $record_id ?>', '<?= $moduleName ?>', '<?= $relatedRecTypeId ?>');
                }
            }
        });
    }
</script>
<script>
    $(function() {
        // var data1 = [{"Email":"dog"},{"Email":"cat","Email":"fish"},{"Email":"catfish"},{"Email":"dogfish"}]; console.log(data1);
        var data = < ? = $email ? > ;
        // Instantiate the Bloodhound suggestion engine
        var tags = new Bloodhound({
            datumTokenizer: function(d) {
                return Bloodhound.tokenizers.whitespace(d.Email);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: $.map(data, function(list) {
                return {
                    Email: list
                };
            })
        });

        tags.initialize();

        // Set up an on-screen console for the demo
        var screenConsole = $('#console');

        // Write callback data to the screen when tags are added or removed in demo inputs
        var logCallbackDataToConsole = function(added, removed) {
            screenConsole.append('Tag Data: ' + (this.val() || null) + ', Added: ' + added + ', Removed: ' + removed + '\n');
        };

        // Create typeahead-enabled tag inputs
        $('.tag-input').tagInput({
            // tags separator
            tagDataSeparator: ',',

            allowDuplicates: false,
            typeahead: true,
            typeaheadOptions: {
                highlight: true
            },
            typeaheadDatasetOptions: {
                display: function(d) {
                    return d.Email;
                },
                source: tags.ttAdapter()
            },
            onTagDataChanged: logCallbackDataToConsole
        });

        // Create basic tag inputs with no typeahead
        $('.tag-input-basic').tagInput({
            onTagDataChanged: logCallbackDataToConsole
        });

        $('#results a[rel="external"]').attr('target', '_blank');

    });
</script>
<style>
    .mab-jquery-taginput input {
        height: 30.984375px !important;
        border: none !important;
        width: 17em !important;
        box-shadow: none !important;
        background: white !important;
        padding: 0px !important;
        margin: 0px !important;
    }

    .tag-input {
        height: 96px !important;

    }

    .delete_rec,
    .share_rec,
    .colaborate_rec {
        display: none;
        padding: 0px 0 20px 0px;
        background: #f6f6f6;
        border: 1px solid #eee;
        margin-top: 10px;
        margin-bottom: 20px;
        width: 100%;
        float: left;
    }

    .delete_rec .top_text,
    .colaborate_rec .top_text,
    .share_rec .top_text {
        float: left;
        background: skyblue;
        width: 100%;
        margin-top: 0;
        padding: 3px;
    }

    .delete_rec .top_text span,
    .share_rec .top_text span,
    .colaborate_rec .top_text span {
        padding: 4px 3px 2px 12px;
        float: left;
        width: 90%;
    }

    .content {
        margin-bottom: 15px;
    }

    .metadata {
        margin: 20px 10px 10px 30px;
    }

    .left_wrapper {
        background: #f0f0f0;
        padding-bottom: 30px;
    }

    .center_wrapper {
        margin-left: 2%;
        width: 98%;
    }

    .ext_type {
        padding: 10px;
    }

    .ext_type i {
        color: #466e90;
    }

    .filename {
        padding: 0;
        display: table;
    }

    .filename span {
        display: table-cell;
        vertical-align: middle;
        width: 100%;
        height: 70px
    }

    .file_wrapper_view {
        height: 83px;
        position: relative;
        padding: 0;
        border-bottom: 1px solid #eee;
        margin-bottom: 5px;
    }

    a.downloadpop1 {
        position: absolute;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
        background: #466e90;
        z-index: 5;
        color: #fff;
        text-align: center;
        line-height: 70px;
        font-size: 20px;
        transition: all 0.3s;
        display: none;
        text-decoration: none;
    }

    a.downloadpop1 i {
        font-size: 30px;
        padding-right: 10px;
        line-height: 70px;
    }

    .file_wrapper_view:hover a.downloadpop1 {
        display: block;
        transition: all 0.3s;
    }

    .fa-download:hover {
        background: none;
    }

    .file_wrapper_view:hover {
        background: #f0f0f0;
    }

    .captcha {
        width: 100%;
        float: left;
        padding: 5px;
        background: #063f73;
        color: #fff;
        text-align: center;
        font-weight: 700;
        font-size: 30px;
    }

    .err_close {
        cursor: pointer;
        text-decoration: none;
        font-weight: 700;
    }

    .delete_body {
        padding: 15px 30px;
        float: left;
        width: 100%;
    }

    .modal-footer {
        border-top: none;
    }

    .pad {
        padding-top: 20px;
    }

    .files {
        background: #555;
        padding: 5px 10px;
        margin: 5px;
        color: #fff;
    }

    .attchdocuments {
        margin: 5px;
        float: left;
    }

    a:hover {
        text-decoration: none;
    }

    .sub_records {
        float: left;
        margin: 5px 0;
        width: 100%;
        background: #F9f9f9;
        padding: 5px 5px 14px 12px;
    }

    .sub_records .h4 {
        color: #000;
        border-bottom: 1px solid #ccc;
        padding: 4px 0;
        float: left;
        width: 100%;
    }

    .sub_rec_wrapper {
        padding: 2px 7px;
        background: #2a5892;
        width: 31.5%;
        color: #fff;
        cursor: pointer;
        margin: 3px 5px;
        float: left;
    }

    @media only screen and (max-width :767px) {
        .metadata {
            margin: 10px 0px;
        }

        .center_wrapper {
            background: #fff;
            margin-left: 0px;
            width: 100%;
        }

        .right-icons {
            padding-left: 0px;
        }

        .sub_rec_wrapper {
            width: 46%;
        }
    }

    .sub_rec_title {
        height: 20px;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }

    .sub_records .fa-trash {
        color: salmon;
    }
</style>

<?php function get_icon($ext)
{
    switch ($ext) {
        case 'jpeg':
            echo '<i class="fa fa-file-image-o fa-4x" aria-hidden="true"></i>';
            break;
        case 'png':
            echo '<i class="fa fa-file-image-o fa-4x" aria-hidden="true"></i>';
            break;
        case 'jpg':
            echo '<i class="fa fa-file-image-o fa-4x" aria-hidden="true"></i>';
            break;
        case 'doc':
            echo '<i class="fa fa-file-word-o fa-4x" aria-hidden="true"></i>';
            break;
        case 'docx':
            echo '<i class="fa fa-file-word-o fa-4x" aria-hidden="true"></i>';
            break;
        case 'pdf':
            echo '<i class="fa fa-file-pdf-o fa-4x" aria-hidden="true"></i>';
            break;
        case 'xls':
            echo '<i class="fa fa-file-excel-o fa-4x" aria-hidden="true"></i>';
            break;
        case 'xlsx':
            echo '<i class="fa fa-file-excel-o fa-4x" aria-hidden="true"></i>';
            break;
        case 'ppt':
            echo '<i class="fa fa-file-powerpoint-o fa-4x" aria-hidden="true"></i>';
            break;
        case 'pptx':
            echo '<i class="fa fa-file-powerpoint-o fa-4x" aria-hidden="true"></i>';
            break;
        case 'txt':
            echo '<i class="fa fa-file-text-o fa-4x" aria-hidden="true"></i>';
            break;
        case 'zip':
            echo '<i class="fa fa-file-archive-o fa-4x" aria-hidden="true"></i>';
            break;
        case 'rar':
            echo '<i class="fa fa-file-archive-o fa-4x" aria-hidden="true"></i>';
            break;
        default:
            echo '<img src="https://png.icons8.com/binary-file-filled/ios7/50/000000">';
    }
}

?>
