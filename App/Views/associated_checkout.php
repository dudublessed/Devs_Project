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

<main>
    <h2 id="list-title">Anuidades de <?php echo htmlspecialchars($associate['nome']); ?></h2>
    <?php if ($associatedAnnuities): ?>
    <h3 id="associate-overdue"><?php echo $status; ?></h3>
    
    <p id="total-annuities"><strong>Total das anuidades devidas: R$ <?php echo number_format($totalAnnuitiesDebt, 2, ',', '.'); ?></strong></p>
        <?php if ($totalAnnuitiesDebt > 0): ?>
        <form action="/associated/pay_all" method="post">
            <input type="hidden" name="id" value="<?php echo $associate['id']; ?>">
            <button class="pay-all-button" type="submit">Pagar Tudo</button>
        </form>
        <?php endif; ?>
    <?php endif; ?>
    <table class="associates-annuities-table" border="1">
        <thead>
            <tr>
                <th>Ano</th>
                <th>Valor</th>
                <th class="associate-annuity-column-paid">Pagamento Efetuado</th>
                <th class="associate-annuity-column-actions">Ações</th>
            </tr>
        </thead>
        <tbody>
    <?php if (!empty($associatedAnnuities)): ?>
        <?php foreach ($associatedAnnuities as $associatedAnnuity): ?>
            <tr>
                <td><?php echo htmlspecialchars((int)$associatedAnnuity['annuity_ano']); ?></td> 
                <td>R$ <?php echo number_format($associatedAnnuity['annuity_valor'], 2, ',', '.'); ?></td>
                <td>
                <?php
                    echo $associatedAnnuity['pagamento_efetuado'] ? 'Sim' : 'Não'; 
                 ?>
                </td>
                <td>
                    <form action="/associated/payment" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $associatedAnnuity['id']; ?>">
                        <button class="payment-button" type="submit">Pagar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">Nenhuma anuidade encontrada para o associado.</td>
        </tr>
    <?php endif; ?>
</tbody>

    </table>
</main>

</body>
</html>
