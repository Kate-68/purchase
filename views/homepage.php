<?php

$this->data = $this->model->get_user_model()->get_data();

?>

<h1>Hello, World!</h1>

Actual number of users: <?php echo($this->data->userCount) ?>