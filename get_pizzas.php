<?php
require "config.php";

header('Content-Type: application/json');

$sql = "SELECT * FROM pizzas";
$result = mysqli_query($conn, $sql);

if(!$result) {
    echo json_encode(["error" => mysqli_error($conn)]);
    exit;
}

$pizzas = [];
while ($row = mysqli_fetch_assoc($result)) {
    $pizzas[] = $row;
}

echo json_encode($pizzas);
?>
