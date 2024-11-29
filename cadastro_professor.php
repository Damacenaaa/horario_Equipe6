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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebendo os dados do formulário de professor
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $id_disciplina = $_POST['id_disciplina'];

    // Inserindo no banco de dados
    $sql = "INSERT INTO professores (nome, email, id_disciplina) VALUES ('$nome', '$email', '$id_disciplina')";

    if ($conn->query($sql) === TRUE) {
        $message = "Professor cadastrado com sucesso!";
    } else {
        $message = "Erro: " . $sql . "<br>" . $conn->error;
    }
}

// Obtendo a lista de disciplinas para o select
$disciplinas_result = $conn->query("SELECT id, nome FROM disciplinas");

if ($disciplinas_result->num_rows == 0) {
    $disciplinas_message = "Nenhuma disciplina cadastrada. Por favor, cadastre uma disciplina primeiro.";
}

// Fechando a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Professor</title>
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

        input[type="text"], input[type="email"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        select {
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

    <!-- Formulário de cadastro de professor -->
    <div class="container">
        <h1>Cadastro de Professor</h1>

        <?php
        if (isset($message)) {
            echo "<p class='message'>$message</p>";
        }

        if (isset($disciplinas_message)) {
            echo "<p class='disciplinas-message'>$disciplinas_message</p>";
        }
        ?>

        <form action="" method="POST">
            <label for="nome">Nome do Professor:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="email">E-mail do Professor:</label>
            <input type="email" id="email" name="email" required>

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

            <input type="submit" value="Cadastrar">
        </form>
    </div>

</body>
</html>
