# Links
Lista de Tarefas defeituosa: https://notes.plaureano.com/m/8F2CDpD54J7tH5Gbkfziub

User Stories: https://notes.plaureano.com/m/eQFriSue3xGmj6ojHei9nv

Código fonte para desafio: https://notes.plaureano.com/m/B3apDejxpoor6CQaVG2DTK



Matilde: https://stackoverflow.com/questions/18022809/how-can-i-solve-error-mysql-shutdown-unexpectedly

-------------------------------------------

    <ul>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li>{$row['description']} - {$row['status']} 
      <a href='delete_task.php?id={$row['id']}'>Apagar</a> | 
      <a href='update_task.php?id={$row['id']}'>Atualizar</a>
      </li>"; 
        }
        ?>
    </ul>


    
