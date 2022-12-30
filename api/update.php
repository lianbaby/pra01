<?php
include_once "base.php";

$table=$_POST['table'];
$row=$$table->find(1);

$row[lcfirst($table)]=$_POST[lcfirst($table)];
$$table->save($row); //$$table變數

to("../back.php?do=".lcfirst(($table)));
?>