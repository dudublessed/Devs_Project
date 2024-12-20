<?php
$nomeErr = $nomeErr ?? '';
$emailErr = $emailErr ?? '';
$cpfErr = $cpfErr ?? '';
$dataFiliacaoErr = $dataFiliacaoErr ?? '';
$exceptionErr = $exceptionErr ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Associates</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
<header class="topbar">
        <h1>Devs RN</h1>
        <div class="navigation">
        <form action="/home" method="get">
            <button class="home" type="submit">Home</button>
        </form>
        <form action="/associates" method="get">
            <button class="associated" type="submit">Associados</button>
        </form>
        </div>
    </header>
<form id="associados-form" action="/associates/store" method="post">
    <h2>Cadastrar Associado</h2>

    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" placeholder="Digite o nome" required>
    <?php if ($nomeErr): ?>
        <p class="error"><?= $nomeErr; ?></p>
    <?php endif; ?>

    <label for="email">E-mail:</label>
    <input type="text" id="email" name="email" placeholder="Digite o e-mail" required>
    <?php if ($emailErr): ?>
        <p class="error"><?= $emailErr; ?></p>
    <?php endif; ?>

    <label for="cpf">CPF:</label>
    <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF" required>
    <?php if ($cpfErr): ?>
        <p class="error"><?= $cpfErr; ?></p>
    <?php endif; ?>

    <label for="data_filiacao">Data de Filiação:</label>
    <input type="date" id="data_filiacao" name="data_filiacao" required>
    <?php if ($dataFiliacaoErr): ?>
        <p class="error"><?= $dataFiliacaoErr; ?></p>
    <?php endif; ?>

    <?php if ($exceptionErr): ?>
        <p class="error"><?= $exceptionErr; ?></p>
    <?php endif; ?>

    <button class="register" type="submit">Cadastrar</button>
</form>
</body>
</html>
