<?php


class PurchaseModel {
    
    function __construct() {
    }

    public function get_data()
    {
        global $mysqli;
        $page = 1;
        if (property_exists((object) $_GET, "page") && is_numeric($_GET["page"])) {
            $page = $_GET["page"];
        }

        // SQL statement
        $sql = "SELECT id, purchase_date, purchase_name, purchase_amount FROM purchases_purchase WHERE user_id='" . $_SESSION['id'] . "' ORDER BY purchase_date DESC, id DESC LIMIT 10 OFFSET " . ($page - 1) * 10;
    
        // Get result
        $result = $mysqli->query($sql)->fetch_all();

        $map_purchases_to_data = function(array $value): array {
            return array(
                "purchase_id" => $value[0],
                "purchase_date" => $value[1],
                "purchase_name" => $value[2],
                "purchase_price" => $value[3]
            );
        };

        $purchases = array_map($map_purchases_to_data, $result);

        // SQL statement
        $sql = "
            SELECT SUM(purchase_amount) as sum
            FROM purchases_purchase
            WHERE user_id='" . $_SESSION['id'] . "' AND
                purchase_date >= LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH AND
                purchase_date <  LAST_DAY(CURDATE()) + INTERVAL 1 DAY
            GROUP BY user_id";
    
        // Get result
        $sum = $mysqli->query($sql)->fetch_assoc();
        if ($sum == NULL)
            $sum = 0;
        else
            $sum = $sum["sum"];

        $sql = "
            SELECT SUM(purchase_amount) as last_sum
            FROM purchases_purchase
            WHERE user_id='" . $_SESSION['id'] . "' AND
                purchase_date >= LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 2 MONTH AND
                purchase_date <  LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH
            GROUP BY user_id";
            
        // Get result
        $last_sum = $mysqli->query($sql)->fetch_assoc();
        if ($last_sum == NULL)
            $last_sum = 0;
        else
            $last_sum = $last_sum["last_sum"];

        $sql = "
            SELECT COUNT(purchase_amount) as count
            FROM purchases_purchase
            WHERE user_id='" . $_SESSION['id'] . "' GROUP BY user_id";
            
        // Get result
        $count = $mysqli->query($sql)->fetch_assoc();
        if ($count == NULL)
            $count = 0;
        else
            $count = $count["count"];

        return (object) array(
            "stats" => (object) array(
                "total_spent" => $sum,
                "trend" => ($sum-$last_sum > 0) - ($sum-$last_sum < 0),
                "page" => $page,
                "max_page" => floor($count / 10 + 1),
            ),
            "purchases" => $purchases
        );
    }

    public function makePurchase() {
        global $mysqli;
        echo ('Parameters: ' . serialize($_POST) . '<br>');

        $fields = [
            'purchase_date' => NULL,
            'purchase_name' => NULL,
            'purchase_amount' => NULL,
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

            // Check bot validation
            else if ($key == 'check_bot' && !empty($value)) {
                $errors[$key] = 'We do not accept robots.';
            }

            else if ($key == 'purchase_amount' && $value <= 0) {
                $errors[$key] = "Value must be greater than 0.";
            }
        }

        if(count($errors) != 0) {
            $this->handle_errors($errors);
        } else {
            // SQL statement
            $sql = "INSERT INTO purchases_purchase (purchase_date, purchase_name, purchase_amount, user_id) VALUES ('" . $fields['purchase_date'] . "', '" . $fields['purchase_name'] . "', '" . $fields['purchase_amount'] . "', '" . $_SESSION['id'] . "')";

            // Execute
            if ($mysqli->query($sql) === FALSE) {
                echo "Error: " . $sql . "<br>";
                // Close connection
                $mysqli->close();
                die();
            }

            // Close connection
            $mysqli->close();
        }
    }
    public function removePurchase() {
        global $mysqli;
        echo ('Parameters: ' . var_dump($_POST) . '<br>');

        $fields = [
            'purchase_id' => NULL,
            'action' => NULL
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
            if (empty($fields[$key])) {
                $errors[$key] = 'This field is required.';
            }

            // Check bot validation
            else if ($key == 'action' && $value != 'delete') {
                $errors[$key] = 'Expected delete action';
            }
        }

        if(count($errors) != 0) {
            $this->handle_errors($errors);
        } else {
            // SQL statement
            $sql = "DELETE FROM purchases_purchase WHERE id = '" . $fields['purchase_id'] . "' AND user_id = " . $_SESSION['id'];

            // Execute
            if ($mysqli->query($sql) === FALSE) {
                echo "Error: " . $sql . "<br>";
                // Close connection
                $mysqli->close();
                die();
            }

            // Close connection
            $mysqli->close();
        }
    }
    private function handle_errors($errors) {
        $_SESSION["errors"] = $errors;
        header("Location: " . $_SERVER["REQUEST_URI"]);
        die();
    }
}