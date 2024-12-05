$(document).ready(function () {
    // Load regions
    $.ajax({
        url: 'fetch-philaddress.php',
        type: 'POST',
        data: { type: 'region' },
        success: function (data) {
            $('#edit_region').html(data);

            // Trigger change to load provinces for the default region (e.g., REGION IV-A)
            $('#edit_region').trigger('change');
        }
    });

    // Load provinces based on selected region
    $('#edit_region').change(function () {
        var region_id = $(this).val();
        if (region_id) {
            $.ajax({
                url: 'fetch-philaddress.php',
                type: 'POST',
                data: { type: 'province', region_id: region_id },
                success: function (data) {
                    $('#edit_province').html(data);
                    $('#edit_city').html('<option value="">Select City/Municipality</option>'); // Clear city dropdown
                }
            });
        } else {
            $('#edit_province').html('<option value="">Select Province</option>');
            $('#edit_city').html('<option value="">Select City/Municipality</option>');
        }
    });

    // Load cities based on selected province
    $('#edit_province').change(function () {
        var province_id = $(this).val();
        if (province_id) {
            $.ajax({
                url: 'fetch-philaddress.php',
                type: 'POST',
                data: { type: 'city', province_id: province_id },
                success: function (data) {
                    $('#edit_city').html(data);
                }
            });
        } else {
            $('#edit_city').html('<option value="">Select City/Municipality</option>');
        }
    });
});
