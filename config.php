<?php

// Enable sessions
if(!session_id()) {
    session_start();
}

// Constants
define('SITE_DOMAIN', 'https://localhost:8000');
define('SITE_LINK', SITE_DOMAIN . '/');

// DB
define('DB_HOST', getenv("DB_HOST") ? getenv("DB_HOST") : 'localhost:3306');
define('DB_USER', getenv("DB_USER") ? getenv("DB_USER") : 'root');
define('DB_PASS', getenv("DB_PASS") ? getenv("DB_PASS") : '');
define('DB_NAME', getenv("DB_NAME") ? getenv("DB_NAME") : 'purchases');

// Connect to database
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Set charset
$mysqli->set_charset('utf8');

// Check connection
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

// Check if logged in and valid
if(array_key_exists('loggedin', $_SESSION)) {
    // SQL statement
    $sql = "SELECT * FROM purchases_user WHERE id='" . $_SESSION['id'] . "'";

    // Get result
    $result = $mysqli->query($sql)->fetch_assoc();

    // Check if result exists
    if($result) {
      $logged = true;
      define('LOGGED_NAME', $result['user_name']);
    }
    else {
        $logged = false;    
    }
}
// If not logged
else {  
  $logged = false;
}

// Login constant
define('LOGGED_IN', $logged);
/**
 * Summary MySQL connection variable
 */
define('$mysqli', $mysqli);

$site = (object) ['title' => 'Purchases', 'link' => SITE_LINK];
define('SITE', $site);