$(document).ready(function () {
  alert('hello');
  /* Email form submit */

  $('#submit_popup').on('click', function (e) {
    //console.log($('#email_list').val());
    e.preventDefault();
    $('#error').removeClass('alert-success');
    $('#error').addClass('alert-danger');
    var emaillist = $('#email_list').val().trim();
    if (emaillist == '') {
      validate('email_list', '');
      $('#msg').html('Email filed should not be empty');
      $('#error').show();
    } else if (checkemail(emaillist) == 'failed') {
      validate('email_list', '');
      $('#msg').html('Please enter valid email');
      $('#error').show();
    } else {
      $('#error').hide();
      var data = new FormData('#emailForm');
      $.ajax({
        type: 'POST',
        url: '../web/mailFolderRecord',
        data: data,
        processData: false,
        contentType: false,
        success: function (data) {
          if (data != 'success') {
            $('#msg').html(data);
            $('#error').removeClass('alert-success');
            $('#error').addClass('alert-danger');
            $('#error').show();
          } else if (data == 'success') {
            $('#share_content').hide();
            $('#error').addClass('alert-success');
            $('#error').removeClass('alert-danger');
            $('#msg').html(
              '<i class="fa fa-thumbs-up"></i> Mails sent successfully... <i class="fa fa-spinner fa-spin"></i>',
            );
            $('#error').show();
            $('input[type="text"], textarea').val('');
            $('input,textarea').css({
              border: '1px solid #ccc',
              background: '#f9f9f9',
              'box-shadow': 'inset 0 1px 1px rgba(0,0,0,.075)',
              transition:
                'border-color ease-in-out .15s,box-shadow ease-in-out .15s',
            });
            setTimeout(function () {
              $('#main_content').show();
              $('#delete_content').hide();
              $('#error').hide();
            }, 4000);
          }
          //resetform();
        },
      });
    }
  });
});
