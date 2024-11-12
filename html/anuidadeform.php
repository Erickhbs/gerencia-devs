<?php

$anuidades = getAnuidades();
?>


<div class="panel-info">

    <form action="" method="post">
        <h3 class="form-title">Cadastrar Anuidade</h3>
        <input type="hidden" name="action" value="create_anuidade">
        <input type="number" name="ano" placeholder="Ano da anuidade" min="<?= date("Y"); ?>" required><br>
        <input type="number" name="valor" placeholder="Valor da anuidade" required><br>
        <button type="submit">Cadastrar</button><br>
    </form>

    <form action="" method="post">
        <h3 class="form-title">Mudar Valor da Anuidade</h3>
        <input type="hidden" name="action" value="update_anuidade">
        <input type="number" name="ano" placeholder="Ano da anuidade" required><br>
        <input type="number" name="valor" placeholder="Valor da anuidade" required><br>
        <button type="submit">Atualizar</button><br>
    </form>

    <br>

    <div class="listagens">
        <?php if (!empty($anuidades)) : ?>
            <?php foreach ($anuidades as $a) : ?>
                <div class="associado-card">
                    <div class="associado-content">
                        <i class='bx bx-calendar-alt icon-user'></i>
                        <span class="nome">Ano: <?= htmlspecialchars($a['a_year']); ?></span>
                    </div>
                    <div class="associado-content">
                        <i class='bx bx-money icon-email'></i>
                        <span class="email">Valor: <?= htmlspecialchars($a['a_value']); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Ainda não há anuidades.</p>
        <?php endif; ?>
    </div>
</div>

