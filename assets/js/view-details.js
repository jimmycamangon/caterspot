document.addEventListener("DOMContentLoaded", function () {
  var location = document.getElementById("location").value.trim();
  var contactNumber = document.getElementById("contact_number").value.trim();

  if (location === "" || contactNumber === "") {
    $("#noselected-display").html(
      '<div class="alert alert-danger" role="alert">Kindly update your Contact Number and Location at your <a href="profile.php">profile page.</a></div>'
    );
    document.getElementById("noticeinfo").style.display = "none";
    var bookBtn = document.getElementById("book-submit");
    bookBtn.disabled = true;
  } else {
    document.getElementById("noticeinfo").style.display = "block";
  }

  var paymentSelection = document.getElementById("payment_selection");
  var hiddenInputs = document.getElementById("payment_selections");

  hiddenInputs.value = "Down Payment";
  // Listen for change event on the select element
  paymentSelection.addEventListener("change", function () {
    // Set the value of the hidden input to the selected value
    hiddenInputs.value = paymentSelection.value;
  });

  // Check quantity when the page loads
  checkQuantity();

  // Get the 'From' input element
  var fromInput = document.getElementById("fromTime");

  // Set its value to '09:00'
  fromInput.value = "09:00";
  calculateEndTime();

  // Initialize subtotal, tax, and grand total to zero
  var subtotal = 0;
  var tax = 0;
  var total = 0;

  // Display the initial subtotal, tax, and grand total
  document.getElementById("subtotal-display").innerHTML =
    "<div class='item'><span>Subtotal: </span><span class='amount'>₱ " +
    subtotal.toFixed(2) +
    "</span></div>";
  document.getElementById("tax-display").innerHTML =
    "<div class='item'><span>Tax (2%): </span><span class='amount'>₱ " +
    tax.toFixed(2) +
    "</span></div>";
  document.getElementById("total-display").innerHTML =
    "<div class='item'><span style='font-weight:bold'>Grand Total: </span><span class='amount' style='font-weight:bold'>₱ " +
    total.toFixed(2) +
    "</span></div>";

  // ============================== Check Out and Calendar

  // Get the submit button
  var submitBtn = document.getElementById("submitBtn");

  // Function to update the state of the submit button
  function updateSubmitButtonState() {
    // Get the selected event date
    var eventDate = document.getElementById("event_date").value;

    var warningMessage = document.getElementById("dateWarning"); // Warning message element
    // Calculate the date one month from now
    var oneMonthFromNow = new Date();
    oneMonthFromNow.setMonth(oneMonthFromNow.getMonth() + 1);

    var today = new Date();
    today.setHours(0, 0, 0, 0); // Set time to 00:00:00 for accurate comparison


    // Check if the selected event date is a past date
    if (new Date(eventDate) < today) {
      warningMessage.style.display = "flex"; // Show the warning message
    } else {
      warningMessage.style.display = "none"; // Hide the warning message
    }

    // Check if the input field is empty, no checkbox is checked, event date is not selected, or event date is not at least one month in advance
    if (
      eventDate === "" || // Check if event date is not selected
      new Date(eventDate) < oneMonthFromNow
    ) {
      submitBtn.disabled = true; // Disable the submit button
      submitBtn.style.opacity = 0.5; // Change button opacity
      submitBtn.style.cursor = "not-allowed"; // Change cursor to not allowed
    } else {
      // Enable the submit button by default
      submitBtn.disabled = false;
      submitBtn.style.opacity = 1; // Reset button opacity
      submitBtn.style.cursor = "pointer"; // Return cursor to normal
    }

    // Check if all quantity input fields have a value of 0
    var allQuantitiesZero = true;
    var quantityInputs = document.querySelectorAll(".form-control");

    quantityInputs.forEach(function (input) {
      var quantity = parseInt(input.value);
      if (quantity !== 0 && !isNaN(quantity)) {
        allQuantitiesZero = false;
      }
    });

    // Disable or enable the submit button based on the quantities
    if (allQuantitiesZero) {
      submitBtn.disabled = true; // Disable the submit button
      submitBtn.style.opacity = 0.5; // Change button opacity
      submitBtn.style.cursor = "not-allowed"; // Change cursor to not allowed
    } else {
      submitBtn.disabled = false; // Enable the submit button
      submitBtn.style.opacity = 1; // Reset button opacity
      submitBtn.style.cursor = "pointer"; // Reset cursor
    }

    document.getElementById("eventDate").value = eventDate;
    checkQuantity();
  }

  // Add event listener to the event date input field
  document.getElementById("event_date").addEventListener("change", function () {
    updateSubmitButtonState();
  });

  // Add event listeners to each quantity input field
  var quantityInputs = document.querySelectorAll(".form-control");
  quantityInputs.forEach(function (input) {
    input.addEventListener("change", updateSubmitButtonState);
  });

  // Check the initial state of the submit button
  updateSubmitButtonState();
});

