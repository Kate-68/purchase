<?php

$this->page = (object) ['title' => 'Register'];

?>

<?php include_once('_header.php'); ?>

<div>
    <h2>Register new user</h2>
    <form method="post">
        <label for="user_name">Name:</label>
        <input type="text" id="user_name" name="user_name">
        
        <label for="user_email">E-mail:</label>
        <input type="text" id="user_email" inputmode="email" name="user_email">
        
        <label for="user_password">Password:</label>
        <input type="password" id="user_password" name="user_password">
        
        <label for="user_password_check">Confirm password:</label>
        <input type="password" id="user_password_check" name="user_password_check">

        <input type="hidden" name="check_bot">
        <input type="submit" value="Register">
    </form>
</div>

<?php include_once('_footer.php'); ?>
