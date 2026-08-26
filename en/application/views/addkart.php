<div class="center_wrapper">

    <div class="row">
        <div class="left-heading col-md-8 col-xs-6">
            <span class="hidden-xs pull-left">
                <i class="fa fa-cart-plus fa-2x" aria-hidden="true"></i>
                <span class="h3">Add to Cart</span>
            </span>
            <span class="visible-xs pull-left">
                <i class="fa fa-cart-plus fa-2x" aria-hidden="true"></i>
                <span class="h4">Add to Cart</span>
            </span>
        </div>
        <div class="col-md-1 col-md-offset-3"><a href="#" id="goback"> Back </a>
        </div>
    </div>

    <div class="row share_rec" id="share_rec">
        <div class="top_text">
            <span>Add files to Document Cart </span>
        </div>
        <div class="delete_body">
            <div class="alert alert-danger" id="error_mail" style="display:none">
                <div id="msg_mail"> </div>
            </div>
            <form class="form-horizontal col-sm-12 pad" name="cartForm" id='cartForm'>
                <?php if (count($files ?? []) || count($sub_files ?? [])) { ?>
                <div class="form-group">
                    <?php for ($i = 0; $i <= count($files ?? []) - 1; $i++) {

                        $label = $files[$i]['Notes'];
                        $doc_id = $files[$i]['DocumentId'];
                        $path = $files[$i]['DocumentPath'];
                        $filename = $files[$i]['filename'];
                        if (empty($filename)) {
                            $filename = explode('-', $path);
                            $filename = $filename[1];
                        }
                        $filename = substr($filename, 0, 11);
                        $ext = $files[$i]['FileType'];
                        ?>
                    <div class="attchdocuments">
                        <input type="checkbox" name="document_id[]" class='document_id_arr' id="document_id_arr" value="<?= $doc_id ?>">
                        <a href="./viewfile?fid=<?= $doc_id ?>" target="_blank" title='View / Download File'><span class="files"> <?= !empty(
    $label
)
    ? $label
    : ucfirst($filename) ?> </span></a>
                    </div>
                    <?php
                    } ?>
                </div>
                <div class="form-group">
                    <?php for (
                        $i = 0;
                        $i <= count($sub_files ?? []) - 1;
                        $i++
                    ) {

                        $label = $sub_files[$i]['Notes'];
                        $doc_id = $sub_files[$i]['DocumentId'];
                        $path = $sub_files[$i]['DocumentPath'];
                        $filename = $sub_files[$i]['filename'];
                        if (empty($filename)) {
                            $filename = explode('-', $path);
                            $filename = $filename[1];
                        }
                        $filename = substr($filename, 0, 11);
                        $ext = $sub_files[$i]['FileType'];
                        ?>
                    <div class="attchdocuments">
                        <input type="checkbox" name="document_id[]" class='document_id_arr' id="document_ids" value="<?= $doc_id ?>">
                        <a href="./viewfile?fid=<?= $doc_id ?>" target="_blank" title='View / Download File'><span class="files"> <?= !empty(
    $label
)
    ? $label
    : ucfirst($filename) ?> </span></a>
                    </div>
                    <?php
                    } ?>
                </div>


                <div class="form-group">
                    <span class='attchdocuments files' style="width:98%">
                        Please select/enter Document-Cart name
                    </span>
                </div>
                <div class="form-group">
                    <input type="hidden" name="record_type_id" value="<?= $recTypeId ?>">
                    <input type="hidden" name='module' value="<?= $moduleName ?>">
                    <input type="hidden" name='submod' value="<?= $tabName ?>">
                    <label class="control-label col-sm-3 hidden-xs " for="cart"></label>
                    <div class="col-sm-4 col-xs-12">
                        <select class="form-control" name='kartName' id="cartName">
                            <option value="">Select Cart Name</option>
                            <?php foreach ($names as $name) { ?>
                            <option value="<?= $name ?>"><?= $name ?></option>
                            <?php } ?>
                            <option value="addnew"> Add New </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3 hidden-xs" for="message"></label>
                    <div class="col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name='newName' id="addNew" placeholder="Enter new cart name " style="display:none;">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="reset" class="btn btn-default" id="reset">Reset</button>
                    </div>
                </div>
                <?php } else {echo '<br> <h4>Ooops! NO attachments found. Please add files to records then try adding to cart. </h4> <br>';} ?>
            </form>
        </div>
    </div>


    <script>
        $("#cartName").change(function() {
            var cart_name = $(this).val();
            if (cart_name == "addnew") {
                $("#addNew").show();
            } else {
                $("#addNew").hide();
            }
        });

        $("#cartForm").submit(function(e) {
            console.log($('#cartName').val());
            e.preventDefault();
            if ($('#cartName').val() == '') {
                validate("cartName", "");
                $("#msg_mail").html('Select Cart Name');
                $("#error_mail").show();
            } else if ($('#cartName').val() == 'addnew' && $("#addNew").val() == "") {
                validate("addNew", "");
                $("#msg_mail").html('Enter Cart Name');
                $("#error_mail").show();
            } else if ($('input[type="checkbox"]:checked').length == 0) {
                //    	validate("document_id_arr","");
                $("#msg_mail").html('Select atleast one attachment');
                $("#error_mail").show();
            } else {
                $("#error_mail").hide();
                var data = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "../web/saveToCart",
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
                            $('#msg_mail').html('<i class="fa fa-thumbs-up"></i> Files Added to document Cart successfully... <i class="fa fa-spinner fa-spin"></i>');
                            $('.form-horizontal').hide();
                            $('#error_mail').show();
                            setTimeout(function() {
                                dkart();
                            }, 4000);

                        }

                    }
                });

            }
        });
        $("#goback").click(function() {
            displayView("<?= $recTypeId ?>", "<?= $files[0][
    'RecordId'
] ?>", "<?= $moduleName ?>", "");
        });
    </script>

    <style>
        .delete_rec,
        .share_rec {
            padding: 0px 0 20px 0px;
            background: #f6f6f6;
            border: 1px solid #eee;
            margin-top: 10px;
            margin-bottom: 20px;
            width: 100%;
            float: left;
        }

        .delete_rec .top_text,
        .share_rec .top_text {
            float: left;
            background: #3a7f94;
            color: #fff;
            width: 100%;
            margin-top: 0;
            margin-bottom: 8px;
            padding: 3px;
        }

        .delete_rec .top_text span,
        .share_rec .top_text span {
            padding: 4px 3px 2px 12px;
            float: left;
            width: 90%;
        }

        .delete_body {
            margin: 6px 0 0 10px;
            float: left;
            width: 98%;
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
    </style>