<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars($_POST["nome"]);
    $mensagem = htmlspecialchars($_POST["mensagem"]);

    // Esta parte é para salvar a mensagem em .txt
    $arquivo = "mensagens.txt";
    $conteudo = "-----------------------------\n";
    $conteudo .= "Data: " . date("d/m/Y H:i:s") . "\n";
    $conteudo .= "Nome: $nome\n";
    $conteudo .= "Mensagem: $mensagem\n";
    $conteudo .= "-----------------------------\n\n";

    file_put_contents($arquivo, $conteudo, FILE_APPEND);

    // caso venha a ser necessário enviar por email ou salvar em banco de dados
    echo "<h2>Mensagem recebida!</h2>";
    echo "<p><strong>Nome:</strong> $nome</p>";
    echo "<p><strong>Mensagem:</strong> $mensagem</p>";

    // Botão pra voltar manualmente
    echo "<br><br>";
    echo "<a href='index.html'>
            <button style='padding:10px 20px; font-size:16px; cursor:pointer;'>
                Voltar ao início
            </button>
          </a>";
} else {
    echo "Método inválido.";
}
?>
