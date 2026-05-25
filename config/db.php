<?php

$conn = mysqli_connect(
"localhost",
"root",
"",
"nml_po_management"
);

if(!$conn)
{
    die("Database Failed");
}

?>