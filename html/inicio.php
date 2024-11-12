<?php
$associados = getAssociados();
$anuidades = getAnuidades();
?>

<div class="panel-inicio">
    <div class="panel-title">
        <h3 class="titulo-panel">ASSOCIADOS</h3>
        <br>
        <div class="listagens">
            <?php if (!empty($associados)) : ?>
                <?php foreach ($associados as $a) : ?>
                    <div class="associado-card">
                        <div class="associado-content">
                            <i class='bx bx-user icon-user'></i>
                            <span class="nome"><?= htmlspecialchars($a['name']); ?></span>
                        </div>
                        <div class="associado-content">
                            <i class='bx bx-envelope icon-email' ></i>
                            <span class="email"><?= htmlspecialchars($a['email']); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Nenhum associado encontrado.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="panel-title">
        <h3 class="titulo-panel">ANUIDADES</h3>
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
                            <i class='bx bx-money icon-email' ></i>
                            <span class="email">Valor: <?= htmlspecialchars($a['a_value']); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Ainda não há anuidades.</p>
            <?php endif; ?>
        </div>
    </div>
    </div>
</div>
