<?php
// Configuração do banco de dados
$host = 'localhost';  // ou o IP do seu servidor
$user = 'root';       // seu usuário do MySQL
$password = '';       // sua senha do MySQL
$dbname = 'escola';   // banco de dados

// Conectando ao banco de dados
$conn = new mysqli($host, $user, $password, $dbname);

// Verificando conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtendo a lista de professores e disciplinas para os selects
$professores_result = $conn->query("SELECT id, nome FROM professores");
$disciplinas_result = $conn->query("SELECT id, nome FROM disciplinas");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebendo os dados do formulário de horário
    $id_professor = $_POST['id_professor'];
    $id_disciplina = $_POST['id_disciplina'];
    $dia_semana = $_POST['dia_semana'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fim = $_POST['hora_fim'];

    // Inserindo no banco de dados
    $sql = "INSERT INTO horarios (id_professor, id_disciplina, dia_semana, hora_inicio, hora_fim) 
            VALUES ('$id_professor', '$id_disciplina', '$dia_semana', '$hora_inicio', '$hora_fim')";

    if ($conn->query($sql) === TRUE) {
        $message = "Horário cadastrado com sucesso!";
    } else {
        $message = "Erro: " . $sql . "<br>" . $conn->error;
    }
}

// Fechando a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Horário</title>
    <style>
        /* Estilo geral */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        /* Cabeçalho */
        .header {
            background-color: #343a40;
            padding: 15px 0;
            text-align: center;
            color: white;
        }

        .header a {
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 15px;
            font-size: 18px;
        }

        .header a:hover {
            background-color: #495057;
            border-radius: 4px;
        }

        /* Estilo do container */
        .container {
            width: 40%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 14px;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"], input[type="time"], select {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #28a745;
        }

        .error {
            color: #d9534f;
        }

        .disciplinas-message {
            text-align: center;
            font-size: 16px;
            color: #d9534f;
        }
    </style>
</head>
<body>

    <!-- Cabeçalho com links -->
    <div class="header">
        <a href="index.php">Cadastro de Disciplina</a>
        <a href="cadastro_professor.php">Cadastro de Professor</a>
        <a href="cadastro_horario.php">Cadastro de Horário</a>
        <a href="exibir_horario.php">Horários</a>
    </div>

    <!-- Formulário de cadastro de horário -->
    <div class="container">
        <h1>Cadastro de Horário</h1>

        <?php
        if (isset($message)) {
            echo "<p class='message'>$message</p>";
        }

        if ($professores_result->num_rows == 0 || $disciplinas_result->num_rows == 0) {
            echo "<p class='disciplinas-message'>Por favor, cadastre pelo menos uma disciplina e um professor antes de cadastrar os horários.</p>";
        }
        ?>

        <form action="" method="POST">
            <label for="id_professor">Professor:</label>
            <select id="id_professor" name="id_professor" required>
                <?php
                if ($professores_result->num_rows > 0) {
                    while ($row = $professores_result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="id_disciplina">Disciplina:</label>
            <select id="id_disciplina" name="id_disciplina" required>
                <?php
                if ($disciplinas_result->num_rows > 0) {
                    while ($row = $disciplinas_result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="dia_semana">Dia da Semana:</label>
            <select id="dia_semana" name="dia_semana" required>
                <option value="Segunda-feira">Segunda-feira</option>
                <option value="Terça-feira">Terça-feira</option>
                <option value="Quarta-feira">Quarta-feira</option>
                <option value="Quinta-feira">Quinta-feira</option>
                <option value="Sexta-feira">Sexta-feira</option>
            </select>

            <label for="hora_inicio">Hora de Início:</label>
            <input type="time" id="hora_inicio" name="hora_inicio" required>

            <label for="hora_fim">Hora de Término:</label>
            <input type="time" id="hora_fim" name="hora_fim" required>

            <input type="submit" value="Cadastrar">
        </form>
    </div>

</body>
</html>
