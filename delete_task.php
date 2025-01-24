<?php
$connection = mysqli_connect("localhost", "root", "", "todo_app");

// Validação da conexão com o banco de dados

try {
    // Tente se conectar ao banco de dados
    $connection = mysqli_connect("localhost", "root", "", "todo_appp");  // Nome do banco de dados com erro (três 'p's)

    // Verificar se a conexão falhou
    if (mysqli_connect_errno()) {
        // Se houver um erro na conexão, lança uma exceção
        throw new Exception("Erro na conexão com o banco de dados: " . mysqli_connect_error());
    }

    // Se a conexão for bem-sucedida
    echo "Conectado com sucesso";
} catch (Exception $e) {
    // Exibe a mensagem de erro capturada
    trigger_error("Erro de conexão", E_USER_WARNING);
}

// Validação e sanitização do ID da tarefa
$task_id = filter_input(INPUT_POST, 'task_id', FILTER_VALIDATE_INT);

if (!$task_id) {
    die('ID da tarefa inválido');
}

// Usar prepared statement com o ID sanitizado
$query = "DELETE FROM tasks WHERE task_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $task_id);

mysqli_query($connection, $query);
header("Location: index.php");
?>
