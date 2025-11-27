<?php

date_default_timezone_set('America/Sao_Paulo'); // isto define o fuso horário

$hora_atual = (int)date('H'); 
$minuto_base_entrega = 35; // tempo médio fora do horário de pico

$is_aberto = ($hora_atual >= 11 && $hora_atual < 23); // período em que a pizzaria está aberta (11h às 23h)
$is_pico = ($hora_atual >= 18 && $hora_atual <= 22); // horário de pico (18h às 22h)

if (!$is_aberto) {
    // caso pizzaria estiver fechada
    $status_classe = "fechado";
    $titulo = "Estamos Fechados";
    $mensagem = "A Pyhrios Pizza abre das 11:00 às 23:00. Faça seu pedido quando abrirmos.";
    $tempo = ""; 
} else {
    // caso a pizzaria esteja aberta
    $status_classe = "aberto";
    $titulo = "Estamos Abertos! Faça seu Pedido";

    if ($is_pico) {
        // cálculo do tempo de entrega no PICO (+ 25 minutos).
        $minuto_adicional = 25; 
        $minuto_total = $minuto_base_entrega + $minuto_adicional;
        $mensagem = "Horário de Pico! Nosso tempo de entrega está um pouco maior. Agradecemos a compreensão.";
        $tempo = "Entrega estimada: **$minuto_total minutos**.";
    } else {
        // cálculo do tempo de entrega normal (fora do pico).
        $minuto_total = $minuto_base_entrega;
        $mensagem = "Nossa cozinha está com capacidade normal. Pedido rápido!";
        $tempo = "Entrega estimada: **$minuto_total minutos**.";
    }
}
?>

<div class="status-box <?php echo $status_classe; ?>">
    <h3><?php echo $titulo; ?></h3>
    <p><?php echo $mensagem; ?></p>
    <?php if ($tempo): ?>
        <p class="tempo-destaque"><?php echo $tempo; ?></p>
    <?php endif; ?>
</div>

<style>

.status-box {
    margin: 20px 0;
    padding: 15px;
    border-radius: 5px;
}
.status-box.aberto {
    background-color: #e6ffe6;
    border: 1px solid #00a000;
}
.status-box.fechado {
    background-color: #ffe6e6;
    border: 1px solid #c00000;
}
.status-box h3 {
    margin-top: 0;
    color: inherit; 
}
.tempo-destaque {
    font-weight: bold;
    font-size: 1.1em;
}
</style>