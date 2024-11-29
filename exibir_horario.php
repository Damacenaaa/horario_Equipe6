<?php
// Configuração do banco de dados
$host = 'localhost';  // ou o IP do seu servidor
$user = 'root';       // seu usuário do MySQL
$password = '';       // sua senha do MySQL
$dbname = 'escola';   // banco de dados

// Conectando ao banco de dados
$conn = new mysqli($host, $user, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consultando os horários com joins para pegar os dados dos professores e disciplinas
$sql = "SELECT h.id, p.nome AS professor, d.nome AS disciplina, h.dia_semana, h.hora_inicio, h.hora_fim
        FROM horarios h
        JOIN professores p ON h.id_professor = p.id
        JOIN disciplinas d ON h.id_disciplina = d.id
        ORDER BY h.dia_semana, h.hora_inicio";

// Executando a consulta
$result = $conn->query($sql);

// Fechando a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exibição de Horários</title>
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

        /* Estilo da tabela */
        table {
            width: 80%;
            margin: 30px auto;
            border-collapse: collapse;
            text-align: left;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        th {
            background-color: #343a40;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Estilo da mensagem */
        .message {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #28a745;
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

    <!-- Tabela de Exibição de Horários -->
    <div class="container">
        <h1 style="text-align:center;">Exibição de Horários</h1>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Professor</th>
                        <th>Disciplina</th>
                        <th>Dia da Semana</th>
                        <th>Hora de Início</th>
                        <th>Hora de Término</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['professor'] ?></td>
                            <td><?= $row['disciplina'] ?></td>
                            <td><?= $row['dia_semana'] ?></td>
                            <td><?= $row['hora_inicio'] ?></td>
                            <td><?= $row['hora_fim'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="message">Ainda não há horários cadastrados.</p>
        <?php endif; ?>
    </div>

</body>
</html>
