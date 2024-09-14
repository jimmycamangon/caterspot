$(document).ready(function () {
  // When a catering name is selected, fetch the corresponding email
  $('#cater_name').on('change', function () {
      var cateringName = $(this).val();

      if (cateringName) {
          $.ajax({
              url: 'functions/fetch-email.php',
              type: 'POST',
              data: { cater_name: cateringName },
              success: function (response) {
                  // Populate the email input with the returned value
                  $('#email').val(response);
                  $('#email').prop('disabled', false); // Enable the email field
              },
              error: function (xhr, status, error) {
                  console.error('Error fetching email:', error);
              }
          });
      }
  });

  // Add client logic
  $("#Addclient").click(function () {
      var cater_name = $("#cater_name").val();
      var email = $("#email").val();
      var password = $("#password").val();

      if (cater_name && email && password) {
          $.ajax({
              url: "functions/add-clients.php",
              method: "POST",
              data: {
                  cater_name: cater_name,
                  email: email,
                  password: password
              },
              dataType: "json",
              success: function (data) {
                  if (data.msg) {
                      $("#message").html('<div class="alert alert-danger">' + data.msg + '</div>');
                  } else if (data.success) {
                      Toastify({
                          text: data.success,
                          backgroundColor: "rgba(31, 166, 49, 0.8)"
                      }).showToast();
                      setTimeout(function () {
                          window.location.href = "clients.php";
                      }, 1000);
                  }
              },
              error: function (xhr, status, error) {
                  console.error('Error:', error);
              }
          });
      } else {
          $("#message").html('<div class="alert alert-danger">All fields are required</div>');
      }
  });
});
