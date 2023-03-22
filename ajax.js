jquery(document).ready(function ($) {
  $("#submit").click(function () {
    $.ajax({
      type: "POST",
      url: em_ajax_url.ajax_url,
      data: {
        action: "my_email",
        email: email_id,
      },
      success: function (response) {
        $("#submit").html(response);
      },
    });
  });
});
