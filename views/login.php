<?php

$this->page = (object) ['title' => 'Login'];

?>

<?php include_once('_header.php'); ?>

<div>
    <h2>Login to an existing account</h2>
    <form method="post">
        <label for="user_email">E-mail:</label>
        <input type="text" id="user_email" inputmode="email" name="user_email">
        
        <label for="user_password">Password:</label>
        <input type="password" id="user_password" name="user_password">
        
        <input type="hidden" name="check_bot">
        <input type="submit" value="Login">
    </form>
</div>

<?php include_once('_footer.php'); ?>