var isFullPayment = false;

// Get all quantity input fields
var quantityInputs = document.querySelectorAll(".form-control-sm");

// Get the submit button
var submitBtn = document.getElementById("submitBtn");

// Function to check if any quantity input field has a non-zero quantity
function checkQuantity() {
  // Get the selected event date
  var eventDate = document.getElementById("event_date").value;

  // Calculate the date one month from now
  var oneMonthFromNow = new Date();
  oneMonthFromNow.setMonth(oneMonthFromNow.getMonth() + 1);

  var isAnyQuantityNonZero = false;
  var allQuantitiesZero = true;
  quantityInputs.forEach(function (input) {
    var quantity = parseInt(input.value);
    if (
      quantity == 2 ||
      quantity == 3 ||
      quantity == 4 ||
      quantity == 5 ||
      quantity == 6 ||
      quantity == 7 ||
      quantity == 8 ||
      quantity == 9
    ) {
      isAnyQuantityNonZero = true;
    }

    if (quantity !== 0 && !isNaN(quantity)) {
      allQuantitiesZero = false;
    }
  });

  // Enable or disable the submit button based on the quantity
  if (
    allQuantitiesZero ||
    isAnyQuantityNonZero ||
    eventDate === "" ||
    new Date(eventDate) < oneMonthFromNow
  ) {
    submitBtn.disabled = true; // Disable the submit button
    submitBtn.style.opacity = 0.5; // Change button opacity
    submitBtn.style.cursor = "not-allowed"; // Change cursor to not allowed
    document.getElementById("invalidpax-display").style.display = "block";
  } else {
    submitBtn.disabled = false; // Enable the submit button
    submitBtn.style.opacity = 1; // Reset button opacity
    submitBtn.style.cursor = "pointer"; // Return cursor to normal
    document.getElementById("invalidpax-display").style.display = "none";
  }
}

// Gcash Input
document
  .getElementById("payment_method")
  .addEventListener("change", function () {
    var paymentMethod = this.value;
    if (paymentMethod === "Gcash") {
      document.getElementById("uploadImageField").style.display = "block";
      document.getElementById("GcashUser").style.display = "block";
    } else {
      document.getElementById("uploadImageField").style.display = "none";
      document.getElementById("GcashUser").style.display = "none";
    }
  });

// Down Payment Input
document
  .getElementById("payment_selection")
  .addEventListener("change", function () {
    // Get the initial payment input field
    var initialInput = document.getElementById("down_payment_input");

    var paymentMethod = this.value;

    if (paymentMethod === "Full Payment") {
      document.getElementById("down_payment_input_wrapper").style.display =
        "none";
      document.getElementById("downpayment-display").innerHTML = "";
      document.getElementById("balance-display").innerHTML = "";
      isFullPayment = true;

      document.getElementById("initial_payment").value = 0;
      document.getElementById("balance").value = 0;
    } else {
      document.getElementById("down_payment_input_wrapper").style.display =
        "block";
      isFullPayment = false;
      // Update the initial amount display

      // Calculate grand total
      downpayment = total / 2;

      // Calculate balance total
      balance = total - downpayment;

      document.getElementById("downpayment-display").innerHTML =
        "<hr><div class='item'><span>Initial Payment: </span><span class='amount'>₱ " +
        downpayment.toFixed(2) +
        "</span></div>";

      document.getElementById("balance-display").innerHTML =
        "<div class='item'><span style='font-weight:bold'>Balance: </span><span class='amount' style='font-weight:bold'>₱ " +
        downpayment.toFixed(2) +
        "</span></div>";

      document.getElementById("initial_payment").value = downpayment.toFixed(2);
      document.getElementById("balance").value = downpayment.toFixed(2);
    }
  });

