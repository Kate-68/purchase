<?php

$this->data = $this->model->get_user_model()->get_data();
$this->page = (object)['title' => 'Home']

?>

<?php include_once('_header.php'); ?>

<div class="top-menu">
    <table>
        <tr>
            <td style="width: 50%">
                <div>
                    <a class="menu-button" href="register">Register</a>
                </div>
            </td>
            <td style="width: 50%">
                <div style="text-align: right">
                    <a class="menu-button" href="login">Login</a>
                </div>
            </td>
        </tr>
    </table>
</div>

<h2>Welcome to Spendings!</h2>
<p>
    The place that helps to put your monthly spendings under control.
</p>

<?php include_once('_footer.php'); ?>
