<?php
namespace App\Models;

$anoErr = $anoErr ?? '';
$valErr = $valErr ?? '';
$exceptionErr = $exceptionErr ?? '';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annuities</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>

<header class="topbar">
        <h1>Devs RN</h1>
        <div class="navigation">
        <form action="/home" method="get">
            <button class="home" type="submit">Home</button>
        </form>
        <form action="/annuities" method="get">
            <button class="annuities" type="submit">Anuidades</button>
        </form>
        </div>
</header>

<form id="annuity_form" action="/annuities/store" method="post">
    <h2>Cadastrar Anuidade</h2>

    <label id="annuity_label" for="ano">Ano:</label>
    <input type="number" id="ano" name="ano" required>
    <?php if ($anoErr): ?>
        <p class="error"><?= $anoErr; ?></p>
    <?php endif; ?>

    <label id="annuity_label" for="valor">Valor:</label>
    <input type="number" id="valor" name="valor" step="0.01" required>
    <?php if ($valErr): ?>
        <p class="error"><?= $valErr; ?></p>
    <?php endif; ?>

    <?php if ($exceptionErr): ?>
        <p class="error"><?= $exceptionErr; ?></p>
    <?php endif; ?>
    <button id="annuity_button" type="submit">Cadastrar Anuidade</button>
</form>
    
</body>
</html>