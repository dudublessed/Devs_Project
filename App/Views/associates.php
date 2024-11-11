<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Associates</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<header class="topbar">
    <h1>Devs RN</h1>
    <div class="navigation">
        <form action="/home" method="get">
            <button class="home" type="submit">Home</button>
        </form>
        <form action="/associates/create" method="get">
            <button class="create" type="submit">Cadastrar Associado</button>
        </form>
    </div>
</header>

<main>
    <h2 id="list-title">Lista de Associados</h2>
    
    <table class="associates-table" border="1">
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>CPF</th>
                <th>Data de Filiação</th>
                <th class="associate-column-actions">Ações</th>
            </tr>
        </thead>
        <tbody>
    <?php if (!empty($associates)): ?>
        <?php foreach ($associates as $associate): ?>
            <tr>
                <td><?php echo htmlspecialchars($associate['nome']); ?></td>
                <td><?php echo htmlspecialchars($associate['email']); ?></td>
                <td><?php echo htmlspecialchars($associate['cpf']); ?></td>
                <td><?php echo htmlspecialchars($associate['data_filiacao']); ?></td>
                <td>
                    <form action="/associates/checkout" method="get" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $associate['id']; ?>">
                        <button class="checkout-button" type="submit">Checkout</button>
                    </form>

                    <form action="/associates/update" method="get" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $associate['id']; ?>">
                        <button class="edit-button" type="submit">Editar</button>
                    </form>

                    <form action="/associates/delete" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $associate['id']; ?>">
                        <button class="delete-button" type="submit" onclick="return confirm('Tem certeza que deseja excluir esta anuidade?');">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">Nenhum associado encontrado.</td>
        </tr>
    <?php endif; ?>
</tbody>

    </table>
</main>

</body>
</html>
