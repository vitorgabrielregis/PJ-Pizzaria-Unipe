<?php
$conn = mysqli_connect("localhost", "root", "", "projeto_pizzaria");

if (!$conn) {
    die("Erro ao conectar ao banco: " . mysqli_connect_error());
}
?>
