$(document).ready(function () {
    // Load regions
    $.ajax({
        url: 'fetch-philaddress.php',
        type: 'POST',
        data: { type: 'region' },
        success: function (data) {
            $('#edit_region').html(data);
        }
    });

    // Load provinces based on selected region
    $('#edit_region').change(function () {
        var region_id = $(this).val();
        $.ajax({
            url: 'fetch-philaddress.php',
            type: 'POST',
            data: { type: 'province', region_id: region_id },
            success: function (data) {
                $('#edit_province').html(data);
                $('#edit_city').html('<option value="">Select City/Municipality</option>'); // Clear city dropdown
            }
        });
    });

    // Load cities based on selected province
    $('#edit_province').change(function () {
        var province_id = $(this).val();
        $.ajax({
            url: 'fetch-philaddress.php',
            type: 'POST',
            data: { type: 'city', province_id: province_id },
            success: function (data) {
                $('#edit_city').html(data);
            }
        });
    });
});