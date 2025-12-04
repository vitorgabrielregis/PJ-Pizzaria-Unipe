<?php
session_start();
session_destroy();

// Redireciona para a página inicial pública
header("Location: index.php");
exit;
