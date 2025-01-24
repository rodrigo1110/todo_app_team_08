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

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = mysqli_real_escape_string($connection, $_GET['id']);
    $status = mysqli_real_escape_string($connection, $_GET['status']);
    
    $query = "UPDATE tasks SET status = '$status' WHERE id = '$id'";
    $result = mysqli_query($connection, $query);
    
    // Validação da atualização
    if (!$result) {
        die("Erro ao atualizar tarefa: " . mysqli_error($connection));
    }
    
    header("Location: index.php");
    exit();
}

// Validação e sanitização dos inputs
$task_id = filter_input(INPUT_POST, 'task_id', FILTER_VALIDATE_INT);
$task_name = filter_input(INPUT_POST, 'task_name', FILTER_SANITIZE_STRING);
$task_description = filter_input(INPUT_POST, 'task_description', FILTER_SANITIZE_STRING);
$due_date = filter_input(INPUT_POST, 'due_date', FILTER_SANITIZE_STRING);
$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

// Validação adicional
if (!$task_id) {
    die('ID da tarefa inválido');
}

if (empty($task_name) || strlen($task_name) > 255) {
    die('Nome da tarefa inválido');
}

if (strlen($task_description) > 1000) {
    die('Descrição da tarefa muito longa');
}

if (!empty($due_date) && !strtotime($due_date)) {
    die('Data inválida');
}

if (!in_array($status, ['pendente', 'em_andamento', 'concluida'])) {
    die('Status inválido');
}

// Usar prepared statement com os dados sanitizados
$query = "UPDATE tasks SET task_name = ?, task_description = ?, due_date = ?, status = ? WHERE task_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("ssssi", $task_name, $task_description, $due_date, $status, $task_id);

$result = $stmt->execute();

// Validação da atualização
if (!$result) {
    die("Erro ao atualizar tarefa: " . mysqli_error($connection));
}

header("Location: index.php");
exit();
?>