// Add event listener to the form submission
document
  .getElementById("orderForm")
  .addEventListener("submit", function (event) {
    var bookBtn = document.getElementById("book-submit");

    bookBtn.disabled = true; // Disable the submit button
    bookBtn.style.opacity = 0.5; // Change button opacity
    bookBtn.style.cursor = "wait"; // Change cursor to not allowed
    // Prevent the default form submission
    event.preventDefault();

    // Validate form fields before submission
    if (validateForm()) {
      // If validation passes, submit the form
      updateSelectedItemsDisplay();

      var pay = document.getElementById("payment_selection").value;

      if (pay === "Full Payment") {
        document.getElementById("initial_payment").value = 0;
        document.getElementById("balance").value = 0;
      } else {
        validateInitial();
      }
      enableInputsBeforeSubmit();
    } else {
      bookBtn.disabled = false; // Disable the submit button
      bookBtn.style.opacity = 1; // Change button opacity
      bookBtn.style.cursor = "pointer"; // Change cursor to not allowed
    }
  });

// Function to validate form fields
function validateForm() {
  // Get form fields
  var fullName = document.getElementById("full_name").value.trim();
  var contactNumber = document.getElementById("contact_number").value.trim();
  var email = document.getElementById("email").value.trim();
  var location = document.getElementById("location").value.trim();
  var paymentMethod = document.getElementById("payment_method").value; // Get selected payment method
  // Initialize flag to check for errors
  var isValid = true;

  // Check if any field is empty
  if (
    fullName === "" ||
    contactNumber === "" ||
    email === "" ||
    location === ""
  ) {
    // Display error message
    displayErrorMessage("Please fill in all required fields.");
    isValid = false;
  }

  // Check if payment method is "Gcash" and upload image is empty
  if (
    paymentMethod === "Gcash" &&
    document.getElementById("upload_image").files.length === 0
  ) {
    // Display error message
    displayErrorMessage(
      "Please upload your gcash receipt for Gcash payment method."
    );
    isValid = false;
  }

  // Return validation result
  return isValid;
}

// Function to display error message
function displayErrorMessage(message) {
  $("#message").html(
    '<div class="alert alert-danger" role="alert">' + message + "</div>"
  );
}

function limitContactNumber(input) {
  // Get the current value of the input
  let inputValue = input.value;

  // Remove any non-digit characters
  let sanitizedValue = inputValue.replace(/\D/g, "");

  // Limit the value to 11 characters
  let limitedValue = sanitizedValue.slice(0, 11);

  // Update the input value
  input.value = limitedValue;
}

// Event Duration and Time function
document
  .getElementById("event_duration")
  .addEventListener("change", function () {
    calculateEndTime();
  });

document.getElementById("fromTime").addEventListener("change", function () {
  calculateEndTime();
});

function calculateEndTime() {
  var eventDuration = parseInt(document.getElementById("event_duration").value);
  var startTime = document.getElementById("fromTime").value;

  if (startTime) {
    var startTimeObj = new Date("2024-01-01T" + startTime + ":00");
    startTimeObj.setHours(startTimeObj.getHours() + eventDuration);

    var hours = startTimeObj.getHours();
    var minutes = startTimeObj.getMinutes();
    var ampm = hours >= 12 ? "PM" : "AM";
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? "0" + minutes : minutes;

    var endTime =
      hours.toString().padStart(2, "0") + ":" + minutes + " " + ampm;

    document.getElementById("toTimes").value = endTime;
  }
}

// Format event dates
document.querySelectorAll(".event-date").forEach(function (element) {
  var date = moment(element.textContent.trim());
  element.textContent = date.format("MMMM DD, YYYY");
});

// Format reservation dates
document.querySelectorAll(".reservation-date").forEach(function (element) {
  var date = moment(element.textContent.trim());
  element.textContent = date.format("MMMM DD, YYYY h:mm a");
});

