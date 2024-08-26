$(document).ready(function () {
  $("#Addclient").click(function () {
    var cater_name = $("#cater_name").val();
    var email = $("#email").val();
    var password = $("#password").val();

    var client_id = clientId;

    // Make sure all fields are filled
    if (cater_name != "" && email != "" && password != "") {
      $.ajax({
        url: "functions/add-clients.php",
        method: "POST",
        data: {
          cater_name: cater_name,
          email: email,
          client_id: client_id,
          password: password
        },
        dataType: "json",
        success: function (data) {
          if (data.msg) {
            $("#message").html(
              '<div class="alert alert-danger" role="alert">' +
                data.msg +
                "</div>"
            );
          } else if (data.success) {
            Toastify({
              text: data.success,
              backgroundColor: "rgba(31, 166, 49, 0.8)",
            }).showToast();

            setTimeout(function () {
              window.location.href = "clients.php";
            }, 1000);
          }
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        },
      });
    } else {
      $("#message").html(
        '<div class="alert alert-danger" role="alert">All fields are required</div>'
      );
    }
  });
});
