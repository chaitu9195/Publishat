<script>
    $('#academic').removeClass('active');
    $('#professional').removeClass('active');
    $('#personal').removeClass('active');
    $('#health').removeClass('active');
    $('#financial').removeClass('active');
    $('#legal').removeClass('active');
    $('#<?= $moduleName ?>').addClass('active');
    $('#uploadFile').change(function() {
        var file = $(this).attr("id");
        var labelname = $(this).val().replace(/C:\\fakepath\\/i, '');
        var label = $("#uploadedfile_tag").val(labelname);
        var Upgraded = '<?= $Upgraded ?>';
        fileutils(file, Upgraded);
    });

    function pickCalender(id) {
        $("#" + id).datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
        }).datepicker("show");
    }
    $("#documentForm").submit(function(e) {
        e.preventDefault();
        var ids = $('.required').map(function() {
            return $(this).attr('id');
        });
        for (var i = 0; i < ids.length; i++) {
            var field = ids[i];
            var fieldvalue = $("#" + field).val();
            if (fieldvalue == "" || fieldvalue == undefined) {
                $("#" + field).focus();
                $("#" + field).css({
                    "border": "1px red solid",
                    "background": "#ffe6e5"
                });
                $("#error").show();
                var label = $("#" + field).closest("div").find("label").text();
                var fieldtype = $("#" + field).attr('type');
                var msg = label + " should not be blank";
                $("#msg").html(msg);
                return false;
            }
        }
        var Upgraded = '<?= $Upgraded ?>';
        if ($("#uploadFile").val() != "" && fileutils("uploadFile", Upgraded) != "success") {

            fileutils("uploadFile", Upgraded);
            return false;
        }
        $("#error").hide();
        $("input,select").css({
            "border": "1px solid #ccc",
            "background": "#f9f9f9",
            "box-shadow": "inset 0 1px 1px rgba(0,0,0,.075)",
            "transition": "border-color ease-in-out .15s,box-shadow ease-in-out .15s"
        });
        $("#sub").hide();
        $("#load").html('Submitting <i class="fa fa-spinner fa-spin"></i>');
        if ($("#uploadFile").val()) {
            $('#loader-icon').show();
            $("#load").html('Uploading <i class="fa fa-spinner fa-spin"></i>');
            $(this).ajaxSubmit({
                url: "../web/addSubRecord",
                beforeSubmit: function() {
                    $("#progress-bar").width('0%');
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    $("#progress-bar").width(percentComplete + '%');
                    $("#progress-bar").html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:100%"> <span id="statusmsg">Uploaded Successfully (' + percentComplete + '%)</span></div></div>');
                },
                success: function(data) {
                    $("#statusmsg").html("(100%) Uploaded Successfully");
                    $("#load").html('Inserted <i class="fa fa-check"></i>');
                    $('#msg1').html("Successfully Inserted. Redirecting <i class='fa fa-spinner fa-spin'></i>");
                    $("#success").show();
                    setTimeout(function() {
                        displayView("<?= $main_record_type_id ?>", "<?= $recordId ?>", "<?= $modName ?>", "<?= $record_type_id ?>");
                    }, 3000);
                },
                resetForm: true
            });
            return false;
        } else {
            var data = new FormData(this);
            $.ajax({
                type: 'POST',
                url: '../web/addSubRecord',
                data: data,
                processData: false,
                contentType: false,
                success: function(result) {
                    $("#load").html('Inserted <i class="fa fa-check"></i>');
                    $("#msg1").html("Successfully Inserted. Redirecting <i class='fa fa-spinner fa-spin'></i>");
                    $("#success").show();
                    setTimeout(function() {
                        displayView("<?= $main_record_type_id ?>", "<?= $recordId ?>", "<?= $modName ?>", "<?= $record_type_id ?>");
                    }, 3000);
                }
            });
        }
    });

    function displayView(mod_id, id, mod, related_type_id) {
        $.ajax({
            type: "POST",
            url: "../web/displayView",
            data: {
                modid: mod_id,
                rid: id,
                module: mod,
                rel_type_id: related_type_id
            },
            cache: false,
            async: false,
            success: function(data) {

                $('#body_content').html(data);
            }
        });
    }
    $('#view_file,.folder_img').click(function() {
        var checkbox = $(this).closest('div').find('input[type=checkbox]');
        checkbox.prop("checked", !checkbox.prop("checked"));
        $(this).closest('div').toggleClass("folder_img_border");
        return false;
    }).dblclick(function() {
        var url = $(this).attr('href');
        window.open(url, '_blank');
        return false;
    });
    $('#view_file,.folder_img').hover(function() {
        var filename = $(this).closest('div').find('input[type=hidden]').attr("value");
        $(this).closest('div').attr("title", filename);
    });
    $("#hide_error").click(function() {
        $("#error").hide();
    });

    document.title = "New Record | <?= $tabName ?> | <?= ucfirst($moduleName) ?> | Publishat";
    $('.doc_id').click(function(e) {
        e.stopPropagation();

    });

    function viewfile(path) {
        window.open(path);
    }
</script>