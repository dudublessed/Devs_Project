<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annuities</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<header class="topbar">
    <h1>Devs RN</h1>
    <div class="navigation">
        <form action="/home" method="get">
            <button class="home" type="submit">Home</button>
        </form>
        <form action="/annuities/create" method="get">
            <button class="create" type="submit">Cadastrar Anuidade</button>
        </form>
    </div>
</header>

<main>
    <h2 id="list-title">Lista de Anuidades</h2>
    
    <table class="annuities-table" border="1">
        <thead>
            <tr>
                <th>Ano</th>
                <th>Valor</th>
                <th class="annuity-column-actions">Ações</th>
            </tr>
        </thead>
        <tbody>
    <?php if (!empty($annuities)): ?>
        <?php foreach ($annuities as $annuity): ?>
            <tr>
                <td><?php echo htmlspecialchars($annuity['ano']); ?></td>
                <td>R$ <?php echo number_format($annuity['valor'], 2, ',', '.'); ?></td>
                <td>
                    <form action="/annuities/update" method="get" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $annuity['id']; ?>">
                        <button class="edit-button" type="submit">Editar</button>
                    </form>

                    <form action="/annuities/delete" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $annuity['id']; ?>">
                        <button class="delete-button" type="submit" onclick="return confirm('Tem certeza que deseja excluir esta anuidade?');">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">Nenhuma anuidade encontrada.</td>
        </tr>
    <?php endif; ?>
    </tbody>
    </table>
</main>

</body>
</html>
