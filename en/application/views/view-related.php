<?php
if (strtolower($moduleName) == 'medical') {
    $modName = 'health';
} else {
    $modName = strtolower($moduleName);
} ?>
<div class="center_wrapper">

    <div class="row">
        <div class="left-heading col-md-8 col-xs-6">
            <span class="hidden-xs pull-left">
                <i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i>
                <span class="h3">View <?= $tabName ?></span>
            </span>
            <span class="visible-xs pull-left">
                <i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i>
                <span class="h4">View <?= $tabName ?></span>
            </span>
        </div>


        <div class="right-icons col-xs-offset-0 col-xs-2 col-md-3 col-md-offset-0 pull-left " id="right_icons" style="display:block;">
            <a href="#/page=ug?mode=edit" id='sub_edit' title='Edit marks memo'><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
            <a class="pull-right" href="#/records" title="View Medical Test" onclick="displayView('<?= $mainRecTypeId ?>','<?= $data[
    'ParentRecordId'
] ?>','<?= strtolower($moduleName) ?>','<?= $recTypeId ?>')"> back </a>
        </div>
    </div>
    <div class='row content' id="view_content">
        <div class="col-sm-8 col-xs-12 left_wrapper">
            <?php
            $record_id = $data['RecordId'];
            $parentId = $data['ParentRecordId'];
            unset($data['_id']);
            unset($data['UserId']);
            unset($data['RecordId']);
            unset($data['RecordId1']);
            unset($data['ParentRecordId']);
            foreach ($data as $label => $field) {
                $na = 'NA'; ?>
            <div class="col-sm-12 col-xs-12 metadata">
                <span class="col-sm-5 col-xs-5"> <strong><?= $label ?></strong> <span style="float:right"> : </span> </span>
                <span class="col-sm-7 col-xs-7"> <?= !empty($field)
                    ? $field
                    : $na ?> </span>
            </div>
            <?php
            }
            ?>

        </div>
        <div class="col-sm-4 col-xs-12">
            <h3> Attachments </h3>
            <?php if (safe_count($files ?? [])) {
                for ($i = 0; $i <= safe_count($files ?? []) - 1; $i++) {

                    $doc_id = $files[$i]['DocumentId'];
                    $label = $files[$i]['Notes'];
                    $label = substr_replace($label, '', -7);
                    $path = $files[$i]['DocumentPath'];
                    $filename = $files[$i]['filename'];
                    if (empty($filename)) {
                        $filename = basename($path);
                        $filename = substr(
                            $filename,
                            strpos($filename, '-') + 1,
                        );
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
                        $filesrc = base_url() . 'web/viewfile?fid=' . $doc_id;
                        $ch = curl_init();
                        $timeout = 5;
                        curl_setopt($ch, CURLOPT_URL, $filesrc);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                        $src = curl_exec($ch);
                        curl_close($ch);
                        echo empty($src)
                            ? "<i class='fa " .
                                file_type_fa($ext) .
                                " fa-4x' style='color:#5a6b7b'></i>"
                            : "<img src='data:image/jpg;base64," .
                                base64_encode($src) .
                                "' alt='$filename;' width='100%' style='padding: 2px' onerror=\"this.style.display='none';this.nextElementSibling.style.display='inline-block'\"><i class='fa " .
                                file_type_fa($ext) .
                                " fa-4x' style='display:none;color:#5a6b7b'></i>";
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
                echo '<br>Files not found<br><br>';
            } ?>

        </div>
    </div>


</div><!-- center wrapper end -->


<script type="text/javascript">
    $('#academic').removeClass('active');
    $('#professional').removeClass('active');
    $('#personal').removeClass('active');
    $('#health').removeClass('active');
    $('#financial').removeClass('active');
    $('#legal').removeClass('active');
    $('#<?= $modName ?>').addClass('active');
    document.title = 'View Sub Test Record | Medical Test | Health | Publishat';
    $('.fa-download,.filename,.file_wrapper_view').hover(function() {
        var filename = $(this).closest('div').find('input[type=hidden]').attr("value");
        $(this).closest('div').attr("title", filename);
    });
    $("#sub_edit").click(function() {
        var id = '<?= $record_id ?>'
        var pid = '<?= $parentId ?>'
        var type_id = '<?= $recTypeId ?>';
        var p_type_id = '<?= $mainRecTypeId ?>';
        var module = '<?= strtolower($moduleName) ?>';
        $.ajax({
            type: "POST",
            url: "../related/editrecord",
            data: {
                rid: id,
                page_refer_id: type_id,
                module: module,
                p_type_id: p_type_id,
                parentId: pid
            },
            cache: false,
            async: false,
            success: function(data) {
                $('#body_content').html(data);
                //alert("file downloded successfully "+data);
            }
        });

    });

    function resetform() {
        $("input, select, textarea").val("");
        $('#error_mail').hide();
        $("#error").hide();
        $("input,select,textarea").css({
            "border": "1px solid #ccc",
            "background": "#f9f9f9",
            "box-shadow": "inset 0 1px 1px rgba(0,0,0,.075)",
            "transition": "border-color ease-in-out .15s,box-shadow ease-in-out .15s"
        });

    }
</script>

<style>
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
        width: 25%;
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
            echo '<i class="fa fa-file-file-o fa-4x" aria-hidden="true"></i>';
    }
}

?>
