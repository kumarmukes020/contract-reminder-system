<?php

include '../config/db.php';

$id = $_GET['id'];

mysqli_query($conn,"
DELETE FROM contracts
WHERE id='$id'
");

header("Location: contracts.php");
?>