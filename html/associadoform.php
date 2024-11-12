<?php
$associados = getAssociados();
$associadoId = isset($_GET['id']) ? $_GET['id'] : null;

if ($associadoId) {
    $associado = getAssociado($associadoId);
    $pagamentos = debtPagamento($associadoId);
}

?>

<div class="primeira-linha">
    <form action="" method="post">
        <h3 class="form-title">Cadastrar Associado</h3>
        <input type="hidden" name="action" value="create_associado">
        <input type="text" name="name" placeholder="Nome e Sobrenome" required><br>
        <input type="email" name="email" placeholder="Email do Associado" required><br>
        <input type="text" name="cpf" placeholder="CPF do Associado" required><br>
        <button type="submit">Cadastrar</button><br>
    </form>

    <?php if ($associadoId): ?>
        <div class="pagamestos">
            <h3>Informações do Associado</h3>
            <p><strong>Nome:</strong> <?= htmlspecialchars($associado['name']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($associado['email']); ?></p>
            <p><strong>CPF:</strong> <?= htmlspecialchars($associado['cpf']); ?></p>

            <h3>Pagamentos</h3>
            <?php if (!empty($pagamentos)): ?>
                <ul>
                    <?php foreach ($pagamentos as $pagamento): ?>
                        <li>Pagamento ID: <?= $pagamento['ano']; ?> - Valor: <?= $pagamento['valor']; ?> - Status: <?= $pagamento['pago']; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Nenhum pagamento encontrado para este associado.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>


<form action="" method="post">
    <h3 class="form-title">Remover Associado</h3>
    <input type="hidden" name="action" value="delete_associado">
    <input type="text" name="cpf" placeholder="Digite o CPF do Associado" required><br>
    <button type="submit">Remover</button><br>
</form>

<br>
<div class="listagens">
    <?php foreach ($associados as $a) : ?>
        <div class="associado-card">
        <a href="gerencia_devs/?navegacao=cadastro_associado&id=<?= $a['id']; ?>" class="associado-link">
                <div class="associado-content">
                    <i class='bx bx-user icon-user'></i>
                    <span class="nome"><?= htmlspecialchars($a['name']); ?></span>
                </div>
                <div class="associado-content">
                    <i class='bx bx-envelope icon-email'></i>
                    <span class="email"><?= htmlspecialchars($a['email']); ?></span>
                </div>
                <div class="associado-content">
                    <i class='bx bx-id-card icon-cpf'></i>
                    <span class="cpf"><?= htmlspecialchars($a['cpf']); ?></span>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>

<?php if ($associadoId): ?>
    <div class="pagamestos">
        <h3>Informações do Associado</h3>
        <p><strong>Nome:</strong> <?= htmlspecialchars($associado['name']); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($associado['email']); ?></p>
        <p><strong>CPF:</strong> <?= htmlspecialchars($associado['cpf']); ?></p>

        <h3>Pagamentos</h3>
        <?php if (!empty($pagamentos)): ?>
            <ul>
                <?php foreach ($pagamentos as $pagamento): ?>
                    <li>Pagamento ID: <?= $pagamento['ano']; ?> - Valor: <?= $pagamento['valor']; ?> - Status: <?= $pagamento['pago']; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Nenhum pagamento encontrado para este associado.</p>
        <?php endif; ?>
    </div>
<?php endif; ?>
