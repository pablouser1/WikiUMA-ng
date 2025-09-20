<?php $this->layout('layouts/hero', ['title' => 'Informe creado', 'withNavbar' => true,]) ?>

<div class="box">
    <p class="title">Tu informe al usuario "<?= $this->e($report->review->username ?? "Anónimo") ?>" ha sido creado.</p>
    <div class="content">
        <p>Tu informe está siendo valorado por la administración.</p>
        <p>Tu ID de informe es: <b><?= $this->e($report->uuid) ?></b>.</p>
        <p>
            <?php if ($report->email !== null): ?>
                Se te enviará un correo electrónico cuando la administración tome una decisión.
            <?php else: ?>
                Si quieres saber el estado de tu informe, puedes enviar un correo electrónico a <b><?= $this->contact() ?></b>.
                Recuerda especificar tu ID.
            <?php endif ?>
        </p>

        <article class="message is-success">
            <div class="message-body">Gracias por hacer de WikiUMA un espacio más cívico y respetuoso <span style="color: #e25555;">&#9829;</span></div>
        </article>

        <a href="<?= $back ?>" class="button">Atrás</a>
    </div>
</div>
