<?php $this->layout('layouts/hero', ['title' => 'Informe creado', 'withNavbar' => true,]) ?>

<div class="box">
    <p class="title">Tu informe al usuario "<?= $this->e($report->review->username ?? "Anónimo") ?>" ha sido creado.</p>
    <div class="content">
        <p>Tu informe está siendo valorado por la administración.</p>

        <p>Tu ID de informe es: <b><?= $this->e($report->uuid) ?></b>. Por favor, manténlo en privado y no lo pierdas.</p>

        <p>
            Recuerda que puedes saber en cualquier momento el estado de tu informe consultando
            <a target="_blank" href="<?= $this->url('/reports/' . $report->uuid) ?>">aquí</a>.
        </p>

        <article class="message is-success">
            <div class="message-body">Gracias por hacer de WikiUMA un espacio más cívico y respetuoso <span style="color: #e25555;">&#9829;</span>.</div>
        </article>

        <a href="<?= $back ?>" class="button">Atrás</a>
    </div>
</div>