// Enable Customer info
function toggleInputs() {
  var full_name = document.getElementById("full_name");
  var contact_number = document.getElementById("contact_number");
  var email = document.getElementById("email");
  var location = document.getElementById("location");
  var editButton = document.getElementById("editButton");

  if (full_name.disabled) {
    full_name.removeAttribute("disabled");
    contact_number.removeAttribute("disabled");
    email.removeAttribute("disabled");
    location.removeAttribute("disabled");
  } else {
    full_name.setAttribute("disabled", "disabled");
    contact_number.setAttribute("disabled", "disabled");
    email.setAttribute("disabled", "disabled");
    location.setAttribute("disabled", "disabled");
  }
}

// Function to enable Customer info fields before form submission
function enableInputsBeforeSubmit() {
  var full_name = document.getElementById("full_name");
  var contact_number = document.getElementById("contact_number");
  var email = document.getElementById("email");
  var location = document.getElementById("location");

  // Enable the fields
  full_name.removeAttribute("disabled");
  contact_number.removeAttribute("disabled");
  email.removeAttribute("disabled");
  location.removeAttribute("disabled");

  var attendeesInput = document.getElementById("attendees");
  var enteredattendees = parseInt(attendeesInput.value);
  var eventDuration = document.getElementById("event_duration").value;
  document.getElementById("attendeesValue").value = enteredattendees;
  document.getElementById("eventDuration").value = eventDuration;

  // Submit the form
  document.getElementById("orderForm").submit();
}

//======================================================================================================================
// Declare global variable
var total = 0;

