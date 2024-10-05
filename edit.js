$(document).ready(function () {
    // Populate the modal with user data when the edit button is clicked
    $('.edit-user').click(function () {
        const userId = $(this).data('id');
        const username = $(this).data('username');
        const email = $(this).data('email');

        // Populate modal fields
        $('#editUserModal input[name="userId"]').val(userId);
        $('#editUserModal input[name="username"]').val(username);
        $('#editUserModal input[name="email"]').val(email);
    });

    // Save changes button click event
    $('#saveChanges').click(function () {
        const userId = $('#editUserModal input[name="userId"]').val();
        const username = $('#editUserModal input[name="username"]').val();
        const email = $('#editUserModal input[name="email"]').val();

        $.ajax({
            type: 'POST',
            url: 'update_user.php',
            data: {
                id: userId,
                username: username,
                email: email
            },
            success: function (response) {
                console.log("AJAX Response:", response); // Debugging line
                const res = JSON.parse(response); // Parse the JSON response

                // Check the response
                if (res.success) {
                    alert('Edit Successfully!'); // Alert notification
                    $('#editUserModal').modal('hide'); // Close the modal
                    location.reload(); // Reload the page to see changes
                } else {
                    alert('Error: ' + res.message); // Error message
                }
            },
            error: function (xhr, status, error) {
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });
});
