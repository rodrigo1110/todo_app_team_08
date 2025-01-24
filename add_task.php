<?php
$connection = mysqli_connect("localhost", "root", "", "todo_ap");

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validação e sanitização dos inputs 
    $task_name = filter_input(INPUT_POST, 'task_name', FILTER_SANITIZE_STRING);
    $task_description = filter_input(INPUT_POST, 'task_description', FILTER_SANITIZE_STRING);
    $due_date = filter_input(INPUT_POST, 'due_date', FILTER_SANITIZE_STRING);

    // Validação adicional
    if (empty($task_name) || strlen($task_name) > 255) {
        die('Nome da tarefa inválido');
    }

    if (strlen($task_description) > 1000) {
        die('Descrição da tarefa muito longa');
    }

    if (!empty($due_date) && !strtotime($due_date)) {
        die('Data inválida');
    }

    $query = "INSERT INTO tasks (task_name, task_description, due_date) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "sss", $task_name, $task_description, $due_date);
    $result = mysqli_stmt_execute($stmt);
    
    // Validação da inserção
    if (!$result) {
        die("Erro ao inserir tarefa: " . mysqli_error($connection));
    }
    
    header("Location: index.php");
    exit();
}
?>