function updateSelectedItemsDisplay() {
  var subtotal = 0;
  var itemsDisplay = ""; // String to hold the display of individual items
  var taxRate = 0.02; // Tax rate
  var hasQuantity = false; // Flag to track if any item has quantity

  // CALENDAR FETCH
  var eventDuration = parseInt(document.getElementById("event_duration").value);
  var startTime = document.getElementById("fromTime").value;

  if (startTime) {
    var startTimeObj = new Date("2024-01-01T" + startTime + ":00");
    startTimeObj.setHours(startTimeObj.getHours() + eventDuration);

    var hours = startTimeObj.getHours();
    var minutes = startTimeObj.getMinutes();
    var ampm = hours >= 12 ? "PM" : "AM";
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? "0" + minutes : minutes;

    var endTime =
      hours.toString().padStart(2, "0") + ":" + minutes + " " + ampm;

    document.getElementById("toTimes").value = endTime;
  }

  // Select the hidden input field
  var hiddenInput = document.getElementById("selected-products");

  // Initialize an empty array to store selected products
  var selectedProducts = [];

  // Select all the input elements with the class 'form-control' inside the parent container
  var quantityInputs = document.querySelectorAll(".form-control");

  // Iterate through each input element
  quantityInputs.forEach(function (input) {
    // Get the value of the input and convert it to a number
    var quantity = parseInt(input.value);

    // Get the price associated with the plus/minus square button
    var price = parseFloat(
      input.previousElementSibling.getAttribute("data-value")
    );

    // Get the menu name associated with the input
    var menuName = input.dataset.menuName; // Corrected to match the attribute name
    var menuImage = input.dataset.menuImage; // Corrected to match the attribute name
    var menuId = input.dataset.menuId; // Corrected to match the attribute name

    // Check if price is a valid number
    if (!isNaN(price) && quantity > 0) {
      // Create an object representing the selected product
      var product = {
        menuName: menuName,
        price: price,
        quantity: quantity,
        menuImage: menuImage,
        menu_id: menuId,
      };

      // Calculate the subtotal for this item
      var itemSubtotal = quantity * price;

      // Add item subtotal to the total
      subtotal += itemSubtotal;

      // Display the menu name, quantity, and subtotal for this item
      itemsDisplay +=
        "<div class='item'><span>" +
        menuName +
        " - x" +
        quantity +
        " </span><span class='amount'>₱ " +
        itemSubtotal.toFixed(2) +
        "</span></div>";

      // Set hasQuantity flag to true if quantity is greater than 0
      hasQuantity = true;

      // Push the product object to the selectedProducts array
      selectedProducts.push(product);
    }
  });

  // Calculate tax
  var tax = subtotal * taxRate;

  // Calculate grand total
  total = subtotal + tax;

  // Calculate grand total
  downpayment = total / 2;

  // Calculate balance total
  balance = total - downpayment;

  // INPUTS

  // Display the individual items
  document.getElementById("selected-items-display").innerHTML = itemsDisplay;

  // Display the subtotal
  document.getElementById("subtotal-display").innerHTML =
    "<br><div class='item'><span>Subtotal: </span><span class='amount'>₱ " +
    subtotal.toFixed(2) +
    "</span></div>";

  // Display the tax
  document.getElementById("tax-display").innerHTML =
    "<div class='item'><span>Tax (" +
    taxRate * 100 +
    "%): </span><span class='amount'>₱ " +
    tax.toFixed(2) +
    "</span></div>";

  // Display the total
  document.getElementById("total-display").innerHTML =
    "<div class='item'><span style='font-weight:bold'>Grand Total: </span><span class='amount' style='font-weight:bold'>₱ " +
    total.toFixed(2) +
    "</span></div>";

  if (!isFullPayment) {
    // Display the Down Payment
    document.getElementById("downpayment-display").innerHTML =
      "<hr><div class='item'><span>Initial Payment (50%): </span><span class='amount'>₱ " +
      downpayment.toFixed(2) +
      "</span></div>";

    // Display the Balance
    document.getElementById("balance-display").innerHTML =
      "<div class='item'><span style='font-weight:bold'>Balance: </span><span class='amount' style='font-weight:bold'>₱ " +
      balance.toFixed(2) +
      "</span></div>";
  }

  checkQuantity();
  hiddenInput.value = JSON.stringify(selectedProducts);

  var eventDate = document.getElementById("event_date").value;
  var eventDuration = document.getElementById("event_duration").value;
  var From = document.getElementById("fromTime").value;
  var attendeesInput = document.getElementById("attendees");
  // Get the entered value
  var enteredattendees = parseInt(attendeesInput.value);

  document.getElementById("attendeesValue").value = enteredattendees;
  document.getElementById("eventDuration").value = eventDuration;
  document.getElementById("totalPrice").value = subtotal;
  document.getElementById("tax").value = tax;
  document.getElementById("totalPriceWithTax").value = total;
  document.getElementById("eventDate").value = eventDate;
  document.getElementById("fromTimes").value = From;
  document.getElementById("toTime").value = endTime;
  document.getElementById("initial_payment").value = downpayment.toFixed(2);
  document.getElementById("balance").value = balance.toFixed(2);

  // Get the select element
  var paymentSelect = document.getElementById("payment_selection_input");
  // Get the hidden input element
  var hiddenInput = document.getElementById("payment_selection");
}

function toggleElements(checkbox) {
  var row = checkbox.closest(".row");
  var relatedElements = row.querySelectorAll(
    ".col-lg-3, #quantity, .col-lg-4, .bxs-minus-square, .bxs-plus-square"
  );
  var opacity = checkbox.checked ? "1" : "0.7";

  relatedElements.forEach(function (element) {
    element.style.opacity = opacity;
    if (!checkbox.checked) {
      element
        .querySelectorAll('input[type="number"]')
        .forEach(function (innerElement) {
          innerElement.disabled = true;
        });
      // Disable minus and plus icons
      element
        .querySelectorAll(".bxs-minus-square, .bxs-plus-square")
        .forEach(function (icon) {
          icon.style.pointerEvents = "none";
          icon.style.opacity = "0.5";
        });
    } else {
      element
        .querySelectorAll('input[type="number"]')
        .forEach(function (innerElement) {
          innerElement.disabled = false;
        });
      // Enable minus and plus icons
      element
        .querySelectorAll(".bxs-minus-square, .bxs-plus-square")
        .forEach(function (icon) {
          icon.style.pointerEvents = "auto";
          icon.style.opacity = "1";
        });
    }
  });

  if (!checkbox.checked) {
    // If checkbox is unchecked, set quantity to 0
    var quantityInput = row.querySelector('input[name="quantity"]');
    quantityInput.value = 0; // Set quantity to 0

    // Update displayed items
    updateSelectedItemsDisplay();
  }
}

