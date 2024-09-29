<?php 
include '../core/init.php';
require_once '../core/classes/validation/Validator.php';
use validation\Validator;

if (isset($_POST['login']) && !empty($_POST['login'])) {
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    if(!empty($email) && !empty($password)) {
        $email = User::checkInput($email);
        $password = User::checkInput($password); 
    } 
    
    $v = new Validator; 
    $v->rules('email', $email, ['required', 'email']);
    $v->rules('password', $password, ['required', 'string']);
    $errors = $v->errors;

    if($errors == []) {
        // Attempt to log in the user
        if (User::login($email, $password) !== false) {
            // Assuming User::login sets a session variable for user id or similar
            // Check if the user is admin by comparing the email
            if ($email === 'admin@gmail.com') {
                // Redirect admin to the admin dashboard
                header('Location: ../admin_dashboard.php');
                exit();
            } else {
                // Redirect regular users to the home page
                header('Location: ../home.php');
                exit();
            }
        } else {
            // If login fails
            $_SESSION['errors'] = ['The email or password is not correct'];
            header('Location: ../index.php');
            exit();
        }
    } else {
        // If there are validation errors
        $_SESSION['errors'] = $errors;
        header('Location: ../index.php');
        exit();
    }

} else {
    // Redirect if accessed without POST data
    header('Location: ../index.php');
    exit();
}
?>
