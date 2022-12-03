<?php

$this->data = $this->model->get_user_model()->get_data();
$this->page = (object)['title' => 'Home']

?>

<?php include_once('_header.php'); ?>

<div>
    <p>
        <a href="register">Register</a>
    </p>
</div>
<div>
    <p>
        <a href="login">Login</a>
    </p>
</div>

<!-- Actual number of users: <?php echo($this->data->userCount) ?> -->

<?php include_once('_footer.php'); ?>
