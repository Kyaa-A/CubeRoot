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
                // Update button text and data-status attribute
                var buttonText = newStatus == 1 ? 'Active' : 'Inactive';
                $('.toggle-status[data-id="' + userId + '"]')
                    .text(buttonText)
                    .data('status', newStatus)
                    .toggleClass('active inactive'); // Optional: add classes for styling
            } else {
                alert('Error updating status');
            }
        },
        error: function() {
            alert('AJAX request failed');
        }
    });
});
