$(document).ready(function () {
    $('.toggle-status').click(function () {
        const userId = $(this).data('id');
        const currentStatus = $(this).text().trim();

        // Toggle status text
        const newStatus = currentStatus === 'Active' ? 'Inactive' : 'Active';
        $(this).text(newStatus);

        // Make an AJAX request to update the status in the database
        $.ajax({
            url: 'handle/handleStatusToggle.php',
            type: 'POST',
            data: { user_id: userId, status: newStatus },
            success: function (response) {
                console.log(response);
            }
        });
    });
});
