$(document).ready(function () {
  // ============================================================== DESCRIPTION SECTION =================================================================================
  // Save changes button click event
  $("#saveChangesBtn_description").click(function () {
    var client_id = $("#edit_client_id").val();
    var description = $("#description").val();

    if (client_id !== "" && description !== "") {
      // AJAX call to update user
      $.ajax({
        url: "../main/functions/settings-functions/update-description.php",
        method: "POST",
        data: {
          client_id: client_id,
          description: description,
        },
        dataType: "json",
        success: function (data) {
          // Handle success response
          if (data.success) {
            // Display success message
            Toastify({
              text: data.success,
              backgroundColor: "rgba(31, 166, 49, 0.8)",
            }).showToast();

            setTimeout(function () {
              window.location.href = "settings.php";
            }, 1000);
          } else {
            // Display error message
            $("#message_desc").html(
              '<div class="alert alert-danger" role="alert">' +
                data.msg +
                "</div>"
            );
          }
        },
        error: function (xhr, status, error) {
          // Handle AJAX errors
          console.error(xhr.responseText);
        },
      });
    } else {
      // Display a danger alert if any required field is empty
      $("#message_desc").html(
        '<div class="alert alert-danger" role="alert">Cater Description is required</div>'
      );
    }
  });

  // ============================================================== FREQUENTLY ASKED QUESTIONS SECTION =================================================================================

  // FAQ's INSERT
  $("#saveChangesBtn-faq").click(function () {
    var client_id = $("#edit_client_id").val();
    var question = $("#question").val();
    var answer = $("#answer").val();

    if (client_id !== "" && question !== "" && answer !== "") {
      // AJAX call to update user
      $.ajax({
        url: "../main/functions/settings-functions/insert-faq.php",
        method: "POST",
        data: {
          client_id: client_id,
          question: question,
          answer: answer,
        },
        dataType: "json",
        success: function (data) {
          // Handle success response
          if (data.success) {
            // Display success message
            Toastify({
              text: data.success,
              backgroundColor: "rgba(31, 166, 49, 0.8)",
            }).showToast();

            setTimeout(function () {
              window.location.href = "settings.php";
            }, 1000);
          } else {
            // Display error message
            $("#message_faq").html(
              '<div class="alert alert-danger" role="alert">' +
                data.msg +
                "</div>"
            );
          }
        },
        error: function (xhr, status, error) {
          // Handle AJAX errors
          console.error(xhr.responseText);
        },
      });
    } else {
      // Display a danger alert if any required field is empty
      $("#message_faq").html(
        '<div class="alert alert-danger" role="alert">Frequently asked questions and answers are both required.</div>'
      );
    }
  });

  // Edit button click event for FAQ
  $(".edit-faq").click(function () {
    var faq_id = $(this).data("faq-id");

    // Call the fetchfaqDetails function with the faq_id
    fetchfaqDetails(faq_id);

    // Disable all other edit-faq buttons
    $(".edit-faq").not(this).prop("disabled", true);
    $(".edit-faq").not(this).addClass("inactive-btn");
    $(".del-faq").not(this).prop("disabled", true);
    $(".del-faq").not(this).addClass("inactive-btn");

    // Toggle the visibility of the buttons
    $("#saveChangesBtn-faq").hide();
    $("#EditChangesBtn").show();
    $("#newChangesBtn").show();

    // Add border color and focus on the button
    $(this).addClass("active-btn").css("border-color", "#2487ce").focus();
  });

  $(".edit-faqs").click(function () {
    // Remove the border color and focus from the button when clicked again
    $(".edit-faq").removeClass("active-btn").css("border-color", "").blur();
    tinymce.get("question").setContent(""); // Clear question editor
    tinymce.get("answer").setContent(""); // Clear answer editor

    $("#question").val("");
    $("#answer").val("");

    // Clear the flag if the button is clicked again
    isButtonClicked = false;

    // Enable all edit-faq buttons
    $(".edit-faq").prop("disabled", false);
    $(".del-faq").prop("disabled", false);

    // Toggle the visibility of the buttons
    $("#saveChangesBtn-faq").show();
    $("#EditChangesBtn").hide();
    $("#newChangesBtn").hide();
  });

  // Function to fetch FAQ details via AJAX
  function fetchfaqDetails(faqId) {
    // Send an AJAX request to get the FAQ details
    $.ajax({
      url: "../main/functions/settings-functions/get-faq-details.php",
      method: "POST",
      data: { faq_id: faqId }, // Send the faq_id to the server
      dataType: "json",
      success: function (data) {
        // Populate edit modal with faq details
        $("#edit_faq_id").val(data.faq_id); // Set the faq_id in the hidden input field
        $("#answer").val(data.cater_answer);
        $("#question").val(data.cater_question);
        // Set the answer in the TinyMCE editor
        tinymce.get("answer").setContent(data.cater_answer);
        // Set the question in the TinyMCE editor
        tinymce.get("question").setContent(data.cater_question);
      },
      error: function (xhr, status, error) {
        // Handle AJAX errors
        console.error(xhr.responseText);
      },
    });
  }

  // Edit Submission for FAQ
  $("#EditChangesBtn").click(function () {
    var client_id = $("#edit_client_id").val();
    var question = $("#question").val();
    var answer = $("#answer").val();
    var faq_id = $("#edit_faq_id").val();

    if (client_id !== "" && question !== "" && answer !== "" && faq_id !== "") {
      // AJAX call to update user
      $.ajax({
        url: "../main/functions/settings-functions/update-faq.php",
        method: "POST",
        data: {
          client_id: client_id,
          question: question,
          answer: answer,
          faq_id: faq_id,
        },
        dataType: "json",
        success: function (data) {
          // Handle success response
          if (data.success) {
            // Display success message
            Toastify({
              text: data.success,
              backgroundColor: "rgba(31, 166, 49, 0.8)",
            }).showToast();

            setTimeout(function () {
              window.location.href = "settings.php";
            }, 1000);
          } else {
            // Display error message
            $("#message_faq").html(
              '<div class="alert alert-danger" role="alert">' +
                data.msg +
                "</div>"
            );
          }
        },
        error: function (xhr, status, error) {
          // Handle AJAX errors
          console.error(xhr.responseText);
        },
      });
    } else {
      // Display a danger alert if any required field is empty
      $("#message_faq").html(
        '<div class="alert alert-danger" role="alert">Frequently asked questions and answers are both required.</div>'
      );
    }
  });

  // Cancel button click event
  $("#newChangesBtn").click(function () {
    // Remove inactive-btn class from all edit-faq buttons
    $(".edit-faq").removeClass("inactive-btn");
    $(".del-faq").removeClass("inactive-btn");
  });

  $(".del-faq").click(function () {
    var faq_id = $(this).data("faqs-id");
    $("#confirmDeleteBtn").data("faqs-id", faq_id); // Store faq_id in the delete confirmation button
  });
  // Delete FAQ
  // Confirm delete button click event
  $("#confirmDeleteBtn").click(function () {
    var faq_id = $(this).data("faqs-id");

    // AJAX call to delete faq
    $.ajax({
      url: "../main/functions/settings-functions/delete-faq.php",
      method: "POST",
      data: { faq_id: faq_id },
      dataType: "json",
      success: function (data) {
        // Handle success response
        if (data.msg) {
          // Display the message in the #message div
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
            window.location.href = "settings.php";
          }, 1000);
        }
      },
      error: function (xhr, status, error) {
        // Handle AJAX errors
        console.error(xhr.responseText);
      },
    });

    // Hide delete confirmation modal
    $("#deleteConfirmationModal").modal("hide");
  });

  // ============================================================== CONTACT SECTION =================================================================================
  // Save changes button click event
  $("#saveChangesBtn_contact").click(function () {
    var client_id = $("#edit_client_id").val();
    var cater_name = $("#cater_name").val();
    var cater_location = $("#cater_location").val();
    var cater_email = $("#cater_email").val();
    var cater_contactno = $("#cater_contactno").val();
    var cater_gmaplink = $("#cater_gmaplink").val();
    var socmed_link = $("#socmed_link").val();

    if (
      client_id !== "" &&
      cater_name !== "" &&
      cater_location !== "" &&
      cater_email !== "" &&
      cater_contactno !== ""
    ) {
      // AJAX call to update user
      $.ajax({
        url: "../main/functions/settings-functions/update-contact.php",
        method: "POST",
        data: {
          client_id: client_id,
          cater_name: cater_name,
          cater_location: cater_location,
          cater_email: cater_email,
          cater_contactno: cater_contactno,
          cater_gmaplink: cater_gmaplink,
          socmed_link: socmed_link,
        },
        dataType: "json",
        success: function (data) {
          // Handle success response
          if (data.success) {
            // Display success message
            Toastify({
              text: data.success,
              backgroundColor: "rgba(31, 166, 49, 0.8)",
            }).showToast();

            setTimeout(function () {
              window.location.href = "settings.php";
            }, 1000);
          } else {
            // Display error message
            $("#message_contact").html(
              '<div class="alert alert-danger" role="alert">' +
                data.msg +
                "</div>"
            );
          }
        },
        error: function (xhr, status, error) {
          // Handle AJAX errors
          console.error(xhr.responseText);
        },
      });
    } else {
      // Display a danger alert if any required field is empty
      $("#message_contact").html(
        '<div class="alert alert-danger" role="alert">All fields are required.</div>'
      );
    }
  });

  // ============================================================== ABOUT US SECTION =================================================================================

  // Save changes button click event
  $("#saveChangesBtn_about").click(function () {
    var client_id = $("#edit_client_id").val();
    var about_us = $("#about_us").val();

    if (client_id !== "" && about_us !== "") {
      // AJAX call to update user
      $.ajax({
        url: "../main/functions/settings-functions/update-about.php",
        method: "POST",
        data: {
          client_id: client_id,
          about_us: about_us,
        },
        dataType: "json",
        success: function (data) {
          // Handle success response
          if (data.success) {
            // Display success message
            Toastify({
              text: data.success,
              backgroundColor: "rgba(31, 166, 49, 0.8)",
            }).showToast();

            setTimeout(function () {
              window.location.href = "settings.php";
            }, 1000);
          } else {
            // Display error message
            $("#message_about").html(
              '<div class="alert alert-danger" role="alert">' +
                data.msg +
                "</div>"
            );
          }
        },
        error: function (xhr, status, error) {
          // Handle AJAX errors
          console.error(xhr.responseText);
        },
      });
    } else {
      // Display a danger alert if any required field is empty
      $("#message_about").html(
        '<div class="alert alert-danger" role="alert">All fields are required.</div>'
      );
    }
  });

  // ============================================================== BACKGROUND IMAGE SECTION =================================================================================



    // Edit button click event
    $(".edit-bg").click(function () {
      // Retrieve bg from the edit button's data attribute
      bgIdToUpdate = $(this).data("bg-id");
  
    });

    
  // Save changes button click event
  $("#saveChangesBtn_bg").click(function () {
    var client_id = bgIdToUpdate;
    var fileInput = document.getElementById("edit_bg_image");
    var bg_image = "";

    // Check if a file is selected
    if (fileInput.files.length > 0) {
      // Extract only the filename if a file is selected
      bg_image = fileInput.files[0].name;
    }

    // AJAX call to update package
    $.ajax({
      url: "functions/settings-functions/update-bg-image.php",
      method: "POST",
      data: {
        client_id: client_id,
        bg_image: bg_image,
      },
      dataType: "json",
      success: function (data) {
        // Handle success response
        if (data.msg) {
          // Display the error message in the #editMessage div
          $("#editMessage").html(
            '<div class="alert alert-danger" role="alert">' +
              data.msg +
              "</div>"
          );
        } else if (data.success) {
          Toastify({
            text: data.success,
            backgroundColor: "rgba(31, 166, 49, 0.8)",
          }).showToast();

          // package update successful, start image upload
          var formData = new FormData();
          formData.append("file", fileInput.files[0]);
          $.ajax({
            url: "functions/settings-functions/upload-bg-image.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
              setTimeout(function () {
                window.location.href = "settings.php";
              }, 1000);
            },
            error: function (xhr, status, error) {
              console.error(error);
            },
          });
        }
      },
      error: function (xhr, status, error) {
        // Handle AJAX errors
        console.error(xhr.responseText);
      },
    });
  });
});
