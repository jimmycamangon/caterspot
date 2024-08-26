$(document).ready(function() {
    // Handle click event on View Image button
    $('.view-image-btn').click(function() {
        // Get the menu ID associated with the clicked button
        var menuId = $(this).data('menu-id');
        console.log("Menu ID: ", menuId); // Debugging: Check if menuId is correct

        // AJAX call to fetch images based on menu ID
        $.ajax({
            url: 'functions/fetch-other-menu-images.php', // Change this to the appropriate PHP file
            type: 'POST',
            data: { menu_id: menuId },
            dataType: 'json',
            success: function(response) {
                console.log("Response:", response); // Debugging: Check the response received
                // Clear existing carousel items
                $('#carouselExampleDark .carousel-inner').empty();
                // Populate carousel with fetched images
                $.each(response.images, function(index, image) {
                    var imagePath = 'assets/img/other-menu-uploads/' + image;
                    var activeClass = (index === 0) ? 'active' : '';
                    var carouselItem = '<div class="carousel-item ' + activeClass + '">' +
                                            '<img src="' + imagePath + '" class="d-block w-100" alt="Image">' +
                                            '<div class="carousel-caption d-none d-md-block">' +
                                            '</div>' +
                                        '</div>';
                    $('#carouselExampleDark .carousel-inner').append(carouselItem);
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});
