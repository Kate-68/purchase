<?php

$this->page = (object) ['title' => 'Spendings'];
$data = $this->model->get_purchase_model()->get_data();
$stats = $data->stats;
$purchases = $data->purchases;

?>

<?php include_once('_header.php'); ?>

<main>
    <h2>Spendings</h2>

    <div class='spendings-overview'>
        <table>
            <tr>
                <td style="width: 4em">Trend:</td>
                <td style="width: 2em"><?php echo $stats->trend == 0 ? '→' : ($stats->trend == -1 ? '↘' : '↗') ?></td>
                <td style="width: 12em"><span class="name">This month's spendings:</span></td>
                <td style="min-width: 8em"><span class="total"><?php echo $stats->total_spent ?>,-</span></td>
                <td id="button-link" style="width: 9em"><a href="purchases">Make a purchase</a></td>
            </tr>
        </table>
    </div>
    <div class='data'>
        <table>
            <thead>
                <tr>
                    <th style="width: 5.15em">Date</th>
                    <th style="min-width: 10em">Name</th>
                    <th style="min-width: 10em">Price</th>
                    <th style="width: 4.4em">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($purchases as $row): array_map('htmlentities', $row); ?>
                    <tr>
                        <td> <?php echo $row["purchase_date"] ?> </td>
                        <td> <?php echo $row["purchase_name"] ?> </td>
                        <td> <?php echo $row["purchase_price"] ?> </td>
                        <td class="spendings-action">
                            <form method="post">
                                <input type="hidden" name="purchase_id" value=<?php echo $row["purchase_id"] ?>>
                                <input type="hidden" name="action" value="delete">
                                <input type="submit" value="🗑">
                            </form>
                            <!-- <form method="post" class="purchase-form">
                                <input type="hidden" name="purchase_id" value=<?php echo $row["purchase_id"] ?>>
                                <input type="hidden" name="action" value="edit">
                                <input type="submit" value="✎">
                            </form> -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </br>
        <div class="paging">
            <a href="/spendings?page=1"><<</a>&nbsp;&nbsp;
            <a href=<?php echo "\"/spendings?page=" . max($stats->page - 1, 1) . "\"" ?>><</a>&nbsp;&nbsp;
            <?php echo $stats->page ?> / <?php echo $stats->max_page ?>&nbsp;&nbsp;
            <a href=<?php echo "\"/spendings?page=" . min($stats->page + 1, $stats->max_page) . "\"" ?>>></a>&nbsp;&nbsp;
            <a href=<?php echo "\"/spendings?page=" . $stats->max_page . "\"" ?>>>></a>
        </div>
    </div>
</main>

<?php include_once('_footer.php'); ?>
