<?php
include 'errorHandler.php';
//$connection = mysqli_connect("localhost", "root", "", "todo_app");

//set_error_handler('errorHandler.customError', E_USER_WARNING);
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

$query = "SELECT * FROM tasks";
$result = mysqli_query($connection, $query);

// Validação da consulta 
if (!$result) {
    die("Erro na consulta: " . mysqli_error($connection));
}

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <title>Lista de Tarefas</title>
    <script>
        function validateForm(event) {
            const taskInput = document.getElementById("task-input");
            if (taskInput.value === "") { 
                alert("Por favor, preencha o campo de tarefa.");
                event.preventDefault();
                return false;
            }
            if (taskInput.value.length > 100) { 
                alert("A tarefa não pode ter mais de 100 caracteres.");
                return false;
            }
            return true;
        }
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("task-form");
            form.addEventListener("submit", validateForm);
        });
    </script>
</head>
<body>
    <h1>Lista de Tarefas</h1>
    <ul>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li>{$row['description']} - {$row['status']} <a href='delete_task.php?id={$row['id']}'>Apagar</a></li>";
        }
        ?>
    </ul>
    <form id="task-form" action="add_task.php" method="POST">
        <input id="task-input" type="text" name="task" placeholder="Nova Tarefa">
        <button type="submit">Adicionar Tarefa</button>
    </form>
</body>
</html>
