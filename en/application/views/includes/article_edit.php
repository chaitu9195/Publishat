<html>

    <head>
        <script type="text/javascript" src="../assets/js/editor.js"></script>
        <link rel="stylesheet" href="../assets/css/editor.css">

        <style>
            .test {
                padding: 24px;
            }

            .header {
                padding: 11px;
                font-size: 20px;
                border-radius: 4px;
                height: 46px;
            }

            .head {
                width: 65% !important;
            }

            .write_article {
                border: 1px solid rgb(152, 160, 175);
                padding: 12px;
                border-radius: 20px;
                color: #337ab7
            }

            .article {
                text-decoration: none;
                padding: 10px;
            }

            .image {
                width: 30%;
                position: absolute;
                padding: 6px;
                margin: 3px;
                opacity: 0;
            }

            .img_ico {
                border: 1px solid rgb(152, 160, 175);
                width: 32%;
                padding: 11px;
                border-radius: 20px;
                position: absolute;
                color: #337ab7;
            }

            .post_article {
                border-radius: 10px;
                background-color: #0084bf;
                border: none;
                color: white;
                width: 16%;
                padding: 6px;
            }

            .text_content {
                width: 100%;
                height: 85% !important;
                resize: none;
                padding: 20px;
            }

            .content_div {
                height: 384px;
            }

            .share_article {
                font-size: 20px;
                border-bottom: 1px solid rgb(222, 224, 230);
            }

            .Editor-container {
                width: 97% !important;
            }

            .desc img {
                width: 60% !important;
            }

            .modal-body .Editor-container {
                width: 89% !important;
            }
        </style>
    </head>

    <body>
        <?php foreach ($data as $articleinfo) {

            $id = $articleinfo['id'];
            $userid = $articleinfo['UserId'];
            $imagepath = $articleinfo['ArticleImage'];
            $articledes = $articleinfo['ArticleDescription'];
            $art_heading = $articleinfo['ArticleHeading'];
            $art_url = $articleinfo['ArticleUrl'];
            ?>
        <script>
            $(document).ready(function() {
                $("#txtEditor<?= $id ?>").Editor();
                $("#txtEditor<?= $id ?>").Editor("setText", '<?php echo $articledes; ?>');

                $("#articles_data<?= $id ?>").submit(function(e) {
                    e.preventDefault();
                    var text = $("#txtEditor<?= $id ?>").Editor("getText");
                    var data = new FormData($('#articles_data<?= $id ?>')[0]);
                    data.append('ArticleDescription', text);
                    $.ajax({
                        type: 'POST',
                        url: '../web/article_update',
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function(result) {
                            $('#body_content').html(result);
                        }

                    });

                });
            });
        </script>
        <form method="post" action="#" enctype="multipart/form-data" id="articles_data<?= $id ?>">
            <!--<div class="col-md-12 content_div">
 <span class="col-md-12 share_article">Share An Article</span>
 <input type="text" name="articleHeading" class="col-md-12" id="article_heading" placeholder="Write An Article Title Here">
<textarea placeholder="Write An Article Description Here..." class="text_content" id="txtEditor" name="ArticleDescription"></textarea>
</div>-->
            <input type="hidden" name="id" value="<?= $id ?>">

            <div class="container-fluid">
                <div class="row">
                    <h2 class="demo-text">Update An Article</h2>
                    <div class="col-lg-12 nopadding">
                        <input type="text" class="col-lg-8 header head" name="articleheading" value="<?= $art_heading ?>" placeholder="HeaderLine">
                        <span class="gap">&nbsp;&nbsp;&nbsp;</span>
                        <input type="text" value="<?= $art_url ?>" class="col-lg-4 header" name="articleurl" placeholder="example bigdata or blog etc....">
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 nopadding">
                                <textarea id="txtEditor<?= $id ?>" name="ArticleDescription" class="editor"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 test">
                <div class="col-md-6">
                    <input type="submit" value="Update" class="pull-right post_article">
                </div>
            </div>
        </form>
        <?php
        } ?>
    </body>
    <script>


    </script>

</html>