function validateQuantity(input) {
  var value = parseInt(input.value, 10);

  var validRange = [2, 3, 4, 5, 6, 7, 8, 9];

  // Add numbers from 10 to 600 to the valid range
  for (var i = 10; i <= 600; i++) {
    validRange.push(i);
  }

  // Check if value is NaN (not a number)
  if (isNaN(value)) {
    input.value = 10; // Set value to 0 if not a number
    $("#paxinfoModal").modal("show");
  } else if (value === 0) {
    input.value = 0;
    $("#paxinfoModal").modal("show");
  } else if (value === 1) {
    input.value = 1; // Reset value to 0 if out of range or "0000"
  } else if (
    !validRange.includes(value) ||
    value < 10 ||
    value > 600 ||
    input.value === "0000"
  ) {
    input.value = 1; // Reset value to 0 if out of range or "0000"
    $("#paxinfoModal").modal("show");
  }
}

function validateAttendees() {
  // Get the attendees input field
  var attendeesInput = document.getElementById("attendees");

  // Get the entered value
  var enteredValue = parseInt(attendeesInput.value);

  // Check if the entered value is NaN (not a number) or empty
  if (isNaN(enteredValue) || attendeesInput.value.trim() === "") {
    // If the entered value is NaN or empty, set it to 0
    attendeesInput.value = 0;
  } else {
    // Validate against negative values
    if (enteredValue < 0) {
      // If the entered value is negative, set it to 0
      attendeesInput.value = 0;
    }

    // Validate against the maximum limit
    if (enteredValue > 600) {
      // If the entered value is greater than 50, set it to 50
      attendeesInput.value = 100;
      $("#attendeesinfoModal").modal("show");
    }
  }
}

function validateInitial() {
  updateSelectedItemsDisplay();
  // Get the initial payment input field
  var initialInput = document.getElementById("down_payment_input");

  // Get the entered value
  var enteredValue = parseInt(initialInput.value);

  // Check if the entered value is NaN (not a number) or empty
  if (isNaN(enteredValue) || initialInput.value.trim() === "") {
    // If the entered value is NaN or empty, set it to 0
    initialInput.value = 0;
    enteredValue = 0; // Update enteredValue to 0
  }

  // Check if the entered value is greater than the grand total
  if (enteredValue > total) {
    document.getElementById("downpayment-display").innerHTML = "";
    document.getElementById("balance-display").innerHTML = "";
    // Show modal if initial payment is greater than total
    $("#InvalidModalLabelModal").modal("show");
    // Reset input value to 0 or any appropriate action
    initialInput.value = 0;

    // Update the initial amount display
    // Calculate grand total
    downpayment = total / 2;

    // Calculate balance total
    balance = total - downpayment;

    document.getElementById("downpayment-display").innerHTML =
      "<hr><div class='item'><span>Initial Payment: </span><span class='amount'>₱ " +
      downpayment.toFixed(2) +
      "</span></div>";

    document.getElementById("balance-display").innerHTML =
      "<div class='item'><span style='font-weight:bold'>Balance: </span><span class='amount' style='font-weight:bold'>₱ " +
      balance.toFixed(2) +
      "</span></div>";
  } else {
    // Update the initial amount display
    var downpayment = enteredValue; // Use enteredValue as the initial amount

    if (downpayment > 0) {
      var balance = total - enteredValue; // Use enteredValue as the initial amount
      document.getElementById("downpayment-display").innerHTML =
        "<hr><div class='item'><span>Initial Payment: </span><span class='amount'>₱ " +
        downpayment.toFixed(2) +
        "</span></div>";

      document.getElementById("balance-display").innerHTML =
        "<div class='item'><span style='font-weight:bold'>Balance: </span><span class='amount' style='font-weight:bold'>₱ " +
        balance.toFixed(2) +
        "</span></div>";

      document.getElementById("initial_payment").value = downpayment.toFixed(2);
      document.getElementById("balance").value = balance.toFixed(2);
    } else {
      // var ini = document.getElementById("downpayment-display").value;
      // document.getElementById("initial_payment").value = ini;
    }
  }
}
