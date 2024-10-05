$(document).ready(function() {
    // Attach click event to delete-user button
    $(document).on('click', '.delete-user', function() {
        var userId = $(this).data('id');
        
        console.log('Delete button clicked for user ID:', userId); // Debugging line
        
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: 'delete_user.php', // Make sure this path is correct
                type: 'POST',
                data: { id: userId },
                dataType: 'json',
                success: function(response) {
                    console.log('Response:', response); // Debugging line
                    
                    if (response.success) {
                        $('.delete-user[data-id="' + userId + '"]').closest('tr').remove();
                        alert('User deleted successfully');
                    } else {
                        alert('Error: ' + response.error);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown); // Debugging line
                    alert('AJAX request failed');
                }
            });
        }
    });
});
