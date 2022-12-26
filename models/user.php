<?php
use function MongoDB\BSON\toJSON;

class UserModel
{
    function __construct() {
    }

    public function get_data()
    { }

    public function login()
    {
        global $mysqli;
        echo ('Parameters: ' . serialize($_POST) . '<br>');

        $fields = [
            'user_email' => NULL,
            'user_password' => NULL,
            'check_bot' => NULL
        ];
        $errors = [];

        // Set fields
        foreach ($fields as $key => $value) {
            // Prevent XSS attack
            $fields[$key] = isset($_POST[$key]) ? htmlspecialchars(trim($_POST[$key])) : null;
        }

        // Validate the provided form
        foreach ($fields as $key => $value) {
            // Check if field is present
            if ($key != 'check_bot' && empty($fields[$key])) {
                $errors[$key] = 'This field is required.';
            }

            // Check e-mail
            if ($key == 'user_email' && !empty($fields['user_email'])) {
                // Check if email is valid
                if (!filter_var($fields['user_email'], FILTER_VALIDATE_EMAIL)) {
                    $errors[$key] = 'Provided e-mail is in an invalid format.';
                }
            }

            // Check bot validation
            else if ($key == 'check_bot' && !empty($value)) {
                $errors[$key] = 'We do not accept robots.';
            }
        }

        // Register new user using the provided values
        if (count($errors) == 0) {
            // SQL statement
            $sql = "SELECT * FROM purchases_user WHERE user_email='" . $fields['user_email'] . "'";
            $result = $mysqli->query($sql)->fetch_assoc();

            // No user found
            if(empty($result) || !password_verify($fields['user_password'], $result['user_password'])) {
                $errors['user_password'] = 'Account does not exist or passwords do not match.';
            } else {
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $result['id'];
                $_SESSION['name'] = $result['user_name'];
                $_SESSION['email'] = $result['user_email'];
                $_SESSION['notification-login'] = true;
            }

            // Close connection
            $mysqli->close();
        }
        
        if(count($errors) != 0) {
            $this->handle_errors($errors);
        }
    }

    public function register()
    {
        global $mysqli;
        echo ('Parameters: ' . serialize($_POST) . '<br>');

        $fields = [
            'user_name' => NULL,
            'user_email' => NULL,
            'user_password' => NULL,
            'user_password_check' => NULL,
            'check_bot' => NULL
        ];
        $errors = [];

        // Set fields
        foreach ($fields as $key => $value) {
            // Prevent XSS attack
            $fields[$key] = isset($_POST[$key]) ? htmlspecialchars(trim($_POST[$key])) : null;
        }

        // Validate the provided form
        foreach ($fields as $key => $value) {
            // Check if field is present
            if ($key != 'check_bot' && empty($fields[$key])) {
                $errors[$key] = 'This field is required.';
            }

            // Check e-mail
            if ($key == 'user_email' && !empty($fields['user_email'])) {
                // Check if email is valid
                if (!filter_var($fields['user_email'], FILTER_VALIDATE_EMAIL)) {
                    $errors[$key] = 'Provided e-mail is in an invalid format.';
                }

                // Get emails with same address
                $email = $mysqli->query("SELECT user_email FROM purchases_user WHERE user_email=\"" . $value . "\"")->fetch_assoc();

                // Check if any result
                if ($email) {
                    $errors[$key] = 'Account with this e-mail already exists.';
                }
            }

            // Check password
            else if ($key == 'user_password_check') {
                if ($value != $fields['user_password']) {
                    $errors[$key] = 'Provided passwords do not match.';
                }
            }

            // Check bot validation
            else if ($key == 'check_bot' && !empty($value)) {
                $errors[$key] = 'We do not accept robots.';
            }
        }

        // Register new user using the provided values
        if (count($errors) == 0) {
            // Hash and store password
            $fields['user_password'] = password_hash($fields['user_password'], PASSWORD_DEFAULT);

            // SQL statement
            $sql = "INSERT INTO purchases_user (user_name, user_email, user_password) VALUES ('" . $fields['user_name'] . "', '" . $fields['user_email'] . "', '" . $fields['user_password'] . "')";

            // Execute
            if ($mysqli->query($sql) === FALSE) {
                echo "Error: " . $sql . "<br>";
                // Close connection
                $mysqli->close();
                die();
            }

            // Close connection
            $mysqli->close();
        } else {
            $this->handle_errors($errors);
        }
    }

    private function handle_errors($errors) {
        $_SESSION["errors"] = $errors;
        header("Location: " . $_SERVER["REQUEST_URI"]);
        die();
    }
}