<div class="row">
    <div class="left-heading col-md-6">
        <span class="hidden-xs pull-left">
            <i class="fa fa-cog fa-2x" aria-hidden="true"></i>
            <span class="h3">Account Settings</span>
        </span>
        <span class="visible-xs pull-left">
            <i class="fa fa-cog fa-2x" aria-hidden="true"></i>
            <span class="h4">Account Settings</span>
        </span>
    </div>
</div>
<div class="row">
    <div class="alert alert-dismissable" id="error" style="display:none">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong id="msg"></strong>
    </div>
</div>
<div class="row">
    <table cellpadding="4" cellspacing="0" class="col-xs-12 col-md-10 col-md-offset-1 ">
        <tr>
            <td>
                <div></div>
                <!--Tabs more Start-->
                <ul id="myTab" class="nav nav-tabs">
                    <li id="s_academic" class="m_title active"><a class="h_title" id="academic">Academic Records</a></li>
                    <li id="s_professional" class="m_title"><a class="h_title" id="professional">Professional Records</a></li>
                    <li id="s_personal" class="m_title"><a class="h_title" id="personal">Personal Records</a></li>
                    <li id="s_health" class="m_title"><a class="h_title" id="health">Health Records</a></li>
                    <li id="s_financial" class="m_title"><a class="h_title" id="financial">Financial Records</a></li>
                    <li id="s_legal" class="m_title"><a class="h_title" id="legal">Legal Records</a></li>
                </ul>
            </td>
        </tr>
    </table>
</div>
<form name="settings_form" method="post" action="#" id="settings_form">
    <div class="row" id="settings_content">

        <table cellpadding="4" cellspacing="0" class="col-xs-12 col-md-8 col-md-offset-2 ">
            <tr align="center">
                <td colspan="2">Show / Hide your Academic Records Settings you do like to update/upload.</td>
            </tr>
            <tr align="center">
                <td colspan="2"><input type="hidden" name="module" id="set_mod" value="<?= $module ?>"> </td>
            </tr>
            <?php foreach ($settings as $row) {
        $checked = $row['SettingValue'] == 'Y' ? 'checked="checked"' : ''; ?>
            <tr>
                <td width="33%" align="right">
                    <input name="account_setting_id[]" id="account_setting_id_arr" type="checkbox" value="<?= $row[
                            'AccountSettingId'
                        ] ?>" <?= $checked ?>>
                </td>
                <td width="67%" align="left">
                    <div class=""><?= $row['Setting'] ?></div>
                </td>
            </tr>
            <?php
    } ?>
            <tr>
                <td width="67%" align="right">
                </td>
                <td width="67%" align="left">
                    <input name="save" id="setting_save" type="submit" value="Save" class="btn btn-primary">
                </td>
            </tr>
        </table>

    </div>
</form>
<!--
<div class="container">
 
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
    <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
    <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
    <li><a data-toggle="tab" href="#menu3">Menu 3</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3>HOME</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
    <div id="menu1" class="tab-pane fade">
      <h3>Menu 1</h3>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div id="menu2" class="tab-pane fade">
      <h3>Menu 2</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    <div id="menu3" class="tab-pane fade">
      <h3>Menu 3</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
  </div>
</div>
-->


<script>
    $(".h_title").click(function() {
        var module = $(this).prop("id");
        getsettings_data(module);
        $(".m_title").removeClass("active");
        $("#s_" + module).addClass("active");
    });

    function getsettings_data(module) {
        $.ajax({
            type: 'POST',
            url: '../web/getsettings_data',
            data: {
                module: module
            },
            cache: false,
            async: false,
            success: function(data) {
                $('#settings_content').html(data);
            }
        });

    }
    $("#settings_form").submit(function(e) {
        e.preventDefault();
        var module = $("#set_mod").val();
        var data = new FormData(this);
        $.ajax({
            type: "POST",
            url: "../web/updateSettings",
            data: data,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data != 'success') {
                    $('#error').addClass('alert-danger');
                    $('#error').removeClass('alert-success');
                    $('#msg').html('<i class="fa fa-thumbs-down"></i> Oops! Something went wrong. try again... ');
                    $('#error').show();
                } else if (data == 'success') {
                    $('#msg').html('<i class="fa fa-thumbs-up"></i> Your account settings have been saved... <i class="fa fa-spinner fa-spin"></i>');
                    $('#error').removeClass('alert-danger');
                    $('#error').addClass('alert-success');
                    $('#error').show();
                    setTimeout(function() {
                        window.location = "records"; /* getsettings_data(module); $('#error').hide(); */
                    }, 4000);
                    /*   
                       $('#msg_mail').html('<i class="fa fa-thumbs-up"></i> Mails sent successfully... <i class="fa fa-spinner fa-spin"></i>');
                       $('.form-horizontal').hide();
                       $('#error_mail').show();
                       setTimeout( function() { //getsettings_data(module);  } , 4000);*/
                }
                //resetform();
            }
        });

    });
</script>

<style>
    .h_title {
        padding: 10px 20px;
        font-weight: 500;
        font-size: 15px;
    }

    td,
    th {
        padding: 3px;
        font-size: 15px;
        width: 60px;
    }
</style>