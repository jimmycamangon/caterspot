function validatePrice(input) {
    // Remove any non-numeric characters from the input value
    input.value = input.value.replace(/[^0-9.]/g, '');

    // If the input value starts with a dot, add a leading zero
    if (input.value.startsWith('.')) {
        input.value = '0' + input.value;
    }
}
