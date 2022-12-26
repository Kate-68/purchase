<?php

$this->page = (object) ['title' => 'Add a purchase'];

$errors = array();
if(property_exists((object) $_SESSION, "errors")) {
    $errors = $_SESSION["errors"];
    unset($_SESSION["errors"]);
}
?>

<?php include_once('_header.php'); ?>

<div>
    <h2>Add a new purchase</h2>
    <form method="post">
        <label for="purchase_date">Date:</label>
        <input type="date" id="purchase_date" name="purchase_date">
        
        <?php if(!empty($errors['purchase_date'])) { ?>
                <span class="field-error"><?= $errors['purchase_date']; ?></span>
        <?php } ?>

        <label for="purchase_name">Name:</label>
        <input type="text" id="purchase_name" name="purchase_name">
        
        <?php if(!empty($errors['purchase_name'])) { ?>
                <span class="field-error"><?= $errors['purchase_name']; ?></span>
        <?php } ?>

        <label for="purchase_amount">Price:</label>
        <input type="number" id="purhcase_amount" name="purchase_amount">
        
        <?php if(!empty($errors['purchase_amount'])) { ?>
                <span class="field-error"><?= $errors['purchase_amount']; ?></span>
        <?php } ?>

        <input type="hidden" name="check_bot">
        <input type="submit" value="Add purchase">
    </form>
</div>

<?php include_once('_footer.php'); ?>

<script>
    document.getElementById("purchase_date").valueAsDate = new Date();
</script>