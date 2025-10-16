<?php
include "config.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "DELETE FROM orders WHERE id = $id";
    mysqli_query($mysql_db, $query);
}

header("Location: view_orders.php");
exit;
?>
