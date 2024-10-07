$(document).on('click', '.toggle-status', function() {
    var userId = $(this).data('id');
    var currentStatus = $(this).data('status');
    var newStatus = currentStatus == 1 ? 0 : 1; // Toggle between 1 and 0

    $.ajax({
        url: 'toggle_status.php',
        type: 'POST',
        data: {
            id: userId,
            status: newStatus
        },
        dataType: 'json', // Ensure you expect JSON response
        success: function(response) {
            if (response.success) {
                // Update button text, status, and class
                var button = $('.toggle-status[data-id="' + userId + '"]');
                var buttonText = newStatus == 1 ? 'Active' : 'Inactive';

                button.text(buttonText)
                      .data('status', newStatus);

                // Toggle the class based on the new status
                if (newStatus == 1) {
                    button.removeClass('inactive').addClass('active');
                } else {
                    button.removeClass('active').addClass('inactive');
                }
            } else {
                alert('Error updating status');
            }
        },
        error: function() {
            alert('AJAX request failed');
        }
    });
});
