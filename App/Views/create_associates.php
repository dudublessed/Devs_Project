<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Associates</title>
</head>
<body>
<form id="associados-form" action="/config/config.php" method="post">   
        <h2>Cadastrar Associado</h2>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" placeholder="Digite o nome" required>

        <label for="email">E-mail:</label>
        <input type="text" id="email" name="email" placeholder="Digite o e-mail" required>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF" required>

        <label for="data_filiacao">Data de Filiação:</label>
        <input type="date" id="data-filiacao" name="data-filiacao" required>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>